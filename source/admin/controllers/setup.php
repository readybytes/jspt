<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
 
class XiptControllerSetup extends XiptController 
{
    
	function __construct($config = array())
	{
		parent::__construct($config);
	}
	
    function display() 
	{
		parent::display();
    }
	
    
    function createfields()
    {
    	global $mainframe;
    	$pFieldCreated = true;
    	$tFieldCreated = true;
		 
		if(!XiptHelperSetup::checkExistanceOfCustomFields(TEMPLATE_CUSTOM_FIELD_CODE))
				$tFieldCreated = XiptHelperSetup::createCustomField(TEMPLATE_CUSTOM_FIELD_CODE);
				
		if(!XiptHelperSetup::checkExistanceOfCustomFields(PROFILETYPE_CUSTOM_FIELD_CODE))
				$pFieldCreated = XiptHelperSetup::createCustomField(PROFILETYPE_CUSTOM_FIELD_CODE);

		//now check field enable required then enable field
		if(!XiptHelperSetup::checkExistanceOfCustomFields(TEMPLATE_CUSTOM_FIELD_CODE,true))
				$tFieldEnabled = XiptHelperSetup::enableField(TEMPLATE_CUSTOM_FIELD_CODE);
				
		if(!XiptHelperSetup::checkExistanceOfCustomFields(PROFILETYPE_CUSTOM_FIELD_CODE,true))
				$pFieldEnabled = XiptHelperSetup::enableField(PROFILETYPE_CUSTOM_FIELD_CODE);
				
		if($pFieldCreated && $tFieldCreated
			&& $pFieldEnabled && $tFieldEnabled)
			$mainframe->enqueueMessage(JText::_("CUSTOM FIELD CREATED AND ENABLED SUCCESSFULLY"));
			
		$mainframe->redirect(XiptRoute::_("index.php?option=com_xipt&view=setup&task=display",false));
    }
    
    
    function createprofiletypes()
    {
    	global $mainframe;
    	$mainframe->redirect(XiptRoute::_("index.php?option=com_xipt&view=profiletypes&task=edit",false));
    }
    
