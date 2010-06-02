<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
*@TODO : Include all helper files or other files in one common file and include that file
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

//Import Joomla Dependency
jimport( 'joomla.application.component.controller' );
jimport('joomla.application.component.model');

// add include files
require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php';

	if(JRequest::getCmd('view') == '') {
	            JRequest::setVar('view', 'cpanel');
	}

	$controller	= JRequest::getCmd( 'view');

	if(!empty( $controller )){
		$controller	= JString::strtolower( $controller );
		$path		= JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'controllers'.DS.$controller.'.php';
	
		// Test if the controller really exists
		if(JFile::exists($path))
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
	
	$version = XiPTHelperSetup::get_js_version();
	
	global $mainframe;
	if(Jstring::stristr($version,'1.5'))
	{
		$msg = "ERROR : The JomSocial Version $version used by you is not supported for ProfileTypes.
				The JSPT 2.x.x release will only supports newer version of JomSocial since JomSocial 1.6.184.";
		$mainframe->enqueueMessage($msg,false);
	}
		
	// Task's are methods of the controller. Perform the Request task
	$controller->execute( $task );
	
	// Redirect if set by the controller
	//$controller->redirect();


//$controller->redirect();
