<?php
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
			
		$mainframe->redirect(JRoute::_("index.php?option=com_xipt&view=setup&task=display",false));
    }
    
    
    function createprofiletypes()
    {
    	global $mainframe;
    	$mainframe->redirect(JRoute::_("index.php?option=com_xipt&view=profiletypes&task=edit",false));
    }
    
    function installplugin()
    {
    	global $mainframe;
    	$mainframe->redirect(JRoute::_("index.php?option=com_installer",false));
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
			
		$mainframe->redirect(JRoute::_("index.php?option=com_xipt&view=setup&task=display",false));
    }
    	
    
    function patchfile()
    {
    	global $mainframe;
    	
    	if(!XiPTHelperSetup::checkFilePatchRequired())
    		$mainframe->redirect(JRoute::_("index.php?option=com_xipt&view=setup&task=display",false));

    	if(XiPTHelperSetup::isModelFilePatchRequired()){
    		$filename = JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'models'.DS.'profile.php';
    		
	    	//	CODREV : create a backup file first
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
    	
    	if(XiPTHelperSetup::isUserControllerPatchRequired()){
    		$filename = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_community'.DS.'controllers'.DS.'users.php';
    		
    		//	CODREV : create a backup file first
    	    if(!JFile::copy($filename, $filename.'.jxibak')){
    	    	global $mainframe;
    	    	$mainframe->enqueueMessage("NOT ABLE TO CREATE A BACKUP FILE CHECK PERMISSION");
    	    	return false;
    	    }
    		
	    	$funcName = 'function save()';
	    	
	    	$searchString = '$model->saveProfile($userId , $values);';
	    	ob_start();
	    	?>$model->saveProfile($userId , $values);
	    	
	    	/*==============HACK TO RUN JSPT CORRECTLY :START ============================*/
	    	$appsLib	=& CAppPlugins::getInstance();
	    	$appsLib->loadApplications();
	    	$args 	= array();
	    	$args[]	= $userId;
	    	$args[]	= true;
	    	$result = $appsLib->triggerEvent( "onAfterProfileUpdate" , $args );
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
        	$filename	= dirname( JPATH_BASE ) . DS. 'components' . DS . 'com_community'
        					.DS.'libraries'.DS.'fields'.DS.'customfields.xml';
        	if (file_exists($filename)) {
		
				if(!is_readable($filename)) 
					JError::raiseWarning(sprintf(JText::_('FILE IS NOT READABLE PLEASE CHECK PERMISSION'),$filename));
				
				$file = file_get_contents($filename);				
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
		        
	        	//	CODREV : create a backup file first
	    	    if(!JFile::copy($filename, $filename.'.jxibak')){
	    	    	global $mainframe;
	    	    	$mainframe->enqueueMessage("NOT ABLE TO CREATE A BACKUP FILE CHECK PERMISSION");
	    	    	return false;
	    	    }
	    	    
	    	    file_put_contents($filename,$file);
	        	 	
        	}
        }
        $msg = JText::_('FILES PATCHED SUCCESSFULLY');
        $mainframe->redirect(JRoute::_("index.php?option=com_xipt&view=setup&task=display",false),$msg);
    	
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
        
        $mainframe->redirect(JRoute::_("index.php?option=com_xipt&view=setup&task=display",false),$msg);
    }
    
	function syncUpUserPT()
    {
    	global $mainframe;    	   	
        //now check library field exist
      	if(XiPTHelperSetup::syncUpUserPT())
        	$msg = JText::_('USERs PROFILETYPE AND TEMPLATES SYNCRONIZED SUCCESSFULLY');
        else
        	$msg = JText::_('USERs PROFILETYPE AND TEMPLATES SYNCRONIZATION FAILED');
        	        
        $mainframe->redirect(JRoute::_("index.php?option=com_xipt&view=setup&task=display",false),$msg);
    }
    
}