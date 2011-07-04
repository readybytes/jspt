TRUNCATE TABLE `#__community_users`;;

INSERT INTO `#__community_users`(`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`, `alias`, `latitude`, `longitude`) VALUES
(62, '', 12, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255),
(83, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255),
(84, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255),
(85, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255),
(86, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255),
(87, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255),
(79, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255),
(80, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255),
(81, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255),
(82, '', 2, '0000-00-00 00:00:00', 'images/avatar/23b20a8afc288ad7bcd02af4.jpg', 'images/avatar/thumb_23b20a8afc288ad7bcd02af4.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255);;

TRUNCATE TABLE  `#__xipt_users`;;

INSERT INTO `#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 2, 'blueface'),
(87, 2, 'blackout'),
(86, 1, 'blueface'),
(85, 1, 'blackout'),
(84, 3, 'blackout'),
(83, 3, 'blueface'),
(82, 2, 'blackout'),
(81, 2, 'blackout'),
(80, 2, 'blueface'),
(79, 1, 'blackout');;

DROP TABLE IF EXISTS `#__xipt_profiletypes`;;

CREATE TABLE IF NOT EXISTS `#__xipt_profiletypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `ordering` int(10) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `tip` text NOT NULL,
  `privacy` text NOT NULL,
  `template` varchar(50) NOT NULL DEFAULT 'default',
  `jusertype` varchar(50) NOT NULL DEFAULT 'Registered',
  `avatar` varchar(250) NOT NULL DEFAULT 'components/com_community/assets/default.jpg',
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  `allowt` tinyint(1) NOT NULL DEFAULT '0',
  `group` varchar(100) NOT NULL,
  `watermark` varchar(250) NOT NULL,
  `params` text NOT NULL,
  `watermarkparams` text NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `config` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;;

INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`, `config`) VALUES
(1, 'PROFILETYPE-1', 2, 1, '<p>PROFILETYPE-ONE-TIP</p>', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, '1', 'images/profiletype/watermark_1.png', '', 'enableWaterMark=1\nxiText=P1\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=1\n\n', 1, ''),
(2, 'PROFILETYPE-2', 1, 1, '<p>PROFILETYPE-TWO-TIP</p>', 'public', 'default', 'Registered', 'images/profiletype/avatar_2.jpg', 0, 0, '0', 'images/profiletype/watermark_2.png', '', 'enableWaterMark=1\nxiText=P2\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=2\n\n', 1, ''),
(3, 'PROFILETYPE-3', 3, 1, 'PROFILETYPE-THREE-TIP', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, '4', '', '', '', 1, ''),
(4, 'PROFILETYPE-4', 4, 0, 'PROFILETYPE-THREE-TIP', 'members', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, '0', '', '', '', 1, '');;

TRUNCATE TABLE `#__community_fields_values`;;

INSERT INTO `#__community_fields_values` (`id`, `user_id`, `field_id`, `value`) VALUES
(22, 62, 3, 'default'),
(130, 81, 9, 'regtest8635954'),
(133, 82, 3, 'regtest8774090'),
(132, 82, 17, '2'),
(131, 82, 16, 'default'),
(159, 86, 2, 'regtest1504555'),
(158, 86, 17, '1'),
(157, 86, 16, 'blueface'),
(156, 85, 9, 'regtest3843261'),
(155, 85, 8, 'regtest3843261'),
(154, 85, 5, 'regtest3843261'),
(153, 85, 4, 'regtest3843261'),
(119, 80, 16, 'blueface'),
(118, 79, 9, 'regtest7046025'),
(23, 62, 4, '1'),
(117, 79, 8, 'regtest7046025'),
(116, 79, 5, 'regtest7046025'),
(135, 82, 5, 'regtest8774090'),
(134, 82, 4, 'regtest8774090'),
(139, 83, 17, '3'),
(138, 83, 16, 'blueface'),
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
(166, 87, 17, '2'),
(165, 87, 16, 'blackout'),
(164, 86, 9, 'regtest1504555'),
(163, 86, 8, 'regtest1504555'),
(129, 81, 5, 'regtest8635954'),
(128, 81, 17, '2'),
(127, 81, 16, 'blackout'),
(126, 80, 9, 'regtest6208627');;

TRUNCATE TABLE  `#__xipt_settings`;;
INSERT INTO `#__xipt_settings` (`name`, `params`) VALUES
('settings', 'show_ptype_during_reg=1\nallow_user_to_change_ptype_after_reg=1\ndefaultProfiletypeID=1\nguestProfiletypeID=1\njspt_show_radio=0\njspt_fb_show_radio=1\njspt_block_dis_app=1\nuser_reg=jomsocial\nsubscription_integrate=1\nsubscription_message=pl\nintegrate_with=aec\nrestrict_advancesearchfield=1\n\n');;

