<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

//require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'profiletypes.php' );
//require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'xiptcore.php' );
 
class XiPTControllerProfiletypes extends JController {
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
		
		$viewName	= JRequest::getCmd( 'view' , 'profiletypes' );
		
		// Get the document object
		$document	=& JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();
		
		$view		=& $this->getView( $viewName , $viewType );
		$layout		= JRequest::getCmd( 'layout' , 'profiletypes.edit' );
		$view->setLayout( $layout );
		echo $view->edit($id);
		
	}
	
	function save()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$post	= JRequest::get('post');
		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		
		
		$user	=& JFactory::getUser();

		if ( $user->get('guest')) {
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return;
		}

		// Load the JTable Object.
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row	=& JTable::getInstance( 'profiletypes' , 'XiPTTable' );
		$row->load( $cid[0] );	
		$isValid	= true;
		
		$data = array();
		$data['name'] = $post['name'];
		$data['tip'] = $post['tip'];
		$data['published'] = $post['published']; 
		$data['template'] = $post['template'];
		$data['jusertype'] = $post['jusertype'];
		$data['privacy'] = $post['privacy'];
		$data['avatar'] = $post['avatar'];
		$data['approve'] = $post['approve'];
		$data['allowt'] = $post['allowt'];
		
		$row->bindAjaxPost($data);
		
		if( $isValid )
		{
			$parent			= '';
			$oldGroupId		=0;	
			// store old group first
			$oldGroupId = XiPTHelperProfiletypes::getProfileTypeData($id,'group');
			$id = $row->store();
			// Get the view
			$view		=& $this->getView( 'profiletypes' , 'html' );
	
			if($id != 0)
			{
				/* Fix existing user's group */
				if($post['resetAll'])
					XiPTHelperProfiletypes::addAllExistingUserToProperGroups($id,$row->group,$oldGroupId);
					
				$msg = JText::_('Profiletype Saved');
			}
		}
		$link = JRoute::_('index.php?option=com_xipt&view=profiletypes', false);
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
		$row	=& JTable::getInstance( 'profiletypes' , 'XiPTTable' );
		$i = 1;
		if(!empty($ids))
		{
			foreach( $ids as $id )
			{
				$row->load( $id );
				if(!$row->delete( $id ))
				{
					// If there are any error when deleting, we just stop and redirect user with error.
					$message	= JText::_('Error in removing list');
					$mainframe->redirect( 'index.php?option=com_xipt&view=profiletypes' , $message);
					exit;
				}
				$i++;
			}
		}
				
		$cache = & JFactory::getCache('com_content');
		$cache->clean();
		$message	= $count.' '.JText::_('Profiletype Removed');		
		$link = JRoute::_('index.php?option=com_xipt&view=profiletypes', false);
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
		
		$pModel	= XiFactory::getModel( 'profiletypes' );
		foreach($ids as $id)
		{
			$pModel->updatePublish($id,1);
		}
		$msg = JText::sprintf( $count.' Items published' );
		$link = JRoute::_('index.php?option=com_xipt&view=profiletypes', false);
		$mainframe->redirect($link, $msg);	}
	
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
		
		$pModel	= XiFactory::getModel( 'profiletypes' );
		foreach($ids as $id)
		{
			$pModel->updatePublish($id,0);
		}
		$msg = JText::sprintf( $count.' Items unpublished' );
		$link = JRoute::_('index.php?option=com_xipt&view=profiletypes', false);
		$mainframe->redirect($link, $msg);
	}
	
}