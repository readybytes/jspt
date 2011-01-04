TRUNCATE TABLE `#__community_users`;;
INSERT INTO `#__community_users` (`userid`) VALUES
(62),
(83),
(84),
(85),
(86),
(87),
(79),
(80),
(81),
(82)
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
(87, 1, 'blueface'),
(86, 1, 'blueface'),
(85, 1, 'blueface'),
(84, 1, 'blueface'),
(83, 1, 'blueface'),
(82, 1, 'blueface'),
(81, 1, 'blueface'),
(80, 1, 'blueface'),
(79, 1, 'blueface')
;;

TRUNCATE TABLE `au_#__xipt_users`;;
INSERT INTO `au_#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 1, 'default'),
(87, 1, 'default'),
(86, 1, 'default'),
(85, 1, 'default'),
(84, 1, 'default'),
(83, 1, 'default'),
(82, 1, 'default'),
(81, 1, 'default'),
(80, 1, 'default'),
(79, 1, 'default')
;;

CREATE TABLE IF NOT EXISTS `bk_#__users` LIKE `#__users`;;
TRUNCATE TABLE `bk_#__users`;;
INSERT INTO `bk_#__users` SELECT * FROM `#__users`;;
CREATE TABLE IF NOT EXISTS `au_#__users` LIKE `#__users`;;
TRUNCATE TABLE `#__users`;;
INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'shyam@readybytes.in', '6a8c2b2fbc4ee1b4f3f042009d8a22f3:K5wzjZ3SlgIYTVPMaKt0wE0w6JUEJ2Bm', 'Super Administrator', 0, 1, 25, '2009-10-27 14:21:57', '2010-06-15 10:40:57', '', '\n'),
(82, 'regtest8774090', 'regtest8774090', 'regtest8774090@gmail.com', 'f478ff7ef92fcb7a7cb62d4c1f08e43a:7rptUeQifMIkdyqE59fnxb0o74NE4sk8', 'Registered', 0, 0, 18, '2009-12-03 08:16:35', '2010-06-15 08:36:29', 'a3a9fc5ff08868ee458cda29142e6e36', '\n'),
(83, 'regtest1789672', 'regtest1789672', 'regtest1789672@gmail.com', 'c33a3ac03bfbc13368383edc0e6ae42d:bUwtJXMI49daOhAPzdaLBdRY1IOOgm0D', 'Editor', 0, 0, 20, '2009-12-03 08:16:44', '0000-00-00 00:00:00', 'a25e8cbbf5a534e0d5b934589be66756', '\n'),
(84, 'regtest6461827', 'regtest6461827', 'regtest6461827@gmail.com', '56f606098f0631341e8c398eaae179c6:aOJ5ghvQqtSCPnIH8SwFw90001MNaRI6', 'Publisher', 0, 0, 21, '2009-12-03 08:16:52', '0000-00-00 00:00:00', 'd8e2cc8000b17d6791a451354a281937', '\n'),
(85, 'regtest3843261', 'regtest3843261', 'regtest3843261@gmail.com', '0f2e8c8f8433fd1604880e9ac0d33fc1:d4b8PHWIkuHEI4AfHM1XWkFh4sR4t1gj', 'Registered', 0, 0, 18, '2009-12-03 08:17:00', '0000-00-00 00:00:00', '0e11cd0ed924846a11c84e3618f2c5eb', '\n'),
(86, 'regtest1504555', 'regtest1504555', 'regtest1504555@gmail.com', '78c3901d9d2c31108f9f758a18ee7f89:UIbbRXlJUORtEqogoLPr9ZP0bouM0lLT', 'Editor', 0, 0, 20, '2009-12-03 08:17:09', '2010-06-15 08:26:38', '77981cae5948a5be5e553db5dcb8d00f', '\n'),
(87, 'regtest1674526', 'regtest1674526', 'regtest1674526@gmail.com', '948b72e649363975c49ba818d6880843:PezoDwP9dbIXQETtPbG0IfkpE0jogLi2', 'Publisher', 0, 0, 21, '2009-12-03 08:17:17', '0000-00-00 00:00:00', '51bcf29e8ec7bbaf00dc2160257b8987', '\n'),
(79, 'regtest7046025', 'regtest7046025', 'regtest7046025@gmail.com', '64d5a5a65e0433fefad4d52255857f59:rBhZVyCqDIKioTNuCNBkpQNhRXsCHb1t', 'Registered', 0, 0, 18, '2009-12-03 08:16:09', '2010-06-15 10:22:52', 'd45373ce0b2c4bfa6065235a5c353add', '\n'),
(80, 'regtest6208627', 'regtest6208627', 'regtest6208627@gmail.com', '73e7830c01e705a5adeaaa3e278fbdec:uQb0sUh0KdTyybJuHnYHAtpOmtfVNxr2', 'Editor', 0, 0, 20, '2009-12-03 08:16:18', '2010-06-15 10:24:28', '0e24ede794209ad6de9624f89077daed', '\n'),
(81, 'regtest8635954', 'regtest8635954', 'regtest8635954@gmail.com', '7dc28bb5bc0119a23ac236b82837586e:vBNJaILgct7EzdE4wmJANFeLuVSTLHdh', 'Publisher', 0, 0, 21, '2009-12-03 08:16:26', '2010-06-15 10:24:50', '1ebc22393cc2619be62d28fe7c960e5a', '\n')
;;

TRUNCATE TABLE `#__core_acl_aro`;;
INSERT INTO `#__core_acl_aro` (`id`, `section_value`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', '62', 0, 'Administrator', 0),
(31, 'users', '83', 0, 'regtest1789672', 0),
(28, 'users', '80', 0, 'regtest6208627', 0),
(32, 'users', '84', 0, 'regtest6461827', 0),
(35, 'users', '87', 0, 'regtest1674526', 0),
(33, 'users', '85', 0, 'regtest3843261', 0),
(34, 'users', '86', 0, 'regtest1504555', 0),
(29, 'users', '81', 0, 'regtest8635954', 0),
(27, 'users', '79', 0, 'regtest7046025', 0),
(30, 'users', '82', 0, 'regtest8774090', 0)
;;

TRUNCATE TABLE `#__core_acl_groups_aro_map`;;
INSERT INTO `#__core_acl_groups_aro_map` (`group_id`, `section_value`, `aro_id`) VALUES
(18, '', 27),
(18, '', 30),
(18, '', 33),
(20, '', 28),
(20, '', 31),
(20, '', 34),
(21, '', 29),
(21, '', 32),
(21, '', 35),
(25, '', 10)
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
(2, 83, 3, 'blueface'),
(3, 84, 3, 'blueface'),
(4, 85, 3, 'blueface'),
(5, 86, 3, 'blueface'),
(6, 87, 3, 'blueface'),
(7, 79, 3, 'blueface'),
(8, 80, 3, 'blueface'),
(9, 81, 3, 'blueface'),
(10, 82, 3, 'blueface');;


TRUNCATE TABLE `au_#__community_fields_values`;;
INSERT INTO `au_#__community_fields_values` (`id`, `user_id`, `field_id`, `value`) VALUES
(1, 62, 3, 'default'),
(2, 83, 3, 'default'),
(3, 84, 3, 'default'),
(4, 85, 3, 'default'),
(5, 86, 3, 'default'),
(6, 87, 3, 'default'),
(7, 79, 3, 'default'),
(8, 80, 3, 'default'),
(9, 81, 3, 'default'),
(10, 82, 3, 'default');;

