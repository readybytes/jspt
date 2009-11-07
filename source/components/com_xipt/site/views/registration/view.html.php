<?php
/**
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'profiletypes.php');
// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiPTViewRegistration extends JView 
{
    function display($tpl = null){
  		
    	$seletedPTypeID = JRequest::getVar('ptypeid','');
    	$profileTypes = XiPTLibraryProfiletypes::getSelectedProfileTypesArray($seletedPTypeID);
    	$this->assign( 'profileTypes' , $profileTypes );
		parent::display( $tpl );
    }
}
