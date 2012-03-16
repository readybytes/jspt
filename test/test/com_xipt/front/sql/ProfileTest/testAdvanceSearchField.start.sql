
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
(9, 'text', 9, 1, 5, 250, 'Hometown9', 'Hometown9', 1, 0, 1, 1, '', 'FIELD_HOMETOWN9'),
(16, 'templates', 10, 1, 10, 100, 'Template', 'Template Of User', 1, 1, 1, 1, '', 'XIPT_TEMPLATE'),
(17, 'profiletypes', 11, 1, 10, 100, 'Profiletype', 'Profiletype Of User', 1, 1, 1, 1, '', 'XIPT_PROFILETYPE');;



--
-- Table structure for table `#__community_users`
--

TRUNCATE TABLE `#__community_users`;;
INSERT INTO `#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`) VALUES
(62, '', 12, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(83, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(84, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(85, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(86, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_2.jpg', 'images/profiletype/avatar_2_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(87, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(79, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(80, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_2.jpg', 'images/profiletype/avatar_2_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(81, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(82, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0);;

TRUNCATE TABLE `#__xipt_profilefields` ;;
INSERT INTO `#__xipt_profilefields` (`id`, `fid`, `pid`, `category`) VALUES
(1, 2, 1, 1),
(2, 2, 3, 1),
(3, 2, 4, 1),
(4, 3, 2, 2),
(5, 3, 3, 2),
(6, 3, 4, 1),
(7, 4, 3, 3),
(8, 4, 4, 1),
(9, 6, 1, 2),
(10, 6, 3, 2),
(11, 6, 4, 3),
(12, 7, 2, 3),
(13, 7, 3, 1),
(14, 7, 4, 2),
(15, 8, 3, 3),
(16, 8, 4, 1);;


TRUNCATE TABLE `#__xipt_profiletypes` ;;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`) VALUES
(1, 'PROFILETYPE-1', 2, 1, '<p>PROFILETYPE-ONE-TIP</p>', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 1, '', '', 'enableWaterMark=0\nxiText=P1\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=1\n\n'),
(2, 'PROFILETYPE-2', 1, 1, '<p>PROFILETYPE-TWO-TIP</p>', 'friends', 'blueface', 'Editor', 'images/profiletype/avatar_2.jpg', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=P2\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=2\n\n'),
(3, 'PROFILETYPE-3', 3, 1, '<p>PROFILETYPE-THREE-TIP</p>', 'members', 'blackout', 'Publisher', 'components/com_community/assets/default.jpg', 0, 0, 4, '', '', 'enableWaterMark=0\nxiText=P3\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=3\n\n'),
(4, 'PROFILETYPE-4', 4, 0, '<p>PROFILETYPE-THREE-TIP</p>', 'members', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=P4\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=4\n\n');;




TRUNCATE TABLE `#__xipt_settings`;;

INSERT INTO `#__xipt_settings` (`name`, `params`) VALUES
('settings', 'show_ptype_during_reg=1\nallow_user_to_change_ptype_after_reg=0\ndefaultProfiletypeID=1\nguestProfiletypeID=3\njspt_show_radio=0\njspt_fb_show_radio=1\nallow_templatechange=0\nshow_watermark=1\njspt_block_dis_app=1\nsubscription_integrate=1\nsubscription_message=pl\nintegrate_with=aec\njspt_restrict_reg_check=1\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=\njspt_prevent_email=\n\n');;
