TRUNCATE TABLE `#__xipt_settings`;;
INSERT INTO `#__xipt_settings` SELECT * FROM `bk_#__xipt_settings`;;
DROP TABLE IF EXISTS `bk_#__xipt_settings`;;