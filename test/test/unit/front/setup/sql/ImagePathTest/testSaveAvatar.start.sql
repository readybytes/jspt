TRUNCATE TABLE `#__community_fields`;;

INSERT INTO `#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`) VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basicr', 1, 1, 1, 1, '', ''),
(2, 'text', 4, 1, 5, 250, 'Hometown2', 'Hometown2', 1, 1, 1, 1, '', 'FIELD_HOMETOWN2'),
(3, 'templates', 3, 1, 10, 100, 'Template', 'Template Of User', 1, 1, 1, 1, '', 'XIPT_TEMPLATE'),
(4, 'profiletypes', 2, 1, 10, 100, 'Profiletype', 'Profiletype Of User', 1, 1, 1, 1, '', 'XIPT_PROFILETYPE');;

TRUNCATE TABLE `#__community_users` ;;

INSERT INTO `#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`, `alias`, `latitude`, `longitude`) VALUES
(62, '', 12, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(83, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(84, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(85, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(86, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(87, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(79, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(80, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(81, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(82, '', 2, '0000-00-00 00:00:00', 'test/test/unit/front/images/avatar.jpg', 'test/test/unit/front/images/thumb_avatar.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(88, '', 0, '0000-00-00 00:00:00', 'test/test/unit/front/images/avatar.jpg', 'test/test/unit/front/images/thumb_avatar.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255);;



TRUNCATE TABLE `#__xipt_settings`;;

INSERT INTO `#__xipt_settings` (`name`, `params`) VALUES
('settings', 'show_ptype_during_reg=1\nallow_user_to_change_ptype_after_reg=0\ndefaultProfiletypeID=1\nguestProfiletypeID=1\njspt_show_radio=0\njspt_fb_show_radio=1\nallow_templatechange=0\nshow_watermark=1\njspt_block_dis_app=1\naec_integrate=1\naec_message=pl\n\n');;

TRUNCATE TABLE `#__xipt_profiletypes` ;;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`, `config`) VALUES
(1, 'PROFILETYPE-1', 2, 1, '<p>PROFILETYPE-ONE-TIP</p>', 'privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, '1', 'test/test/unit/front/setup/images/watermark_1.png', '', 'enableWaterMark=1\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=1\n\n', 1, 'jspt_restrict_reg_check=0\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(2, 'PROFILETYPE-2', 1, 1, 'PROFILETYPE-TWO-TIP', 'friends', 'blueface', 'Editor', 'components/com_community/assets/group.jpg', 0, 0, '0', '', '', '', 1, ''),
(3, 'PROFILETYPE-3', 3, 1, 'PROFILETYPE-THREE-TIP', 'members', 'blackout', 'Publisher', 'components/com_community/assets/default.jpg', 0, 0, '4', '', '', '', 1, ''),
(4, 'PROFILETYPE-4', 4, 0, 'PROFILETYPE-THREE-TIP', 'members', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, '0', '', '', '', 1, '');;

TRUNCATE TABLE `#__xipt_users`;;
INSERT INTO `#__xipt_users`(`userid`, `profiletype`, `template`) VALUES
(62, 1, 'default'),
(87, 3, 'blackout'),
(86, 2, 'blueface'),
(85, 1, 'default'),
(84, 3, 'blackout'),
(83, 2, 'blueface'),
(82, 1, 'default'),
(81, 1, 'default'),
(79, 1, 'default'),
(80, 1, 'default'),
(88, 1, 'default');;

TRUNCATE TABLE `#__users`;;
