

TRUNCATE TABLE `#__community_users`;;

INSERT INTO `#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`, `alias`, `latitude`, `longitude`) VALUES
(62, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(63, '', 4, '0000-00-00 00:00:00', 'test/test/unit/front/setup/images/avatar_1.gif', 'test/test/unit/front/setup/images/avatar_1_thumb.gif', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(64, '', 2, '0000-00-00 00:00:00', 'images/avatar/77a4023572dee874956a16c5.jpg', 'images/avatar/thumb_77a4023572dee874956a16c5.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255);;


TRUNCATE TABLE `#__users`;;

INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'shyam@readybytes.in', '6a8c2b2fbc4ee1b4f3f042009d8a22f3:K5wzjZ3SlgIYTVPMaKt0wE0w6JUEJ2Bm', 'Super Administrator', 0, 1, 25, '2009-10-27 14:21:57', '2010-12-04 05:20:40', '', ''),
(63, '123', '123', '123@gg.com', '37a7633c128d44bd93629348a746ee82:TVa8P2R0wf8tHDitikdUDOTpNMLj5jtG', 'Registered', 0, 0, 18, '2010-12-03 12:08:03', '2010-12-04 05:52:26', 'b39ac6adf13f344ce78a26a7a8f14527', '\n'),
(64, '1234', '1234', '1234@gg.com', '53403598fcc62b2d65ecf9ce2a322a55:p495nv2jRhMwzrqh25Y9niFuED76tbtk', 'Registered', 0, 0, 18, '2010-12-04 05:36:47', '2010-12-04 05:52:21', 'bb28b660e01fc9e1782d07aaec9045d3', '\n');;


TRUNCATE TABLE `#__xipt_profiletypes`;;

INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`, `config`) VALUES
(1, 'PROFILETYPE-1', 1, 1, '', 'privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, '0', 'test/test/unit/front/setup/images/watermark_1.png', '', 'enableWaterMark=0\nxiText=AAA\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tr\ndemo=0\n\n', 1, 'jspt_restrict_reg_check=0\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(2, 'PROFILETYPE-2', 2, 1, '', '', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, '', '', '', '', 1, '');;

TRUNCATE TABLE `#__xipt_settings`;;

INSERT INTO `#__xipt_settings` (`name`, `params`) VALUES
('settings', 'defaultProfiletypeID=1\n');;

TRUNCATE TABLE  `#__xipt_users` ;;

INSERT INTO `#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 1, 'default'),
(63, 1, 'default'),
(64, 2, 'default');;
