<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
require_once JPATH_SITE.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php';


	if(JRequest::getCmd('view') == '') {
	            JRequest::setVar('view', 'registration');
	}

	$controller	= JRequest::getCmd( 'view');

	if( !empty( $controller ) )
	{
		$controller	= JString::strtolower( $controller );
		$path		= JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'controllers'.DS.$controller.'.php';
	
		// Test if the controller really exists
		if( JFile::exists( $path ) )
			require_once( $path );
		else
			JError::raiseError( 500 , JText::_( 'Invalid Controller. File does not exists in this context.' ) );
	}
	
	$class	= 'XiPTController'. JString::ucfirst( $controller ) ;
	
	// Test if the object really exists in the current context
	if(class_exists($class))
		$controller	= new $class();
	else
		JError::raiseError( 500 , JText::_('Invalid Controller Object.Class definition does not exists in this context') );
	
	// Perform the Request task
	$task = JRequest::getCmd('task');
	
	if($task == '')
	{
		JRequest::setVar('task', 'display');
		$task='display';
	}
	
	// Task's are methods of the controller. Perform the Request task
	$controller->execute( $task );
	
	// Redirect if set by the controller
	//$controller->redirect();
