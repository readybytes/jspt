TRUNCATE TABLE `#__xipt_profiletypes`;;

INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`, `config`) VALUES
(1, 'ProfileType1', NULL, 1, '', 'privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, '0', 'images/profiletype/watermark_1.png', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=1\n\n', 1, 'jspt_restrict_reg_check=0\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(2, 'ProfileType2', NULL, 1, '', 'privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'blueface', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, '1,2', 'images/profiletype/watermark_2.png', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=1\n\n', 1, 'jspt_restrict_reg_check=0\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=\njspt_prevent_email=\n\n');;

TRUNCATE TABLE `#__community_groups`;;
INSERT INTO `#__community_groups` (`id`, `published`, `ownerid`, `categoryid`, `name`, `description`, `email`, `website`, `approvals`, `created`, `avatar`, `thumb`, `discusscount`, `wallcount`, `membercount`, `params`) VALUES
(1, 1, 62, 4, 'Group1', 'Group1', '', '', 0, '2010-10-09 10:10:19', '', '', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\nnewmembernotification=1\njoinrequestnotification=1\nwallnotification=1\n\n'),
(2, 1, 62, 4, 'Group2', 'Group2', '', '', 0, '2010-10-09 10:10:32', '', '', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\nnewmembernotification=1\njoinrequestnotification=1\nwallnotification=1\n\n'),
(3, 1, 62, 4, 'Group3', 'Group3', '', '', 0, '2010-10-09 10:10:43', '', '', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\nnewmembernotification=1\njoinrequestnotification=1\nwallnotification=1\n\n');;

