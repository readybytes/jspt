DROP TABLE IF EXISTS `bk_#__xipt_applications`;;
CREATE TABLE IF NOT EXISTS `bk_#__xipt_applications` SELECT * FROM `#__xipt_applications`;;
TRUNCATE TABLE `#__xipt_applications`;;

DROP TABLE IF EXISTS `au_#__xipt_applications`;;
CREATE TABLE IF NOT EXISTS `au_#__xipt_applications` SELECT * FROM `#__xipt_applications`;;

INSERT INTO `#__xipt_applications` (`id`, `applicationid`, `profiletype`) VALUES
(1, 44, 2),
(2, 45, 1),
(3, 46, 1),
(4, 46, 2);;

INSERT INTO `au_#__xipt_applications` (`id`, `applicationid`, `profiletype`) VALUES
(1, 44, 2),
(2, 45, 1);;
