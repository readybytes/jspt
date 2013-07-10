TRUNCATE TABLE `#__xipt_profilefields`;;
INSERT INTO `#__xipt_profilefields` SELECT * FROM `bk_#__xipt_profilefields`;;
DROP TABLE IF EXISTS `bk_#__xipt_profilefields`;;

TRUNCATE TABLE `#__xipt_profiletypes`;;
INSERT INTO `#__xipt_profiletypes` SELECT * FROM `bk_#__xipt_profiletypes`;;
DROP TABLE IF EXISTS `bk_#__xipt_profiletypes`;;

DROP TABLE IF EXISTS `au_#__xipt_profilefields`;;

