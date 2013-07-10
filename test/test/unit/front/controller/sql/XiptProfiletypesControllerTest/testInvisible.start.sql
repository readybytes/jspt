DROP TABLE IF EXISTS `bk_#__xipt_profiletypes`;;
DROP TABLE IF EXISTS `au_#__xipt_profiletypes`;;

CREATE TABLE IF NOT EXISTS `au_#__xipt_profiletypes` 
	SELECT * FROM `#__xipt_profiletypes`;;
CREATE TABLE IF NOT EXISTS `bk_#__xipt_profiletypes` 
	SELECT * FROM `#__xipt_profiletypes`;;

TRUNCATE TABLE `au_#__xipt_profiletypes`;;
TRUNCATE TABLE `#__xipt_profiletypes`;;

INSERT INTO `au_#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `visible`) VALUES
(1, 'PROFILETYPE-1', 2, 1, 0),
(2, 'PROFILETYPE-2', 1, 1, 0),
(3, 'PROFILETYPE-3', 3, 1, 0),
(4, 'PROFILETYPE-4', 4, 1, 0),
(6, 'PROFILETYPE-6', 6, 1, 0);;

INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `visible`) VALUES
(1, 'PROFILETYPE-1', 2, 1, 1),
(2, 'PROFILETYPE-2', 1, 1, 1),
(3, 'PROFILETYPE-3', 3, 1, 1),
(4, 'PROFILETYPE-4', 4, 1, 1),
(6, 'PROFILETYPE-6', 6, 1, 1);;


