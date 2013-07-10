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
(10, 'access group category', 'accessgroupcategory', 'core_profiletype=3\ncore_display_message=YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE\ncore_redirect_url=index.php?option=com_community\n\n', 'group_category=3\n\n', 1),
(11, 'access group category', 'accessgroupcategory', 'core_profiletype=0\ncore_display_message=YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE\ncore_redirect_url=index.php?option=com_community\n\n', 'group_category=4\n\n', 1);;

TRUNCATE TABLE `#__community_groups`;;
INSERT INTO `#__community_groups` (`id`, `published`, `ownerid`, `categoryid`, `name`, `description`, `email`, `website`, `approvals`, `created`, `avatar`, `thumb`, `discusscount`, `wallcount`, `membercount`) VALUES
(5, 1, 86, 3, 'pt2', 'pt2', '', '', 0, '2010-05-25 12:31:16', 'components/com_community/assets/groupAvatar.png', 'components/com_community/assets/groupThumbAvatar.png', 0, 0, 1),
(6, 1, 85, 4, 'pt1', 'aaaa', '', '', 0, '2010-05-25 12:37:15', 'components/com_community/assets/groupAvatar.png', 'components/com_community/assets/groupThumbAvatar.png', 0, 0, 1),
(7, 1, 87, 4, 'pt3', 'ytut', '', '', 0, '2010-05-25 12:40:14', 'components/com_community/assets/groupAvatar.png', 'components/com_community/assets/groupThumbAvatar.png', 0, 0, 1)
;;

TRUNCATE TABLE `#__community_groups_category`;;
INSERT INTO `#__community_groups_category` (`id`,`name`,`description`) VALUES
(1,'General1','For general1 users'),
(2,'General2','For general2 users'),
(3,'General3','For general3 users'),
(4,'General4','For general4 users'),
(5,'General5','For general5 users');;


