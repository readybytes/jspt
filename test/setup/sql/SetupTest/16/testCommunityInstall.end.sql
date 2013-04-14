TRUNCATE TABLE `#__extensions`;;
INSERT INTO `#__extensions` SELECT * FROM `bk_#__extensions`;;
DROP TABLE IF EXISTS `bk_#__extensions`;;
