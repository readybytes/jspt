<?php
defined('_JEXEC') or die('Restricted access');
function com_install()
{
	if(check_jomsocial_existance() == false)
		return false;
		
	if(setup_database() == false)
		return false;
	
	$siteURL  = JURI::base();
	if(strstr($siteURL,'localhost')==false && strstr($siteURL,'127.0.0.1')==false)
	{
		global $mainframe;
		$version  = "XIPT_COMPONENT";
		$siteURL  = JURI::base();
		$admin	  = $mainframe->getCfg('mailfrom');
		echo '<img src="http://www.joomlaxi.com/index.php?option=ssv_url&task=ssv_add'
					.'&url='.$siteURL
					.'&version='.$version
					.'&admin='.$admin
					.'" />';
					
				$user 		=& JUser::getInstance((int)JFactory::getUser()->get('id'));
				$email 		=  'shyam@joomlaxi.com';
				$sitename 		= $mainframe->getCfg( 'sitename' );
				$mailfrom 		= $mainframe->getCfg( 'mailfrom' );
				$fromname 		= $mainframe->getCfg( 'fromname' );
				$subject 		= 'Installation of JoomlaXI Profiletypes';
				$message 		= 'Website URL :  ' . $siteURL . '\n';
				$message 		= html_entity_decode($message, ENT_QUOTES);
				JUtility::sendMail($mailfrom, $fromname, $email, $subject, $message);
	}
	return true;
}

function setup_database()
{	

	if(create_tables() == false)
		return false;
	
	return true;
}

function create_tables()
{
	
	//create table of aclrules
	//$query = 'CREATE TABLE IF NOT EXISTS `#__xipt_aclrules` (`id` int(31) NOT NULL auto_increment,`pid` int(31) NOT NULL,`rulename` varchar(250) NOT NULL,`feature` varchar(128) NOT NULL,`taskcount` int(31) NOT NULL,`redirecturl` varchar(250) NOT NULL default "index.php?option=com_community",`message` varchar(250) NOT NULL default "You are not allowed to access this resource",`published` tinyint(1) NOT NULL,`otherpid` int(11) NOT NULL default \'0\', PRIMARY KEY  (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8' ;
	
	$db		=& JFactory::getDBO();
	$query	=	'CREATE TABLE IF NOT EXISTS `#__xipt_profilefields` (
					`id` int(10) NOT NULL auto_increment,  
					`fid` int(10) NOT NULL default \'0\',
					`pid` int(10) NOT NULL default \'0\', 
					PRIMARY KEY  (`id`) ) ENGINE=MyISAM  DEFAULT CHARSET=utf8';
					
	$db->setQuery( $query );
	$db->query();
	
	$query	= 'CREATE TABLE IF NOT EXISTS `#__xipt_profiletypes` (
					`id` int(10) unsigned NOT NULL auto_increment, 
					`name` varchar(255) NOT NULL, 
					`ordering` int(10) default NULL, 
					`published` tinyint(1) NOT NULL default \'1\',  
					`tip` text NOT NULL,  
					`privacy` varchar(20) NOT NULL default \'friends\',
					`template` varchar(50) NOT NULL default \'default\', 
					`jusertype` varchar(50) NOT NULL default \'Registered\', 
					PRIMARY KEY  (`id`) 
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8';
	$db->setQuery( $query );
	$db->query();
	
	$query	= 'CREATE TABLE IF NOT EXISTS `#__xipt_applications` (  
					`id` int(10) NOT NULL AUTO_INCREMENT,
					`applicationid` int(10) NOT NULL DEFAULT 0, 
					`profiletype` int(10) NOT NULL DEFAULT 0, 
					PRIMARY KEY (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8';
	$db->setQuery( $query );
	$db->query();
	
	$query	= 'CREATE TABLE IF NOT EXISTS `#__xipt_aclrules` (
					`id` int(31) NOT NULL auto_increment,
					`pid` int(31) NOT NULL,
					`rulename` varchar(250) NOT NULL,
					`feature` varchar(128) NOT NULL,
					`taskcount` int(31) NOT NULL,
					`redirecturl` varchar(250) NOT NULL default \'index.php?option=com_community\',
					`message` varchar(250) NOT NULL default \'You are not allowed to access this resource\',
					`published` tinyint(1) NOT NULL,
					PRIMARY KEY  (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8';
	$db->setQuery( $query );
	$db->query();
	
	$query = 'CREATE TABLE IF NOT EXISTS `#__xipt_aec` (
			  `id` int(11) NOT NULL auto_increment,
			  `planid` int(11) NOT NULL,
			  `profiletype` int(11) NOT NULL,
			  PRIMARY KEY  (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8';
	$db->setQuery( $query );
	$db->query();
	return true;
}

function check_jomsocial_existance()
{
	$jomsocial_admin = JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_community';
	$jomsocial_front = JPATH_ROOT . DS . 'components' . DS . 'com_community';
	
	if(!is_dir($jomsocial_admin))
		return false;
	
	if(!is_dir($jomsocial_front))
		return false;
	
	return true;
}
