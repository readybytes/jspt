CREATE TABLE IF NOT EXISTS `au_#__xipt_aclrules` (
  `id` int(31) NOT NULL auto_increment,
  `rulename` varchar(250) NOT NULL,
  `aclname` varchar(128) NOT NULL,
  `coreparams` text NOT NULL,
  `aclparams` text NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;;


TRUNCATE TABLE  `au_#__xipt_aclrules`;;

CREATE TABLE IF NOT EXISTS `au_#__xipt_aec` (
  `id` int(11) NOT NULL auto_increment,
  `planid` int(11) NOT NULL,
  `profiletype` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  ;;


CREATE TABLE IF NOT EXISTS `au_#__xipt_applications` (
  `id` int(10) NOT NULL auto_increment,
  `applicationid` int(10) NOT NULL default '0',
  `profiletype` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;;

TRUNCATE TABLE  `au_#__xipt_applications`;;

CREATE TABLE IF NOT EXISTS `au_#__xipt_profilefields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `fid` int(10) NOT NULL DEFAULT '0',
  `pid` int(10) NOT NULL DEFAULT '0',
  `category` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;;
TRUNCATE TABLE  `au_#__xipt_profilefields`;;


CREATE TABLE IF NOT EXISTS `au_#__xipt_profiletypes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `ordering` int(10) default NULL,
  `published` tinyint(1) NOT NULL default '1',
  `tip` text NOT NULL,
  `privacy` varchar(20) NOT NULL default 'friends',
  `template` varchar(50) NOT NULL default 'default',
  `jusertype` varchar(50) NOT NULL default 'Registered',
  `avatar` varchar(250) NOT NULL default 'components/com_community/assets/default.jpg',
  `approve` tinyint(1) NOT NULL default '0',
  `allowt` tinyint(1) NOT NULL default '0',
  `group` int(11) NOT NULL default '0',
  `watermark` varchar(250) NOT NULL,
  `params` text NOT NULL,
  `watermarkparams` text NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;;
TRUNCATE TABLE  `au_#__xipt_profiletypes` ;;

CREATE TABLE IF NOT EXISTS `au_#__xipt_users` (
  `userid` int(11) NOT NULL,
  `profiletype` int(10) NOT NULL default '0',
  `template` varchar(80) NOT NULL default 'NOT_DEFINED',
  PRIMARY KEY  (`userid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;;

TRUNCATE TABLE `au_#__xipt_users` ;;


CREATE TABLE IF NOT EXISTS `au_#__xipt_settings` (
  `name` varchar(250) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `au_#__xipt_settings`
--

INSERT INTO `au_#__xipt_settings` (`name`, `params`) VALUES
('settings', '');


