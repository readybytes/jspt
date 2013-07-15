TRUNCATE TABLE `#__community_users`;;
INSERT INTO `#__community_users` (`userid`) VALUES
(62),
(43),
(44),
(45),
(46),
(47),
(48),
(49),
(50),
(51)
;;

CREATE TABLE IF NOT EXISTS `bk_#__xipt_profiletypes` LIKE `#__xipt_profiletypes`;;
TRUNCATE TABLE `bk_#__xipt_profiletypes` ;;
INSERT INTO `bk_#__xipt_profiletypes` SELECT * FROM `#__xipt_profiletypes`;;

TRUNCATE TABLE `#__xipt_profiletypes` ;;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`) VALUES
(1, 'PROFILETYPE-1', 1, 1);;

CREATE TABLE IF NOT EXISTS `bk_#__xipt_users` LIKE `#__xipt_users`;;
TRUNCATE TABLE `bk_#__xipt_users`;;
INSERT INTO `bk_#__xipt_users` SELECT * FROM `#__xipt_users`;;
CREATE TABLE IF NOT EXISTS `au_#__xipt_users` LIKE `#__xipt_users`;;


TRUNCATE TABLE `#__xipt_users`;;
INSERT INTO `#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 1, 'blueface'),
(43, 1, 'blueface'),
(44, 1, 'blueface'),
(45, 1, 'blueface'),
(46, 1, 'blueface'),
(47, 1, 'blueface'),
(48, 1, 'blueface'),
(49, 1, 'blueface'),
(50, 1, 'blueface'),
(51, 1, 'blueface')
;;

TRUNCATE TABLE `au_#__xipt_users`;;
INSERT INTO `au_#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 1, 'default'),
(43, 1, 'default'),
(44, 1, 'default'),
(45, 1, 'default'),
(46, 1, 'default'),
(47, 1, 'default'),
(48, 1, 'default'),
(49, 1, 'default'),
(50, 1, 'default'),
(51, 1, 'default')
;;

CREATE TABLE IF NOT EXISTS `bk_#__community_fields` LIKE `#__community_fields`;;
TRUNCATE TABLE `bk_#__community_fields`;;
INSERT INTO `bk_#__community_fields` SELECT * FROM `#__community_fields`;;


TRUNCATE TABLE `#__community_fields`;;
INSERT INTO `#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`) VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basicr', 1, 1, 1, 1, '', ''),
(2, 'text', 2, 1, 5, 250, 'Hometown2', 'Hometown2', 1, 1, 1, 1, '', 'FIELD_HOMETOWN2'),
(3, 'templates', 0, 1, 10, 100, 'Template', 'Template Of User', 1, 1, 1, 1, '', 'XIPT_TEMPLATE'),
(4, 'profiletypes', 0, 1, 10, 100, 'Profiletype', 'Profiletype Of User', 1, 1, 1, 1, '', 'XIPT_PROFILETYPE');;


CREATE TABLE IF NOT EXISTS `bk_#__community_fields_values` LIKE `#__community_fields_values`;;
TRUNCATE TABLE `bk_#__community_fields_values`;;
INSERT INTO `bk_#__community_fields_values` SELECT * FROM `#__community_fields_values`;;
CREATE TABLE IF NOT EXISTS `au_#__community_fields_values` LIKE `#__community_fields_values`;;


TRUNCATE TABLE `#__community_fields_values`;;
INSERT INTO `#__community_fields_values` (`id`, `user_id`, `field_id`, `value`) VALUES
(1, 62, 3, 'blueface'),
(2, 43, 3, 'blueface'),
(3, 44, 3, 'blueface'),
(4, 45, 3, 'blueface'),
(5, 46, 3, 'blueface'),
(6, 47, 3, 'blueface'),
(7, 48, 3, 'blueface'),
(8, 49, 3, 'blueface'),
(9, 50, 3, 'blueface'),
(10, 51, 3, 'blueface');;


TRUNCATE TABLE `au_#__community_fields_values`;;
INSERT INTO `au_#__community_fields_values` (`id`, `user_id`, `field_id`, `value`) VALUES
(1, 62, 3, 'default'),
(2, 43, 3, 'default'),
(3, 44, 3, 'default'),
(4, 45, 3, 'default'),
(5, 46, 3, 'default'),
(6, 47, 3, 'default'),
(7, 48, 3, 'default'),
(8, 49, 3, 'default'),
(9, 50, 3, 'default'),
(10, 51, 3, 'default');;

