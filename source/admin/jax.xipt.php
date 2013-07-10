<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined('_JEXEC') or die('Restricted access');

global $jaxFuncNames;
	if (!isset($jaxFuncNames) or !is_array($jaxFuncNames)) $jaxFuncNames = array();


$jaxFuncNames['xipt_entry'] = "";

$jaxFuncNames[] = 'applications,ajaxSwitch';

//
//// Dont process other plugin ajax definitions for back end
//if(!JString::stristr(JPATH_COMPONENT, 'administrator' . DS . 'components' . DS . 'com_community' ))
//{
//	// Include CAppPlugins library
//	require_once( JPATH_COMPONENT . DS . 'libraries' . DS . 'apps.php');
//
//	// Load Ajax plugins jax file.
//	CAppPlugins::loadAjaxPlugins();
//}


	/**
	 * Entry poitn for all ajax call
	 */
	function xiptAjaxEntry($func, $args = null)
	{
		// For AJAX calls, we need to load the language file manually.
		$lang =& JFactory::getLanguage();
		$lang->load( 'com_xipt' );
		echo "fsdfsf";
		$response = new JAXResponse();
		$output = '';

		// Built-in ajax calls go here
		$config		= array();
		$func		= $_REQUEST['func'];
		$callArray	= explode(',', $func);
		$viewController = JString::strtolower($callArray[0]);
		
		$viewController = JString::ucfirst($viewController);
		$viewController	= 'XiptController'.$viewController;
		$controller		 = new $viewController($config);
	
		// Perform the Request task
		$output = call_user_func_array(array(&$controller, $callArray[1]), $args);
		
		return $output;
	}