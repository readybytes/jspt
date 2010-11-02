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

TRUNCATE TABLE `#__users`;;
INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'shyam@readybytes.in', '6a8c2b2fbc4ee1b4f3f042009d8a22f3:K5wzjZ3SlgIYTVPMaKt0wE0w6JUEJ2Bm', 'Super Administrator', 0, 1, 25, '2009-10-27 14:21:57', '2010-11-01 11:45:50', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(82, 'regtest8774090', 'regtest8774090', 'regtest8774090@gmail.com', 'f478ff7ef92fcb7a7cb62d4c1f08e43a:7rptUeQifMIkdyqE59fnxb0o74NE4sk8', 'Registered', 0, 0, 18, '2009-12-03 08:16:35', '0000-00-00 00:00:00', 'a3a9fc5ff08868ee458cda29142e6e36', 'language=\ntimezone=0\n\n'),
(83, 'regtest1789672', 'regtest1789672', 'regtest1789672@gmail.com', 'c33a3ac03bfbc13368383edc0e6ae42d:bUwtJXMI49daOhAPzdaLBdRY1IOOgm0D', 'Registered', 0, 0, 18, '2009-12-03 08:16:44', '0000-00-00 00:00:00', 'a25e8cbbf5a534e0d5b934589be66756', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(84, 'regtest6461827', 'regtest6461827', 'regtest6461827@gmail.com', '56f606098f0631341e8c398eaae179c6:aOJ5ghvQqtSCPnIH8SwFw90001MNaRI6', 'Registered', 0, 0, 18, '2009-12-03 08:16:52', '0000-00-00 00:00:00', 'd8e2cc8000b17d6791a451354a281937', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(85, 'regtest3843261', 'regtest3843261', 'regtest3843261@gmail.com', '0f2e8c8f8433fd1604880e9ac0d33fc1:d4b8PHWIkuHEI4AfHM1XWkFh4sR4t1gj', 'Registered', 0, 0, 18, '2009-12-03 08:17:00', '0000-00-00 00:00:00', '0e11cd0ed924846a11c84e3618f2c5eb', 'language=\ntimezone=0\n\n'),
(86, 'regtest1504555', 'regtest1504555', 'regtest1504555@gmail.com', '78c3901d9d2c31108f9f758a18ee7f89:UIbbRXlJUORtEqogoLPr9ZP0bouM0lLT', 'Registered', 0, 0, 18, '2009-12-03 08:17:09', '0000-00-00 00:00:00', '77981cae5948a5be5e553db5dcb8d00f', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(87, 'regtest1674526', 'regtest1674526', 'regtest1674526@gmail.com', '948b72e649363975c49ba818d6880843:PezoDwP9dbIXQETtPbG0IfkpE0jogLi2', 'Registered', 0, 0, 18, '2009-12-03 08:17:17', '0000-00-00 00:00:00', '51bcf29e8ec7bbaf00dc2160257b8987', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(79, 'regtest7046025', 'regtest7046025', 'regtest7046025@gmail.com', '64d5a5a65e0433fefad4d52255857f59:rBhZVyCqDIKioTNuCNBkpQNhRXsCHb1t', 'Registered', 0, 0, 18, '2009-12-03 08:16:09', '0000-00-00 00:00:00', 'd45373ce0b2c4bfa6065235a5c353add', 'language=\ntimezone=0\n\n'),
(80, 'regtest6208627', 'regtest6208627', 'regtest6208627@gmail.com', '73e7830c01e705a5adeaaa3e278fbdec:uQb0sUh0KdTyybJuHnYHAtpOmtfVNxr2', 'Registered', 0, 0, 18, '2009-12-03 08:16:18', '0000-00-00 00:00:00', '0e24ede794209ad6de9624f89077daed', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(81, 'regtest8635954', 'regtest8635954', 'regtest8635954@gmail.com', '7dc28bb5bc0119a23ac236b82837586e:vBNJaILgct7EzdE4wmJANFeLuVSTLHdh', 'Registered', 0, 0, 18, '2009-12-03 08:16:26', '0000-00-00 00:00:00', '1ebc22393cc2619be62d28fe7c960e5a', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n');;

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
