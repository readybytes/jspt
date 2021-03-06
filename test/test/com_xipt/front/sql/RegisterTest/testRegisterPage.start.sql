TRUNCATE TABLE `#__session`;;  /* Clean session */

TRUNCATE TABLE `#__xipt_profiletypes`;;
DROP TABLE IF EXISTS `au_#__xipt_profiletypes`;;
INSERT INTO `#__xipt_profiletypes`  (`name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`,`visible`)  
VALUES 
('PROFILETYPE-1', 2, '1', 'PROFILETYPE-ONE-TIP', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '0','1'),
('PROFILETYPE-2', 1, '1', 'PROFILETYPE-TWO-TIP', 'friends', 'blueface', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '0','1'),
('PROFILETYPE-3', 3, '1', 'PROFILETYPE-THREE-TIP', 'members', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '0','1'),
('PROFILETYPE-4', 4, '0', 'PROFILETYPE-THREE-TIP', 'members', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '0','1'),
('PROFILETYPE-5', 5, '1', 'PROFILETYPE-FIVE-TIP', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '0','0');;

TRUNCATE TABLE`#__xipt_settings`;;

INSERT INTO `#__xipt_settings` (`name`, `params`) VALUES
('settings', 'show_ptype_during_reg=1\nallow_user_to_change_ptype_after_reg=0\ndefaultProfiletypeID=1\nguestProfiletypeID=3\njspt_show_radio=1\njspt_fb_show_radio=1\nallow_templatechange=0\nshow_watermark=1\njspt_block_dis_app=1\nuser_reg=jomsocial\nsubscription_integrate=1\nsubscription_message=pl\nintegrate_with=aec\n\n');;
