<?php
$name = 'com_xipt';
if(!defined("JPATH_COMPONENT"))
	define( 'JPATH_COMPONENT',					JPATH_BASE.DS.'components'.DS.$name);
if(!defined("JPATH_COMPONENT_SITE"))
	define( 'JPATH_COMPONENT_SITE',				JPATH_SITE.DS.'components'.DS.$name);
if(!defined("JPATH_COMPONENT_ADMINISTRATOR"))
	define('JPATH_COMPONENT_ADMINISTRATOR',	JPATH_ADMINISTRATOR.DS.'components'.DS.$name);

define("JSPT_TEST_MODE", true);