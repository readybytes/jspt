TRUNCATE TABLE `#__session`;; /* Clean session */

TRUNCATE TABLE `#__xipt_profiletypes`;; /* Create various types */
INSERT INTO `#__xipt_profiletypes`  (`id`,`name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `config`)   VALUES 
(1,'PROFILETYPE-1', 2, '1', 'PROFILETYPE-ONE-TIP', 'privacyProfileView=10\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '1', 'jspt_restrict_reg_check=0\njspt_prevent_username=\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(2, 'PROFILETYPE-2', 1, '1', 'PROFILETYPE-TWO-TIP', 'privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'blueface', 'Editor', 'components/com_community/assets/group.jpg', '0', '0', '0', 'jspt_restrict_reg_check=0\njspt_prevent_username=\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(3, 'PROFILETYPE-3', 3, '1', 'PROFILETYPE-THREE-TIP', 'privacyProfileView=20\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'blackout', 'Publisher', 'components/com_community/assets/default.jpg', '0', '0', '4', 'jspt_restrict_reg_check=0\njspt_prevent_username=\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(4, 'PROFILETYPE-4', 4, '0', 'PROFILETYPE-THREE-TIP', 'privacyProfileView=20\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '0', 'jspt_restrict_reg_check=0\njspt_prevent_username=\njspt_allowed_email=\njspt_prevent_email=\n\n');;


/*store profiletype v/s fields */
TRUNCATE TABLE `#__xipt_profilefields`;;

INSERT INTO `#__xipt_profilefields` 
(`fid`, `pid`) VALUES
(2, 1),(2, 3),(2, 4), 	/*field 2 is for pt2*/
(3, 2),(3, 3),(3, 4), 	/*field 3 is for pt1*/
(4, 3),(4, 4), 			/*field 4 is for pt1,2*/
						/*5 is for all*/
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

TRUNCATE TABLE`#__xipt_settings`;;

INSERT INTO `#__xipt_settings` (`name`, `params`) VALUES
('settings', 'show_ptype_during_reg=1\nallow_user_to_change_ptype_after_reg=0\ndefaultProfiletypeID=1\nguestProfiletypeID=3\njspt_show_radio=1\njspt_fb_show_radio=1\nallow_templatechange=0\nshow_watermark=1\njspt_block_dis_app=1\nuser_reg=jomsocial\naec_integrate=1\naec_message=pl\n\n');;
