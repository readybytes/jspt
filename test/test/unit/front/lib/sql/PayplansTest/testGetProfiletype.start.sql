TRUNCATE TABLE `#__session`;;

TRUNCATE TABLE `#__xipt_profiletypes`;;

INSERT INTO `#__xipt_profiletypes`  (`id`,`name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `config`)   VALUES 
(1,'PROFILETYPE-1', 2, '1', 'PROFILETYPE-ONE-TIP', 'privacyProfileView=10\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '1','jspt_restrict_reg_check=0\njspt_prevent_username=\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(2, 'PROFILETYPE-2', 1, '1', 'PROFILETYPE-TWO-TIP', 'privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'blueface', 'Editor', 'components/com_community/assets/group.jpg', '0', '0', '0', 'jspt_restrict_reg_check=0\njspt_prevent_username=\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(3, 'PROFILETYPE-3', 3, '1', 'PROFILETYPE-THREE-TIP', 'privacyProfileView=20\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'blackout', 'Publisher', 'components/com_community/assets/default.jpg', '0', '0', '4', 'jspt_restrict_reg_check=0\njspt_prevent_username=\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(4, 'PROFILETYPE-4', 4, '0', 'PROFILETYPE-THREE-TIP', 'privacyProfileView=20\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '0', 'jspt_restrict_reg_check=0\njspt_prevent_username=\njspt_allowed_email=\njspt_prevent_email=\n\n');;

TRUNCATE TABLE `#__xipt_settings`;;

INSERT INTO `#__xipt_settings` (`name`, `params`) VALUES
('settings', 'show_ptype_during_reg=0\nallow_user_to_change_ptype_after_reg=0\ndefaultProfiletypeID=1\nguestProfiletypeID=3\njspt_show_radio=0\njspt_fb_show_radio=1\nallow_templatechange=0\nshow_watermark=1\njspt_block_dis_app=1\nuser_reg=jomsocial\nsubscription_integrate=1\nsubscription_message=pl\nintegrate_with=payplans\n\n');;

TRUNCATE TABLE `#__payplans_app`;;

INSERT INTO `#__payplans_app` (`app_id`, `title`, `type`, `description`, `core_params`, `app_params`, `ordering`, `published`) VALUES
(1, 'Admin Payment', 'adminpay', 'Through this application Admin can create payment from back-end. There is no either way to create payment from back-end. This application can not be created, changed and deleted. And can not be used for fron-end payment.', 'applyAll=1\n\n', '\n', 1, 1),
(2, 'PT1', 'xiprofiletype', '', 'applyAll=0\n\n', 'on_status=1601\nxiprofiletype=1\n\n', 2, 1),
(3, 'PT2', 'xiprofiletype', '', 'applyAll=0\n\n', 'on_status=1601\nxiprofiletype=2\n\n', 3, 1),
(4, 'PT3', 'xiprofiletype', '', 'applyAll=0\n\n', 'on_status=1601\nxiprofiletype=3\n\n', 4, 1),
(5, 'PT4', 'xiprofiletype', '', 'applyAll=0\n\n', 'on_status=1601\nxiprofiletype=4\n\n', 5, 1);;

TRUNCATE TABLE `#__payplans_plan`;;

INSERT INTO `#__payplans_plan` (`plan_id`, `title`, `published`, `visible`, `ordering`, `checked_out`, `checked_out_time`, `modified_date`, `description`, `details`, `params`) VALUES
(1, 'plan2', 1, 1, 2, 0, '0000-00-00 00:00:00', '2011-07-08 13:06:08', '', 'expirationtype=fixed\nexpiration=000000000000\nrecurrence_count=0\n\n', 'teasertext=\nuser_activation=0\n\n'),
(2, 'plan3', 1, 1, 3, 0, '0000-00-00 00:00:00', '2011-07-08 13:06:24', '', 'expirationtype=fixed\nexpiration=000000000000\nrecurrence_count=0\n\n', 'teasertext=\nuser_activation=0\n\n'),
(3, 'plan1', 1, 1, 1, 0, '0000-00-00 00:00:00', '2011-07-08 13:04:39', '', 'expirationtype=fixed\nexpiration=000000000000\nrecurrence_count=0\n\n', 'teasertext=\nuser_activation=0\n\n'),
(4, 'plan4', 1, 1, 4, 0, '0000-00-00 00:00:00', '2011-07-08 13:05:59', '', 'expirationtype=fixed\nexpiration=000000000000\nrecurrence_count=0\n\n', 'teasertext=\nuser_activation=0\n\n');;
