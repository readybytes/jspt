DROP TABLE IF EXISTS `bk_#__xipt_profiletypes`;;
DROP TABLE IF EXISTS `au_#__xipt_profiletypes`;;
CREATE TABLE IF NOT EXISTS `bk_#__xipt_profiletypes` LIKE `#__xipt_profiletypes`;;
INSERT INTO `bk_#__xipt_profiletypes` SELECT * FROM `#__xipt_profiletypes`;;
CREATE TABLE IF NOT EXISTS `au_#__xipt_profiletypes` LIKE `#__xipt_profiletypes`;;
TRUNCATE TABLE `au_#__xipt_profiletypes`;;

DROP TABLE IF EXISTS `#__xipt_profiletypes`;;
CREATE TABLE IF NOT EXISTS `#__xipt_profiletypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `ordering` int(10) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `tip` text NOT NULL,
  `privacy` varchar(20) NOT NULL DEFAULT 'friends',
  `template` varchar(50) NOT NULL DEFAULT 'default',
  `jusertype` varchar(50) NOT NULL DEFAULT 'Registered',
  `avatar` varchar(250) NOT NULL DEFAULT 'components/com_community/assets/default.jpg',
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  `allowt` tinyint(1) NOT NULL DEFAULT '0',
  `group` varchar(100) CHARACTER SET utf8 NOT NULL,
  `watermark` varchar(250) NOT NULL,
  `params` text NOT NULL,
  `watermarkparams` text NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;;
