TRUNCATE TABLE `#__session`;; /* Clean session */
TRUNCATE TABLE `#__acctexp_temptoken`;; /* Clean session */

/*store profiletype v/s fields */
TRUNCATE TABLE `#__xipt_profilefields`;;

INSERT INTO `#__xipt_profilefields` 
(`fid`, `pid`) VALUES
(2, 1),(2, 3),(2, 4), 	/*field 2 is for pt2*/
(3, 2),(3, 3),(3, 4), 	/*field 3 is for pt1*/
(4, 3),(4, 4), 			/*field 4 is for pt1,2*/
/* 5 is for all*/
(6, 1),(6, 3),(6, 4), 	/*field 6 is for pt2*/
(7, 2),(7, 3),(7, 4), 	/*field 7 is for pt1*/
(8, 3),(8, 4);;			/*field 8 is for pt1,2*/
/*9 is for all*/

TRUNCATE TABLE `#__community_groups`;;
INSERT INTO `#__community_groups` (`id`, `published`, `ownerid`, `categoryid`, `name`, `description`, `email`, `website`, `approvals`, `created`, `avatar`, `thumb`, `discusscount`, `wallcount`, `membercount`, `params`) VALUES
(1, 1, 62, 4, 'Groups PT 1', 'Groups PT 1', '', '', 0, '2009-12-03 07:37:15', 'components/com_community/assets/groupAvatar.png', 'components/com_community/assets/groupThumbAvatar.png', 0, 0, 1, 'discussordering=1\nphotopermission=1\nvideopermission=1\n\n'),
(2, 1, 62, 4, 'Groups PT 2', 'Groups PT 2', '', '', 0, '2009-12-03 07:37:36', 'components/com_community/assets/groupAvatar.png', 'components/com_community/assets/groupThumbAvatar.png', 0, 0, 1, 'discussordering=1\nphotopermission=1\nvideopermission=1\n\n'),
(3, 1, 62, 4, 'Groups PT 3', 'Groups PT 3', '', '', 0, '2009-12-03 07:37:50', 'components/com_community/assets/groupAvatar.png', 'components/com_community/assets/groupThumbAvatar.png', 0, 0, 1, 'discussordering=1\nphotopermission=1\nvideopermission=1\n\n'),
(4, 1, 62, 4, 'Private Group', 'Private Group', '', '', 1, '2009-12-03 07:38:07', 'components/com_community/assets/groupAvatar.png', 'components/com_community/assets/groupThumbAvatar.png', 0, 0, 1, 'discussordering=1\nphotopermission=1\nvideopermission=1\n\n');;
