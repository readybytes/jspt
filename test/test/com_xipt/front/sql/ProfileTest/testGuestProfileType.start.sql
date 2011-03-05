
TRUNCATE TABLE `#__xipt_aclrules` ;;
INSERT INTO `#__xipt_aclrules` (`id`, `rulename`, `aclname`, `coreparams`, `aclparams`, `published`) VALUES
(1, 'Can''t View Other Profile ', 'cantviewotherprofile', 'core_profiletype=2\ncore_display_message=WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRQ==\ncore_redirect_url=index.php?option=com_community\n\n', 'other_profiletype=1\nacl_applicable_to_friend=1\n\n', 1);;


TRUNCATE TABLE `#__community_fields` ;;
INSERT INTO `#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`) VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basicr', 1, 1, 1, 1, '', ''),
(2, 'text', 2, 1, 5, 250, 'Hometown2', 'Hometown2', 1, 1, 1, 1, '', 'FIELD_HOMETOWN2'),
(3, 'text', 3, 1, 5, 250, 'Hometown3', 'Hometown3', 1, 1, 1, 1, '', 'FIELD_HOMETOWN3'),
(4, 'text', 4, 1, 5, 250, 'Hometown4', 'Hometown4', 1, 1, 1, 1, '', 'FIELD_HOMETOWN4'),
(5, 'text', 5, 1, 5, 250, 'Hometown5', 'Hometown5', 1, 1, 1, 1, '', 'FIELD_HOMETOWN5'),
(6, 'text', 6, 1, 5, 250, 'Hometown6', 'Hometown6', 1, 1, 1, 1, '', 'FIELD_HOMETOWN6'),
(7, 'text', 7, 1, 5, 250, 'Hometown7', 'Hometown7', 1, 1, 1, 1, '', 'FIELD_HOMETOWN7'),
(8, 'text', 8, 1, 5, 250, 'Hometown8', 'Hometown8', 1, 1, 1, 1, '', 'FIELD_HOMETOWN8'),
(9, 'text', 9, 1, 5, 250, 'Hometown9', 'Hometown9', 1, 1, 1, 1, '', 'FIELD_HOMETOWN9'),
(16, 'templates', 10, 1, 10, 100, 'Template', 'Template Of User', 1, 1, 1, 1, '', 'XIPT_TEMPLATE'),
(17, 'profiletypes', 11, 1, 10, 100, 'Profiletype', 'Profiletype Of User', 1, 1, 1, 1, '', 'XIPT_PROFILETYPE');;

TRUNCATE TABLE  `#__community_fields_values`;;
INSERT INTO `#__community_fields_values` (`id`, `user_id`, `field_id`, `value`) VALUES
(22, 62, 3, 'default'),
(130, 81, 9, 'regtest8635954'),
(133, 82, 3, 'regtest8774090'),
(132, 82, 17, '1'),
(131, 82, 16, 'default'),
(159, 86, 2, 'regtest1504555'),
(158, 86, 17, '2'),
(157, 86, 16, 'blueface'),
(156, 85, 9, 'regtest3843261'),
(155, 85, 8, 'regtest3843261'),
(154, 85, 5, 'regtest3843261'),
(153, 85, 4, 'regtest3843261'),
(119, 80, 16, 'blueface'),
(118, 79, 9, 'regtest7046025'),
(23, 62, 4, '1'),
(117, 79, 8, 'regtest7046025'),
(116, 79, 5, 'regtest7046025'),
(135, 82, 5, 'regtest8774090'),
(134, 82, 4, 'regtest8774090'),
(139, 83, 17, '2'),
(138, 83, 16, 'blueface'),
(137, 82, 9, 'regtest8774090'),
(136, 82, 8, 'regtest8774090'),
(168, 87, 9, 'regtest1674526'),
(167, 87, 5, 'regtest1674526'),
(152, 85, 3, 'regtest3843261'),
(151, 85, 17, '1'),
(150, 85, 16, 'default'),
(149, 84, 9, 'regtest6461827'),
(148, 84, 5, 'regtest6461827'),
(147, 84, 17, '3'),
(146, 84, 16, 'blackout'),
(141, 83, 4, 'regtest1789672'),
(140, 83, 2, 'regtest1789672'),
(145, 83, 9, 'regtest1789672'),
(144, 83, 8, 'regtest1789672'),
(143, 83, 6, 'regtest1789672'),
(142, 83, 5, 'regtest1789672'),
(160, 86, 4, 'regtest1504555'),
(125, 80, 8, 'regtest6208627'),
(124, 80, 6, 'regtest6208627'),
(123, 80, 5, 'regtest6208627'),
(122, 80, 4, 'regtest6208627'),
(121, 80, 2, 'regtest6208627'),
(120, 80, 17, '2'),
(115, 79, 4, 'regtest7046025'),
(114, 79, 3, 'regtest7046025'),
(113, 79, 17, '1'),
(112, 79, 16, 'default'),
(162, 86, 6, 'regtest1504555'),
(161, 86, 5, 'regtest1504555'),
(166, 87, 17, '3'),
(165, 87, 16, 'blackout'),
(164, 86, 9, 'regtest1504555'),
(163, 86, 8, 'regtest1504555'),
(129, 81, 5, 'regtest8635954'),
(128, 81, 17, '3'),
(127, 81, 16, 'blackout'),
(126, 80, 9, 'regtest6208627');;


