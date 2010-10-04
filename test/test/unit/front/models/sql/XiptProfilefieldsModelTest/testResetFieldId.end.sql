TRUNCATE TABLE `#__xipt_profilefields`;;
INSERT INTO `#__xipt_profilefields` SELECT * FROM `bk_#__xipt_profilefields`;;
DROP TABLE IF EXISTS `bk_#__xipt_profilefields`;;
DROP TABLE IF EXISTS `au_#__xipt_profilefields`;;
