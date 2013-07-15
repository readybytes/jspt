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
(11, 'RULE-11', 'joingroup', 'core_profiletype=1\ncore_display_message=NotAllowed\ncore_redirect_url=index.php\n\n', 'joingroup_limit=0\n\n', 1),
(12, 'RULE-12', 'joingroup', 'core_profiletype=0\ncore_display_message=NotAllowed\ncore_redirect_url=index.php\n\n', 'joingroup_limit=0\n\n', 1),
(13, 'RULE-13', 'joingroup', 'core_profiletype=1\ncore_display_message=NotAllowed\ncore_redirect_url=index.php\n\n', 'joingroup_limit=2\n\n', 1)
;;

TRUNCATE TABLE `#__community_groups`;;
INSERT INTO `#__community_groups` (`id`, `published`, `ownerid`, `categoryid`, `name`) VALUES
(1, 1, 79, 4, 'pt1'),
(2, 1, 80, 4, 'pt2'),
(3, 1, 81, 4, 'pt3'),
(4, 1, 62, 4, 'admin')
;;

TRUNCATE TABLE `#__community_groups_members` ;;
INSERT INTO `#__community_groups_members` (`groupid`, `memberid`, `approved`, `permissions`) VALUES
(1, 79, 1, 0),
(2, 80, 1, 0),
(3, 81, 1, 0),

(2, 85, 1, 0),
(3, 85, 1, 0),

(1, 82, 1, 0),
(2, 82, 1, 0),
(3, 82, 1, 0)
;;

