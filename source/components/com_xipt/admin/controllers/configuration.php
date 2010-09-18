<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');
 
class XiPTControllerConfiguration extends JController 
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
		$layout		= JRequest::getCmd( 'layout' , 'configuration.edit' );
		$view->setLayout( $layout );
		echo $view->edit($id);
		
	}
	
	function save()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
				
		$user	=& JFactory::getUser();

		if ( $user->get('guest')) {
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return;
		}
		$method	= JRequest::getMethod();
		
		if( $method == 'GET' )
		{
			JError::raiseError( 500 , JText::_('Access Method not allowed') );
			return;
		}
		
		$mainframe	=& JFactory::getApplication();		

		$cModel	=& XiFactory::getModel( 'configuration' );
		
		// Try to save configurations
		if( $cModel->save() )
		{
			$message	= JText::_('Configuration Updated');
		}
		else
		{
			JError::raiseWarning( 100 , JText::_( 'Unable to save configuration into database. Please ensure that the table jos_community_config exists' ) );
		}
		$link = XiPTRoute::_('index.php?option=com_xipt&view=configuration', false);
		$mainframe->redirect($link, $message);
	}
	
	function reset()
	{
		global $mainframe;
		
		$id	= JRequest::getVar( 'profileId','0','GET');
				
		$user	=& JFactory::getUser();

		if ( $user->get('guest')) {
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return;
		}
		
		$mainframe	=& JFactory::getApplication();		

		$cModel	=& XiFactory::getModel( 'configuration' );
		
		// Try to save configurations
		if( $cModel->reset($id) )
		{
			$message = JText::_('Profiletype has been Reset');
		}
		else
		{
			JError::raiseWarning( 100 , JText::_( 'Unable to reset profiletype into database. Please ensure that the table jos_xipt_profiletypes exists' ) );
		}
		$link = XiPTRoute::_('index.php?option=com_xipt&view=configuration', false);
		$mainframe->redirect($link, $message);
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
		$link = XiPTRoute::_('index.php?option=com_xipt&view=profiletypes', false);
		$mainframe->redirect($link, $message);
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

			$cache	=& JFactory::getCache( 'com_content');
			$cache->clean();
			
			$mainframe->redirect( 'index.php?option=com_xipt&view=profiletypes' );
		}
	}
	
}