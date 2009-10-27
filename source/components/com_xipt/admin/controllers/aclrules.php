<?php

// no direct access
defined('_JEXEC') or die('Restricted access');
 
require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'xiptcore.php' );
 
class XiPTControllerAclRules extends JController {
    /**
     * Constructor
     * @access private
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
		
		$viewName	= JRequest::getCmd( 'view');
		
		// Get the document object
		$document	=& JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();
		
		$view		=& $this->getView( $viewName , $viewType );
		$layout		= JRequest::getCmd( 'layout' , 'aclrules.edit' );
		$view->setLayout( $layout );
		echo $view->edit($id);
		
	}
	
	function save()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$post	= JRequest::get('post');
		
		$user	=& JFactory::getUser();

		if ( $user->get('guest')) {
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return;
		}
		
		$data = array();
		$data['rulename'] = $post['rulename'];
		$data['profiletype'] = $post['profiletype'];
		$data['otherprofiletype']= $post['otherprofiletype'];
		$data['feature'] = $post['feature'];
		$data['taskcount']	= $post['taskcount'];
		$data['redirecturl']	= $post['redirecturl'];
		$data['message']	= $post['message'];
		$data['published']		= $post['published'];
		
		// Load the JTable Object.
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row	=& JTable::getInstance( 'aclrules' , 'XiPTTable' );
		$row->load( $post['id'] );	
		$isValid	= true;
		$row->bindAjaxPost($data);

		
		if( $isValid )
		{
			$id = $row->store();
			$msg = JText::_('RULE SAVED');
		}

		$link = JRoute::_('index.php?option=com_xipt&view=aclrules', false);
		$mainframe->redirect($link, $msg);
	}
	

function remove()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$ids	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
	
		//$post['id'] = (int) $cid[0];
		$count	= count($ids);
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row	=& JTable::getInstance( 'aclrules' , 'XiPTTable' );
		$i = 1;
		if(!empty($ids))
		{
			foreach( $ids as $id )
			{
				$row->load( $id );
				if(!$row->delete( $id ))
				{
					// If there are any error when deleting, we just stop and redirect user with error.
					$message	= JText::_('ERROR IN REMOVING RULE');
					$mainframe->redirect( 'index.php?option=com_xipt&view=aclrules' , $message);
					exit;
				}
				$i++;
			}
		}
				
		$cache = & JFactory::getCache('com_content');
		$cache->clean();
		$message	= $count.' '.JText::_('RULE REMOVED');		
		$link = JRoute::_('index.php?option=com_xipt&view=aclrules', false);
		$mainframe->redirect($link, $message);
	}
	
	
	function publish()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		// Initialize variables
		$ids		= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$count			= count( $ids );

		if (empty( $ids )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
		
		$jaclModel	= XiFactory::getModel( 'aclrules' );
		foreach($ids as $id)
		{
			$jaclModel->updatePublish($id,1);
		}
		$msg = JText::sprintf( $count.' ITEMS PUBLISHED' );
		$link = JRoute::_('index.php?option=com_xipt&view=aclrules', false);
		$mainframe->redirect($link, $msg);
	}
	
	function unpublish()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		// Initialize variables
		$ids		= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$count			= count( $ids );

		if (empty( $ids )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
		
		$jaclModel	= XiFactory::getModel( 'aclrules' );
		foreach($ids as $id)
		{
			$jaclModel->updatePublish($id,0);
		}
		$msg = JText::sprintf( $count.' ITEMS UNPUBLISHED' );
		$link = JRoute::_('index.php?option=com_xipt&view=aclrules', false);
		$mainframe->redirect($link, $msg);
	}
	
	
	function cancel()
	{
		// Check for request forgeries
		global $mainframe;
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$mainframe->redirect( 'index.php?option=com_xipt&view=aclrules' );

	}
}