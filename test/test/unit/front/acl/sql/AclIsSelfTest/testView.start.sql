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
(10, 'access event', 'accessevent', 'core_profiletype=3\ncore_display_message=YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE\ncore_redirect_url=index.php?option=com_community\n\n', 'other_profiletype=1\nacl_applicable_to_friend=1\nacl_applicable_to_self=1\n\n', 1),
(11, 'access event', 'accessevent', 'core_profiletype=3\ncore_display_message=YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE\ncore_redirect_url=index.php?option=com_community\n\n', 'other_profiletype=1\nacl_applicable_to_friend=0\nacl_applicable_to_self=0\n\n', 1);;



TRUNCATE TABLE `#__community_events`;;
INSERT INTO `#__community_events` (`id`, `catid`, `contentid`, `type`, `title`, `creator`, `published`) VALUES
(1, 2, 0, 'profile', 'myevent1',  85, 1),
(2, 2, 0, 'profile', 'myevent2',  86, 1),
(3, 2, 0, 'profile', 'myevent3',  87, 1);;

TRUNCATE TABLE  `#__community_connection` ;;
INSERT INTO `#__community_connection` (`connection_id`, `connect_from`, `connect_to`, `status`, `group`, `created`, `msg`) VALUES
(1, 85, 87, 1, 0, NULL, ''),
(2, 87, 85, 1, 0, NULL, '');;

