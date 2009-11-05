<?php
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
		//@TODO : do some validation for visibility and publish of ptype
		if(JRequest::getVar('save', '', 'POST') == 'save'){
			
			$selectedProfiletypeID = JRequest::getVar( 'profiletypes' , 'XIPT_NOT_DEFINED' , 'POST' );
			//set value in session and redirect to destination url
			
			if($selectedProfiletypeID != 'XIPT_NOT_DEFINED') {
				
				$this->mySess->set('SELECTED_PROFILETYPE_ID',$selectedProfiletypeID, 'XIPT');
				$retURL = $this->mySess->get('RETURL', 'XIPT_NOT_DEFINED', 'XIPT');
				if($retURL != 'XIPT_NOT_DEFINED')
				{
					$retURL	= $retURL ? base64_decode($retURL) : 'index.php';
					$mainframe->redirect($retURL);
				}
				
				$selectedpTypeName = XiPTLibraryProfiletypes::getProfileTypeNameFromID($selectedProfiletypeID);
				
				$msg = JTEXT::_("PROFILETYPE ".$selectedpTypeName." SAVED");
				$mainframe->enqueueMessage($msg);
			}
		}

		$viewName	= JRequest::getCmd( 'view' , 'registration' );
		
		// Get the document object
		$document	=& JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();
		
		$view		=& $this->getView( $viewName , $viewType );
		
		$params = JComponentHelper::getParams('com_xipt');
		
		//$view->assign('error', $this->getError());
		$view->display();
		
    }
}