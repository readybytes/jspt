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
(10, 'access video category', 'accessvideocategory', 'core_profiletype=3\ncore_display_message=YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE\ncore_redirect_url=index.php?option=com_community\n\n', 'video_category=3\n\n', 1),
(11, 'access video category', 'accessvideocategory', 'core_profiletype=0\ncore_display_message=YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE\ncore_redirect_url=index.php?option=com_community\n\n', 'video_category=4\n\n', 1);;

TRUNCATE TABLE `#__community_videos` ;;
INSERT INTO `#__community_videos` 
(`id`, `title`, `type`, `video_id`, `description`, `creator`, `creator_type`, `created`, `permissions`, `category_id`) 
VALUES
(5, 'Kites Song F', 'youtube', 'PN626ZXD204', 'Kites', 84, 'user', '2010-05-25 11:57:38', '0', 3),
(6, 'PHP Tutorial', 'youtube', 'afgyNp5HueQ', 'PHP'  , 86, 'user', '2010-05-25 12:19:16', '0', 4),
(7, 'Hrithik R*',   'youtube', 'luXxeIlOoKU', 'Hrit' , 87, 'user', '2010-05-25 12:28:01', '0', 4)
;;

TRUNCATE TABLE `#__community_videos_category`;;
INSERT INTO `#__community_videos_category` (`id`,`name`,`description`,`published`) VALUES
(1,'General1','For general1 users',1),
(2,'General2','For general2 users',1),
(3,'General3','For general3 users',1),
(4,'General4','For general4 users',1),
(5,'General5','For general5 users',1);;


