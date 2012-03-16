
TRUNCATE TABLE `#__users`;;
INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'shyam@readybytes.in', '6a8c2b2fbc4ee1b4f3f042009d8a22f3:K5wzjZ3SlgIYTVPMaKt0wE0w6JUEJ2Bm', 'Super Administrator', 0, 1, 25, '2009-10-27 14:21:57', '2009-12-28 06:29:06', '', '\n'),
(82, 'regtest8774090', 'regtest8774090', 'regtest8774090@gmail.com', 'f478ff7ef92fcb7a7cb62d4c1f08e43a:7rptUeQifMIkdyqE59fnxb0o74NE4sk8', 'Editor', 0, 0, 20, '2009-12-03 08:16:35', '2009-12-28 06:28:45', 'a3a9fc5ff08868ee458cda29142e6e36', '\n'),
(83, 'regtest1789672', 'regtest1789672', 'regtest1789672@gmail.com', 'c33a3ac03bfbc13368383edc0e6ae42d:bUwtJXMI49daOhAPzdaLBdRY1IOOgm0D', 'Publisher', 0, 0, 21, '2009-12-03 08:16:44', '2009-12-28 06:28:52', 'a25e8cbbf5a534e0d5b934589be66756', '\n'),
(84, 'regtest6461827', 'regtest6461827', 'regtest6461827@gmail.com', '56f606098f0631341e8c398eaae179c6:aOJ5ghvQqtSCPnIH8SwFw90001MNaRI6', 'Registered', 0, 0, 18, '2009-12-03 08:16:52', '2009-12-28 06:28:59', 'd8e2cc8000b17d6791a451354a281937', '\n'),
(85, 'regtest3843261', 'regtest3843261', 'regtest3843261@gmail.com', '0f2e8c8f8433fd1604880e9ac0d33fc1:d4b8PHWIkuHEI4AfHM1XWkFh4sR4t1gj', 'Registered', 0, 0, 18, '2009-12-03 08:17:00', '0000-00-00 00:00:00', '0e11cd0ed924846a11c84e3618f2c5eb', '\n'),
(86, 'regtest1504555', 'regtest1504555', 'regtest1504555@gmail.com', '78c3901d9d2c31108f9f758a18ee7f89:UIbbRXlJUORtEqogoLPr9ZP0bouM0lLT', 'Editor', 0, 0, 20, '2009-12-03 08:17:09', '0000-00-00 00:00:00', '77981cae5948a5be5e553db5dcb8d00f', '\n'),
(87, 'regtest1674526', 'regtest1674526', 'regtest1674526@gmail.com', '948b72e649363975c49ba818d6880843:PezoDwP9dbIXQETtPbG0IfkpE0jogLi2', 'Publisher', 0, 0, 21, '2009-12-03 08:17:17', '0000-00-00 00:00:00', '51bcf29e8ec7bbaf00dc2160257b8987', '\n'),
(79, 'regtest7046025', 'regtest7046025', 'regtest7046025@gmail.com', '64d5a5a65e0433fefad4d52255857f59:rBhZVyCqDIKioTNuCNBkpQNhRXsCHb1t', 'Registered', 0, 0, 18, '2009-12-03 08:16:09', '2009-12-28 06:28:75', 'd45373ce0b2c4bfa6065235a5c353add', '\n'),
(80, 'regtest6208627', 'regtest6208627', 'regtest6208627@gmail.com', '73e7830c01e705a5adeaaa3e278fbdec:uQb0sUh0KdTyybJuHnYHAtpOmtfVNxr2', 'Editor', 0, 0, 20, '2009-12-03 08:16:18', '0000-00-00 00:00:00', '0e24ede794209ad6de9624f89077daed', '\n'),
(81, 'regtest8635954', 'regtest8635954', 'regtest8635954@gmail.com', '7dc28bb5bc0119a23ac236b82837586e:vBNJaILgct7EzdE4wmJANFeLuVSTLHdh', 'Publisher', 0, 0, 21, '2009-12-03 08:16:26', '0000-00-00 00:00:00', '1ebc22393cc2619be62d28fe7c960e5a', '\n'),
(88, 'regtest9754090', 'regtest9754090', 'regtest9754090@gmail.com', 'b5d1561e631ee61c2c1d6520eb9a5d53:Sn8uEOI2T0obmxNMnhEIdOS0hrKyIsAQ', 'Registered', 0, 0, 18, '2009-12-03 08:16:26', '2009-12-28 06:28:65', '7a8681dabe3df14e97f9df40701007a0', '\n');;

