DROP TABLE IF EXISTS `bk_#__xipt_profilefields`;;
DROP TABLE IF EXISTS `bk_#__xipt_profiletypes`;;
DROP TABLE IF EXISTS `au_#__xipt_profilefields`;;

CREATE TABLE IF NOT EXISTS `bk_#__xipt_profilefields` 
	SELECT * FROM `#__xipt_profilefields`;;
CREATE TABLE IF NOT EXISTS `au_#__xipt_profilefields` 
	SELECT * FROM `#__xipt_profilefields`;;
CREATE TABLE IF NOT EXISTS `bk_#__xipt_profiletypes` 
	SELECT * FROM `#__xipt_profiletypes`;;

TRUNCATE TABLE `#__xipt_profilefields`;;
TRUNCATE TABLE `#__xipt_profiletypes`;;

INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`) VALUES
(1, 'PROFILETYPE-1', 2, 1),
(2, 'PROFILETYPE-2', 1, 1);;


TRUNCATE TABLE `au_#__xipt_profilefields`;;

INSERT INTO `au_#__xipt_profilefields` (`id`, `fid`, `pid`, `category`) VALUES
(30, 5, 1, 4),
(2, 4, 2, 0),
(24, 5, 1, 2),
(29, 2, 1, 4),
(5, 4, 2, 1),
(23, 2, 1, 2),
(28, 5, 2, 4),
(8, 4, 2, 2),
(22, 5, 1, 1),
(27, 2, 2, 4),
(11, 4, 2, 3),
(21, 2, 1, 1),
(26, 5, 1, 3),
(14, 4, 2, 4),
(20, 5, 1, 0),
(25, 2, 1, 3),
(17, 4, 1, 4),
(19, 2, 1, 0);;
