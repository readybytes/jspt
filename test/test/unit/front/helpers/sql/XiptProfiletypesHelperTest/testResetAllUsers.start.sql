TRUNCATE TABLE `#__xipt_profiletypes`;;

INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`, `config`) VALUES
(1, 'ProfileType1', NULL, 1, '', 'privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, '0', 'images/profiletype/watermark_1.png', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=1\n\n', 1, 'jspt_restrict_reg_check=0\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(2, 'ProfileType2', NULL, 1, '', 'privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, '', 'images/profiletype/watermark_2.png', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=1\n\n', 1, 'jspt_restrict_reg_check=0\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=\njspt_prevent_email=\n\n');;


-- XIPT user tabel
TRUNCATE TABLE `#__xipt_users`;;
DROP TABLE IF EXISTS `au_#__xipt_users`;;
CREATE TABLE IF NOT EXISTS `au_#__xipt_users` SELECT * FROM `#__xipt_users`;;
TRUNCATE TABLE `au_#__xipt_users`;;

INSERT INTO `#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 1, 'default'),
(63, 1, 'default'),
(64, 2, 'default'),
(65, 1, 'default'),
(66, 2, 'default');;

INSERT INTO `au_#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 1, 'blackout'),
(63, 1, 'blackout'),
(64, 2, 'default'),
(65, 1, 'blackout'),
(66, 2, 'default');;

TRUNCATE TABLE `#__community_users`;;
TRUNCATE TABLE `#__community_users`;;
DROP TABLE IF EXISTS `au_#__community_users`;;
CREATE TABLE IF NOT EXISTS `au_#__community_users` SELECT * FROM `#__community_users`;;
TRUNCATE TABLE `au_#__community_users`;;

INSERT INTO `#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`, `alias`, `latitude`, `longitude`) VALUES
(62, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(63, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(64, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(65, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(66, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255);;

INSERT INTO `au_#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`, `alias`, `latitude`, `longitude`) VALUES
(62, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(63, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(64, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(65, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=0\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(66, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255);;



TRUNCATE TABLE `#__community_groups`;;
INSERT INTO `#__community_groups` (`id`, `published`, `ownerid`, `categoryid`, `name`, `description`, `email`, `website`, `approvals`, `created`, `avatar`, `thumb`, `discusscount`, `wallcount`, `membercount`, `params`) VALUES
(1, 1, 62, 4, 'Group1', 'Group1', '', '', 0, '2010-10-09 10:10:19', '', '', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\nnewmembernotification=1\njoinrequestnotification=1\nwallnotification=1\n\n'),
(2, 1, 62, 4, 'Group2', 'Group2', '', '', 0, '2010-10-09 10:10:32', '', '', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\nnewmembernotification=1\njoinrequestnotification=1\nwallnotification=1\n\n'),
(3, 1, 62, 4, 'Group3', 'Group3', '', '', 0, '2010-10-09 10:10:43', '', '', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\nnewmembernotification=1\njoinrequestnotification=1\nwallnotification=1\n\n');;


TRUNCATE TABLE  `#__community_groups_members`;;
DROP TABLE IF EXISTS `au_#__community_groups_members`;;
CREATE TABLE IF NOT EXISTS `au_#__community_groups_members` SELECT * FROM `#__community_groups_members`;;
TRUNCATE TABLE `au_#__community_groups_members`;;
INSERT INTO `au_#__community_groups_members` (`groupid`, `memberid`, `approved`, `permissions`) VALUES
(1, 62, 1, 0),
(1, 63, 1, 0),
(1, 65, 1, 0);;


