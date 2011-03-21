TRUNCATE TABLE `#__xipt_profiletypes`;;
DROP TABLE IF EXISTS `au_#__xipt_profiletypes`;;
CREATE TABLE `au_#__xipt_profiletypes` SELECT * FROM `#__xipt_profiletypes`;;

INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`) VALUES
(1, 'ProfileType1', 1, 1, '', 'privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=0\n\n'),
(2, 'ProfileType2', 2, 1, '', 'privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=0\n\n'),
(3, 'ProfileType3', 3, 1, '', 'privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'components/com_community/assets/group.jpg', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=0\n\n');;

TRUNCATE TABLE `au_#__xipt_profiletypes`;;
INSERT INTO `au_#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`) VALUES
(1, 'ProfileType1', 1, 1, '', 'privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'images/profiletype/avatar_1.png', 0, 0, 0, 'images/profiletype/watermark_1.png', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=0\n\n'),
(2, 'ProfileType2', 2, 1, '', 'privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=0\n\n'),
(3, 'ProfileType3', 3, 1, '', 'privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'components/com_community/assets/group.jpg', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=0\n\n');;



TRUNCATE TABLE `#__xipt_users`;;
INSERT INTO `#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 1, 'default'),
(88, 1, 'default'),
(89, 2, 'blackout'),
(90, 1, 'default');;

TRUNCATE TABLE `#__community_users`;;
DROP TABLE IF EXISTS `au_#__community_users`;;
CREATE TABLE `au_#__community_users` SELECT * FROM `#__community_users`;;

INSERT INTO `#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`) VALUES
(62, '', 12, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(88, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(89, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(90, '', 2, '0000-00-00 00:00:00', 'test/test/com_xipt/admin/avatar_1.png', 'test/test/com_xipt/admin/avatar_1.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0);;

TRUNCATE TABLE `au_#__community_users`;;
INSERT INTO `au_#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`) VALUES
(62, '', 12, '0000-00-00 00:00:00', 'images/profiletype/avatar_1.png', 'images/profiletype/avatar_1_thumb.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(88, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_1.png', 'images/profiletype/avatar_1_thumb.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(89, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(90, '', 2, '0000-00-00 00:00:00', 'test/test/com_xipt/admin/avatar_1.png', 'test/test/com_xipt/admin/avatar_1.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0);;
