<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined('_JEXEC') or die('Restricted access');

class XiPTControllerAclRules extends JController 
{
   
	function __construct($config = array())
	{
		parent::__construct($config);
	}
	
    function display() 
    {
		parent::display();
    }
    

    function add()
	{
		$viewName	= JRequest::getCmd( 'view' , 'aclRules' );
		
		// Get the document object
		$document	=& JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();
		
		$view		=& $this->getView( $viewName , $viewType );
		
		$layout		= JRequest::getCmd( 'layout' , 'acl.add' );
			
		$view->setLayout( $layout );

		echo $view->add();
	}
	
	
	function renderacl()
	{
		$id = JRequest::getVar('editId', 0 );
		$acl = JRequest::getVar('acl', 0 ) ;
		
		$viewName	= JRequest::getCmd( 'view' , 'aclRule' );
		
		// Get the document object
		$document	=& JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();
		
		$view		=& $this->getView( $viewName , $viewType );
		
		if(!$acl && !$id) {
			$layout		= JRequest::getCmd( 'layout' , 'acl.add' );
			$view->setLayout( $layout );
			echo $view->add();
			return;
		}
		
		$data = array();
		$data['id'] = $id;
		
		if($acl) {
			$aclObject = aclFactory::getAclObject($acl);
			$aclObject->load($id);
			$data = $aclObject->getObjectInfoArray();
		}
		
		
		if($id){
			
			$aclObject = aclFactory::getAclObjectFromId($id);
			if(!$aclObject) {
				$layout		= JRequest::getCmd( 'layout' , 'acl.add' );
				$view->setLayout( $layout );
				echo $view->add();
				return;
			}
					
			$aclObject->load($id);
			$data = $aclObject->getObjectInfoArray();
		}
		
		$layout		= JRequest::getCmd( 'layout' , 'aclrules.edit' );
		$view->setLayout( $layout );
		echo $view->renderacl($data);
	}
	
	
	function processSave()
	{
		//save aclparam and core param in individual columns
		// Test if this is really a post request
		$method	= JRequest::getMethod();
		$id = JRequest::getVar('editId', 0 );
		if( $method == 'GET' )
		{
			JError::raiseError( 500 , JText::_('ACCESS METHOD NOT ALLOWED') );
			return;
		}
		
		$mainframe	=& JFactory::getApplication();

		$post	= JRequest::get('post');
		
		jimport('joomla.filesystem.file');

		$aclTable	=& JTable::getInstance( 'aclrules' , 'XiPTTable' );
		$aclTable->load($post['id']);
				
		$data = array();
		
		$registry	=& JRegistry::getInstance( 'xipt' );
		$registry->loadArray($post['coreparams'],'xipt_coreparams');
		// Get the complete INI string
		$data['coreparams']	= $registry->toString('INI' , 'xipt_coreparams' );
		
		$data['id'] 			= $post['id'];
		$data['aclname'] 		= $post['aclname'];
		$data['rulename']	 	= $post['rulename'];
		$data['published'] 		= $post['published'];
		
		unset($post['id']);
		unset($post['rulename']);
		unset($post['aclname']);
		unset($post['published']);
		unset($post['coreparams']);
		
		$aclObject = aclFactory::getAclObject($data['aclname']);
		$data['aclparams'] = $aclObject->collectParamsFromPost($post);
		
		
		$aclTable->bind($data);
		$data = array();
		// Save it
		if(! ($data['id'] = $aclTable->store()) )
			$data['msg'] = JText::_('ERROR IN SAVING RULE');
		else
			$data['msg'] = JText::_('RULE SAVED');	

		return $data;
	}
	
	function save()
	{
		$data = $this->processSave();
		$link = XiPTRoute::_('index.php?option=com_xipt&view=aclrules', false);
		$mainframe	=& JFactory::getApplication();
		$mainframe->redirect($link, $data['msg']);		
		
	}
	
	function apply()
	{
		$data = $this->processSave();
		$link = XiPTRoute::_('index.php?option=com_xipt&view=aclrules&task=renderacl&editId='.$data['id'], false);
		$mainframe	=& JFactory::getApplication();
		$mainframe->redirect($link, $data['msg']);				
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
		$link = XiPTRoute::_('index.php?option=com_xipt&view=aclrules', false);
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
		
		$aclModel	= XiFactory::getModel( 'aclrules' );
		foreach($ids as $id)
		{
			$aclModel->updatePublish($id,1);
		}
		$msg = JText::sprintf( $count.' ITEMS PUBLISHED' );
		$link = XiPTRoute::_('index.php?option=com_xipt&view=aclrules', false);
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
		
		$aclModel	= XiFactory::getModel( 'aclrules' );
		foreach($ids as $id)
		{
			$aclModel->updatePublish($id,0);
		}
		$msg = JText::sprintf( $count.' ITEMS UNPUBLISHED' );
		$link = XiPTRoute::_('index.php?option=com_xipt&view=aclrules', false);
		$mainframe->redirect($link, $msg);
		return true;
	}
		
}
