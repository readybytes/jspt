DROP TABLE IF EXISTS `bk_#__xipt_users`;;
CREATE TABLE IF NOT EXISTS `bk_#__xipt_users` SELECT * FROM `#__xipt_users`;;
TRUNCATE TABLE `#__xipt_users`;;

DROP TABLE IF EXISTS `au_#__xipt_users`;;
CREATE TABLE IF NOT EXISTS `au_#__xipt_users` SELECT * FROM `#__xipt_users`;;

INSERT INTO `#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 1, 'default'),
(63, 2, 'bubble'),
(64, 3, 'blueface');;

INSERT INTO `au_#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 1, 'default'),
(63, 3, 'blackout'),
(64, 3, 'blueface'),
(65, 3, 'blueface');;
