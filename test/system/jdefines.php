<?php
require_once dirname(__FILE__). '/joomlaFramework.php';

define('JOOMLA_LOCATION',	'http://localhost/@joomla.folder@/');
define('JOOMLA_FTP_LOCATION', 	JPATH_BASE);

define('TIMEOUT_SEC',30000);
define('JOOMLA_ADMIN_USERNAME', 'admin');
define('JOOMLA_ADMIN_PASSWORD',	'ssv445');

//these files should have been copied by phing during setup of joomla 
define('PLG_XIPT_COM_PKG',	JOOMLA_FTP_LOCATION.'/plg_xipt_community.zip');
define('PLG_XIPT_SYS_PKG',	JOOMLA_FTP_LOCATION.'/plg_xipt_system.zip');
define('COM_XIPT_PKG',		JOOMLA_FTP_LOCATION.'/com_xipt.zip');
define('JOMSOCIAL_PKG',		JOOMLA_FTP_LOCATION.'/com_community.zip');

define('JOMSOCIAL_APPS1',	JOOMLA_FTP_LOCATION.'/plg_feeds.zip');
define('JOMSOCIAL_APPS2',	JOOMLA_FTP_LOCATION.'/plg_groups.zip');
define('JOMSOCIAL_APPS3',	JOOMLA_FTP_LOCATION.'/plg_latestphoto.zip');
define('JOMSOCIAL_APPS4',	JOOMLA_FTP_LOCATION.'/plg_myarticles.zip');
define('JOMSOCIAL_APPS5',	JOOMLA_FTP_LOCATION.'/plg_testing001.tar.gz');
define('JOMSOCIAL_APPS6',	JOOMLA_FTP_LOCATION.'/plg_testing002.tar.gz');
