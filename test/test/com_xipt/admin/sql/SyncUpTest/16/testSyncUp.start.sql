
TRUNCATE TABLE `#__users`;;

INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(42, 'Super User', 'admin', 'shyam@readybytes.in', '6a8c2b2fbc4ee1b4f3f042009d8a22f3:K5wzjZ3SlgIYTVPMaKt0wE0w6JUEJ2Bm', 'deprecated', 0, 1,  '2009-10-27 14:21:57', '2010-07-20 15:33:59', '', '\n'),
(82, 'regtest8774090', 'regtest8774090', 'regtest8774090@gmail.com', 'f478ff7ef92fcb7a7cb62d4c1f08e43a:7rptUeQifMIkdyqE59fnxb0o74NE4sk8', 'Manager', 0, 0, '2009-12-03 08:16:35', '0000-00-00 00:00:00', 'a3a9fc5ff08868ee458cda29142e6e36', '\n'),
(83, 'regtest1789672', 'regtest1789672', 'regtest1789672@gmail.com', 'c33a3ac03bfbc13368383edc0e6ae42d:bUwtJXMI49daOhAPzdaLBdRY1IOOgm0D', 'Editor', 0, 0, '2009-12-03 08:16:44', '0000-00-00 00:00:00', 'a25e8cbbf5a534e0d5b934589be66756', '\n'),
(84, 'regtest6461827', 'regtest6461827', 'regtest6461827@gmail.com', '56f606098f0631341e8c398eaae179c6:aOJ5ghvQqtSCPnIH8SwFw90001MNaRI6', 'Publisher', 0, 0, '2009-12-03 08:16:52', '0000-00-00 00:00:00', 'd8e2cc8000b17d6791a451354a281937', '\n'),
(85, 'regtest3843261', 'regtest3843261', 'regtest3843261@gmail.com', '0f2e8c8f8433fd1604880e9ac0d33fc1:d4b8PHWIkuHEI4AfHM1XWkFh4sR4t1gj', 'Manager', 0, 0, '2009-12-03 08:17:00', '0000-00-00 00:00:00', '0e11cd0ed924846a11c84e3618f2c5eb', '\n'),
(86, 'regtest1504555', 'regtest1504555', 'regtest1504555@gmail.com', '78c3901d9d2c31108f9f758a18ee7f89:UIbbRXlJUORtEqogoLPr9ZP0bouM0lLT', 'Editor', 0, 0, '2009-12-03 08:17:09', '0000-00-00 00:00:00', '77981cae5948a5be5e553db5dcb8d00f', '\n'),
(87, 'regtest1674526', 'regtest1674526', 'regtest1674526@gmail.com', '948b72e649363975c49ba818d6880843:PezoDwP9dbIXQETtPbG0IfkpE0jogLi2', 'Publisher', 0, 0, '2009-12-03 08:17:17', '0000-00-00 00:00:00', '51bcf29e8ec7bbaf00dc2160257b8987', '\n'),
(79, 'regtest7046025', 'regtest7046025', 'regtest7046025@gmail.com', '64d5a5a65e0433fefad4d52255857f59:rBhZVyCqDIKioTNuCNBkpQNhRXsCHb1t', 'Manager', 0, 0, '2009-12-03 08:16:09', '0000-00-00 00:00:00', 'd45373ce0b2c4bfa6065235a5c353add', '\n'),
(80, 'regtest6208627', 'regtest6208627', 'regtest6208627@gmail.com', '73e7830c01e705a5adeaaa3e278fbdec:uQb0sUh0KdTyybJuHnYHAtpOmtfVNxr2', 'Editor', 0, 0, '2009-12-03 08:16:18', '0000-00-00 00:00:00', '0e24ede794209ad6de9624f89077daed', '\n'),
(81, 'regtest8635954', 'regtest8635954', 'regtest8635954@gmail.com', '7dc28bb5bc0119a23ac236b82837586e:vBNJaILgct7EzdE4wmJANFeLuVSTLHdh', 'Publisher', 0, 0, '2009-12-03 08:16:26', '0000-00-00 00:00:00', '1ebc22393cc2619be62d28fe7c960e5a', '\n');;






TRUNCATE TABLE `#__community_users`;;
DROP TABLE IF EXISTS `au_#__community_users`;;
CREATE TABLE IF NOT EXISTS `au_#__community_users` SELECT * FROM `#__community_users`;;


