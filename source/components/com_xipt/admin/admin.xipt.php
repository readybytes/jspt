<?php
/**
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.controller' );

// Require the base controller
jimport('joomla.application.component.model');
JModel::addIncludePath(JPATH_BASE.DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'models');
JTable::addIncludePath( JPATH_BASE.DS.'administrator'.DS.'components'.DS.'com_xipt' . DS . 'tables' );

JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');

if(JRequest::getCmd('view') == '') {
            JRequest::setVar('view', 'profiletypes');
        }

$controller	= JRequest::getCmd( 'view');

	if( !empty( $controller ) )
	{
		$controller	= JString::strtolower( $controller );
		$path		= JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'controllers'.DS.$controller.'.php';
	
		// Test if the controller really exists
		if( file_exists( $path ) )
		{
			require_once( $path );
		}
		else
		{
			JError::raiseError( 500 , JText::_( 'Invalid Controller. File does not exists in this context.' ) );
		}
	}
	
	$class	= 'XiPTController' . JString::ucfirst( $controller );
	
	// Test if the object really exists in the current context
	if( class_exists( $class ) )
	{
		$controller	= new $class();
	}
	else
	{
		// Throw some errors if the system is unable to locate the object's existance
		JError::raiseError( 500 , 'Invalid Controller Object. Class definition does not exists in this context.' );
	}
	
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


//$controller->redirect();

?>