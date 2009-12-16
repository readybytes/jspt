<?php
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
	    
	    /*
	     * CODREV : in future we can use this
		$allParents 	= XiPTLibraryProfiletypes::getParentArray($seletedPTypeID,0,-1);
		$allChilds = XiPTLibraryProfiletypes::getChildArray($seletedPTypeID,0,1,true);
		$allProfileTypes = array_merge($allParents,$allChilds);
		
		$self = array();
		//add self also
		if($seletedPTypeID) {
	    	$self = XiPTLibraryProfiletypes::getProfiletypeArray(false,$seletedPTypeID);
	    	$allProfileTypes = array_merge($allProfileTypes,$self);
		}
		*/
	    
	    //CODREV : now on first level display only root level ptypes
		//then after click on any ptype display next level ptypes , if exist for selected ptype
		//TODO : trigger an API Event to add something to templates, or modify $profiletypes array
		// e.g. : I want to patch description. with some extra information
		$filter = array('published'=>1);
	    $allProfileTypes = XiPTLibraryProfiletypes::getProfiletypeArray($filter);
	    
	    //CODREV : get value from param if parent should be seletectable or not
	    $disableParent = true;
		
		$this->assign( 'allProfileTypes' , $allProfileTypes );
		$this->assign( 'selectedProfileTypeID' , $seletedPTypeID );
		$this->assign( 'disableParent' , $disableParent );
		$params = JComponentHelper::getParams('com_xipt');
		$this->assign( 'showAsRadio' , $params->get('jspt_show_radio',true));
		
		parent::display( $tpl );
	}
}
