TRUNCATE TABLE `#__xipt_profiletypes`;;
ALTER TABLE `#__xipt_profiletypes` AUTO_INCREMENT=1;;
DROP TABLE IF EXISTS `au_#__xipt_profiletypes`;;
CREATE TABLE `au_#__xipt_profiletypes` SELECT * FROM `#__xipt_profiletypes`;;
TRUNCATE TABLE `au_#__xipt_profiletypes`;;
INSERT INTO `au_#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`) VALUES
(1,'PROFILETYPE-TWO', NULL, 1, '', 'jsPrivacyController=1\nprivacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nprivacyVideoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'components/com_community/assets/user.png', 0, 0, 0, 'images/profiletype/watermark_1.png', '', 'enableWaterMark=0\nxiText=Profiletype1\nxiWidth=150\nxiHeight=30\nxiFontName=monofont\nxiFontSize=24\nxiTextColor=FFFFFF\nxiBackgroundColor=0F15D0\nxiWatermarkPosition=tr\ndemo=1\n\n', 1);;
