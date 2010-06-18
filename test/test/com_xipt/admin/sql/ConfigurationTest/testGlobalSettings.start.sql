TRUNCATE TABLE `#__xipt_profiletypes` ;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`) VALUES
(1, 'PROFILETYPE-1', 2, 1, 'PROFILETYPE-ONE-TIP', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 1, '', '', '', 1),
(2, 'PROFILETYPE-2', 1, 1, 'PROFILETYPE-TWO-TIP', 'public', 'blueface', 'Editor', 'images/profiletype/avatar_2.gif', 0, 0, 0, '', '', '', 1),
(3, 'PROFILETYPE-3', 3, 1, 'PROFILETYPE-THREE-TIP', 'public', 'blackout', 'Publisher', 'images/profiletype/avatar_3.png', 0, 0, 4, '', '', '', 1),
(4, 'PROFILETYPE-4', 4, 0, 'PROFILETYPE-THREE-TIP', 'public', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', '', 1);



TRUNCATE TABLE `#__xipt_settings`;
DROP TABLE IF EXISTS `au_#__xipt_settings`;
CREATE TABLE IF NOT EXISTS `au_#__xipt_settings` SELECT * FROM `#__xipt_settings`;
TRUNCATE TABLE `au_#__xipt_settings`;

INSERT INTO `#__xipt_settings` (`name`, `params`) VALUES
('settings', '');

INSERT INTO `au_#__xipt_settings` (`name`, `params`) VALUES
('settings', 'show_ptype_during_reg=1\nallow_user_to_change_ptype_after_reg=0\ndefaultProfiletypeID=1\nguestProfiletypeID=3\njspt_show_radio=0\njspt_fb_show_radio=1\nallow_templatechange=0\nshow_watermark=1\njspt_block_dis_app=1\naec_integrate=1\naec_message=pl\njspt_restrict_reg_check=1\njspt_prevent_username=\njspt_allowed_email=\njspt_prevent_email=\n\n');
