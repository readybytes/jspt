<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
defined('_JEXEC') or die('Restricted access');
 
class XiPTControllerApplications extends JController 
{
    
	function __construct($config = array())
	{
		parent::__construct($config);
	}
	
    function display() 
	{
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
		
		if(!array_key_exists('profileTypes0',$post))
		{
			foreach($allTypes as $type)
			{
				if($type)
				{
					if(!array_key_exists('profileTypes'.$type,$post))
					{
						  XiPTHelperApplications::addApplicationProfileType($post['id'], $type);
					}
				}
			}
		}
		$msg = JText::_('APPLICATION SAVED');
		$link = XiPTRoute::_('index.php?option=com_xipt&view=Applications', false);
		$mainframe->redirect($link, $msg);
	}
}