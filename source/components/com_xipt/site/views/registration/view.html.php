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
  		
    	$profileTypeHtml = XiPTLibraryProfiletypes::getProfiletypeFieldHTML(0);
    	$this->assign( 'profileTypeHtml' , $profileTypeHtml );
		parent::display( $tpl );
    }
}
?>