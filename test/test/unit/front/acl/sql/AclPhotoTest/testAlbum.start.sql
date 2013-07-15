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

TRUNCATE TABLE `#__xipt_profiletypes` ;;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`) VALUES
(1, 'PROFILETYPE-1', 2, 1),
(2, 'PROFILETYPE-2', 1, 1),
(3, 'PROFILETYPE-3', 3, 1);;

TRUNCATE TABLE `#__xipt_users`;;
INSERT INTO `#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 1, 'default'),
(87, 3, 'blackout'),
(86, 2, 'blueface'),
(85, 1, 'default'),
(84, 3, 'blackout'),
(83, 2, 'blueface'),
(82, 1, 'default'),
(81, 3, 'blackout'),
(80, 2, 'blueface'),
(79, 1, 'default');;

TRUNCATE TABLE `#__xipt_aclrules`;;
INSERT INTO `#__xipt_aclrules` (`id`, `rulename`, `aclname`, `coreparams`, `aclparams`, `published`) VALUES
(11, 'RULE-11', 'addalbums', 'core_profiletype=1\ncore_display_message=NotAllowed\ncore_redirect_url=index.php\n\n', 'addalbums_limit=0\n\n', 1),
(12, 'RULE-12', 'addalbums', 'core_profiletype=2\ncore_display_message=NotAllowed\ncore_redirect_url=index.php\n\n', 'addalbums_limit=1\n\n', 1),
(13, 'RULE-13', 'addalbums', 'core_profiletype=2\ncore_display_message=NotAllowed\ncore_redirect_url=index.php\n\n', 'addalbums_limit=2\n\n', 1),
(14, 'RULE-14', 'addalbums', 'core_profiletype=2\ncore_display_message=NotAllowed\ncore_redirect_url=index.php\n\n', 'addalbums_limit=3\n\n', 1)
;;


TRUNCATE TABLE `#__community_photos_albums`;;
INSERT INTO `#__community_photos_albums` 
(`id`, `photoid`, `creator`, `name`, `description`, `permissions`, `created`, `path`, `type`) VALUES
(1, 0, 80, 'a', 'a', '', '2010-10-17 10:22:01', 'images/photos/62/', 'user'),

(2, 0, 83, 'a', 'a', '', '2010-10-17 10:22:01', 'images/photos/62/', 'user'),
(3, 0, 83, 'a', 'a', '', '2010-10-17 10:22:01', 'images/photos/62/', 'user'),

(4, 0, 86, 'a', 'a', '', '2010-10-17 10:22:01', 'images/photos/62/', 'user'),
(5, 0, 86, 'a', 'a', '', '2010-10-17 10:22:01', 'images/photos/62/', 'user'),
(6, 0, 86, 'a', 'a', '', '2010-10-17 10:22:01', 'images/photos/62/', 'user')
;;


