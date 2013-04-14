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
(11, 'RULE-11', 'accessprofilevideo', 'core_profiletype=1\ncore_display_message=NotAllowed\ncore_redirect_url=index.php\n\n', 'other_profiletype=2\n\n', 1),
(12, 'RULE-12', 'accessprofilevideo', 'core_profiletype=2\ncore_display_message=NotAllowed\ncore_redirect_url=index.php\n\n', 'acl_applicable_to_friend=0\nother_profiletype=3\n\n', 1)
;;

TRUNCATE TABLE `#__community_videos` ;;
INSERT INTO `#__community_videos` 
(`id`, `title`, `type`, `video_id`, `description`, `creator`, `creator_type`, `created`, `permissions`, `category_id`) 
VALUES
(4, 'Kites Song F', 'youtube', 'PN626ZXD204', 'Kites', 84, 'user', '2010-05-25 11:57:38', '0', 1),
(6, 'PHP Tutorial', 'youtube', 'afgyNp5HueQ', 'PHP'  , 86, 'user', '2010-05-25 12:19:16', '0', 1),
(7, 'Hrithik R*',   'youtube', 'luXxeIlOoKU', 'Hrit' , 87, 'user', '2010-05-25 12:28:01', '0', 1)
;;


TRUNCATE TABLE  `#__community_connection` ;;
INSERT INTO `#__community_connection` (`connection_id`, `connect_from`, `connect_to`, `status`, `group`, `created`, `msg`) VALUES
(1, 84, 86, 1, 0, NULL, ''),
(2, 86, 84, 1, 0, NULL, '');;
