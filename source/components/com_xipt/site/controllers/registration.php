<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class XiPTControllerRegistration extends JController {
    /**
     * Constructor
     * @access private
     * @subpackage profilestatus
     */
	function __construct($config = array())
	{
		parent::__construct($config);
	}
	
    function display() 
	{
		if($_POST['save'])
		{
			//set value in session and redirect to destination url
			$mySess 	=& JFactory::getSession();
			$mySess->set('XI_PROFILETYPES',$_POST['profiletypes'], 'XIPT');
			global $mainframe;
			$mainframe->enqueueMessage("profieltype ".$_POST['profiletypes']." saved");
			$retURL = $mySess->get('RETURL', '', 'XIPT');
			if(!empty($retURL))
			{
				$retURL	= $retURL ? base64_decode($retURL) : 'index.php';
				$mainframe->redirect($retURL);
			}
		}
		$viewName	= JRequest::getCmd( 'view' , 'registration' );
		
		// Get the document object
		$document	=& JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();
		
		$view		=& $this->getView( $viewName , $viewType );
		
		$params = JComponentHelper::getParams('com_xipt');
		
		if(  $params->get('jspt_during_reg')==false || $params->get('jspt_show_radio')==false) 
			$profileTypeHtml="";
		$view->assign('error', $this->getError());
		$view->display();
		
		//parent::display();
    }
}