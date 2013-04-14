DROP TABLE IF EXISTS `bk_#__xipt_applications`;;
DROP TABLE IF EXISTS `bk_#__xipt_profiletypes`;;
DROP TABLE IF EXISTS `au_#__xipt_applications`;;

CREATE TABLE IF NOT EXISTS `bk_#__xipt_applications` 
	SELECT * FROM `#__xipt_applications`;;
CREATE TABLE IF NOT EXISTS `bk_#__xipt_profiletypes` 
	SELECT * FROM `#__xipt_profiletypes`;;

TRUNCATE TABLE `#__xipt_applications`;;
TRUNCATE TABLE `#__xipt_profiletypes`;;

INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`) VALUES
(1, 'PROFILETYPE-1', 2, 1),
(2, 'PROFILETYPE-2', 1, 1),
(3, 'PROFILETYPE-3', 3, 1),
(4, 'PROFILETYPE-4', 4, 1),
(6, 'PROFILETYPE-6', 6, 1);;

CREATE TABLE IF NOT EXISTS `au_#__xipt_applications` SELECT * FROM `#__xipt_applications`;;
INSERT INTO `au_#__xipt_applications` (`id`, `applicationid`, `profiletype`) VALUES
(6, 100, 6),
(5, 100, 2),
(4, 100, 1),
(7, 101, 1),
(8, 101, 2),
(9, 101, 4);;
