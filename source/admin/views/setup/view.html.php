<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
if(!defined('_JEXEC')) die('Restricted access');

// Import Joomla! libraries
class XiptViewSetup extends XiptView 
{
    function display($tpl = null)
	{
		$this->setToolBar();
			
		$requiredSetup = array();
		
		//get all files required for setup
		$setupRules = XiptSetupHelper::getOrderedRules();
		
		//for each file check that setup is required or not & get message a/c to this.
		foreach($setupRules as $setup)
		{
			//get object of class
			$setupObject = XiptFactory::getSetupRule($setup['name']);
			$helpMsg[$setup['name']] = $setupObject->getHelpMsg($setup['name']);
			
			if(!$setupObject->isApplicable())
				continue;
				
			$data = $setupObject->getMessage();
			$requiredSetup[$setup['name']]['done'] 	  = $data['done'];
			$requiredSetup[$setup['name']]['message'] = $data['message'];
			$requiredSetup[$setup['name']]['type']	  = $setup['type'];	
		}

		// to check that setup screen is clean or not		
		$mysess = JFactory::getSession();
		$mysess->set('requireSetupCleanUp',false);
		foreach($requiredSetup as $req)
		{
			if($req["done"]==false){
				$mysess->set('requireSetupCleanUp',true);
				break;
			}
		}
		
		$pane	=& JPane::getInstance('sliders');
		$this->assignRef( 'pane', 		$pane );
				
		$this->assign('requiredSetup',	$requiredSetup);
		$this->assign('helpMsg',		$helpMsg);
		$this->assign('setupRules',		$setupRules);
		
		parent::display( $tpl );
    }
			 	 
	function setToolBar()
	{
		// Set the titlebar text
		JToolBarHelper::title( XiptText::_( 'Setup' ), 'setup' );
		JToolBarHelper::custom('unhook','unhook','',XiptText::_('UNHOOK'),0,0);
	}
	
	
}
