
TRUNCATE TABLE `#__xipt_profilefields`;;
INSERT INTO `#__xipt_profilefields` (`id`, `fid`, `pid`, `category`) VALUES
(1, 2, 2, 0),
(2, 2, 2, 1),
(3, 2, 2, 2),
(4, 2, 2, 3),
(5, 2, 2, 4),
(6, 3, 1, 0),
(7, 3, 1, 1),
(8, 3, 1, 2),
(9, 3, 1, 3),
(10, 3, 1, 4),
(11, 5, 2, 0),
(12, 5, 1, 1),
(13, 5, 2, 2),
(14, 5, 1, 3),
(15, 4, 1, 0),
(16, 4, 2, 0),
(17, 4, 1, 2),
(18, 4, 2, 2),
(19, 4, 2, 3),
(20, 4, 1, 4);;

TRUNCATE TABLE `#__xipt_profiletypes`;;

INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`, `config`) VALUES
(1, 'ProfileType1', NULL, 1, '', 'privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, '0', 'images/profiletype/watermark_1.png', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=1\n\n', 1, 'jspt_restrict_reg_check=0\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(2, 'ProfileType2', NULL, 1, '', 'privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, '0', 'images/profiletype/watermark_2.png', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=1\n\n', 1, 'jspt_restrict_reg_check=0\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=\njspt_prevent_email=\n\n');;

