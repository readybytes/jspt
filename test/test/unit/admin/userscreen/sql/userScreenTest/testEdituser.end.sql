TRUNCATE TABLE `#__xipt_profiletypes`;;

INSERT INTO `#__xipt_profiletypes` SELECT * FROM `bk_#__xipt_profiletypes`;;

DROP TABLE IF EXISTS `bk_#__xipt_profiletypes`;;

TRUNCATE TABLE `#__users`;;

INSERT INTO `#__users` SELECT * FROM `bk_#__users`;;

DROP TABLE IF EXISTS `bk_#__users`;;


TRUNCATE TABLE `#__xipt_users`;;

INSERT INTO `#__xipt_users` SELECT * FROM `bk_#__xipt_users`;;

DROP TABLE IF EXISTS `bk_#__xipt_users`;;
