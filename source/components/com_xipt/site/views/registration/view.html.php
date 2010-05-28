<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiPTViewRegistration extends JView
{
	function display($tpl = null)
	{
    	//   refine it, if empty will add default pType
    	$allProfileTypes = array();
	    $seletedPTypeID 	= JRequest::getVar('ptypeid','');
	    
		//TODO : trigger an API Event to add something to templates, or modify $profiletypes array
		// e.g. : I want to patch description. with some extra information
		$filter = array('published'=>1);
	    $allProfileTypes = XiPTLibraryProfiletypes::getProfiletypeArray($filter);
	    
		
		$this->assign( 'allProfileTypes' , $allProfileTypes );
		$this->assign( 'selectedProfileTypeID' , $seletedPTypeID );
		$params = JComponentHelper::getParams('com_xipt');
		$this->assign( 'showAsRadio' , $params->get('jspt_show_radio',true));
		
		parent::display( $tpl );
	}
}
