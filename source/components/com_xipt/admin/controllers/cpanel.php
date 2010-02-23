<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
 
class XiPTControllerCPanel extends JController 
{
  
	function __construct($config = array())
	{
		parent::__construct($config);
	}
	
    function display() 
	{
		parent::display();
    }
    
	function aboutus()
	{
		$viewName	= JRequest::getCmd( 'view' , 'cpanel' );
				// Get the document object
		$document	=& JFactory::getDocument();
		// Get the view type
		$viewType	= $document->getType();
	
		$view		=& $this->getView( $viewName , $viewType );

		$layout		= JRequest::getCmd( 'layout' , 'aboutus' );
		$view->setLayout( $layout );
		//echo parent::display();
		echo $view->aboutus();
	}
	
}
