--
-- Dumping data for table `au_#__xipt_settings`
--
TRUNCATE TABLE `au_#__xipt_settings`;;
INSERT INTO `au_#__xipt_settings` (`name`, `params`) VALUES
('settings', '');;


CREATE TABLE IF NOT EXISTS `au_#__components` SELECT * FROM `#__components`;;
TRUNCATE TABLE `au_#__components`;;
INSERT INTO `au_#__components` (`id`, `name`, `link`, `menuid`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`, `iscore`, `params`, `enabled`) VALUES
(263, 'JomSocial Profile Types', 'option=com_xipt', 0, 0, 'option=com_xipt', 'JomSocial Profile Types', 'com_xipt', 0, 'components/com_xipt/images/icon-profiletypes.gif', 0, '', 1);;


