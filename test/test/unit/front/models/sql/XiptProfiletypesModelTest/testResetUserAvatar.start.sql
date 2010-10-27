-- XIPT user tabel
DROP TABLE IF EXISTS `bk_#__xipt_users`;;
CREATE TABLE IF NOT EXISTS `bk_#__xipt_users` SELECT * FROM `#__xipt_users`;;
TRUNCATE TABLE `#__xipt_users`;;
INSERT INTO `#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 1, 'default'),
(63, 1, 'default'),
(64, 2, 'default'),
(65, 1, 'default'),
(66, 2, 'default');;


DROP TABLE IF EXISTS `bk_#__community_users`;;
CREATE TABLE IF NOT EXISTS `bk_#__community_users` SELECT * FROM `#__community_users`;;
TRUNCATE TABLE `#__community_users`;;

DROP TABLE IF EXISTS `au_#__community_users`;;
CREATE TABLE IF NOT EXISTS `au_#__community_users` SELECT * FROM `#__community_users`;;
TRUNCATE TABLE `au_#__community_users`;;

INSERT INTO `#__community_users` (`userid`, `avatar`, `thumb`) VALUES
(62, 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg'),
(63, 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg'),
(64, 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg'),
(65, 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg'),
(66, 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg');;

INSERT INTO `au_#__community_users` (`userid`, `avatar`, `thumb`) VALUES
(62, 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg'),
(63, 'components/com_community/assets/avatar1.jpg', 'components/com_community/assets/avatar1_thumb.jpg'),
(64, 'components/com_community/assets/avatar2.jpg', 'components/com_community/assets/avatar2_thumb.jpg'),
(65, 'components/com_community/assets/avatar1.jpg', 'components/com_community/assets/avatar1_thumb.jpg'),
(66, 'components/com_community/assets/avatar2.jpg', 'components/com_community/assets/avatar2_thumb.jpg');;
