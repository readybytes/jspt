<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
 
class XiptControllerSetup extends XiptController 
{
	//Need to override, as we dont have model
	public function getModel($modelName=null)
	{
		// support for parameter
		if($modelName===null || $modelName === $this->getName())
			return false;

		return parent::getModel($modelName);
	}
	
	
	function __construct($config = array())
	{
		parent::__construct($config);
	}
	
    function display() 
	{
		parent::display();
    }
    
    function doApply()
    {
    	global $mainframe;
    	$name = JRequest::getVar('name', '' );
    	
    	//get object of class
		$setupObject = XiptFactory::getSetupObject($name);
		$msg = $setupObject->doApply();
		
		$mainframe->redirect(XiptRoute::_("index.php?option=com_xipt&view=setup&task=display",false), $msg);
    }
    
    function unhook()
    {
    	//get all files required for setup
		$setupNames = XiptSetupHelper::getOrder();
		
		foreach($setupNames as $setup)
		{
			//get object of class
			$setupObject = XiptFactory::getSetupObject($setup);
			
			$setupObject->doRevert();
		}
		
//    	XiptHelperUnhook::uncopyHackedFiles();
//		// disable plugins
//		XiptHelperUnhook::disable_plugin('xipt_system');
//		XiptHelperUnhook::disable_plugin('xipt_community');
//		
//		XiptHelperUnhook::disable_custom_fields();
		
		global $mainframe;
		$msg = JText::_('UNHOOKED SUCCESSFULLY');
		$mainframe->redirect(XiptRoute::_("index.php?option=com_xipt&view=setup&task=display",false),$msg);
    }
}