    function installplugin()
    {
    	global $mainframe;
    	$mainframe->redirect(XiptRoute::_("index.php?option=com_installer",false));
    }
    
    
	function enableplugin()
    {
    	global $mainframe;
    	$sEnabled = true;
    	$cEnabled = true;
		 
		if(XiptHelperSetup::isPluginInstalledAndEnabled('xipt_system','system')
			&& !XiptHelperSetup::isPluginInstalledAndEnabled('xipt_system','system',true))
				$sEnabled = XiptHelperSetup::enablePlugin('xipt_system');
				
		if(XiptHelperSetup::isPluginInstalledAndEnabled('xipt_community','community')
			&& !XiptHelperSetup::isPluginInstalledAndEnabled('xipt_community','community',true))
				$cEnabled = XiptHelperSetup::enablePlugin('xipt_community');
				
		if($sEnabled && $cEnabled)
			$mainframe->enqueueMessage(JText::_("PLUGIN ENABLED SUCCESSFULLY"));
			
		$mainframe->redirect(XiptRoute::_("index.php?option=com_xipt&view=setup&task=display",false));
    }
    	
    
    function patchfile()
    {
    	global $mainframe;
    	
    	if(!XiptHelperSetup::checkFilePatchRequired())
    		$mainframe->redirect(XiptRoute::_("index.php?option=com_xipt&view=setup&task=display",false));

    	if(XiptHelperSetup::isModelFilePatchRequired()){
    		$filename = JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'models'.DS.'profile.php';
    		
	    	//	create a backup file first
    	    if(!JFile::copy($filename, $filename.'.jxibak')){
    	    	global $mainframe;
    	    	$mainframe->enqueueMessage("NOT ABLE TO CREATE A BACKUP FILE CHECK PERMISSION");
    	    	return false;
    	    }
    		
	    	//1. Replace _ fields calling in _loadAllFields function
	    	$funcName = 'function _loadAllFields';
	    	
	    	$searchString = '$fields = $db->loadObjectList();';
	    	ob_start();
	    	?>$fields = $db->loadObjectList();
	    	
	    	/*==============HACK TO RUN JSPT CORRECTLY :START ============================*/
	    	require_once(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.php');
	    	$pluginHandler=& XiptFactory::getLibraryPluginHandler();
	    	$userId = 0;
	    	$pluginHandler->onProfileLoad($userId, $fields, __FUNCTION__);
	    	/*==============HACK TO RUN JSPT CORRECTLY : DONE ============================*/
	        <?php 
	        
	        $replaceString = ob_get_contents();
	        ob_end_clean();
	        
	        $success = XiptHelperSetup::patchData($searchString,$replaceString,$filename,$funcName);
	        
	        //2. Replace data in getViewableProfile fn
	        $funcName =  'function getViewableProfile';
	        $searchString = '$result	= $db->loadAssocList();';
	    	ob_start();
	    	?>$result	= $db->loadAssocList();
	    	
	    	/*==============HACK TO RUN JSPT CORRECTLY :START ============================*/
			require_once(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.php');
		    $pluginHandler=& XiptFactory::getLibraryPluginHandler();
		    $pluginHandler->onProfileLoad($userId, $result, __FUNCTION__);
		    /*==============HACK TO RUN JSPT CORRECTLY : DONE ============================*/
	        <?php 
	        
	        $replaceString = ob_get_contents();
	        ob_end_clean();
	        
	        $success = XiptHelperSetup::patchData($searchString,$replaceString,$filename,$funcName);
	        
	        
	        //3. Replace data in getEditablePRofile function
	        $funcName =  'function getEditableProfile';
	        $success = XiptHelperSetup::patchData($searchString,$replaceString,$filename,$funcName);
	        
    	}

    	// we need to patch Model:User in backend also for editing
    	if(XiptHelperSetup::isAdminUserModelPatchRequired()){
    		$filename = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_community'.DS.'models'.DS.'users.php';
    		
    		//	create a backup file first
    	    if(!JFile::copy($filename, $filename.'.jxibak')){
    	    	global $mainframe;
    	    	$mainframe->enqueueMessage("NOT ABLE TO CREATE A BACKUP FILE CHECK PERMISSION");
    	    	return false;
    	    }
    		
	    	$funcName = 'function getEditableProfile($userId	= null)';
	    	
	    	$searchString = '$result	= $db->loadAssocList();';
	    	ob_start();
	    	?>$result	= $db->loadAssocList();
	    	
	    	/*==============HACK TO RUN JSPT CORRECTLY :START ============================*/
			require_once(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.php');
		    $pluginHandler=& XiptFactory::getLibraryPluginHandler();
		    $pluginHandler->onProfileLoad($userId, $result, __FUNCTION__);
		    /*==============HACK TO RUN JSPT CORRECTLY : DONE ============================*/
	        <?php 
	        
	        $replaceString = ob_get_contents();
	        ob_end_clean();
	        
	        $success = XiptHelperSetup::patchData($searchString,$replaceString,$filename,$funcName);
    	}
        
        //now check library field exist
        if(XiptHelperSetup::isCustomLibraryFieldRequired()){
        	//copy library field files into community // libraries // fields folder
        	XiptHelperSetup::copyLibraryfiles();
        }
        
        
        //now check XML File patch required
        if(XiptHelperSetup::isXMLFilePatchRequired()) {
        	//give patch data fn file to patch
        	$filename	= JPATH_ROOT . DS. 'components' . DS . 'com_community'
        					.DS.'libraries'.DS.'fields'.DS.'customfields.xml';
        	if (JFile::exists($filename)) {
		
				if(!is_readable($filename)) 
					XiptError::raiseWarning(sprintf(JText::_('FILE IS NOT READABLE PLEASE CHECK PERMISSION'),$filename));
				
				$file =JFile::read($filename);				
			    $searchString = '</fields>';
		    	ob_start();
		    	?><field>
		    	<type>profiletypes</type>
		    	<name>Profiletypes</name>
		    	</field>
				<field>
					<type>templates</type>
					<name>Templates</name>
				</field>
				</fields><?php 
		        
		        $replaceString = ob_get_contents();
		        $file = str_replace($searchString,$replaceString,$file);
		        
	        	// create a backup file first
	    	    if(!JFile::copy($filename, $filename.'.jxibak')){
	    	    	global $mainframe;
	    	    	$mainframe->enqueueMessage("NOT ABLE TO CREATE A BACKUP FILE CHECK PERMISSION");
	    	    	return false;
	    	    }
	    	    
	    	    JFile::write($filename,$file);
	        	 	
        	}
        }
        $msg = JText::_('FILES PATCHED SUCCESSFULLY');
        $mainframe->redirect(XiptRoute::_("index.php?option=com_xipt&view=setup&task=display",false),$msg);
    	return true;
    }
    
	function patchAECfile()
    {
    	global $mainframe;    	   	
        //now check library field exist
        if(XiptHelperSetup::isAECMIRequired()){
        	if(XiptHelperSetup::copyAECfiles())
        		$msg = JText::_('AEC MI COPIED SUCCESSFULLY');
        	else
        		$msg = JText::_('AEC MI COPY FAILED');
        }
        else
        	$msg = JText::_('AEC MI ALREADY EXIST');
        
        $mainframe->redirect(XiptRoute::_("index.php?option=com_xipt&view=setup&task=display",false),$msg);
    }
    
	function syncUpUserPT()
    {
    	global $mainframe;    	   	
        //now check library field exist
        $start=JRequest::getVar('start', 0, 'GET');
		$limit=JRequest::getVar('limit',SYNCUP_USER_LIMIT, 'GET');
      	if(XiptHelperSetup::syncUpUserPT($start,$limit))
        	$msg = JText::_('USERs PROFILETYPE AND TEMPLATES SYNCRONIZED SUCCESSFULLY');
        else
        	$msg = JText::_('USERs PROFILETYPE AND TEMPLATES SYNCRONIZATION FAILED');
        	        
        $mainframe->redirect(XiptRoute::_("index.php?option=com_xipt&view=setup&task=display",false),$msg);
    }
    
    /**
     * this functions migrate all JSPT 1.4.xxx avatars
     * to JSPT 2.0.xx version
     */
    function migrateAvatar()
    {
    	//Migrate Avatars
		$imgPrefix 			= 'avatar_';
		$storage			= PROFILETYPE_AVATAR_STORAGE_PATH;
		
		//here check if folder exist or not ? if not then create it.
		if(JFolder::exists($storage)==false)
			JFolder::create($storage);
		
		$profiletypes = XiptLibProfiletypes::getProfiletypeArray();
		
		if(!$profiletypes)		
			return;
			
		//get avatars of all profileype 
		foreach($profiletypes as $profiletype)
		{
			$pId 	= $profiletype->id;
			$avatar = $profiletype->avatar;

			//if avatar is default then skip
			if($avatar == DEFAULT_AVATAR)
				continue;
			
			//create proper names 
			$type = JFile::getExt($avatar);
			$storageImage		= $storage. DS .$imgPrefix. $pId .".$type" ;
			$storageThumbnail	= $storage. DS .$imgPrefix. $pId ."_thumb.$type";
			$image				= PROFILETYPE_AVATAR_STORAGE_REFERENCE_PATH.DS .$imgPrefix. $pId .".$type" ;;			
			//if avatar is already in new format 
			if($avatar == $image)
				continue;
						
			$avatarThumb = XiptLibUtils::getThumbAvatarFromFull($avatar);
	
			//copy absolute files to new locations
			JFile::copy(JPATH_ROOT.DS.$avatar, 	  $storageImage);
			JFile::copy(JPATH_ROOT.DS.$avatarThumb,  $storageThumbnail);
			
			//IMP : First we need to update users. update all users of that profiletype
			$allUsers = XiptLibProfiletypes::getAllUsers($pId);
			if(!$allUsers)
				continue;

			$filter[] = 'avatar';
			$newData['avatar'] = $image;
			$oldData['avatar'] = $avatar;  
			foreach ($allUsers as $userid)
				XiptLibProfiletypes::updateUserProfiletypeFilteredData($userid, $filter, $oldData, $newData);
				
				
			//update database xipt_profiletypes
			//IMP : Store reference path only
			$db =& JFactory::getDBO();
			$query	= 'UPDATE ' . $db->nameQuote( '#__xipt_profiletypes' ) . ' '
	    			. 'SET ' . $db->nameQuote( 'avatar' ) . '=' . $db->Quote( $image ) . ' '
	    			. 'WHERE ' . $db->nameQuote( 'id' ) . '=' . $db->Quote( $pId );
	    	$db->setQuery( $query );
	    	$db->query( $query );
			if($db->getErrorNum())
				XiptError::raiseError( 500, $db->stderr());
		}
		
		global $mainframe;
		$msg = JText::_('AVATARS MIGRATED');
		$mainframe->redirect(XiptRoute::_("index.php?option=com_xipt&view=setup&task=display",false),$msg); 
    }
    
    function unhook()
    {
    	XiptHelperUnhook::uncopyHackedFiles();
		// disable plugins
		XiptHelperUnhook::disable_plugin('xipt_system');
		XiptHelperUnhook::disable_plugin('xipt_community');
		
		XiptHelperUnhook::disable_custom_fields();
		
		global $mainframe;
		$msg = JText::_('UNHOOKED SUCCESSFULLY');
		$mainframe->enqueueMessage($msg);
		$mainframe->redirect(XiptRoute::_("index.php?option=com_xipt&view=setup&task=display",false),$msg);
    }
    
    function enableAdminApproval()
    {
    	global $mainframe;
    	if(XiptHelperSetup::isPluginInstalledAndEnabled('xi_adminapproval','system')
			&& !XiptHelperSetup::isPluginInstalledAndEnabled('xi_adminapproval','system',true))
				$cEnabled = XiptHelperSetup::enablePlugin('xi_adminapproval');
				
		if($sEnabled && $cEnabled)
			$mainframe->enqueueMessage(JText::_("PLUGIN ENABLED SUCCESSFULLY"));
			
		$mainframe->redirect(XiptRoute::_("index.php?option=com_xipt&view=setup&task=display",false));
    }
    	
}
