<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');
 
class XiPTControllerSetup extends JController 
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
		 
		if(!XiPTHelperSetup::checkExistanceOfCustomFields(TEMPLATE_CUSTOM_FIELD_CODE))
				$tFieldCreated = XiPTHelperSetup::createCustomField(TEMPLATE_CUSTOM_FIELD_CODE);
				
		if(!XiPTHelperSetup::checkExistanceOfCustomFields(PROFILETYPE_CUSTOM_FIELD_CODE))
				$pFieldCreated = XiPTHelperSetup::createCustomField(PROFILETYPE_CUSTOM_FIELD_CODE);

		//now check field enable required then enable field
		if(!XiPTHelperSetup::checkExistanceOfCustomFields(TEMPLATE_CUSTOM_FIELD_CODE,true))
				$tFieldEnabled = XiPTHelperSetup::enableField(TEMPLATE_CUSTOM_FIELD_CODE);
				
		if(!XiPTHelperSetup::checkExistanceOfCustomFields(PROFILETYPE_CUSTOM_FIELD_CODE,true))
				$pFieldEnabled = XiPTHelperSetup::enableField(PROFILETYPE_CUSTOM_FIELD_CODE);
				
		if($pFieldCreated && $tFieldCreated
			&& $pFieldEnabled && $tFieldEnabled)
			$mainframe->enqueueMessage(JText::_("CUSTOM FIELD CREATED AND ENABLED SUCCESSFULLY"));
			
		$mainframe->redirect(XiPTRoute::_("index.php?option=com_xipt&view=setup&task=display",false));
    }
    
    
    function createprofiletypes()
    {
    	global $mainframe;
    	$mainframe->redirect(XiPTRoute::_("index.php?option=com_xipt&view=profiletypes&task=edit",false));
    }
    
    function installplugin()
    {
    	global $mainframe;
    	$mainframe->redirect(XiPTRoute::_("index.php?option=com_installer",false));
    }
    
    
	function enableplugin()
    {
    	global $mainframe;
    	$sEnabled = true;
    	$cEnabled = true;
		 
		if(XiPTHelperSetup::isPluginInstalledAndEnabled('xipt_system','system')
			&& !XiPTHelperSetup::isPluginInstalledAndEnabled('xipt_system','system',true))
				$sEnabled = XiPTHelperSetup::enablePlugin('xipt_system');
				
		if(XiPTHelperSetup::isPluginInstalledAndEnabled('xipt_community','community')
			&& !XiPTHelperSetup::isPluginInstalledAndEnabled('xipt_community','community',true))
				$cEnabled = XiPTHelperSetup::enablePlugin('xipt_community');
				
		if($sEnabled && $cEnabled)
			$mainframe->enqueueMessage(JText::_("PLUGIN ENABLED SUCCESSFULLY"));
			
		$mainframe->redirect(XiPTRoute::_("index.php?option=com_xipt&view=setup&task=display",false));
    }
    	
    
    function patchfile()
    {
    	global $mainframe;
    	
    	if(!XiPTHelperSetup::checkFilePatchRequired())
    		$mainframe->redirect(XiPTRoute::_("index.php?option=com_xipt&view=setup&task=display",false));

    	if(XiPTHelperSetup::isModelFilePatchRequired()){
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
	    	require_once(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php');
	    	$pluginHandler=& XiPTFactory::getLibraryPluginHandler();
	    	$userId = 0;
	    	$pluginHandler->onProfileLoad($userId, $fields, __FUNCTION__);
	    	/*==============HACK TO RUN JSPT CORRECTLY : DONE ============================*/
	        <?php 
	        
	        $replaceString = ob_get_contents();
	        ob_end_clean();
	        
	        $success = XiPTHelperSetup::patchData($searchString,$replaceString,$filename,$funcName);
	        
	        //2. Replace data in getViewableProfile fn
	        $funcName =  'function getViewableProfile';
	        $searchString = '$result	= $db->loadAssocList();';
	    	ob_start();
	    	?>$result	= $db->loadAssocList();
	    	
	    	/*==============HACK TO RUN JSPT CORRECTLY :START ============================*/
			require_once(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php');
		    $pluginHandler=& XiPTFactory::getLibraryPluginHandler();
		    $pluginHandler->onProfileLoad($userId, $result, __FUNCTION__);
		    /*==============HACK TO RUN JSPT CORRECTLY : DONE ============================*/
	        <?php 
	        
	        $replaceString = ob_get_contents();
	        ob_end_clean();
	        
	        $success = XiPTHelperSetup::patchData($searchString,$replaceString,$filename,$funcName);
	        
	        
	        //3. Replace data in getEditablePRofile function
	        $funcName =  'function getEditableProfile';
	        $success = XiPTHelperSetup::patchData($searchString,$replaceString,$filename,$funcName);
	        
    	}

    	// we need to patch Model:User in backend also for editing
    	if(XiPTHelperSetup::isAdminUserModelPatchRequired()){
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
			require_once(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php');
		    $pluginHandler=& XiPTFactory::getLibraryPluginHandler();
		    $pluginHandler->onProfileLoad($userId, $result, __FUNCTION__);
		    /*==============HACK TO RUN JSPT CORRECTLY : DONE ============================*/
	        <?php 
	        
	        $replaceString = ob_get_contents();
	        ob_end_clean();
	        
	        $success = XiPTHelperSetup::patchData($searchString,$replaceString,$filename,$funcName);
    	}
        
        //now check library field exist
        if(XiPTHelperSetup::isCustomLibraryFieldRequired()){
        	//copy library field files into community // libraries // fields folder
        	XiPTHelperSetup::copyLibraryfiles();
        }
        
        
        //now check XML File patch required
        if(XiPTHelperSetup::isXMLFilePatchRequired()) {
        	//give patch data fn file to patch
        	$filename	= JPATH_ROOT . DS. 'components' . DS . 'com_community'
        					.DS.'libraries'.DS.'fields'.DS.'customfields.xml';
        	if (JFile::exists($filename)) {
		
				if(!is_readable($filename)) 
					JError::raiseWarning(sprintf(JText::_('FILE IS NOT READABLE PLEASE CHECK PERMISSION'),$filename));
				
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
        $mainframe->redirect(XiPTRoute::_("index.php?option=com_xipt&view=setup&task=display",false),$msg);
    	return true;
    }
    
	function patchAECfile()
    {
    	global $mainframe;    	   	
        //now check library field exist
        if(XiPTHelperSetup::isAECMIRequired()){
        	if(XiPTHelperSetup::copyAECfiles())
        		$msg = JText::_('AEC MI COPIED SUCCESSFULLY');
        	else
        		$msg = JText::_('AEC MI COPY FAILED');
        }
        else
        	$msg = JText::_('AEC MI ALREADY EXIST');
        
        $mainframe->redirect(XiPTRoute::_("index.php?option=com_xipt&view=setup&task=display",false),$msg);
    }
    
	function syncUpUserPT()
    {
    	global $mainframe;    	   	
        //now check library field exist
        $start=JRequest::getVar('start', 0, 'GET');
		$limit=JRequest::getVar('limit',SYNCUP_USER_LIMIT, 'GET');
      	if(XiPTHelperSetup::syncUpUserPT($start,$limit))
        	$msg = JText::_('USERs PROFILETYPE AND TEMPLATES SYNCRONIZED SUCCESSFULLY');
        else
        	$msg = JText::_('USERs PROFILETYPE AND TEMPLATES SYNCRONIZATION FAILED');
        	        
        $mainframe->redirect(XiPTRoute::_("index.php?option=com_xipt&view=setup&task=display",false),$msg);
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
		
		$profiletypes = XiPTLibraryProfiletypes::getProfiletypeArray();
		
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
						
			$avatarThumb = XiPTLibraryUtils::getThumbAvatarFromFull($avatar);
	
			//copy absolute files to new locations
			JFile::copy(JPATH_ROOT.DS.$avatar, 	  $storageImage);
			JFile::copy(JPATH_ROOT.DS.$avatarThumb,  $storageThumbnail);
			
			//IMP : First we need to update users. update all users of that profiletype
			$allUsers = XiPTLibraryProfiletypes::getAllUsers($pId);
			if(!$allUsers)
				continue;

			$filter[] = 'avatar';
			$newData['avatar'] = $image;
			$oldData['avatar'] = $avatar;  
			foreach ($allUsers as $userid)
				XiPTLibraryProfiletypes::updateUserProfiletypeFilteredData($userid, $filter, $oldData, $newData);
				
				
			//update database xipt_profiletypes
			//IMP : Store reference path only
			$db =& JFactory::getDBO();
			$query	= 'UPDATE ' . $db->nameQuote( '#__xipt_profiletypes' ) . ' '
	    			. 'SET ' . $db->nameQuote( 'avatar' ) . '=' . $db->Quote( $image ) . ' '
	    			. 'WHERE ' . $db->nameQuote( 'id' ) . '=' . $db->Quote( $pId );
	    	$db->setQuery( $query );
	    	$db->query( $query );
			if($db->getErrorNum())
				JError::raiseError( 500, $db->stderr());
		}
		
		global $mainframe;
		$msg = JText::_('AVATARS MIGRATED');
		$mainframe->redirect(XiPTRoute::_("index.php?option=com_xipt&view=setup&task=display",false),$msg); 
    }
    
    function unhook()
    {
    	XiPTHelperUnhook::uncopyHackedFiles();
		// disable plugins
		XiPTHelperUnhook::disable_plugin('xipt_system');
		XiPTHelperUnhook::disable_plugin('xipt_community');
		
		XiPTHelperUnhook::disable_custom_fields();
		
		global $mainframe;
		$msg = JText::_('UNHOOKED SUCCESSFULLY');
		$mainframe->enqueueMessage($msg);
		$mainframe->redirect(XiPTRoute::_("index.php?option=com_xipt&view=setup&task=display",false),$msg);
    }
    
    function enableAdminApproval()
    {
    	global $mainframe;
    	if(XiPTHelperSetup::isPluginInstalledAndEnabled('xi_adminapproval','system')
			&& !XiPTHelperSetup::isPluginInstalledAndEnabled('xi_adminapproval','system',true))
				$cEnabled = XiPTHelperSetup::enablePlugin('xi_adminapproval');
				
		if($sEnabled && $cEnabled)
			$mainframe->enqueueMessage(JText::_("PLUGIN ENABLED SUCCESSFULLY"));
			
		$mainframe->redirect(XiPTRoute::_("index.php?option=com_xipt&view=setup&task=display",false));
    }
    	
}
