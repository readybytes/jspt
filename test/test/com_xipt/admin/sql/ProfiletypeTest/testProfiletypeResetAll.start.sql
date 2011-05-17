TRUNCATE TABLE `#__xipt_aclrules`;;

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
(22, 62, 3, 'default'),
(130, 81, 9, 'regtest8635954'),
(133, 82, 3, 'regtest8774090'),
(132, 82, 17, '1'),
(131, 82, 16, 'default'),
(159, 86, 2, 'regtest1504555'),
(158, 86, 17, '2'),
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
(139, 83, 17, '2'),
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
(166, 87, 17, '3'),
(165, 87, 16, 'blackout'),
(164, 86, 9, 'regtest1504555'),
(163, 86, 8, 'regtest1504555'),
(129, 81, 5, 'regtest8635954'),
(128, 81, 17, '3'),
(127, 81, 16, 'blackout'),
(126, 80, 9, 'regtest6208627');;

DROP TABLE IF EXISTS `au_#__community_fields_values`;;
CREATE TABLE IF NOT EXISTS `au_#__community_fields_values` SELECT * FROM `#__community_fields_values`;;
TRUNCATE TABLE  `au_#__community_fields_values`;;
INSERT INTO `au_#__community_fields_values` (`id`, `user_id`, `field_id`, `value`) VALUES
(22, 62, 3, 'default'),
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
(23, 62, 4, '1'),
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
(126, 80, 9, 'regtest6208627');;


TRUNCATE TABLE `#__community_groups` ;;
INSERT INTO `#__community_groups` (`id`, `published`, `ownerid`, `categoryid`, `name`, `description`, `email`, `website`, `approvals`, `created`, `avatar`, `thumb`, `discusscount`, `wallcount`, `membercount`, `params`) VALUES
(1, 1, 62, 4, 'Groups PT 1', 'Groups PT 1', '', '', 0, '2009-12-03 07:37:15', 'components/com_community/assets/groupAvatar.png', 'components/com_community/assets/groupThumbAvatar.png', 0, 0, 4, 'discussordering=1\nphotopermission=1\nvideopermission=1\n\n'),
(2, 1, 62, 4, 'Groups PT 2', 'Groups PT 2', '', '', 0, '2009-12-03 07:37:36', 'components/com_community/assets/groupAvatar.png', 'components/com_community/assets/groupThumbAvatar.png', 0, 0, 1, 'discussordering=1\nphotopermission=1\nvideopermission=1\n\n'),
(3, 1, 62, 4, 'Groups PT 3', 'Groups PT 3', '', '', 0, '2009-12-03 07:37:50', 'components/com_community/assets/groupAvatar.png', 'components/com_community/assets/groupThumbAvatar.png', 0, 0, 1, 'discussordering=1\nphotopermission=1\nvideopermission=1\n\n'),
(4, 1, 62, 4, 'Private Group', 'Private Group', '', '', 1, '2009-12-03 07:38:07', 'components/com_community/assets/groupAvatar.png', 'components/com_community/assets/groupThumbAvatar.png', 0, 0, 4, 'discussordering=1\nphotopermission=1\nvideopermission=1\n\n');;


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
(4, 87, 1, 0);;

DROP TABLE IF EXISTS `au_#__community_groups_members`;;
CREATE TABLE IF NOT EXISTS  `au_#__community_groups_members` SELECT * FROM `#__community_groups_members`;;
TRUNCATE TABLE `au_#__community_groups_members` ;;
INSERT INTO `au_#__community_groups_members` (`groupid`, `memberid`, `approved`, `permissions`) VALUES
(1, 62, 1, 1),
(2, 62, 1, 1),
(3, 62, 1, 1),
(4, 62, 1, 1),
(2, 81, 1, 0),
(1, 79, 1, 0),
(1, 82, 1, 0),
(2, 84, 1, 0),
(1, 85, 1, 0),
(2, 87, 1, 0);;


