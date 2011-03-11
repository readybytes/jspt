<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );
jimport('joomla.filesystem.file');

if(!JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.php'))
 	return false;

$includeXipt=require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.php');

if($includeXipt === false)
	return false;

class plgSystemxipt_system extends JPlugin
{
	var $_debugMode = 1;
	var $_eventPreText = 'event_';
	private $_pluginHandler;

	function __construct( $subject, $params )
	{
		parent::__construct( $subject, $params );
		$this->_pluginHandler = XiptFactory::getPluginHandler();
	}


	function onAfterRoute()
	{
		$app = JFactory::getApplication();

		if($app->isAdmin()){
 			return false;
 		}

		// get option, view and task
		$option 	= JRequest::getVar('option','BLANK');
		$view 		= JRequest::getVar('view','BLANK');
		$task 		= JRequest::getVar('task','BLANK');
		$component	= JRequest::getVar('component','BLANK');

		// perform all acl check from here
		XiptAclHelper::performACLCheck(false, false, false);

		//do routine works
		$eventName = $this->_eventPreText.strtolower($option).'_'.strtolower($view).'_'.strtolower($task);
		//call defined event to handle work
		$exist = method_exists($this,$eventName);
		if($exist)
			$this->$eventName();

		return false;
	}

	/**
	 * This function will store user's registration information
	 * in the tables, when User object is created
	 * @param $cuser
	 * @return true
	 */
	function onAfterStoreUser($properties,$isNew,$result,$error)
	{
		return $this->onUserAfterSave($properties,$isNew,$result,$error);
	}
	/**
	 * 
	 * @param unknown_type $properties : Holds the new user data.
	 * @param unknown_type $isNew: True if a new user is stored.
	 * @param unknown_type $result: True if user was succesfully stored in the database.
	 * @param unknown_type $error : Error Message
	 */
	function onUserAfterSave($properties,$isNew,$result,$error)
	{
		// we only store new users
		if($isNew == false || $result == false || $error == true) {
			$this->_pluginHandler->cleanRegistrationSession();
			return true;
		}

		$profiletypeID = $this->_pluginHandler->getRegistrationPType();
		// need to set everything
		XiptLibProfiletypes::updateUserProfiletypeData($properties['id'], $profiletypeID,'', 'ALL');

		//clean the session
		$this->_pluginHandler->cleanRegistrationSession();
		return true;
	}
	
	/**
	 * for Joomla 1.5
	 * @param unknown_type $properties
	 * @param unknown_type $result
	 * @param unknown_type $error
	 */
	function onAfterDeleteUser($properties,$result,$error)
	{
		if($result == false || $error == true){
			return true;
		}

		return XiptFactory::getInstance('users','model')->delete($properties['id']);
	}
	
	/**
	 * fo Joomla 1.6
	 * @param $properties
	 * @param $result
	 * @param $error
	 */
	function onUserAfterDelete($properties,$result,$error)
	{
		if($result == false || $error == true){
			return true;
		}

		return XiptFactory::getInstance('users','model')->delete($properties['id']);
	}

	// this is trigerred on registraion page of xipt
	function onBeforeProfileTypeSelection()
	{
		// if user comes from genaral registration link then return
		$ptypeid = JRequest::getVar('ptypeid',0);

		// if user comes from a direct link (with profile type selected)
		// the reset will be false or does not exist
		// if user comes for selecting profile type again then reset is true
		$reset = JRequest::getVar('reset',false);

		if($ptypeid == 0 || $reset)
			return true;

		if(!XiptLibProfiletypes::validateProfiletype($ptypeid))
			return true;

		XiptHelperProfiletypes::setProfileTypeInSession($ptypeid);
		return true;
	}

	// this is trigerred on after post on registration page of xipt
	function onAfterProfileTypeSelection($ptypeid)
	{
		// set the profile type in session
		return XiptHelperProfiletypes::setProfileTypeInSession($ptypeid);
	}

	/*
	 * Events generated from the onAfterRoute
	 */

	//BLANK means task should be empty
	function event_com_community_register_blank()
	{
		return $this->_pluginHandler->integrateRegistrationWithPType();
	}

	function event_com_user_register_blank()
	{
	    return $this->_pluginHandler->integrateRegistrationWithPType();
	}
	
	/**
	 * for Joomla 1.6 
	 * replace (option) user to users and (view) register to registration.
	 */
	function event_com_users_registration_blank()
	{
	    return $this->event_com_user_register_blank();
	}

	function event_com_community_profile_blank()
	{
		if(!$this->_pluginHandler->getDataInSession('FROM_FACEBOOK',false))
			return true;

		// reset the session data of FROM_FACEBOOK
		$this->_pluginHandler->resetDataInSession('FROM_FACEBOOK');

		if(XiptFactory::getSettings('aec_integrate', 0) == true) {
			$link = XiptRoute::_('index.php?option=com_acctexp&task=subscribe',false);
			JFactory::getApplication()->redirect($link);
		}

		return true;
	}

	/* get the plan id when the direct link of AEC are used */
	function event_com_acctexp_blank_subscribe()
	{
		$usage  = JRequest::getVar( 'usage', 0, 'REQUEST');
		//XiptError::assert($usage);
		$this->_pluginHandler->setDataInSession('AEC_REG_PLANID', $usage);
	}

	// we are on xipt registration page
	function event_com_xipt_registration_blank()
	{
	    $aecExists 		= XiptLibAec::isAecExists();
	    $integrateAEC   = XiptFactory::getSettings('aec_integrate');

	    // check AEC exist or not
	    // AND check JSPT is integrated with AEC or not
	    if(!$aecExists || !$integrateAEC)
	        return false;

	    // find selected profiletype from AEC
	    $aecData = XiptLibAec::getProfiletypeInfoFromAEC();
		$app	 = JFactory::getApplication();

	    // as user want to integrate the AEC so a plan must be selected
        // send user to profiletype selection page
	    if($aecData['planSelected'] == false)
	        $app->redirect(XiptRoute::_('index.php?option=com_acctexp&task=subscribe',false),XiptText::_('PLEASE_SELECT_AEC_PLAN_IT_IS_RQUIRED'));

	    // set selected profiletype in session
	    $this->_pluginHandler->mySess->set('SELECTED_PROFILETYPE_ID',$aecData['profiletype'], 'XIPT');
	    $app->redirect(XiptHelperJomsocial::getReturnURL());

	    return true;
	}

	function onAfterDispatch()
    {
    	$app = JFactory::getApplication();
		
 		if($app->isAdmin() && $this->_pluginHandler->checkSetupRequired())
 			$app->enqueueMessage(XiptText::_('JSPT_SETUP_SCREEN_IS_NOT_CLEAN_PLEASE_CLEAN_IT'), 'error');
 		 		
        // get option, view and task
        $option     = JRequest::getVar('option');
        $view         = JRequest::getVar('view');
        $task         = JRequest::getVar('task');

        if($option != 'com_community' || $view != 'search' || $task != 'advancesearch')
            return true;

        $allTypes = XiptLibProfiletypes::getProfiletypeArray(array('published'=>1, 'visible'=>1));

        if (!$allTypes)
			return false;
		// when we are getting Html of select list(for Profile-Types) 
		//then  don't addd "\n" at end of line
		if(XIPT_JOOMLA_16){
			JHtml::$formatOptions= array_merge(
								   JHtml::$formatOptions,
									array('format.eol' => ""));
		}

		$profileType = JHTML::_('select.genericlist',  $allTypes, 'profiletypes', 'class="inputbox"', 'id', 'name');

        ob_start();
        $this->_addXiptSearchScript($profileType);

        $content = ob_get_contents();
        ob_clean();
        $doc = JFactory::getDocument();
		if(XIPT_JOOMLA_15)
        	JHTML::script('jquery1.4.2.js','components/com_xipt/assets/js/', true);
		
       	if(XIPT_JOOMLA_16)
        	JHTML::script('components/com_xipt/assets/js/jquery1.4.2.js');
        
        $doc->addCustomTag( '<script type="text/javascript">jQuery.noConflict();</script>' );

        $doc->addScriptDeclaration($content);
        return true;
    }


	// $userInfo ia an array and contains contains
	// userid
	// oldPtype
	// & newPtype
	function onBeforeProfileTypeChange($userInfo)
	{
		return false;
	}

	function onAfterProfileTypeChange($newPtype, $result)
	{
		return false;
	}

	function _addXiptSearchScript($profileType)
	{
	   //CAssets::attach(JURI::root().'components/com_community/assets/joms.jquery', 'js');
		?>
		$(document).ready(function(){
			 // find all select list object
			 var sel = document.getElementsByTagName("select");
			 var selLength =  sel.length;

		     for (i=0 ; i <= selLength; i++){
		        joms.jQuery.xipt.getProfileTypesFields(joms.jQuery, joms.jQuery(sel[i]).attr("id"));
		        }
		    });

			joms.jQuery(function($){
			// change on select list then attach our HTML
			$("select[id^='field']").live('change', function(){
				joms.jQuery.xipt.getProfileTypesFields($, $(this).attr("id"));
				});

			$("#profiletypes").live('change', function(){

			 		//set profileType value in  hidden textbox
					profileFieldValue= $(this).val();
					parentId = $(this).prev().attr("id");
					$("#"+ $("#" + parentId + ":first-child" ).attr("id")).val(profileFieldValue);
				});

			});

    	joms.jQuery.extend({
    		xipt:{
			  getProfileTypesFields : function($, id){
					var value = $('#'+id).val();

              		if(value != "XIPT_PROFILETYPE")
                      return true;

                    ptHtml = '<?php echo $profileType; ?>';
                    // valueinputId is parent id of valueId and  profiletype List
                    valueinputId = $('#'+id).attr("id").replace("field", "valueinput");

				    // find hidden text box
				    valueId = $('#'+id).attr("id").replace("field", "value");
				    $('#'+valueId).css('display', 'none');
				    $(ptHtml).appendTo('div#'+valueinputId);


				    // set profileType value in select list by hidden textbox
				    if($('#'+valueId).val())
				    	 $('#'+valueId).next().val($('#'+valueId).val());
				     else
				         $('#'+valueId).val($('#'+valueId).next().val());			//set default value of hidden textbox
				    }

				}
			});

		<?php
	}
}