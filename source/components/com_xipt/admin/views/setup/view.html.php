<?php
/**
 *
 */

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
		$link = JRoute::_("index.php?option=com_xipt&view=setup&task=createprofiletypes",false);
		if(!$ptypes) {
			$requiredSetup['profiletypes']['message'] = '<a href="'.$link.'">'.JText::_("PLEASE CLICK HERE TO CREATE PRFOILETYPES").'</a>';
			$requiredSetup['profiletypes']['done']  = false;
		}
		else {
			$requiredSetup['profiletypes']['message'] = JText::_("PROFILETYPE VALIDATION SUCCESSFULL");
			$requiredSetup['profiletypes']['done']  = true;
		}
			
		//check default profiletype
		$params = JComponentHelper::getParams('com_xipt');
		$defaultProfiletypeID = $params->get('defaultProfiletypeID',0);
		$link = JRoute::_("index.php?option=com_config&controller=component&component=com_xipt",false);
		if(!$defaultProfiletypeID) {
			$requiredSetup['defaultprofiletype']['message'] = '<a  class="modal"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 600, y: 400}}">'.JText::_("PLEASE CLICK HERE TO SET DEFAULT PRFOILETYPE").'</a>';
			$requiredSetup['defaultprofiletype']['done']  = false;
		}
		else {
			$requiredSetup['defaultprofiletype']['message'] = JText::_("DEFAULT PROFILETYPE EXIST");
			$requiredSetup['defaultprofiletype']['done']  = true;
		}
		
			
		//validate custom field
		$link = JRoute::_("index.php?option=com_xipt&view=setup&task=createfields",false);
		if(XiPTHelperSetup::checkCustomfieldRequired()) {
			$requiredSetup['customfields']['message'] = '<a href="'.$link.'">'.JText::_("PLEASE CLICK HERE TO CREATE CUSTOM FIELDS").'</a>';
			$requiredSetup['customfields']['done'] = false;
		}
		else {
			$requiredSetup['customfields']['message'] = JText::_("CUSTOM FIELDS EXIST");
			$requiredSetup['customfields']['done'] = true;
		}
		
		
		//check file patch up required or not
		$link = JRoute::_("index.php?option=com_xipt&view=setup&task=patchfile",false);
		if(XiPTHelperSetup::checkFilePatchRequired()) {
			$requiredSetup['profilefilepatch']['message'] = '<a href="'.$link.'">'.JText::_("PLEASE CLICK HERE TO PATCH FILES").'</a>';
			$requiredSetup['profilefilepatch']['done'] = false;
		}
		else {
			$requiredSetup['profilefilepatch']['message'] = JText::_("FILES ARE PATCHED");
			$requiredSetup['profilefilepatch']['done'] = true;
		}
		
		
		//check plugins( community and system ) are installed
		$link = JRoute::_("index.php?option=com_xipt&view=setup&task=installplugin",false);
		if(($msg = XiPTHelperSetup::checkPluginInstallationRequired())) {
			$requiredSetup['plugininstalled']['message'] = '<a href="'.$link.'">'.$msg.'</a>';
			$requiredSetup['plugininstalled']['done'] = false;
		}
		else {
			$requiredSetup['plugininstalled']['message'] = JText::_("PLUGINS ARE INSTALLED");
			$requiredSetup['plugininstalled']['done'] = true;
		}
		
		
		//check plugins( community and system ) are enabled
		$link = JRoute::_("index.php?option=com_xipt&view=setup&task=enableplugin",false);
		if(XiPTHelperSetup::checkPluginEnableRequired()) {
			$requiredSetup['pluginenabled']['message'] = '<a href="'.$link.'">'.JText::_("PLEASE CLICK HERE TO ENABLE PLUGIN").'</a>';
			$requiredSetup['pluginenabled']['done'] = false;
		}
		else {
			$requiredSetup['pluginenabled']['message'] = JText::_("PLUGINS ARE ENABLED");
			$requiredSetup['pluginenabled']['done'] = true;
		}
		
		
		jimport('joomla.html.pane');
		$pane	=& JPane::getInstance('sliders');
		
		$this->assignRef( 'pane', $pane );
		
		
		$this->assign('requiredSetup',$requiredSetup);
		
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
