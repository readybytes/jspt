DROP TABLE IF EXISTS `#__xipt_profiletypes`;;
CREATE TABLE IF NOT EXISTS `#__xipt_profiletypes` LIKE `bk_#__xipt_profiletypes`;;
INSERT INTO `#__xipt_profiletypes` SELECT * FROM `bk_#__xipt_profiletypes`;;

DROP TABLE IF EXISTS  `bk_#__xipt_profiletypes`;;
