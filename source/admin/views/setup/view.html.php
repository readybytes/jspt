<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');
class XiPTViewSetup extends JView 
{
    function display($tpl = null)
	{
		self::setToolBar();
		//@TODO : check whether custom field exitst or not
		//Default ptype exist or not
		//profiletypes exist or not
		//patch file 
			
		$requiredSetup = array();
		//check profiletype existance
		$ptypes = XiPTHelperProfiletypes::getProfileTypeArray();
		$link = XiPTRoute::_("index.php?option=com_xipt&view=setup&task=createprofiletypes",false);
		if(!$ptypes) {
			$requiredSetup['profiletypes']['message'] = '<a href="'.$link.'">'.JText::_("PLEASE CLICK HERE TO CREATE PROFILETYPES").'</a>';
			$requiredSetup['profiletypes']['done']  = false;
		}
		else {
			$requiredSetup['profiletypes']['message'] = JText::_("PROFILETYPE VALIDATION SUCCESSFULL");
			$requiredSetup['profiletypes']['done']  = true;
		}
			
		//check default profiletype
		$defaultProfiletypeID = XiPTLibraryUtils::getParams('defaultProfiletypeID', 0);
		$link = XiPTRoute::_("index.php?option=com_xipt&view=settings",false);
		if(!$defaultProfiletypeID || XiPTLibraryProfiletypes::validateProfiletype($defaultProfiletypeID)==false) {
			$requiredSetup['defaultprofiletype']['message'] = '<a href="'.$link.'">'.JText::_("PLEASE CLICK HERE TO SET DEFAULT PROFILETYPE").'</a>';
			$requiredSetup['defaultprofiletype']['done']  = false;
		}
		else {
			$requiredSetup['defaultprofiletype']['message'] = JText::_("DEFAULT PROFILETYPE EXIST");
			$requiredSetup['defaultprofiletype']['done']  = true;
		}
		
			
		//validate custom field
		$link = XiPTRoute::_("index.php?option=com_xipt&view=setup&task=createfields",false);
		if(XiPTHelperSetup::checkCustomfieldRequired()) {
			$requiredSetup['customfields']['message'] = '<a href="'.$link.'">'.JText::_("PLEASE CLICK HERE TO CREATE AND ENABLE CUSTOM FIELDS").'</a>';
			$requiredSetup['customfields']['done'] = false;
		}
		else {
			$requiredSetup['customfields']['message'] = JText::_("CUSTOM FIELDS EXIST");
			$requiredSetup['customfields']['done'] = true;
		}
		
		
		//check file patch up required or not
		$link = XiPTRoute::_("index.php?option=com_xipt&view=setup&task=patchfile",false);
		if(XiPTHelperSetup::checkFilePatchRequired()) {
			$requiredSetup['filepatch']['message'] = '<a href="'.$link.'">'.JText::_("PLEASE CLICK HERE TO PATCH FILES").'</a>';
			$requiredSetup['filepatch']['done'] = false;
		}
		else {
			$requiredSetup['filepatch']['message'] = JText::_("FILES ARE PATCHED");
			$requiredSetup['filepatch']['done'] = true;
		}
		
		//check plugins( community and system ) are installed
		$link = XiPTRoute::_("index.php?option=com_xipt&view=setup&task=installplugin",false);
		if(($msg = XiPTHelperSetup::checkPluginInstallationRequired())) {
			$requiredSetup['plugininstalled']['message'] = '<a href="'.$link.'">'.$msg.'</a>';
			$requiredSetup['plugininstalled']['done'] = false;
		}
		else {
			$requiredSetup['plugininstalled']['message'] = JText::_("PLUGINS ARE INSTALLED");
			$requiredSetup['plugininstalled']['done'] = true;
		}
		
		
		//check plugins( community and system ) are enabled
		$link = XiPTRoute::_("index.php?option=com_xipt&view=setup&task=enableplugin",false);
		if(XiPTHelperSetup::checkPluginEnableRequired()) {
			$requiredSetup['pluginenabled']['message'] = '<a href="'.$link.'">'.JText::_("PLEASE CLICK HERE TO ENABLE PLUGIN").'</a>';
			$requiredSetup['pluginenabled']['done'] = false;
		}
		else {
			$requiredSetup['pluginenabled']['message'] = JText::_("PLUGINS ARE ENABLED");
			$requiredSetup['pluginenabled']['done'] = true;
		}

		
			$link = XiPTRoute::_("index.php?option=com_xipt&view=setup&task=syncUpUserPT",false);
			if(XiPTHelperSetup::syncUpUserPTRequired()) {
				$requiredSetup['syncUpUserPT']['message'] = '<a href="'.$link.'">'.JText::_("PLEASE CLICK HERE TO SYNC UP USERS PROFILETYPES").'</a>';
				$requiredSetup['syncUpUserPT']['done'] = false;
			}
			else {
				$requiredSetup['syncUpUserPT']['message'] = JText::_("USERS PROFILETYPES ALREADY IN SYNC");
				$requiredSetup['syncUpUserPT']['done'] = true;
			}
		
			$link = XiPTRoute::_("index.php?option=com_xipt&view=setup&task=migrateAvatar",false);
			if(XiPTHelperSetup::migrateAvatarRequired()) {
				$requiredSetup['migrateAvatar']['message'] = '<a href="'.$link.'">'.JText::_("PLEASE CLICK HERE TO MIGRATE AVATARS").'</a>';
				$requiredSetup['migrateAvatar']['done'] = false;
			}
			else {
				$requiredSetup['migrateAvatar']['message'] = JText::_("AVATARS ALREADY MIGRATED");
				$requiredSetup['migrateAvatar']['done'] = true;
			}
			
			
		/*Display only if user have AEC installed*/
		if(XiPTLibraryAEC::_checkAECExistance()){
			
			$link = XiPTRoute::_("index.php?option=com_xipt&view=setup&task=patchAECfile",false);
			if(XiPTHelperSetup::isAECMIRequired()) {
				$requiredSetup['patchAECfile']['message'] = '<a href="'.$link.'">'.JText::_("PLEASE CLICK HERE TO INSTALL JSPT MI INTO AEC").'</a>';
				$requiredSetup['patchAECfile']['done'] = false;
			}
			else {
				$requiredSetup['patchAECfile']['message'] = JText::_("AEC MI ALREADY THERE");
				$requiredSetup['patchAECfile']['done'] = true;
			}
		}
		
	/* display the link if admin approvel is installed but not enabled */
	//XITODO : check if any profiletype have enbaled admin approval
		if(XiPTHelperSetup::isPluginInstalledAndEnabled('xi_adminapproval','system',false)){
			if(XiPTHelperSetup::isPluginInstalledAndEnabled('xi_adminapproval','system',true)==false)
				$warnings['enableAdminApproval']['message'] = JText::_("ADMIN APPROVAL PLUGIN IS INSTALLED BUT NOT ENABLE.");
			}
		
		if(XiPTHelperSetup::isWaterMarkingRequired())
				$warnings['enableWaterMarking']['message'] = JText::_("WATER MARKING IS NOT ENABLED IN SETTINGS BUT ENABLE FOR PROFILE TYPES.");
			
		// to check that setup screen is clean or not
		$cleanUp=true;
		$mysess = & JFactory::getSession();
		foreach($requiredSetup as $req)
		{
			if($req["done"]==false)
			{
				$cleanUp=false;
				$mysess->set('requireSetupCleanUp',true);
				break;
			}
		}
		if($cleanUp)
		{
			$mysess->set('requireSetupCleanUp',false);
		}
		
		jimport('joomla.html.pane');
		$pane	=& JPane::getInstance('sliders');
		
		$this->assignRef( 'pane', $pane );
		
		$this->assign('requiredSetup',$requiredSetup);
		if(isset($warnings))
			$this->assign('warnings',$warnings);
		
		parent::display( $tpl );
    }
		
	/**
	 * Private method to set the toolbar for this view
	 * 
	 * @access private
	 * 
	 * @return null
	 **/	 	 
	function setToolBar()
	{

		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'Setup' ), 'setup' );
	}
	
	
}
