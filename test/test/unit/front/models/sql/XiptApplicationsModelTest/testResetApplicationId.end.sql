TRUNCATE TABLE `#__xipt_applications`;;
INSERT INTO `#__xipt_users` SELECT * FROM `bk_#__xipt_applications`;;
DROP TABLE IF EXISTS `bk_#__xipt_applications`;;
DROP TABLE IF EXISTS `au_#__xipt_applications`;;
