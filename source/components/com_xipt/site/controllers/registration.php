<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class XiPTControllerRegistration extends JController {

	var $mySess;

	function __construct($config = array())
	{
		$this->mySess 	=& JFactory::getSession();
		parent::__construct($config);
	}

    function display()
	{
		global $mainframe;
		$redirectUrl = XiPTLibraryUtils::getReturnURL();

		// 	check for session, if does not exist redirect user to community page
		if(!$this->mySess){
			// session expired, redirect to community page
			$redirectUrl	= JRoute::_('index.php?option=com_community&view=register',false);
			$msg = JText::_('YOUR SESSION HAVE BEEN EXPIRED, PLEASE PERFORM THE OPERATION AGAIN');
			$mainframe->redirect($redirectUrl,$msg);
		}

		//If not allowed to select PT for user then return
		if(XiPTLibraryUtils::getParams('show_ptype_during_reg','com_xipt')==0){

		    // we need to set default things
			$selectedProfiletypeID= XiPTLibraryProfiletypes::getDefaultProfiletype();
			$this->mySess->set('SELECTED_PROFILETYPE_ID',$selectedProfiletypeID, 'XIPT');

			// redirect to correct page
			//$redirectUrl = XiPTLibraryUtils::getReturnURL();
			$msg = JText::_('USERS ARE NOT ALLOWED TO SELECT PROFILETYPES');
			$mainframe->redirect($redirectUrl,$msg);
		}



		//@XITODO : do some validation for visibility and publish of ptype
		if(JRequest::getVar('save', '', 'POST') != ''){

			$selectedProfiletypeID = JRequest::getVar( 'profiletypes' , 0 , 'POST' );

			// validate values
			if(!XiPTLibraryProfiletypes::validateProfiletype($selectedProfiletypeID)) {
				//$redirectUrl = XiPTLibraryUtils::getReturnURL();
				$msg = JText::_('PLEASE ENTER VALID PROFILETYPE');
				$mainframe->redirect($redirectUrl,$msg);
				return;
			}
			
			//set value in session and redirect to destination url
			$this->mySess->set('SELECTED_PROFILETYPE_ID',$selectedProfiletypeID, 'XIPT');
			//$retURL  = XiPTLibraryUtils::getReturnURL();
			$mainframe->redirect($redirectUrl);
		}

		$css		= JURI::root() . 'components/com_xipt/assets/style.css';

		$document	=& JFactory::getDocument();
		$document->addStyleSheet($css);

		// Get the view
		$viewName	= JRequest::getCmd( 'view' , 'registration' );
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		$view->display();
    }
}
