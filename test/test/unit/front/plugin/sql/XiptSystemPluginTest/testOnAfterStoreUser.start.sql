
TRUNCATE TABLE `#__xipt_settings`;;

INSERT INTO `#__xipt_settings` (`name`, `params`) VALUES
('settings', 'show_ptype_during_reg=1\nallow_user_to_change_ptype_after_reg=0\ndefaultProfiletypeID=1\nguestProfiletypeID=3\njspt_show_radio=0\njspt_fb_show_radio=1\nallow_templatechange=0\nshow_watermark=1\njspt_block_dis_app=1\nuser_reg=jomsocial\naec_integrate=0\naec_message=pl\n\n');;

TRUNCATE TABLE `#__xipt_profiletypes`;;

INSERT INTO `#__xipt_profiletypes`  (`id`,`name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `config`)   VALUES 
(1,'PROFILETYPE-1', 2, '1', 'PROFILETYPE-ONE-TIP', 'privacyProfileView=10\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '1','jspt_restrict_reg_check=0\njspt_prevent_username=\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(2, 'PROFILETYPE-2', 1, '1', 'PROFILETYPE-TWO-TIP', 'privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'blueface', 'Editor', 'components/com_community/assets/group.jpg', '0', '0', '0', 'jspt_restrict_reg_check=0\njspt_prevent_username=\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(3, 'PROFILETYPE-3', 3, '1', 'PROFILETYPE-THREE-TIP', 'privacyProfileView=20\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'blackout', 'Publisher', 'components/com_community/assets/default.jpg', '0', '0', '4', 'jspt_restrict_reg_check=0\njspt_prevent_username=\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(4, 'PROFILETYPE-4', 4, '0', 'PROFILETYPE-THREE-TIP', 'privacyProfileView=20\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '0', 'jspt_restrict_reg_check=0\njspt_prevent_username=\njspt_allowed_email=\njspt_prevent_email=\n\n');;
