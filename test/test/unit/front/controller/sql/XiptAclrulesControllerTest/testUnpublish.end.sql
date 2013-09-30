TRUNCATE TABLE `#__xipt_aclrules`;;
INSERT INTO `#__xipt_aclrules` SELECT * FROM `bk_#__xipt_aclrules`;;
DROP TABLE IF EXISTS `bk_#__xipt_aclrules`;;
DROP TABLE IF EXISTS `au_#__xipt_aclrules`;;

