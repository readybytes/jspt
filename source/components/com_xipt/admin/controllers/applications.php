<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'xiptcore.php' );
require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'applications.php' );
 
class XiPTControllerApplications extends JController {
    /**
     * Constructor
     * @access private
     * @subpackage profilestatus
     */
	function __construct($config = array())
	{
		parent::__construct($config);
	}
	
    function display() {
		parent::display();
    }
	
	function edit()
	{
		$id = JRequest::getVar('editId', 0 , 'GET');
		
		$viewName	= JRequest::getCmd( 'view' , 'Applications' );
		
		// Get the document object
		$document	=& JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();
		
		$view		=& $this->getView( $viewName , $viewType );
		$layout		= JRequest::getCmd( 'layout' , 'Applications.edit' );
		$view->setLayout( $layout );
		echo $view->edit($id);
		
	}
	
	function save()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$post	= JRequest::get('post');
		//$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		//$post['id'] = (int) $cid[0];
		
		$user	=& JFactory::getUser();
		//print_r("application id =".$applicationId);
		if ( $user->get('guest')) {
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return;
		}

		//remove all rows related to specific plugin id 
		// cleaning all data for storing new profiletype with application
		XiPTHelperApplications::remMyApplicationProfileType($post['id']);
		
		$allTypes		= XiPTHelperApplications::getProfileTypeArrayforApplication();
		// Add ALL also
		$allTypes[] = 0;
		$profileTypeCount = count($allTypes)-1;
		//print_r("profileTypesCount = ".$profileTypesCount);
		
		if(!array_key_exists('profileTypes0',$post))
		{
			foreach($allTypes as $type)
			{
				if($type)
				{
					if(!array_key_exists('profileTypes'.$type,$post))
					{
						  // print_r("pid = ".$data['profileTypes'.$i]);
						  XiPTHelperApplications::addApplicationProfileType($post['id'], $type);
						  $msg = JText::_('APPLICATION SAVED');
					}
				}
			}
		}
		$link = JRoute::_('index.php?option=com_xipt&view=Applications', false);
		$mainframe->redirect($link, $msg);
	}
}