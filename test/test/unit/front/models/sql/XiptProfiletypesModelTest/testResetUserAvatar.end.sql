TRUNCATE TABLE `#__xipt_users`;;
INSERT INTO `#__xipt_users` SELECT * FROM `bk_#__xipt_users`;;
DROP TABLE IF EXISTS `bk_#__xipt_users`;;


TRUNCATE TABLE `#__community_users`;;
INSERT INTO `#__community_users` SELECT * FROM `bk_#__community_users`;;
DROP TABLE IF EXISTS `bk_#__community_users`;;
DROP TABLE IF EXISTS `au_#__community_users`;;

