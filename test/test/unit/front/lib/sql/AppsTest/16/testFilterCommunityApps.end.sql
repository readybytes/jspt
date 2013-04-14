TRUNCATE TABLE `#__extensions`;;
INSERT INTO `#__extensions` SELECT * FROM `bk_#__extensions`;;
DROP TABLE IF EXISTS `bk_#__extensions`;;
DROP TABLE IF EXISTS `au_#__extensions`;;

TRUNCATE TABLE `#__xipt_applications`;;
INSERT INTO `#__xipt_applications` SELECT * FROM `bk_#__xipt_applications`;;
DROP TABLE IF EXISTS `bk_#__xipt_applications`;;
DROP TABLE IF EXISTS `au_#__xipt_applications`;;
