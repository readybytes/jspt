TRUNCATE TABLE `#__xipt_applications`;;
INSERT INTO `#__xipt_applications` SELECT * FROM `bk_#__xipt_applications`;;
DROP TABLE IF EXISTS `bk_#__xipt_applications`;;

TRUNCATE TABLE `#__xipt_profiletypes`;;
INSERT INTO `#__xipt_profiletypes` SELECT * FROM `bk_#__xipt_profiletypes`;;
DROP TABLE IF EXISTS `bk_#__xipt_profiletypes`;;

DROP TABLE IF EXISTS `au_#__xipt_applications`;;
