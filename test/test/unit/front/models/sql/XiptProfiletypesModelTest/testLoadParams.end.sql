TRUNCATE TABLE `#__xipt_profiletypes`;;
INSERT INTO `#__xipt_profiletypes` SELECT * FROM `bk_#__xipt_profiletypes`;;
DROP TABLE IF EXISTS `bk_#__xipt_profiletypes`;;

TRUNCATE TABLE `#__community_config`;;
INSERT INTO `#__community_config` SELECT * FROM `bk_#__community_config`;;
DROP TABLE IF EXISTS `bk_#__community_config`;;



