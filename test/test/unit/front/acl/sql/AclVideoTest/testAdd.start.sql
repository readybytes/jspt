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
(11, 'RULE-11', 'addvideos', 'core_profiletype=1\ncore_display_message=NotAllowed\ncore_redirect_url=index.php\n\n', 'addvideos_limit=0\n\n', 1),
(12, 'RULE-12', 'addvideos', 'core_profiletype=2\ncore_display_message=NotAllowed\ncore_redirect_url=index.php\n\n', 'addvideos_limit=1\n\n', 1),
(13, 'RULE-13', 'addvideos', 'core_profiletype=2\ncore_display_message=NotAllowed\ncore_redirect_url=index.php\n\n', 'addvideos_limit=2\n\n', 1),
(14, 'RULE-14', 'addvideos', 'core_profiletype=2\ncore_display_message=NotAllowed\ncore_redirect_url=index.php\n\n', 'addvideos_limit=3\n\n', 1)
;;


TRUNCATE TABLE `#__community_videos` ;;
INSERT INTO `#__community_videos` 
(`id`, `title`, `type`, `video_id`, `description`, `creator`, `creator_type`, `created`, `permissions`, `category_id`,`status`) 
VALUES
(10, 'Kites Song F', 'youtube', 'PN626ZXD204', 'Kites', 80, 'user', '2010-05-25 11:57:38', '0', 1,'ready'),
(3, 'PHP Tutorial', 'youtube', 'afgyNp5HueQ', 'PHP'  , 83, 'user', '2010-05-25 12:19:16', '0',  1,'ready'),
(13, 'Hrithik R*',   'youtube', 'luXxeIlOoKU', 'Hrit' , 83, 'user', '2010-05-25 12:28:01', '0', 1,'ready'),
(16, 'Kites Song F', 'youtube', 'PN626ZXD204', 'Kites', 86, 'user', '2010-05-25 11:57:38', '0', 1,'ready'),
(26, 'PHP Tutorial', 'youtube', 'afgyNp5HueQ', 'PHP'  , 86, 'user', '2010-05-25 12:19:16', '0', 1,'ready'),
(36, 'Hrithik R*',   'youtube', 'luXxeIlOoKU', 'Hrit' , 86, 'user', '2010-05-25 12:28:01', '0', 1,'ready')
;;



