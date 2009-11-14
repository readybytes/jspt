<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiPTViewRegistration extends JView
{
	function display($tpl = null){

		//refine it, if empty will add default pType
		$seletedPTypeID 	= JRequest::getVar('ptypeid','');
		$allProfileTypes 	= XiPTLibraryProfiletypes::getProfiletypeArray();
		
		//TODO : trigger an API Event to add something to templates, or modify $profiletypes array
		// e.g. : I want to patch description. with some extra information
		
		$this->assign( 'allProfileTypes' , $allProfileTypes );
		$this->assign( 'selectedProfileTypeID' , $seletedPTypeID );
		
		parent::display( $tpl );
	}
}