DROP TABLE IF EXISTS `au_#__users`;;
CREATE TABLE IF NOT EXISTS  `au_#__users` SELECT * FROM `#__users`;;
TRUNCATE TABLE `au_#__users`;;
INSERT INTO `au_#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'shyam@readybytes.in', '6a8c2b2fbc4ee1b4f3f042009d8a22f3:K5wzjZ3SlgIYTVPMaKt0wE0w6JUEJ2Bm', 'Super Administrator', 0, 1, 25, '2009-10-27 14:21:57', '2012-02-28 06:38:24', '', 'update_cache_list=1\n\n'),
(82, 'regtest8774090', 'regtest8774090', 'regtest8774090@gmail.com', 'f478ff7ef92fcb7a7cb62d4c1f08e43a:7rptUeQifMIkdyqE59fnxb0o74NE4sk8', 'Editor', 0, 0, 20, '2009-12-03 08:16:35', '2012-02-28 06:37:07', 'a3a9fc5ff08868ee458cda29142e6e36', 'update_cache_list=1\n\n'),
(83, 'regtest1789672', 'regtest1789672', 'regtest1789672@gmail.com', 'c33a3ac03bfbc13368383edc0e6ae42d:bUwtJXMI49daOhAPzdaLBdRY1IOOgm0D', 'Publisher', 0, 0, 21, '2009-12-03 08:16:44', '2012-02-28 06:37:30', 'a25e8cbbf5a534e0d5b934589be66756', 'update_cache_list=1\n\n'),
(84, 'regtest6461827', 'regtest6461827', 'regtest6461827@gmail.com', '56f606098f0631341e8c398eaae179c6:aOJ5ghvQqtSCPnIH8SwFw90001MNaRI6', 'Registered', 0, 0, 18, '2009-12-03 08:16:52', '2012-02-28 06:37:48', 'd8e2cc8000b17d6791a451354a281937', 'update_cache_list=1\n\n'),
(85, 'regtest3843261', 'regtest3843261', 'regtest3843261@gmail.com', '0f2e8c8f8433fd1604880e9ac0d33fc1:d4b8PHWIkuHEI4AfHM1XWkFh4sR4t1gj', 'Registered', 0, 0, 18, '2009-12-03 08:17:00', '0000-00-00 00:00:00', '0e11cd0ed924846a11c84e3618f2c5eb', '\n'),
(86, 'regtest1504555', 'regtest1504555', 'regtest1504555@gmail.com', '78c3901d9d2c31108f9f758a18ee7f89:UIbbRXlJUORtEqogoLPr9ZP0bouM0lLT', 'Editor', 0, 0, 20, '2009-12-03 08:17:09', '0000-00-00 00:00:00', '77981cae5948a5be5e553db5dcb8d00f', '\n'),
(87, 'regtest1674526', 'regtest1674526', 'regtest1674526@gmail.com', '948b72e649363975c49ba818d6880843:PezoDwP9dbIXQETtPbG0IfkpE0jogLi2', 'Publisher', 0, 0, 21, '2009-12-03 08:17:17', '0000-00-00 00:00:00', '51bcf29e8ec7bbaf00dc2160257b8987', '\n'),
(79, 'regtest7046025', 'regtest7046025', 'regtest7046025@gmail.com', '64d5a5a65e0433fefad4d52255857f59:rBhZVyCqDIKioTNuCNBkpQNhRXsCHb1t', 'Registered', 0, 0, 18, '2009-12-03 08:16:09', '2012-02-28 06:36:48', 'd45373ce0b2c4bfa6065235a5c353add', 'update_cache_list=1\n\n'),
(80, 'regtest6208627', 'regtest6208627', 'regtest6208627@gmail.com', '73e7830c01e705a5adeaaa3e278fbdec:uQb0sUh0KdTyybJuHnYHAtpOmtfVNxr2', 'Editor', 0, 0, 20, '2009-12-03 08:16:18', '0000-00-00 00:00:00', '0e24ede794209ad6de9624f89077daed', '\n'),
(81, 'regtest8635954', 'regtest8635954', 'regtest8635954@gmail.com', '7dc28bb5bc0119a23ac236b82837586e:vBNJaILgct7EzdE4wmJANFeLuVSTLHdh', 'Publisher', 0, 0, 21, '2009-12-03 08:16:26', '0000-00-00 00:00:00', '1ebc22393cc2619be62d28fe7c960e5a', '\n'),
(88, 'regtest9754090', 'regtest9754090', 'regtest9754090@gmail.com', 'b5d1561e631ee61c2c1d6520eb9a5d53:Sn8uEOI2T0obmxNMnhEIdOS0hrKyIsAQ', 'Registered', 0, 0, 18, '2009-12-03 08:16:26', '2012-02-28 06:38:06', '7a8681dabe3df14e97f9df40701007a0', 'update_cache_list=1\n\n');;

TRUNCATE TABLE `#__core_acl_aro`;;
INSERT INTO `#__core_acl_aro` (`id`, `section_value`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', '62', 0, 'Administrator', 0),
(31, 'users', '83', 0, 'regtest1789672', 0),
(28, 'users', '80', 0, 'regtest6208627', 0),
(32, 'users', '84', 0, 'regtest6461827', 0),
(35, 'users', '87', 0, 'regtest1674526', 0),
(33, 'users', '85', 0, 'regtest3843261', 0),
(34, 'users', '86', 0, 'regtest1504555', 0),
(29, 'users', '81', 0, 'regtest8635954', 0),
(27, 'users', '79', 0, 'regtest7046025', 0),
(30, 'users', '82', 0, 'regtest8774090', 0),
(36, 'users', '88', 0, 'regtest9754090', 0);;


TRUNCATE TABLE `#__core_acl_groups_aro_map`;;
INSERT INTO `#__core_acl_groups_aro_map` (`group_id`, `section_value`, `aro_id`) VALUES
(18, '', 27),
(18, '', 30),
(18, '', 33),
(20, '', 28),
(20, '', 31),
(20, '', 34),
(21, '', 29),
(21, '', 32),
(21, '', 35),
(25, '', 10),
(18, '', 36);;

DROP TABLE IF EXISTS `au_#__core_acl_groups_aro_map`;;
CREATE TABLE IF NOT EXISTS `au_#__core_acl_groups_aro_map` SELECT * FROM `#__core_acl_groups_aro_map`;;
TRUNCATE TABLE `au_#__core_acl_groups_aro_map`;;
INSERT INTO `au_#__core_acl_groups_aro_map` (`group_id`, `section_value`, `aro_id`) VALUES
(18, '', 27),
(18, '', 32),
(18, '', 33),
(18, '', 36),
(20, '', 28),
(20, '', 30),
(20, '', 34),
(21, '', 29),
(21, '', 31),
(21, '', 35),
(25, '', 10);;



TRUNCATE TABLE `#__community_users`;;
INSERT INTO `#__community_users` (`userid`, `status`, `status_access`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friends`, `groups`, `events`, `friendcount`, `alias`, `latitude`, `longitude`, `profile_id`, `storage`, `watermark_hash`, `search_email`) VALUES
(62, '', 0, 13, '0000-00-00 00:00:00', 'images/avatar/dlhfsadhfjskdlfjh.jpg', 'images/avatar/thumb_dlhfsadhfjskdlfjh.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\npostFacebookStatus=1\n\n', 0, '', '1,2,3,4', '', 0, '', 255, 255, 0, 'file', '', 1),
(83, '', 0, 3, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', '', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\npostFacebookStatus=1\n\n', 0, '', '', '', 0, '', 255, 255, 0, 'file', '', 1),
(84, '', 0, 3, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', '', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\npostFacebookStatus=1\n\n', 0, '', '4', '', 0, '', 255, 255, 0, 'file', '', 1),
(85, '', 0, 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, '', '', '', 0, '', 255, 255, 0, 'file', '', 1),
(86, '', 0, 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_2.gif', 'images/profiletype/avatar_2_thumb.gif', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, '', '', '', 0, '', 255, 255, 0, 'file', '', 1),
(87, '', 0, 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, '', '', '', 0, '', 255, 255, 0, 'file', '', 1),
(79, '', 0, 3, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', '', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\npostFacebookStatus=1\n\n', 0, '80,81', '1', '', 2, '', 255, 255, 0, 'file', '', 1),
(80, '', 0, 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_2.gif', 'images/profiletype/avatar_2_thumb.gif', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, '', '', '', 0, '', 255, 255, 0, 'file', '', 1),
(81, '', 0, 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, '', '', '', 0, '', 255, 255, 0, 'file', '', 1),
(82, '', 0, 3, '0000-00-00 00:00:00', 'images/profiletype/avatar_2.gif', 'images/profiletype/avatar_2_thumb.gif', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\npostFacebookStatus=1\n\n', 0, '', '1', '', 0, '', 255, 255, 0, 'file', '', 1),
(88, '', 0, 3, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', '', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\npostFacebookStatus=1\n\n', 0, '', '1', '', 0, '', 255, 255, 0, 'file', '', 1);;



DROP TABLE IF EXISTS `au_#__community_users`;;
CREATE TABLE IF NOT EXISTS `au_#__community_users` SELECT * FROM `#__community_users`;;
TRUNCATE TABLE `au_#__community_users`;;
INSERT INTO `au_#__community_users` (`userid`, `status`, `status_access`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friends`, `groups`, `events`, `friendcount`, `alias`, `latitude`, `longitude`, `profile_id`, `storage`, `watermark_hash`, `search_email`) VALUES
(62, '', 0, 14, '0000-00-00 00:00:00', 'images/avatar/dlhfsadhfjskdlfjh.jpg', 'images/avatar/thumb_dlhfsadhfjskdlfjh.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\npostFacebookStatus=1\n\n', 0, '', '1,2,3,4', '', 0, '', 255, 255, 0, 'file', '', 1),
(83, '', 0, 4, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', '', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\npostFacebookStatus=1\n\n', 0, '', '', '', 0, '', 255, 255, 0, 'file', '', 1),
(84, '', 0, 4, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', '', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\npostFacebookStatus=1\n\n', 0, '', '4', '', 0, '', 255, 255, 0, 'file', '', 1),
(85, '', 0, 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, '', '', '', 0, '', 255, 255, 0, 'file', '', 1),
(86, '', 0, 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_2.gif', 'images/profiletype/avatar_2_thumb.gif', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, '', '', '', 0, '', 255, 255, 0, 'file', '', 1),
(87, '', 0, 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, '', '', '', 0, '', 255, 255, 0, 'file', '', 1),
(79, '', 0, 4, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', '', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\npostFacebookStatus=1\n\n', 0, '80,81', '1', '', 2, '', 255, 255, 0, 'file', '', 1),
(80, '', 0, 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_2.gif', 'images/profiletype/avatar_2_thumb.gif', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, '', '', '', 0, '', 255, 255, 0, 'file', '', 1),
(81, '', 0, 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, '', '', '', 0, '', 255, 255, 0, 'file', '', 1),
(82, '', 0, 4, '0000-00-00 00:00:00', 'images/profiletype/avatar_2.gif', 'images/profiletype/avatar_2_thumb.gif', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\npostFacebookStatus=1\n\n', 0, '', '1', '', 0, '', 255, 255, 0, 'file', '', 1),
(88, '', 0, 4, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', '', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\npostFacebookStatus=1\n\n', 0, '', '1', '', 0, '', 255, 255, 0, 'file', '', 1);;



--
-- Table structure for table `#__community_groups`
--

TRUNCATE TABLE `#__community_groups` ;;
INSERT INTO `#__community_groups` (`id`, `published`, `ownerid`, `categoryid`, `name`, `description`, `email`, `website`, `approvals`, `created`, `avatar`, `thumb`, `discusscount`, `wallcount`, `membercount`, `params`) VALUES
(1, 1, 62, 4, 'Groups PT 1', 'Groups PT 1', '', '', 0, '2009-12-03 07:37:15', 'components/com_community/assets/groupAvatar.png', 'components/com_community/assets/groupThumbAvatar.png', 0, 0, 4, 'discussordering=1\nphotopermission=1\nvideopermission=1\n\n'),
(2, 1, 62, 4, 'Groups PT 2', 'Groups PT 2', '', '', 0, '2009-12-03 07:37:36', 'components/com_community/assets/groupAvatar.png', 'components/com_community/assets/groupThumbAvatar.png', 0, 0, 1, 'discussordering=1\nphotopermission=1\nvideopermission=1\n\n'),
(3, 1, 62, 4, 'Groups PT 3', 'Groups PT 3', '', '', 0, '2009-12-03 07:37:50', 'components/com_community/assets/groupAvatar.png', 'components/com_community/assets/groupThumbAvatar.png', 0, 0, 1, 'discussordering=1\nphotopermission=1\nvideopermission=1\n\n'),
(4, 1, 62, 4, 'Private Group', 'Private Group', '', '', 1, '2009-12-03 07:38:07', 'components/com_community/assets/groupAvatar.png', 'components/com_community/assets/groupThumbAvatar.png', 0, 0, 4, 'discussordering=1\nphotopermission=1\nvideopermission=1\n\n');;

-- --------------------------------------------------------

--
-- Table structure for table `#__community_groups_members`
--

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
(1, 88, 1, 0);;

DROP TABLE IF EXISTS `au_#__community_groups_members`;;
CREATE TABLE IF NOT EXISTS  `au_#__community_groups_members` SELECT * FROM `#__community_groups_members`;;
TRUNCATE TABLE `au_#__community_groups_members` ;;
INSERT INTO `au_#__community_groups_members` (`groupid`, `memberid`, `approved`, `permissions`) VALUES
(1, 62, 1, 1),
(2, 62, 1, 1),
(3, 62, 1, 1),
(4, 62, 1, 1),
(4, 81, 1, 0),
(1, 79, 1, 0),
(4, 83, 1, 0),
(1, 84, 1, 0),
(1, 85, 1, 0),
(4, 87, 1, 0),
(1, 88, 1, 0);;


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
(79, 1, 'default'),
(88, 10, 'default');;


DROP TABLE IF EXISTS `au_#__xipt_users`;; 
CREATE TABLE IF NOT EXISTS  `au_#__xipt_users` SELECT * FROM `#__xipt_users`;;
TRUNCATE TABLE `au_#__xipt_users`;;
INSERT INTO `au_#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 3, 'blueface'),
(87, 3, 'blackout'),
(86, 2, 'blueface'),
(85, 1, 'default'),
(84, 1, 'default'),
(83, 3, 'blackout'),
(82, 2, 'default'),
(81, 3, 'blackout'),
(80, 2, 'blueface'),
(79, 10, 'default'),
(88, 1, 'default');;



TRUNCATE TABLE  `#__community_fields_values`;;
INSERT INTO `#__community_fields_values` (`id`, `user_id`, `field_id`, `value`, `access`) VALUES
(22, 62, 3, 'default', 0),
(130, 81, 9, 'regtest8635954', 0),
(133, 82, 3, 'regtest8774090', 0),
(132, 82, 17, '1', 0),
(131, 82, 16, 'default', 0),
(159, 86, 2, 'regtest1504555', 0),
(158, 86, 17, '2', 0),
(157, 86, 16, 'blueface', 0),
(156, 85, 9, 'regtest3843261', 0),
(155, 85, 8, 'regtest3843261', 0),
(154, 85, 5, 'regtest3843261', 0),
(153, 85, 4, 'regtest3843261', 0),
(119, 80, 16, 'blueface', 0),
(118, 79, 9, 'regtest7046025', 0),
(23, 62, 4, '1', 0),
(117, 79, 8, 'regtest7046025', 0),
(116, 79, 5, 'regtest7046025', 0),
(135, 82, 5, 'regtest8774090', 0),
(134, 82, 4, 'regtest8774090', 0),
(139, 83, 17, '2', 0),
(138, 83, 16, 'blackout', 0),
(137, 82, 9, 'regtest8774090', 0),
(136, 82, 8, 'regtest8774090', 0),
(168, 87, 9, 'regtest1674526', 0),
(167, 87, 5, 'regtest1674526', 0),
(152, 85, 3, 'regtest3843261', 0),
(151, 85, 17, '1', 0),
(150, 85, 16, 'default', 0),
(149, 84, 9, 'regtest6461827', 0),
(148, 84, 5, 'regtest6461827', 0),
(147, 84, 17, '3', 0),
(146, 84, 16, 'default', 0),
(141, 83, 4, 'regtest1789672', 0),
(140, 83, 2, 'regtest1789672', 0),
(145, 83, 9, 'regtest1789672', 0),
(144, 83, 8, 'regtest1789672', 0),
(143, 83, 6, 'regtest1789672', 0),
(142, 83, 5, 'regtest1789672', 0),
(160, 86, 4, 'regtest1504555', 0),
(125, 80, 8, 'regtest6208627', 0),
(124, 80, 6, 'regtest6208627', 0),
(123, 80, 5, 'regtest6208627', 0),
(122, 80, 4, 'regtest6208627', 0),
(121, 80, 2, 'regtest6208627', 0),
(120, 80, 17, '2', 0),
(115, 79, 4, 'regtest7046025', 0),
(114, 79, 3, 'regtest7046025', 0),
(113, 79, 17, '1', 0),
(112, 79, 16, 'default', 0),
(162, 86, 6, 'regtest1504555', 0),
(161, 86, 5, 'regtest1504555', 0),
(166, 87, 17, '3', 0),
(165, 87, 16, 'blackout', 0),
(164, 86, 9, 'regtest1504555', 0),
(163, 86, 8, 'regtest1504555', 0),
(129, 81, 5, 'regtest8635954', 0),
(128, 81, 17, '3', 0),
(127, 81, 16, 'blackout', 0),
(126, 80, 9, 'regtest6208627', 0),
(170, 88, 3, 'regtest9754090', 0),
(171, 88, 17, '10', 0),
(172, 88, 16, 'default', 0),
(173, 79, 7, '', 0),
(174, 82, 7, '', 0),
(175, 88, 4, '', 0),
(176, 88, 5, '', 0),
(177, 88, 7, '', 0),
(178, 88, 8, '', 0),
(179, 88, 9, '', 0),
(180, 62, 5, '', 0),
(181, 62, 7, '', 0),
(182, 62, 8, '', 0),
(183, 62, 9, '', 0),
(184, 62, 16, 'blueface', 0),
(185, 62, 17, '10', 0);;

DROP TABLE IF EXISTS `au_#__community_fields_values`;;
CREATE TABLE IF NOT EXISTS `au_#__community_fields_values` SELECT * FROM `#__community_fields_values`;;
TRUNCATE TABLE  `au_#__community_fields_values`;;
INSERT INTO `au_#__community_fields_values` (`id`, `user_id`, `field_id`, `value`, `access`) VALUES
(22, 62, 3, 'default', 0),
(130, 81, 9, 'regtest8635954', 0),
(133, 82, 3, 'regtest8774090', 0),
(132, 82, 17, '2', 0),
(131, 82, 16, 'default', 0),
(159, 86, 2, 'regtest1504555', 0),
(158, 86, 17, '2', 0),
(157, 86, 16, 'blueface', 0),
(156, 85, 9, 'regtest3843261', 0),
(155, 85, 8, 'regtest3843261', 0),
(154, 85, 5, 'regtest3843261', 0),
(153, 85, 4, 'regtest3843261', 0),
(119, 80, 16, 'blueface', 0),
(118, 79, 9, 'regtest7046025', 0),
(23, 62, 4, '1', 0),
(117, 79, 8, 'regtest7046025', 0),
(116, 79, 5, 'regtest7046025', 0),
(135, 82, 5, 'regtest8774090', 0),
(134, 82, 4, 'regtest8774090', 0),
(139, 83, 17, '3', 0),
(138, 83, 16, 'blackout', 0),
(137, 82, 9, 'regtest8774090', 0),
(136, 82, 8, 'regtest8774090', 0),
(168, 87, 9, 'regtest1674526', 0),
(167, 87, 5, 'regtest1674526', 0),
(152, 85, 3, 'regtest3843261', 0),
(151, 85, 17, '1', 0),
(150, 85, 16, 'default', 0),
(149, 84, 9, 'regtest6461827', 0),
(148, 84, 5, 'regtest6461827', 0),
(147, 84, 17, '1', 0),
(146, 84, 16, 'default', 0),
(141, 83, 4, 'regtest1789672', 0),
(140, 83, 2, 'regtest1789672', 0),
(145, 83, 9, 'regtest1789672', 0),
(144, 83, 8, 'regtest1789672', 0),
(143, 83, 6, 'regtest1789672', 0),
(142, 83, 5, 'regtest1789672', 0),
(160, 86, 4, 'regtest1504555', 0),
(125, 80, 8, 'regtest6208627', 0),
(124, 80, 6, 'regtest6208627', 0),
(123, 80, 5, 'regtest6208627', 0),
(122, 80, 4, 'regtest6208627', 0),
(121, 80, 2, 'regtest6208627', 0),
(120, 80, 17, '2', 0),
(115, 79, 4, 'regtest7046025', 0),
(114, 79, 3, 'regtest7046025', 0),
(113, 79, 17, '10', 0),
(112, 79, 16, 'default', 0),
(162, 86, 6, 'regtest1504555', 0),
(161, 86, 5, 'regtest1504555', 0),
(166, 87, 17, '3', 0),
(165, 87, 16, 'blackout', 0),
(164, 86, 9, 'regtest1504555', 0),
(163, 86, 8, 'regtest1504555', 0),
(129, 81, 5, 'regtest8635954', 0),
(128, 81, 17, '3', 0),
(127, 81, 16, 'blackout', 0),
(126, 80, 9, 'regtest6208627', 0),
(170, 88, 3, 'regtest9754090', 0),
(171, 88, 17, '1', 0),
(172, 88, 16, 'default', 0),
(173, 79, 7, '', 0),
(174, 82, 7, '', 0),
(175, 88, 4, '', 0),
(176, 88, 5, '', 0),
(177, 88, 7, '', 0),
(178, 88, 8, '', 0),
(179, 88, 9, '', 0),
(180, 62, 5, '', 0),
(181, 62, 7, '', 0),
(182, 62, 8, '', 0),
(183, 62, 9, '', 0),
(184, 62, 16, 'blueface', 0),
(185, 62, 17, '3', 0);;
-- --------------------------------------------------------

