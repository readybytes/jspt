<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
 
class XiPTControllerProfiletypes extends JController 
{
    
	function __construct($config = array())
	{
		parent::__construct($config);
		
		//registering some extra in all task list which we want to call
		$this->registerTask( 'orderup' , 'saveOrder' );
		$this->registerTask( 'orderdown' , 'saveOrder' );
	}
	
    function display() 
	{
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
		$data['name'] 		= $post['name'];
		$data['tip'] 		= $post['tip'];
		$data['published'] 	= $post['published']; 
		$data['template'] 	= $post['template'];
		$data['jusertype'] 	= $post['jusertype'];
		$data['privacy'] 	= $post['privacy'];
		$data['avatar'] 	= $post['avatar'];
		$data['approve'] 	= $post['approve'];
		$data['allowt'] 	= $post['allowt'];
		
		$row->bindAjaxPost($data);
		
		if( $isValid )
		{
			$parent			= '';
			$id = $row->store();
			// Get the view
			$view		=& $this->getView( 'profiletypes' , 'html' );
	
			if($id != 0)
			{
				/* Reset existing user's */
				if($post['resetAll'])
					XiPTHelperProfiletypes::resetAllUsers($row->id);
					
				$msg = JText::_('PROFILETYPE SAVED');
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
					$message	= JText::_('ERROR IN REMOVING PROFILETYPE');
					$mainframe->redirect( 'index.php?option=com_xipt&view=profiletypes' , $message);
					exit;
				}
				$i++;
			}
		}
				
		$cache = & JFactory::getCache('com_content');
		$cache->clean();
		$message	= $count.' '.JText::_('PROFILETYPE REMOVED');		
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
		$msg = sprintf(JText::_('ITEMS PUBLISHED'),$count);
		$link = JRoute::_('index.php?option=com_xipt&view=profiletypes', false);
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
		
		$pModel	= XiFactory::getModel( 'profiletypes' );
		foreach($ids as $id)
		{
			$pModel->updatePublish($id,0);
		}
		$msg = sprintf(JText::_('ITEMS UNPUBLISHED'),$count);
		$link = JRoute::_('index.php?option=com_xipt&view=profiletypes', false);
		$mainframe->redirect($link, $msg);
	}
	
	
	
/**	
	 * Save the ordering of the entire records.
	 *	 	
	 * @access public
	 *
	 **/	 
	function saveOrder()
	{
		global $mainframe;
	
		// Determine whether to order it up or down
		$direction	= ( JRequest::getWord( 'task' , '' ) == 'orderup' ) ? -1 : 1;

		// Get the ID in the correct location
 		$id			= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$db			=& JFactory::getDBO();

		if( isset( $id[0] ) )
		{
			$id		= (int) $id[0];

			// Load the JTable Object.
			$table	=& JTable::getInstance( 'profiletypes' , 'XiPTTable' );
			
			$table->load( $id );
			$table->move( $direction );

			$cache	=& JFactory::getCache( 'com_content');
			$cache->clean();
			
			$mainframe->redirect( 'index.php?option=com_xipt&view=profiletypes' );
		}
	}
	
}