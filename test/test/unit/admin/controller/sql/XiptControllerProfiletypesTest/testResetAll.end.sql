TRUNCATE TABLE `#__xipt_profiletypes`;;
DROP TABLE IF EXISTS `au_#__xipt_profiletypes`;;
INSERT INTO `#__xipt_profiletypes` SELECT * FROM `bk_#__xipt_profiletypes`;;
DROP TABLE IF EXISTS  `bk_#__xipt_profiletypes`;;

TRUNCATE TABLE `#__xipt_users`;;
DROP TABLE IF EXISTS `au_#__xipt_users`;;
INSERT INTO `#__xipt_users` SELECT * FROM `bk_#__xipt_users`;;
DROP TABLE IF EXISTS  `bk_#__xipt_users`;;

TRUNCATE TABLE `#__users`;;
DROP TABLE IF EXISTS `au_#__users`;;
INSERT INTO `#__users` SELECT * FROM `bk_#__users`;;
DROP TABLE IF EXISTS  `bk_#__users`;;


TRUNCATE TABLE `#__community_fields_values`;;
DROP TABLE IF EXISTS `au_#__community_fields_values`;;
INSERT INTO `#__community_fields_values` SELECT * FROM `bk_#__community_fields_values`;;
DROP TABLE IF EXISTS  `bk_#__community_fields_values`;;


TRUNCATE TABLE `#__community_fields`;;
INSERT INTO `#__community_fields` SELECT * FROM `bk_#__community_fields`;;
DROP TABLE IF EXISTS  `bk_#__community_fields`;;

