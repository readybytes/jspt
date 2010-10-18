<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
jimport( 'joomla.application.component.controller' );

abstract class XiptController extends JController
{
	public function getPrefix()
	{
		if(isset($this->_prefix) && empty($this->_prefix)===false)
			return $this->_prefix;

		$r = null;
		if (!preg_match('/(.*)Controller/i', get_class($this), $r)) {
			XiError::raiseError (500, "XiptController::getName() : Can't get or parse class name.");
		}

		$this->_prefix  =  JString::strtolower($r[1]);
		return $this->_prefix;
	}

	function getName()
	{
		$name = $this->_name;

		if (empty( $name ))
		{
			$r = null;
			if (!preg_match('/Controller(.*)/i', get_class($this), $r)) {
				XiptError::raiseError (500, "XiusController : Can't get or parse class name.");
			}
			$name = strtolower( $r[1] );
		}

		return $name;
	}

	public function getView()
	{
//		if(isset($this->_view))
//			return $this->_view;

		//get Instance from Factory
		$this->_view	= 	XiptFactory::getInstance($this->getName(),'View', $this->getPrefix());
		$layout	= JRequest::getCmd( 'layout' , 'default' );
		$this->_view->setLayout( $layout );
		return $this->_view;
	}

	/**
	 * Get an object of controller-corresponding Model.
	 * @return XiptModel
	 */
	public function getModel($modelName=null)
	{
		// support for parameter
		if($modelName===null)
			$modelName = $this->getName();

		return XiptFactory::getInstance($modelName,'Model');
	}
	
	function publish($ids=array(0))
	{
		$ids		= JRequest::getVar('cid', $ids, 'post', 'array');
		$count		= count( $ids );

		if(!$this->getModel()->publish($ids)){
			XiptError::raiseWarning(500,JText::_('ERROR IN PUBLISHING ITEM'));
			return false;
		}
		
		$msg = sprintf(JText::_('ITEMS PUBLISHED'),$count);
		$link = XiptRoute::_('index.php?option=com_xipt&view='.$this->getName(), false);
		$this->setRedirect($link, $msg);	
		return true;		
	}
	
	function unpublish($ids=array(0))
	{
		$ids		= JRequest::getVar('cid', $ids, 'post', 'array');
		$count		= count( $ids );

		if(!$this->getModel()->unpublish($ids)){
			XiptError::raiseWarning(500,JText::_('ERROR IN UNPUBLISHING ACLRULES'));
			return false;
		}
		
		$msg = sprintf(JText::_('ITEMS UNPUBLISHED'),$count);
		$link = XiptRoute::_('index.php?option=com_xipt&view='.$this->getName(), false);
		$this->setRedirect($link, $msg);	
		return true;		
	}
	
	/**	
	 * Save the ordering of the entire records.
	 *	 	
	 * @access public
	 *
	 **/	 
	function saveOrder($ids=array(),$task='')
	{		
		// Get the ID in the correct location
 		$ids	= JRequest::getVar( 'cid', $ids, 'post', 'array' );
 		XiptError::assert(!empty($ids));
		$id	= (int) array_shift($ids);
		
		// Determine whether to order it up or down
		$direction	= ( JRequest::getWord( 'task' , $task ) == 'orderup' ) ? -1 : 1;
			
		$this->getModel()->order($id, $direction);
		$this->setRedirect(XiptRoute::_('index.php?option=com_xipt&view='.$this->getName(), false));
	}
	
	function execute( $task )
	{
		parent::execute($task);
		if(JFactory::getApplication()->isAdmin() == true)		
			include_once(XIPT_ADMIN_PATH_VIEWS.DS.'cpanel'.DS.'tmpl'.DS.'default_footermenu.php');
	}	
}

