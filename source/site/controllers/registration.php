<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class XiPTControllerRegistration extends JController {

	function __construct($config = array())
	{
		$this->mySess 	=& JFactory::getSession();
		parent::__construct($config);
	}

    function display()
	{
		//trigger event
		$dispatcher =& JDispatcher::getInstance();
		$dispatcher->trigger( 'onBeforeProfileTypeSelection');

		// 	check for session
        //  if does not exist redirect user to community page
		XiPTHelperProfiletypes::checkSessionForProfileType();

		//If not allowed to select PT for user then return
		if(XiPTLibraryUtils::getParams('show_ptype_during_reg')==0){
			$selectedProfiletypeID= XiPTLibraryProfiletypes::getDefaultProfiletype();
			XiPTHelperProfiletypes::setProfileTypeInSession($selectedProfiletypeID);
		}

		// do some validation for visibility and publish of ptype
		if(JRequest::getVar('save', '', 'POST') != ''){
			$selectedProfiletypeID = JRequest::getVar( 'profiletypes' , 0 , 'POST' );
			if(XiPTLibraryProfiletypes::validateProfiletype($selectedProfiletypeID,array('published'=>1,'visible'=>1)) == false)
			{
				global $mainframe;
				$msg = sprintf(JText::_('INVALID PROFILE TYPE SELECTED'),$count);
				$link = XiPTRoute::_('index.php?option=com_xipt&view=registration', false);
				$mainframe->redirect($link, $msg);	
			}
			$dispatcher->trigger( 'onAfterProfileTypeSelection',array(&$selectedProfiletypeID));			
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
