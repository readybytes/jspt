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
(6, 5, 2, 3),
(5, 5, 2, 1),
(4, 5, 1, 0),
(7, 5, 2, 4),
(8, 5, 1, 4);;
