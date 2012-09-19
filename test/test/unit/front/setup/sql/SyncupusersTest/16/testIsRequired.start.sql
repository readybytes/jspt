
TRUNCATE TABLE `#__users` ;;
INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'shyam@readybytes.in', '6a8c2b2fbc4ee1b4f3f042009d8a22f3:K5wzjZ3SlgIYTVPMaKt0wE0w6JUEJ2Bm', 'Super Administrator', 0, 1, '2009-10-27 14:21:57', '2012-02-15 10:06:29', '', '\n'),
(87, 'username1030', 'username1030', 'username1030@email.com', 'password', 'Registered', 0, 1,'2009-10-27 14:21:57', '2012-02-15 04:59:39', 'af9154cd03a8f88fac81a67ea33f8047', '\n'),
(86, 'username1031', 'username1031', 'username1031@email.com', 'password', 'Registered', 0, 1, '2009-10-27 14:21:57', '2012-02-15 04:59:39', '07805f125cd043f5ffcead1a774ac54b', '\n'),
(85, 'username1032', 'username1032', 'username1032@email.com', 'password', 'Registered', 0, 1, '2009-10-27 14:21:57', '2012-02-15 04:59:39', '7f7c7c32922c4cb28bffb614d73c7a33', '\n'),
(84, 'username1033', 'username1033', 'username1033@email.com', 'password', 'Registered', 0, 1,'2009-10-27 14:21:57', '2012-02-15 04:59:39', 'b64f7a76a298246d5362533737722099', '\n'),
(83, 'username1034', 'username1034', 'username1034@email.com', 'password', 'Registered', 0, 1, '2009-10-27 14:21:57', '2012-02-15 04:59:39', 'de25ad76e717394bbf2ddf71c4cd0fd1', '\n'),
(82, 'username1035', 'username1035', 'username1035@email.com', 'password', 'Registered', 0, 1, '2009-10-27 14:21:57', '2012-02-15 04:59:39', '82b0ae04348adcd0e95d0f1611f5e32e', '\n'),
(81, 'username1036', 'username1036', 'username1036@email.com', 'password', 'Registered', 0, 1, '2009-10-27 14:21:57', '2012-02-15 04:59:39', '458989e4e71aafd0e9eeb5eea0839ad9', '\n'),
(80, 'username1037', 'username1037', 'username1037@email.com', 'password', 'Registered', 0, 1, '2009-10-27 14:21:57', '2012-02-15 04:59:39', 'e7c38ab9a90b7f2357889f4d83bd2bf9', '\n'),
(79, 'username1038', 'username1038', 'username1038@email.com', 'password', 'Registered', 0, 1,'2009-10-27 14:21:57', '2012-02-15 04:59:39', '2d35e1953a2632926ac07619e6072569', '\n');;



TRUNCATE TABLE `#__xipt_settings`;;

INSERT INTO `#__xipt_settings` (`name`, `params`) VALUES
('settings', 'show_ptype_during_reg=1\nallow_user_to_change_ptype_after_reg=0\ndefaultProfiletypeID=1\nguestProfiletypeID=1\njspt_show_radio=0\njspt_fb_show_radio=1\nallow_templatechange=0\nshow_watermark=1\njspt_block_dis_app=1\nsubscription_integrate=1\nsubscription_message=pl\nintegrate_with=aec\n\n');;

TRUNCATE TABLE `#__xipt_profiletypes` ;;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`, `config`) VALUES
(1, 'PROFILETYPE-1', 2, 1, 'PROFILETYPE-ONE-TIP', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 1, '', '', '', 1, ''),
(2, 'PROFILETYPE-2', 1, 1, 'PROFILETYPE-TWO-TIP', 'friends', 'blueface', 'Editor', 'components/com_community/assets/group.jpg', 0, 0, 0, '', '', '', 1, ''),
(3, 'PROFILETYPE-3', 3, 1, 'PROFILETYPE-THREE-TIP', 'members', 'blackout', 'Publisher', 'components/com_community/assets/default.jpg', 0, 0, 4, '', '', '', 1, ''),
(4, 'PROFILETYPE-4', 4, 0, 'PROFILETYPE-THREE-TIP', 'members', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', '', 1, '');;

TRUNCATE TABLE `#__xipt_users`;;
INSERT INTO `#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 1, 'default'),
(87, 3, 'blackout'),
(86, 2, 'blueface'),
(85, 1, 'default'),
(84, 3, 'blackout'),
(83, 2, 'blueface'),
(82, 1, 'default'),
(81, 3, 'blackout'),
(80, 2, 'blueface'),
(79, 1, 'default');;

TRUNCATE TABLE `#__community_fields`;;

INSERT INTO `#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`) VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basicr', 1, 1, 1, 1, '', ''),
(2, 'text', 4, 1, 5, 250, 'Hometown2', 'Hometown2', 1, 1, 1, 1, '', 'FIELD_HOMETOWN2'),
(3, 'templates', 3, 1, 10, 100, 'Template', 'Template Of User', 1, 1, 1, 1, '', 'XIPT_TEMPLATE'),
(4, 'profiletypes', 2, 1, 10, 100, 'Profiletype', 'Profiletype Of User', 1, 1, 1, 1, '', 'XIPT_PROFILETYPE');;
