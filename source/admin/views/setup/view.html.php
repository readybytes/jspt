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
		$setupNames = XiptSetupHelper::getOrder();
		
		//for each file check that setup is required or not & get message a/c to this.
		foreach($setupNames as $setup)
		{
			//get object of class
			$setupObject = XiptFactory::getSetupObject($setup);
			
			if($setupObject->isApplicable())
			{
				$data = $setupObject->getMessage();
			
				// if we are checking setup for watermark,we will show warning
				if($setup === 'watermark')
					$warnings = $data;
				else
				{
					$requiredSetup[$setup]['done'] 	  = $data['done'];
					$requiredSetup[$setup]['message'] = $data['message'];
				}
			}
		}

		// to check that setup screen is clean or not
		$cleanUp=true;
		$mysess = JFactory::getSession();
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
			 	 
	function setToolBar()
	{
		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'Setup' ), 'setup' );
	}
	
	
}
