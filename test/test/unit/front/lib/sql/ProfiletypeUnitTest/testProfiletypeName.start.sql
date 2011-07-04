
TRUNCATE TABLE `#__xipt_profiletypes` ;;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`) VALUES
(1, 'PROFILETYPE-1', 2, 1, 'PROFILETYPE-ONE-TIP', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 1, '', '', '', 1),
(2, 'PROFILETYPE-2', 1, 1, 'PROFILETYPE-TWO-TIP', 'friends', 'blueface', 'Editor', 'components/com_community/assets/group.jpg', 0, 0, 0, '', '', '', 1),
(3, 'PROFILETYPE-3', 3, 1, 'PROFILETYPE-THREE-TIP', 'members', 'blackout', 'Publisher', 'components/com_community/assets/default.jpg', 0, 0, 4, '', '', '', 1),
(4, 'PROFILETYPE-4', 4, 0, 'PROFILETYPE-THREE-TIP', 'members', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', '', 1),
(5, 'PROFILETYPE-5', 5, 1, 'PROFILETYPE-THREE-TIP', 'members', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', '', 1),
(6, 'PROFILETYPE-6', 6, 1, 'PROFILETYPE-THREE-TIP', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', '', 1),
(7, 'PROFILETYPE-7', 7, 1, 'PROFILETYPE-THREE-TIP', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', '', 1),
(8, 'PROFILETYPE-8', 8, 1, 'PROFILETYPE-THREE-TIP', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', '', 1),
(9, 'PROFILETYPE-9', 9, 1, 'PROFILETYPE-THREE-TIP', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', '', 1),
(10, 'PROFILETYPE-10', 10, 1, 'PROFILETYPE-THREE-TIP', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', '', 1);;


TRUNCATE TABLE `#__xipt_settings` ;;
INSERT INTO `#__xipt_settings` (`name`, `params`) VALUES
('settings', 'show_ptype_during_reg=1\nallow_user_to_change_ptype_after_reg=1\ndefaultProfiletypeID=2\nguestProfiletypeID=2\njspt_show_radio=1\njspt_fb_show_radio=1\nallow_templatechange=0\nshow_watermark=1\njspt_block_dis_app=2\nsubscription_integrate=0\nsubscription_message=b\njspt_restrict_reg_check=1\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=\njspt_prevent_email=\n');;