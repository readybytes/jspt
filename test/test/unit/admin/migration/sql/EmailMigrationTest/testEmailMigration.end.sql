TRUNCATE TABLE `#__xipt_profiletypes`;;
INSERT INTO `#__xipt_profiletypes` SELECT * FROM `bk_#__xipt_profiletypes`;;
DROP TABLE IF EXISTS `bk_#__xipt_profiletypes`;;
DROP TABLE IF EXISTS `au_#__xipt_profiletypes`;;

TRUNCATE TABLE `#__xipt_settings`;;
INSERT INTO `#__xipt_settings` SELECT * FROM `bk_#__xipt_settings`;;
DROP TABLE IF EXISTS `bk_#__xipt_settings`;;

