<?php
require_once dirname(__FILE__). '/joomlaFramework.php';

// which selenium server to pick
$whichSelRC = getenv('useSelRC'); // can be local / network
if($whichSelRC == FALSE)
{
	echo "\n Environment variable not set picking up localhost as useSelRC";
	$whichSelRC = 'local';
}

require_once dirname(__FILE__). "/selRC_$whichSelRC.php";

define('JOOMLA_LOCATION',	'http://'.JOOMLA_HOST.'/@joomla.folder@/');
define('JOOMLA_FTP_LOCATION', 	JPATH_BASE);

$_SERVER['HTTP_HOST'] = JOOMLA_LOCATION;

define('TIMEOUT_SEC',30000);
define('JOOMLA_ADMIN_USERNAME', 'admin');
define('JOOMLA_ADMIN_PASSWORD',	'ssv445');

//these files should have been copied by phing during setup of joomla 
define('PLG_XIPT_COM_PKG',	JOOMLA_LOCATION.'/plg_xipt_community.zip');
define('PLG_XIPT_SYS_PKG',	JOOMLA_LOCATION.'/plg_xipt_system.zip');
define('COM_XIPT_PKG',		JOOMLA_LOCATION.'/com_xipt.zip');
define('JOMSOCIAL_PKG',		JOOMLA_LOCATION.'/com_community.zip');

define('JOMSOCIAL_APPS1',	JOOMLA_LOCATION.'/plg_feeds.zip');
define('JOMSOCIAL_APPS2',	JOOMLA_LOCATION.'/plg_groups.zip');
define('JOMSOCIAL_APPS3',	JOOMLA_LOCATION.'/plg_latestphoto.zip');
define('JOMSOCIAL_APPS4',	JOOMLA_LOCATION.'/plg_myarticles.zip');
define('JOMSOCIAL_APPS5',	JOOMLA_LOCATION.'/plg_testing001.tar.gz');
define('JOMSOCIAL_APPS6',	JOOMLA_LOCATION.'/plg_testing002.tar.gz');
