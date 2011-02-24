<?php
$name = 'com_xipt';
if(!defined("JPATH_COMPONENT"))
	define( 'JPATH_COMPONENT',					JPATH_BASE.DS.'components'.DS.$name);
if(!defined("JPATH_COMPONENT_SITE"))
	define( 'JPATH_COMPONENT_SITE',				JPATH_SITE.DS.'components'.DS.$name);
if(!defined("JPATH_COMPONENT_ADMINISTRATOR"))
	define('JPATH_COMPONENT_ADMINISTRATOR',	JPATH_ADMINISTRATOR.DS.'components'.DS.$name);

define("JSPT_TEST_MODE", true);

// Community Application IDs
if (TEST_XIPT_JOOMLA_15){
	define('XIPT_TEST_COMMUNITY_WALLS', 44);
	define('XIPT_TEST_COMMUNITY_FEEDS', 45);
	define('XIPT_TEST_COMMUNITY_ARTICLES', 48);
}
if (TEST_XIPT_JOOMLA_16){
	define('XIPT_TEST_COMMUNITY_WALLS', 10003);
	define('XIPT_TEST_COMMUNITY_FEEDS', 10007);
	define('XIPT_TEST_COMMUNITY_ARTICLES', 10009);
}
