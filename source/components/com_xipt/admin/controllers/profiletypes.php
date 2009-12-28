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
		
		jimport('joomla.filesystem.file');
		jimport('joomla.utilities.utility');

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
		
		//for Reset we will save old Data
		$oldData = clone($row);
		
		$data = array();
		$data['name'] 		= $post['name'];
		$data['tip'] 		= JRequest::getVar( 'tip', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$data['published'] 	= $post['published']; 
		$data['template'] 	= $post['template'];
		$data['jusertype'] 	= $post['jusertype'];
		$data['privacy'] 	= $post['privacy'];
		$data['approve'] 	= $post['approve'];
		$data['allowt'] 	= $post['allowt'];
		$data['group'] 		= $post['group'];
		//$data['ordering']	= 0;
		
		$row->bindAjaxPost($data);

		
		/*$data['avatar'] 	= $post['avatar'];
		$data['watermark'] 	= $post['watermark'];*/
		
		if( $isValid )
		{
			$id = $row->store();	
			if($id != 0)
			{
				
				//call uploadImage function if post(image) data is set
				$fileAvatar		= JRequest::getVar( 'FileAvatar' , '' , 'FILES' , 'array' );
		
				if( isset( $fileAvatar['tmp_name'] ) && !empty( $fileAvatar['tmp_name'] ) )
					XiPTHelperProfiletypes::uploadAndSetImage($fileAvatar,$row->id,'avatar');
 


				$fileWatermark		= JRequest::getVar( 'FileWatermark' , '' , 'FILES' , 'array' );
		
				if( isset( $fileWatermark['tmp_name'] ) && !empty( $fileWatermark['tmp_name'] ) ) 
					XiPTHelperProfiletypes::uploadAndSetImage($fileWatermark,$row->id,'watermark');		

				// CODREV: If not uploaded data then by default save the previous values 
				$data['avatar'] 	= XiPTLibraryProfiletypes::getProfiletypeData($cid[0],'avatar');
				$data['watermark'] 	= XiPTLibraryProfiletypes::getProfiletypeData($cid[0],'watermark');
					
				/* Reset existing user's */
				if($post['resetAll'])
					XiPTHelperProfiletypes::resetAllUsers($row->id, $oldData, $data);
					
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

		$count = $i - 1;
		
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
		return true;
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
		return true;
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

		if( isset( $id[0] ) )
		{
			$id		= (int) $id[0];
			
			// Load the JTable Object.
			$table	=& JTable::getInstance( 'profiletypes' , 'XiPTTable' );
		
			$table->load( $id );
			$table->move( $direction );
			
			
			$mainframe->redirect( 'index.php?option=com_xipt&view=profiletypes' );
		}
	}
	
}
