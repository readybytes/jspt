
TRUNCATE TABLE `#__plugins`;;
INSERT INTO `#__plugins` SELECT * FROM `bk_#__plugins`;;
DROP TABLE IF EXISTS `bk_#__plugins`;;
DROP TABLE IF EXISTS `au_#__plugins`;;
