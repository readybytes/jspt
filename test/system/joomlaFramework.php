<?php

define( '_JEXEC', 1 );
define( 'JPATH_BASE', dirname(dirname(dirname(__FILE__))));
define( 'DS', DIRECTORY_SEPARATOR );

require_once JPATH_BASE.DS.'includes'.DS.'defines.php';
require_once JPATH_BASE.DS.'includes'.DS.'framework.php';

// required in J 1.7
jimport('joomla.environment.request');

// Templates etc. are not available for the XMLRPC application, therefore this simple error handler
JError::setErrorHandling( E_ERROR,	 'echo' );
JError::setErrorHandling( E_WARNING, 'echo' );
JError::setErrorHandling( E_NOTICE,	 'echo' );

// Initalize frontend framework
$mainframe =& JFactory::getApplication('site');
$GLOBALS['mainframe']=$mainframe;
$_SERVER['HTTP_HOST'] = '';
$mainframe->initialise();

$uri	= JURI::getInstance();
$host	= $uri->getHost();

$version = new JVersion();

if($version->RELEASE==='1.5'){
	define('TEST_XIPT_JOOMLA_15', true);
	define('TEST_XIPT_JOOMLA_17', false);
}
else{
	define('TEST_XIPT_JOOMLA_15', false);
	define('TEST_XIPT_JOOMLA_17', true);
}

if(TEST_XIPT_JOOMLA_17){
	require_once JPATH_LIBRARIES.DS.'import.php';
	require_once JPATH_LIBRARIES.DS.'joomla'.DS.'environment'.DS.'request.php';
}
else{
	require_once JPATH_LIBRARIES.DS.'joomla'.DS.'import.php';
}

require_once JPATH_BASE .DS.'libraries'.DS.'joomla'.DS.'factory.php';
// Initalize frontend framework
JFactory::getApplication('site');

define('XIPT_TEST_MODE', true);

if(file_exists(JPATH_ROOT .DS.'components'.DS.'com_xipt'.DS.'includes.php')){
	require_once JPATH_ROOT .DS.'components'.DS.'com_xipt'.DS.'includes.php';
	require_once JPATH_ADMINISTRATOR .DS.'components'.DS.'com_xipt'.DS.'includes.php';
}