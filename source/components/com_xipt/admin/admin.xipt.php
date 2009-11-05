<?php
/**
 *
 //@TODO : Include all helper files or other files in one common file and include that file
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

//Import Joomla Dependency
jimport( 'joomla.application.component.controller' );
jimport('joomla.application.component.model');

// add include files
require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php';

	if(JRequest::getCmd('view') == '') {
	            JRequest::setVar('view', 'profiletypes');
	}

	$controller	= JRequest::getCmd( 'view');

	if(!empty( $controller )){
		$controller	= JString::strtolower( $controller );
		$path		= JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'controllers'.DS.$controller.'.php';
	
		// Test if the controller really exists
		if(file_exists($path))
			require_once( $path );
		else
			JError::raiseError( 500 , JText::_( 'Invalid Controller. File does not exists in this context.' ) );
	}
	
	$class	= 'XiPTController' . JString::ucfirst( $controller );
	
	// Test if the object really exists in the current context
	if( class_exists( $class ) )
		$controller	= new $class();
	else
		JError::raiseError( 500 , 'Invalid Controller Object. Class definition does not exists in this context.' );
	
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