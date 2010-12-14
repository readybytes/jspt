TRUNCATE TABLE `#__core_acl_aro`;;
INSERT INTO `#__core_acl_aro` (`id`, `section_value`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', '62', 0, 'Administrator', 0),
(11, 'users', '63', 0, 'regtest8774090', 0),
(12, 'users', '64', 0, 'User2', 0),
(13, 'users', '65', 0, 'regtest6461827', 0),
(14, 'users', '66', 0, 'User22', 0),
(15, 'users', '99', 0, 'Manish', 0);;

TRUNCATE TABLE `#__core_acl_groups_aro_map`;;
INSERT INTO `#__core_acl_groups_aro_map` (`group_id`, `section_value`, `aro_id`) VALUES
(18, '', 11),
(18, '', 12),
(18, '', 13),
(18, '', 14),
(25, '', 10),
(21, '', 15);;


TRUNCATE TABLE `#__users`;;
INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'shyam@readybytes.in', '6a8c2b2fbc4ee1b4f3f042009d8a22f3:K5wzjZ3SlgIYTVPMaKt0wE0w6JUEJ2Bm', 'Super Administrator', 0, 1, 25, '2009-10-27 14:21:57', '2010-12-11 12:29:36', '', '\n'),
(63, 'regtest8774090', 'regtest8774090', 'regtest8774090@gmail.com', 'f478ff7ef92fcb7a7cb62d4c1f08e43a:7rptUeQifMIkdyqE59fnxb0o74NE4sk8', 'Registered', 0, 0, 18, '2009-12-03 08:16:35', '2010-06-15 08:36:29', 'a3a9fc5ff08868ee458cda29142e6e36', '\n'),
(64, 'regtest1789672', 'regtest1789672', 'regtest1789672@gmail.com', 'c33a3ac03bfbc13368383edc0e6ae42d:bUwtJXMI49daOhAPzdaLBdRY1IOOgm0D', 'Registered', 0, 0, 20, '2009-12-03 08:16:44', '0000-00-00 00:00:00', 'a25e8cbbf5a534e0d5b934589be66756', '\n'),
(65, 'regtest6461827', 'regtest6461827', 'regtest6461827@gmail.com', '56f606098f0631341e8c398eaae179c6:aOJ5ghvQqtSCPnIH8SwFw90001MNaRI6', 'Registered', 0, 0, 18, '2009-12-03 08:16:52', '0000-00-00 00:00:00', 'd8e2cc8000b17d6791a451354a281937', '\n'),
(66, 'regtest3843261', 'regtest3843261', 'regtest3843261@gmail.com', '0f2e8c8f8433fd1604880e9ac0d33fc1:d4b8PHWIkuHEI4AfHM1XWkFh4sR4t1gj', 'Registered', 0, 0, 18, '2009-12-03 08:17:00', '0000-00-00 00:00:00', '0e11cd0ed924846a11c84e3618f2c5eb', '\n'),
(99, 'Manish', 'manish', 'manish@gmail.com', '55955f13f3e32e11b8078c3265287f70:0T4e63zmgLFBQ2nN5KCHIbOhd9q12D4I', 'Publisher', 0, 0, 21, '2010-12-11 12:29:12', '0000-00-00 00:00:00', '7dbf68fe9ce02a6334c6b33a30789318', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n');;


TRUNCATE TABLE `#__community_users`;;
INSERT INTO `#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`, `alias`, `latitude`, `longitude`) VALUES
(62, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(63, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(64, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(65, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(66, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(99, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255);;


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


DROP TABLE IF EXISTS `au_#__xipt_users`;;
CREATE TABLE IF NOT EXISTS `au_#__xipt_users` SELECT * FROM `#__xipt_users`;;

TRUNCATE TABLE `au_#__xipt_users`;;
INSERT INTO `au_#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 1, 'default'),
(87, 3, 'blackout'),
(86, 2, 'blueface'),
(85, 1, 'default'),
(84, 3, 'blackout'),
(83, 2, 'blueface'),
(82, 1, 'default'),
(81, 3, 'blackout'),
(80, 2, 'blueface'),
(79, 1, 'default'),
(99, 3, 'blackout');;

TRUNCATE TABLE `#__xipt_settings`;;

INSERT INTO `#__xipt_settings` (`name`, `params`) VALUES
('settings', 'show_ptype_during_reg=1\nallow_user_to_change_ptype_after_reg=0\ndefaultProfiletypeID=1\nguestProfiletypeID=3\njspt_show_radio=0\njspt_fb_show_radio=1\nallow_templatechange=0\nshow_watermark=1\njspt_block_dis_app=1\nuser_reg=jomsocial\naec_integrate=0\naec_message=pl\n\n');;

TRUNCATE TABLE `#__xipt_profiletypes`;;

INSERT INTO `#__xipt_profiletypes`  (`id`,`name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `config`)   VALUES 
(1,'PROFILETYPE-1', 2, '1', 'PROFILETYPE-ONE-TIP', 'privacyProfileView=10\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '1','jspt_restrict_reg_check=0\njspt_prevent_username=\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(2, 'PROFILETYPE-2', 1, '1', 'PROFILETYPE-TWO-TIP', 'privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'blueface', 'Editor', 'components/com_community/assets/group.jpg', '0', '0', '0', 'jspt_restrict_reg_check=0\njspt_prevent_username=\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(3, 'PROFILETYPE-3', 3, '1', 'PROFILETYPE-THREE-TIP', 'privacyProfileView=20\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'blackout', 'Publisher', 'components/com_community/assets/default.jpg', '0', '0', '4', 'jspt_restrict_reg_check=0\njspt_prevent_username=\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(4, 'PROFILETYPE-4', 4, '0', 'PROFILETYPE-THREE-TIP', 'privacyProfileView=20\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '0', 'jspt_restrict_reg_check=0\njspt_prevent_username=\njspt_allowed_email=\njspt_prevent_email=\n\n');;
