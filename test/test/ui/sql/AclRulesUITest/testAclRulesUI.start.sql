TRUNCATE TABLE `#__community_users`;;
INSERT INTO `#__community_users` (`userid`) VALUES
(62),
(83),
(84),
(85),
(86),
(87),
(79),
(80),
(81),
(82)
;;

TRUNCATE TABLE `#__xipt_profiletypes` ;;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`) VALUES
(1, 'PROFILETYPE-1', 2, 1),
(2, 'PROFILETYPE-2', 1, 1),
(3, 'PROFILETYPE-3', 3, 1),
(4, 'PROFILETYPE-4', 4, 1),
(5, 'PROFILETYPE-5', 5, 1),
(6, 'PROFILETYPE-6', 6, 1),
(7, 'PROFILETYPE-7', 7, 1),
(9, 'PROFILETYPE-9', 8, 1)
;;

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
(79, 1, 'default')
;;

TRUNCATE TABLE `#__users`;;
INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'shyam@readybytes.in', '6a8c2b2fbc4ee1b4f3f042009d8a22f3:K5wzjZ3SlgIYTVPMaKt0wE0w6JUEJ2Bm', 'Super Administrator', 0, 1, 25, '2009-10-27 14:21:57', '2010-06-15 10:40:57', '', '\n'),
(82, 'regtest8774090', 'regtest8774090', 'regtest8774090@gmail.com', 'f478ff7ef92fcb7a7cb62d4c1f08e43a:7rptUeQifMIkdyqE59fnxb0o74NE4sk8', 'Registered', 0, 0, 18, '2009-12-03 08:16:35', '2010-06-15 08:36:29', 'a3a9fc5ff08868ee458cda29142e6e36', '\n'),
(83, 'regtest1789672', 'regtest1789672', 'regtest1789672@gmail.com', 'c33a3ac03bfbc13368383edc0e6ae42d:bUwtJXMI49daOhAPzdaLBdRY1IOOgm0D', 'Editor', 0, 0, 20, '2009-12-03 08:16:44', '0000-00-00 00:00:00', 'a25e8cbbf5a534e0d5b934589be66756', '\n'),
(84, 'regtest6461827', 'regtest6461827', 'regtest6461827@gmail.com', '56f606098f0631341e8c398eaae179c6:aOJ5ghvQqtSCPnIH8SwFw90001MNaRI6', 'Publisher', 0, 0, 21, '2009-12-03 08:16:52', '0000-00-00 00:00:00', 'd8e2cc8000b17d6791a451354a281937', '\n'),
(85, 'regtest3843261', 'regtest3843261', 'regtest3843261@gmail.com', '0f2e8c8f8433fd1604880e9ac0d33fc1:d4b8PHWIkuHEI4AfHM1XWkFh4sR4t1gj', 'Registered', 0, 0, 18, '2009-12-03 08:17:00', '0000-00-00 00:00:00', '0e11cd0ed924846a11c84e3618f2c5eb', '\n'),
(86, 'regtest1504555', 'regtest1504555', 'regtest1504555@gmail.com', '78c3901d9d2c31108f9f758a18ee7f89:UIbbRXlJUORtEqogoLPr9ZP0bouM0lLT', 'Editor', 0, 0, 20, '2009-12-03 08:17:09', '2010-06-15 08:26:38', '77981cae5948a5be5e553db5dcb8d00f', '\n'),
(87, 'regtest1674526', 'regtest1674526', 'regtest1674526@gmail.com', '948b72e649363975c49ba818d6880843:PezoDwP9dbIXQETtPbG0IfkpE0jogLi2', 'Publisher', 0, 0, 21, '2009-12-03 08:17:17', '0000-00-00 00:00:00', '51bcf29e8ec7bbaf00dc2160257b8987', '\n'),
(79, 'regtest7046025', 'regtest7046025', 'regtest7046025@gmail.com', '64d5a5a65e0433fefad4d52255857f59:rBhZVyCqDIKioTNuCNBkpQNhRXsCHb1t', 'Registered', 0, 0, 18, '2009-12-03 08:16:09', '2010-06-15 10:22:52', 'd45373ce0b2c4bfa6065235a5c353add', '\n'),
(80, 'regtest6208627', 'regtest6208627', 'regtest6208627@gmail.com', '73e7830c01e705a5adeaaa3e278fbdec:uQb0sUh0KdTyybJuHnYHAtpOmtfVNxr2', 'Editor', 0, 0, 20, '2009-12-03 08:16:18', '2010-06-15 10:24:28', '0e24ede794209ad6de9624f89077daed', '\n'),
(81, 'regtest8635954', 'regtest8635954', 'regtest8635954@gmail.com', '7dc28bb5bc0119a23ac236b82837586e:vBNJaILgct7EzdE4wmJANFeLuVSTLHdh', 'Publisher', 0, 0, 21, '2009-12-03 08:16:26', '2010-06-15 10:24:50', '1ebc22393cc2619be62d28fe7c960e5a', '\n')
;;

