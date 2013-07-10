DROP TABLE IF EXISTS `bk_#__xipt_profilefields`;;
CREATE TABLE IF NOT EXISTS `bk_#__xipt_profilefields` SELECT * FROM `#__xipt_profilefields`;;
TRUNCATE TABLE `#__xipt_profilefields`;;

INSERT INTO `#__xipt_profilefields` (`id`, `fid`, `pid`, `category`) VALUES
(1, 2, 2, 0),
(2, 2, 2, 1),
(3, 2, 1, 1),
(4, 3, 1, 0),
(5, 3, 1, 1);;