TRUNCATE TABLE `#__community_users`;;
INSERT INTO `#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`) VALUES
(62, '', 12, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(83, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_2.gif', 'images/profiletype/avatar_2_thumb.gif', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(84, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(85, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=00\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(86, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_2.gif', 'images/profiletype/avatar_2_thumb.gif', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(87, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(79, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(80, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_2.gif', 'images/profiletype/avatar_2_thumb.gif', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(81, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(82, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0);;


DROP TABLE IF EXISTS `au_#__community_users`;;
CREATE TABLE IF NOT EXISTS `au_#__community_users` SELECT * FROM `#__community_users`;;
TRUNCATE TABLE `au_#__community_users`;;
INSERT INTO `au_#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`) VALUES
(62, '', 12, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(83, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_2.gif', 'images/profiletype/avatar_2_thumb.gif', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(84, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(85, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(86, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_2.gif', 'images/profiletype/avatar_2_thumb.gif', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(87, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(79, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(80, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_2.gif', 'images/profiletype/avatar_2_thumb.gif', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(81, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(82, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0);;


TRUNCATE TABLE `#__xipt_profilefields` ;;
INSERT INTO `#__xipt_profilefields` (`id`, `fid`, `pid`) VALUES
(1, 2, 1),
(2, 2, 3),
(3, 2, 4),
(4, 3, 2),
(5, 3, 3),
(6, 3, 4),
(7, 4, 3),
(8, 4, 4),
(9, 6, 1),
(10, 6, 3),
(11, 6, 4),
(12, 7, 2),
(13, 7, 3),
(14, 7, 4),
(15, 8, 3),
(16, 8, 4);;


TRUNCATE TABLE `#__xipt_profiletypes` ;;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`) VALUES
(1, 'PROFILETYPE-1', 2, 1, 'PROFILETYPE-ONE-TIP', 'jsPrivacyController=1\nprivacyProfileView=0\nprivacyFriendsView=0\nprivacyPhotoView=0\nprivacyVideoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 1, '', '', 'enableWaterMark=0\nxiText=Profiletype1\nxiWidth=150\nxiHeight=30\nxiThumbWidth=80\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=24\nxiTextColor=FFFFFF\nxiBackgroundColor=0F15D0\nxiWatermarkPosition=tr\ndemo=1\n\n'),
(2, 'PROFILETYPE-2', 1, 1, 'PROFILETYPE-TWO-TIP', 'jsPrivacyController=1\nprivacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nprivacyVideoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'blueface', 'Editor', 'images/profiletype/avatar_2.gif', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=Profiletype2\nxiWidth=160\nxiHeight=40\nxiThumbWidth=80\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=2\n\n'),
(3, 'PROFILETYPE-3', 3, 1, 'PROFILETYPE-THREE-TIP', 'jsPrivacyController=1\nprivacyProfileView=20\nprivacyFriendsView=0\nprivacyPhotoView=0\nprivacyVideoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'blackout', 'Publisher', 'components/com_community/assets/default.jpg', 0, 0, 4, '', '', 'enableWaterMark=0\nxiText=Profiletype3\nxiWidth=100\nxiHeight=40\nxiThumbWidth=80\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=18\nxiTextColor=FFFFFF\nxiBackgroundColor=0F15D0\nxiWatermarkPosition=rb\ndemo=3\n\n'),
(4, 'PROFILETYPE-4', 4, 0, 'PROFILETYPE-FOUR-TIP', 'jsPrivacyController=1\nprivacyProfileView=20\nprivacyFriendsView=0\nprivacyPhotoView=0\nprivacyVideoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=Profiletype4\nxiWidth=100\nxiHeight=40\nxiThumbWidth=80\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=18\nxiTextColor=FFFFFF\nxiBackgroundColor=0F15D0\nxiWatermarkPosition=rb\ndemo=4\n\n');;

DROP TABLE IF EXISTS `au_#__xipt_profiletypes`;;
CREATE TABLE IF NOT EXISTS `au_#__xipt_profiletypes` SELECT * FROM `#__xipt_profiletypes`;;
TRUNCATE TABLE `au_#__xipt_profiletypes` ;;
INSERT INTO `au_#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`) VALUES
(1, 'PROFILETYPE-1', 2, 1, 'PROFILETYPE-ONE-TIP', 'jsPrivacyController=1\nprivacyProfileView=0\nprivacyFriendsView=0\nprivacyPhotoView=0\nprivacyVideoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Manager', 'components/com_community/assets/default.jpg', 0, 0, 1, '', '', 'enableWaterMark=0\nxiText=Profiletype1\nxiWidth=150\nxiHeight=30\nxiThumbWidth=80\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=24\nxiTextColor=FFFFFF\nxiBackgroundColor=0F15D0\nxiWatermarkPosition=tr\ndemo=1\n\n'),
(2, 'PROFILETYPE-2', 1, 1, 'PROFILETYPE-TWO-TIP', 'jsPrivacyController=1\nprivacyProfileView=0\nprivacyFriendsView=0\nprivacyPhotoView=0\nprivacyVideoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Editor', 'images/profiletype/avatar_2.gif', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=Profiletype2\nxiWidth=160\nxiHeight=40\nxiThumbWidth=80\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=2\n\n'),
(3, 'PROFILETYPE-3', 3, 1, 'PROFILETYPE-THREE-TIP', 'jsPrivacyController=1\nprivacyProfileView=20\nprivacyFriendsView=0\nprivacyPhotoView=0\nprivacyVideoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'blackout', 'Publisher', 'components/com_community/assets/default.jpg', 0, 0, 2, '', '', 'enableWaterMark=0\nxiText=Profiletype3\nxiWidth=100\nxiHeight=40\nxiThumbWidth=80\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=18\nxiTextColor=FFFFFF\nxiBackgroundColor=0F15D0\nxiWatermarkPosition=rb\ndemo=3\n\n'),
(4, 'PROFILETYPE-4', 4, 0, 'PROFILETYPE-FOUR-TIP', 'jsPrivacyController=1\nprivacyProfileView=20\nprivacyFriendsView=0\nprivacyPhotoView=0\nprivacyVideoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=Profiletype4\nxiWidth=100\nxiHeight=40\nxiThumbWidth=80\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=18\nxiTextColor=FFFFFF\nxiBackgroundColor=0F15D0\nxiWatermarkPosition=rb\ndemo=4\n\n');;

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
CREATE TABLE IF NOT EXISTS  `au_#__xipt_users` SELECT * FROM `#__xipt_users`;;
TRUNCATE TABLE `au_#__xipt_users`;;
INSERT INTO `au_#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 1, 'default'),
(87, 3, 'blackout'),
(86, 2, 'default'),
(85, 1, 'default'),
(84, 3, 'blackout'),
(83, 2, 'default'),
(82, 1, 'default'),
(81, 3, 'blackout'),
(80, 2, 'default'),
(79, 1, 'default');;