TRUNCATE TABLE `#__community_users`;;
INSERT INTO `#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`) VALUES
(62, '', 12, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(83, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(84, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 1, 0),
(85, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(86, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(87, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(79, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(80, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(81, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(82, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0);;
TRUNCATE TABLE `#__xipt_profiletypes` ;;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`) VALUES
(1, 'PROFILETYPE-1', 2, 1, 'PROFILETYPE-ONE-TIP', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 1, '', ''),
(2, 'PROFILETYPE-2', 1, 1, 'PROFILETYPE-TWO-TIP', 'friends', 'blueface', 'Editor', 'components/com_community/assets/group.jpg', 0, 0, 0, '', 'enableterms=0\nregistrationTerms=\nrecaptcha=0\nrecaptchapublic=\nrecaptchaprivate=\nrecaptchatheme=red\nrecaptchalang=en\nenablereporting=1\nmaxReport=50\nnotifyMaxReport=\nenableguestreporting=0\npredefinedreports=Spamming / Advertisement\nprivacyprofile=0\nprivacyfriends=0\nprivacyphotos=0\nprivacyemail=1\nprivacyapps=1\nprivacywallcomment=0\nenablepm=0\npmperday=30\nlockprofilewalls=1\nlockvideoswalls=1\nlockgroupwalls=1\nenablegroups=0\nmoderategroupcreation=0\ncreategroups=1\ngroupcreatelimit=1\ngroupphotouploadlimit=500\ngroupvideouploadlimit=500\ncreatediscussion=1\ngroupphotos=1\ngroupvideos=1\ngroupdiscussnotification=0\nenablevideos=0\nenablevideosupload=0\nvideouploadlimit=1\ndeleteoriginalvideos=0\nvideofolder=images\nmaxvideouploadsize=8\nffmpegPath=\nflvtool2=\nqscale=11\nvideosSize=400x300\ncustomCommandForVideo=\nvideoskey=\nenablevideopseudostream=0\nvideodebug=0\nfolderpermissionsvideo=0755\nenablephotos=0\nphotouploadlimit=1\nmaxuploadsize=8\nmagickPath=\nflashuploader=0\nfolderpermissionsphoto=0755\nautoalbumcover=1\nenablemyblogicon=0\n\n'),
(3, 'PROFILETYPE-3', 3, 1, 'PROFILETYPE-THREE-TIP', 'public', 'blackout', 'Publisher', 'components/com_community/assets/default.jpg', 0, 0, 4, '', ''),
(4, 'PROFILETYPE-4', 4, 0, 'PROFILETYPE-THREE-TIP', 'members', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '');;

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



TRUNCATE TABLE `#__community_apps`;;
INSERT INTO `#__community_apps` (`id`, `userid`, `apps`, `ordering`, `params`, `privacy`) VALUES
(1, 62, 'testing001', 0, '', ''),
(2, 62, 'walls', 0, '', ''),
(3, 62, 'feeds', 0, '', ''),
(4, 62, 'groups', 0, '', ''),
(5, 62, 'latestphoto', 0, '', ''),
(6, 62, 'myarticles', 0, '', ''),
(7, 82, 'testing001', 0, '', ''),
(8, 82, 'walls', 0, '', ''),
(9, 82, 'feeds', 0, '', ''),
(10, 82, 'groups', 0, '', ''),
(11, 82, 'latestphoto', 0, '', ''),
(12, 82, 'myarticles', 0, '', ''),
(13, 83, 'testing001', 0, '', ''),
(14, 83, 'walls', 0, '', ''),
(15, 83, 'feeds', 0, '', ''),
(17, 83, 'latestphoto', 0, '', ''),
(18, 83, 'myarticles', 0, '', ''),
(19, 84, 'testing001', 0, '', ''),
(20, 84, 'walls', 0, '', ''),
(21, 84, 'feeds', 0, '', ''),
(22, 84, 'groups', 0, '', ''),
(23, 84, 'latestphoto', 0, '', ''),
(24, 84, 'myarticles', 0, '', '');;


TRUNCATE TABLE `#__xipt_applications`;;
INSERT INTO `#__xipt_applications` (`id`, `applicationid`, `profiletype`) VALUES
(21, 44, 4),
(20, 44, 2),
(4, 48, 1),
(5, 45, 3),
(6, 47, 2),
(7, 46, 2),
(8, 49, 2),
(9, 49, 3),
(10, 49, 4),
(11, 50, 1),
(12, 50, 3),
(13, 50, 4);;
