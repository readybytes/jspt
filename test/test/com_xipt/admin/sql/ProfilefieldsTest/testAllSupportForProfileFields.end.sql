TRUNCATE TABLE `#__xipt_profilefields`;;
INSERT INTO `#__xipt_profilefields` SELECT * FROM `bak_#__xipt_profilefields`;;
DROP TABLE IF EXISTS `bak_#__xipt_profilefields`;;

TRUNCATE TABLE  `#__community_fields`;;
INSERT INTO `#__community_fields` SELECT * FROM `bak_#__community_fields`;;
DROP TABLE IF EXISTS `bak_#__community_fields`;;
