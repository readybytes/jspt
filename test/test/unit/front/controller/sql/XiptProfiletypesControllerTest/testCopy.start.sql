DROP TABLE IF EXISTS `bk_#__xipt_profiletypes`;;
DROP TABLE IF EXISTS `au_#__xipt_profiletypes`;;

CREATE TABLE IF NOT EXISTS `au_#__xipt_profiletypes` 
	SELECT * FROM `#__xipt_profiletypes`;;
CREATE TABLE IF NOT EXISTS `bk_#__xipt_profiletypes` 
	SELECT * FROM `#__xipt_profiletypes`;;

TRUNCATE TABLE `au_#__xipt_profiletypes`;;
TRUNCATE TABLE `#__xipt_profiletypes`;;

INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`) VALUES
(1, 'PROFILETYPE-1', 2, 0),
(2, 'PROFILETYPE-2', 1, 0),
(3, 'PROFILETYPE-3', 3, 0),
(4, 'PROFILETYPE-4', 4, 0);;

INSERT INTO `au_#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`) VALUES
(1, 'PROFILETYPE-1', 2, 0),
(2, 'PROFILETYPE-2', 1, 0),
(3, 'PROFILETYPE-3', 3, 0),
(4, 'PROFILETYPE-4', 4, 0),
(5, 'Copy of PROFILETYPE-1', 5, 0),
(6, 'Copy of PROFILETYPE-2', 6, 0),
(7, 'Copy of PROFILETYPE-4', 7, 0),
(8, 'Copy of PROFILETYPE-1', 8, 0),
(9, 'Copy of PROFILETYPE-2', 9, 0),
(10, 'Copy of PROFILETYPE-3', 10, 0);;