INSERT INTO `#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`, `alias`, `longitude`, `latitude`) VALUES
(42, '', 12, '0000-00-00 00:00:00', 'components/com_community/assets/user.png', 'components/com_community/assets/user_thumb.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(83, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_2.gif', 'images/profiletype/avatar_2_thumb.gif', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(84, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/user.png', 'components/com_community/assets/user_thumb.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(85, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/user.png', 'components/com_community/assets/user_thumb.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(86, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_2.gif', 'images/profiletype/avatar_2_thumb.gif', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(87, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/user.png', 'components/com_community/assets/user_thumb.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(79, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/user.png', 'components/com_community/assets/user_thumb.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(80, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_2.gif', 'images/profiletype/avatar_2_thumb.gif', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(81, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/user.png', 'components/com_community/assets/user_thumb.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(82, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/user.png', 'components/com_community/assets/user_thumb.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255);;





INSERT INTO `au_#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`, `alias`, `longitude`, `latitude`) VALUES
(42, '', 12, '0000-00-00 00:00:00', 'components/com_community/assets/user.png', 'components/com_community/assets/user_thumb.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(83, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_1.png', 'images/profiletype/avatar_1_thumb.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(84, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_1.png', 'images/profiletype/avatar_1_thumb.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(85, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_1.png', 'images/profiletype/avatar_1_thumb.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(86, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_1.png', 'images/profiletype/avatar_1_thumb.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(87, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_1.png', 'images/profiletype/avatar_1_thumb.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(79, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_1.png', 'images/profiletype/avatar_1_thumb.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(80, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_1.png', 'images/profiletype/avatar_1_thumb.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(81, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_1.png', 'images/profiletype/avatar_1_thumb.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(82, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_1.png', 'images/profiletype/avatar_1_thumb.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255);;


TRUNCATE TABLE `#__xipt_profilefields` ;;

INSERT INTO `#__xipt_profilefields` (`id`, `fid`, `pid`, `category`) VALUES
(1, 2, 1, 0),
(2, 2, 3, 0),
(3, 2, 4, 0),
(4, 3, 2, 0),
(5, 3, 3, 0),
(6, 3, 4, 0),
(7, 4, 3, 0),
(8, 4, 4, 0),
(9, 6, 1, 0),
(10, 6, 3, 0),
(11, 6, 4, 0),
(12, 7, 2, 0),
(13, 7, 3, 0),
(14, 7, 4, 0),
(15, 8, 3, 0),
(16, 8, 4, 0);;


TRUNCATE TABLE `#__community_fields` ;;

INSERT INTO `#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`) VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basicr', 1, 1, 1, 1, '', ''),
(2, 'text', 2, 1, 5, 250, 'Hometown2', 'Hometown2', 1, 1, 1, 1, '', 'FIELD_HOMETOWN2'),
(3, 'text', 3, 1, 5, 250, 'Hometown3', 'Hometown3', 1, 0, 1, 1, '', 'FIELD_HOMETOWN3'),
(4, 'text', 4, 1, 5, 250, 'Hometown4', 'Hometown4', 1, 0, 1, 1, '', 'FIELD_HOMETOWN4'),
(5, 'text', 5, 1, 5, 250, 'Hometown5', 'Hometown5', 1, 0, 1, 1, '', 'FIELD_HOMETOWN5'),
(6, 'text', 6, 1, 5, 250, 'Hometown6', 'Hometown6', 0, 0, 1, 1, '', 'FIELD_HOMETOWN6'),
(7, 'text', 7, 1, 5, 250, 'Hometown7', 'Hometown7', 1, 0, 1, 0, '', 'FIELD_HOMETOWN7'),
(8, 'text', 8, 1, 5, 250, 'Hometown8', 'Hometown8', 1, 0, 1, 1, '', 'FIELD_HOMETOWN8'),
(9, 'text', 9, 1, 5, 250, 'Hometown9', 'Hometown9', 1, 0, 0, 1, '', 'FIELD_HOMETOWN9'),
(16, 'templates', 10, 1, 10, 100, 'Template', 'Template Of User', 1, 1, 1, 1, '', 'XIPT_TEMPLATE'),
(17, 'profiletypes', 11, 1, 10, 100, 'Profiletype', 'Profiletype Of User', 1, 1, 1, 1, '', 'XIPT_PROFILETYPE');;


TRUNCATE TABLE  `#__community_fields_values`;;

INSERT INTO `#__community_fields_values` (`id`, `user_id`, `field_id`, `value`) VALUES
(22, 42, 3, 'default'),
(130, 81, 9, 'regtest8635954'),
(133, 82, 3, 'regtest8774090'),
(132, 82, 17, '1'),
(131, 82, 16, 'default'),
(159, 86, 2, 'regtest1504555'),
(158, 86, 17, '2'),
(157, 86, 16, 'default'),
(156, 85, 9, 'regtest3843261'),
(155, 85, 8, 'regtest3843261'),
(154, 85, 5, 'regtest3843261'),
(153, 85, 4, 'regtest3843261'),
(119, 80, 16, 'default'),
(118, 79, 9, 'regtest7046025'),
(23, 42, 4, '1'),
(117, 79, 8, 'regtest7046025'),
(116, 79, 5, 'regtest7046025'),
(135, 82, 5, 'regtest8774090'),
(134, 82, 4, 'regtest8774090'),
(139, 83, 17, '2'),
(138, 83, 16, 'default'),
(137, 82, 9, 'regtest8774090'),
(136, 82, 8, 'regtest8774090'),
(168, 87, 9, 'regtest1674526'),
(167, 87, 5, 'regtest1674526'),
(152, 85, 3, 'regtest3843261'),
(151, 85, 17, '1'),
(150, 85, 16, 'default'),
(149, 84, 9, 'regtest6461827'),
(148, 84, 5, 'regtest6461827'),
(147, 84, 17, '3'),
(146, 84, 16, 'blackout'),
(141, 83, 4, 'regtest1789672'),
(140, 83, 2, 'regtest1789672'),
(145, 83, 9, 'regtest1789672'),
(144, 83, 8, 'regtest1789672'),
(143, 83, 6, 'regtest1789672'),
(142, 83, 5, 'regtest1789672'),
(160, 86, 4, 'regtest1504555'),
(125, 80, 8, 'regtest6208627'),
(124, 80, 6, 'regtest6208627'),
(123, 80, 5, 'regtest6208627'),
(122, 80, 4, 'regtest6208627'),
(121, 80, 2, 'regtest6208627'),
(120, 80, 17, '2'),
(115, 79, 4, 'regtest7046025'),
(114, 79, 3, 'regtest7046025'),
(113, 79, 17, '1'),
(112, 79, 16, 'default'),
(162, 86, 6, 'regtest1504555'),
(161, 86, 5, 'regtest1504555'),
(166, 87, 17, '3'),
(165, 87, 16, 'blackout'),
(164, 86, 9, 'regtest1504555'),
(163, 86, 8, 'regtest1504555'),
(129, 81, 5, 'regtest8635954'),
(128, 81, 17, '3'),
(127, 81, 16, 'blackout'),
(126, 80, 9, 'regtest6208627'),
(169, 42, 16, 'default');;

TRUNCATE TABLE `#__xipt_profiletypes` ;;

TRUNCATE TABLE `#__xipt_users`;;
DROP TABLE IF EXISTS `au_#__xipt_users`;;
CREATE TABLE IF NOT EXISTS `au_#__xipt_users` SELECT * FROM `#__xipt_users`;;


INSERT INTO `#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(42, 1, 'default'),
(87, 3, 'blackout'),
(86, 2, 'default'),
(85, 1, 'default'),
(84, 3, 'blackout'),
(83, 2, 'default'),
(82, 1, 'default'),
(81, 3, 'blackout'),
(80, 2, 'default'),
(79, 1, 'default');;

INSERT INTO `au_#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(42, 1, 'default'),
(87, 1, 'default'),
(86, 1, 'default'),
(85, 1, 'default'),
(84, 1, 'default'),
(83, 1, 'default'),
(82, 1, 'default'),
(81, 1, 'default'),
(80, 1, 'default'),
(79, 1, 'default');;

TRUNCATE TABLE `#__xipt_settings`;;
INSERT INTO `#__xipt_settings` (`name`, `params`) VALUES
('settings', 'show_ptype_during_reg=1\nallow_user_to_change_ptype_after_reg=0\ndefaultProfiletypeID=1\nguestProfiletypeID=1\njspt_show_radio=0\njspt_fb_show_radio=1\nallow_templatechange=0\nshow_watermark=1\njspt_block_dis_app=1\nsubscription_integrate=1\nsubscription_message=pl\nintegrate_with=aec\njspt_restrict_reg_check=1\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=\njspt_prevent_email=\nrestrict_advancesearchfield=1\n\n');;