TRUNCATE TABLE `#__core_acl_aro`;;
INSERT INTO `#__core_acl_aro` (`id`, `section_value`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', '62', 0, 'Administrator', 0),
(31, 'users', '83', 0, 'regtest1789672', 0),
(28, 'users', '80', 0, 'regtest6208627', 0),
(32, 'users', '84', 0, 'regtest6461827', 0),
(35, 'users', '87', 0, 'regtest1674526', 0),
(33, 'users', '85', 0, 'regtest3843261', 0),
(34, 'users', '86', 0, 'regtest1504555', 0),
(29, 'users', '81', 0, 'regtest8635954', 0),
(27, 'users', '79', 0, 'regtest7046025', 0),
(30, 'users', '82', 0, 'regtest8774090', 0)
;;

TRUNCATE TABLE `#__core_acl_groups_aro_map`;;
INSERT INTO `#__core_acl_groups_aro_map` (`group_id`, `section_value`, `aro_id`) VALUES
(18, '', 27),
(18, '', 30),
(18, '', 33),
(20, '', 28),
(20, '', 31),
(20, '', 34),
(21, '', 29),
(21, '', 32),
(21, '', 35),
(25, '', 10)
;;


TRUNCATE TABLE `#__xipt_aclrules`;;
INSERT INTO `#__xipt_aclrules` (`id`, `rulename`, `aclname`, `coreparams`, `aclparams`, `published`) VALUES
(11, 'RULE-11', 'creategroup', 		'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(12, 'RULE-12', 'joingroup', 		'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(13, 'RULE-13', 'accessgroup', 		'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 0),

(14, 'RULE-14', 'createvent', 		'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(15, 'RULE-15', 'deletevent', 		'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(16, 'RULE-16', 'accessevent', 		'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 0),

(17, 'RULE-17', 'addalbums', 		'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(18, 'RULE-18', 'addphotos', 		'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 0),

(19, 'RULE-19', 'changeavatar', 	'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(20, 'RULE-20', 'changeprivacy', 	'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(21, 'RULE-21', 'editselfprofile', 	'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(22, 'RUL22', 'editselfprofiledetails', 'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(23, 'RULE-23', 'cantviewotherprofile', 'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 0),

(24, 'RULE-24', 'addvideos', 		'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(25, 'RULE-25', 'accessvideo', 		'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 0),

(26, 'RULE-26', 'addprofilevideo', 	'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(27, 'RULE-27', 'deleteprofilevideo', 	'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(28, 'RULE-28', 'accessprofilevideo', 	'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 0),

(29, 'RULE-29', 'writemessages', 	'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(30, 'RULE-20', 'addasfriends', 	'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(31, 'RULE-31', 'statusbox', 		'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php\n\n', '\n\n', 1)
;;



TRUNCATE TABLE `#__community_groups`;;
INSERT INTO `#__community_groups` (`id`, `published`, `ownerid`, `categoryid`, `name`) VALUES
(2, 1, 82, 4, 'pt1'),
(3, 1, 83, 4, 'pt2')
;;

TRUNCATE TABLE `#__community_groups_members` ;;
INSERT INTO `#__community_groups_members` (`groupid`, `memberid`, `approved`, `permissions`) VALUES
(2, 82, 1, 0),
(3, 83, 1, 0)
;;

TRUNCATE TABLE `#__community_events`;;
INSERT INTO `#__community_events` (`id`, `catid`, `contentid`, `type`, `title`, `creator`, `published`) VALUES
(2, 2, 0, 'profile', 'myevent1',  82, 1),
(3, 2, 0, 'profile', 'myevent2',  83, 1)
;;


TRUNCATE TABLE `#__community_msg`;;
INSERT INTO `#__community_msg` (`id`, `from`, `parent`, `deleted`, `from_name`, `posted_on`, `subject`, `body`) 
VALUES
(2, 82, 2, 0, 'regtest1789672', '2010-09-15 07:55:30', 'testmessage', 'testmessage'),
(3, 83, 3, 0, 'regtest1789672', '2010-09-15 07:55:30', 'testmessage', 'testmessage')

;;

TRUNCATE TABLE `#__community_msg_recepient`;;
INSERT INTO `#__community_msg_recepient` (`msg_id`, `msg_parent`, `msg_from`, `to`, `bcc`, `is_read`, `deleted`) 
VALUES
(2, 2, 82, 83, 0, 1, 0),
(3, 3, 83, 82, 0, 1, 0)
;;


TRUNCATE TABLE `#__community_photos_albums`;;
INSERT INTO `#__community_photos_albums` 
(`id`, `photoid`, `creator`, `name`, `description`, `permissions`, `created`, `path`, `type`) VALUES
(2, 0, 82, 'a', 'a', '', '2010-10-17 10:22:01', 'images/photos/62/', 'user'),
(3, 0, 83, 'a', 'a', '', '2010-10-17 10:22:01', 'images/photos/62/', 'user')
;;

TRUNCATE TABLE `#__community_photos` ;;
INSERT INTO `#__community_photos` (`id`, `albumid`, `caption`, `published`, `creator`, `permissions`, `image`, `thumbnail`, `original`, `created`, `filesize`, `storage`, `ordering`) VALUES
(2, 2, 'IMG_1287', 1, 82, '', 'images/photos/62/7/df4fb2a38b6e2eeffdb5093b.jpg', 'images/photos/62/7/thumb_df4fb2a38b6e2eeffdb5093b.jpg', 'images/originalphotos/62/7/df4fb2a38b6e2eeffdb5093b.jpg', '2010-10-17 10:29:19', 4096, 'file', 0),
(3, 2, 'IMG_1287', 1, 83, '', 'images/photos/62/7/df4fb2a38b6e2eeffdb5093b.jpg', 'images/photos/62/7/thumb_df4fb2a38b6e2eeffdb5093b.jpg', 'images/originalphotos/62/7/df4fb2a38b6e2eeffdb5093b.jpg', '2010-10-17 10:29:19', 4096, 'file', 0)
;;


TRUNCATE TABLE `#__community_videos` ;;
INSERT INTO `#__community_videos` 
(`id`, `title`, `type`, `video_id`, `description`, `creator`, `creator_type`, `created`, `permissions`, `category_id`,`status`) 
VALUES
(2, 'Kites Song F', 'youtube', 'PN626ZXD204', 'Kites', 82, 'user', '2010-05-25 11:57:38', '0', 1,'ready'),
(3, 'PHP Tutorial', 'youtube', 'afgyNp5HueQ', 'PHP'  , 83, 'user', '2010-05-25 12:19:16', '0', 1,'ready'),
(4, 'Hrithik R*',   'youtube', 'luXxeIlOoKU', 'Hrit' , 84, 'user', '2010-05-25 12:28:01', '0', 1,'ready')
;;
