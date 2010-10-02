

TRUNCATE TABLE `#__community_groups_members` ;;

INSERT INTO `#__community_groups_members` (`groupid`, `memberid`, `approved`, `permissions`) VALUES
(1, 62, 1, 1),
(2, 62, 1, 1),
(3, 62, 1, 1),
(4, 62, 1, 1),
(4, 81, 1, 0),
(1, 79, 1, 0),
(1, 82, 1, 0),
(4, 84, 1, 0),
(1, 85, 1, 0),
(4, 87, 1, 0),
(2, 83, 1, 0),
(3, 83, 1, 0);;



TRUNCATE TABLE `au_#__community_groups_members` ;;

INSERT INTO `au_#__community_groups_members` (`groupid`, `memberid`, `approved`, `permissions`) VALUES
(1, 62, 1, 1),
(2, 62, 1, 1),
(3, 62, 1, 1),
(4, 62, 1, 1),
(4, 81, 1, 0),
(1, 79, 1, 0),
(1, 82, 1, 0),
(4, 84, 1, 0),
(1, 85, 1, 0),
(4, 87, 1, 0);;

TRUNCATE TABLE `#__community_groups`;;

INSERT INTO `#__community_groups` (`id`, `published`, `ownerid`, `categoryid`, `name`, `description`, `email`, `website`, `approvals`, `created`, `avatar`, `thumb`, `discusscount`, `wallcount`, `membercount`, `params`) VALUES
(1, 1, 62, 4, 'Groups PT 1', 'Groups PT 1', '', '', 0, '2009-12-03 07:37:15', 'components/com_community/assets/groupAvatar.png', 'components/com_community/assets/groupThumbAvatar.png', 0, 0, 4, 'discussordering=1\nphotopermission=1\nvideopermission=1\n\n'),
(2, 1, 62, 4, 'Groups PT 2', 'Groups PT 2', '', '', 0, '2009-12-03 07:37:36', 'components/com_community/assets/groupAvatar.png', 'components/com_community/assets/groupThumbAvatar.png', 0, 0, 1, 'discussordering=1\nphotopermission=1\nvideopermission=1\n\n'),
(3, 1, 62, 4, 'Groups PT 3', 'Groups PT 3', '', '', 0, '2009-12-03 07:37:50', 'components/com_community/assets/groupAvatar.png', 'components/com_community/assets/groupThumbAvatar.png', 0, 0, 1, 'discussordering=1\nphotopermission=1\nvideopermission=1\n\n'),
(4, 1, 62, 4, 'Private Group', 'Private Group', '', '', 1, '2009-12-03 07:38:07', 'components/com_community/assets/groupAvatar.png', 'components/com_community/assets/groupThumbAvatar.png', 0, 0, 4, 'discussordering=1\nphotopermission=1\nvideopermission=1\n\n');;
