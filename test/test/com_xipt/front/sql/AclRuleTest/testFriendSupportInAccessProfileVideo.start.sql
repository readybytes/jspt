TRUNCATE TABLE `#__community_users`;;
INSERT INTO `#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`, `alias`, `latitude`, `longitude`) VALUES
(62, '', 12, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(83, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\nprofileVideo=11\n\n', 4, 0, '', 255, 255),
(84, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\nprofileVideo=12\n\n', 4, 0, '', 255, 255),
(85, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(86, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 2, 0, '', 255, 255),
(87, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\nprofileVideo=3\n\n', 0, 0, '', 255, 255),
(79, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\nprofileVideo=0\n\n', 0, 0, '', 255, 255),
(80, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(81, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(82, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\nprofileVideo=2\n\n', 0, 0, '', 255, 255);;



TRUNCATE TABLE `#__users`;;
INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'shyam@readybytes.in', '6a8c2b2fbc4ee1b4f3f042009d8a22f3:K5wzjZ3SlgIYTVPMaKt0wE0w6JUEJ2Bm', 'Super Administrator', 0, 1, 25, '2009-10-27 14:21:57', '2009-12-03 08:11:53', '', '\n'),
(82, 'regtest8774090', 'regtest8774090', 'regtest8774090@gmail.com', 'f478ff7ef92fcb7a7cb62d4c1f08e43a:7rptUeQifMIkdyqE59fnxb0o74NE4sk8', 'Registered', 0, 0, 18, '2009-12-03 08:16:35', '0000-00-00 00:00:00', 'a3a9fc5ff08868ee458cda29142e6e36', '\n'),
(83, 'regtest1789672', 'regtest1789672', 'regtest1789672@gmail.com', 'c33a3ac03bfbc13368383edc0e6ae42d:bUwtJXMI49daOhAPzdaLBdRY1IOOgm0D', 'Editor', 0, 0, 20, '2009-12-03 08:16:44', '0000-00-00 00:00:00', 'a25e8cbbf5a534e0d5b934589be66756', '\n'),
(84, 'regtest6461827', 'regtest6461827', 'regtest6461827@gmail.com', '56f606098f0631341e8c398eaae179c6:aOJ5ghvQqtSCPnIH8SwFw90001MNaRI6', 'Publisher', 0, 0, 21, '2009-12-03 08:16:52', '0000-00-00 00:00:00', 'd8e2cc8000b17d6791a451354a281937', '\n'),
(85, 'regtest3843261', 'regtest3843261', 'regtest3843261@gmail.com', '0f2e8c8f8433fd1604880e9ac0d33fc1:d4b8PHWIkuHEI4AfHM1XWkFh4sR4t1gj', 'Registered', 0, 0, 18, '2009-12-03 08:17:00', '0000-00-00 00:00:00', '0e11cd0ed924846a11c84e3618f2c5eb', '\n'),
(86, 'regtest1504555', 'regtest1504555', 'regtest1504555@gmail.com', '78c3901d9d2c31108f9f758a18ee7f89:UIbbRXlJUORtEqogoLPr9ZP0bouM0lLT', 'Editor', 0, 0, 20, '2009-12-03 08:17:09', '0000-00-00 00:00:00', '77981cae5948a5be5e553db5dcb8d00f', '\n'),
(87, 'regtest1674526', 'regtest1674526', 'regtest1674526@gmail.com', '948b72e649363975c49ba818d6880843:PezoDwP9dbIXQETtPbG0IfkpE0jogLi2', 'Publisher', 0, 0, 21, '2009-12-03 08:17:17', '0000-00-00 00:00:00', '51bcf29e8ec7bbaf00dc2160257b8987', '\n'),
(79, 'regtest7046025', 'regtest7046025', 'regtest7046025@gmail.com', '64d5a5a65e0433fefad4d52255857f59:rBhZVyCqDIKioTNuCNBkpQNhRXsCHb1t', 'Registered', 0, 0, 18, '2009-12-03 08:16:09', '0000-00-00 00:00:00', 'd45373ce0b2c4bfa6065235a5c353add', '\n'),
(80, 'regtest6208627', 'regtest6208627', 'regtest6208627@gmail.com', '73e7830c01e705a5adeaaa3e278fbdec:uQb0sUh0KdTyybJuHnYHAtpOmtfVNxr2', 'Editor', 0, 0, 20, '2009-12-03 08:16:18', '0000-00-00 00:00:00', '0e24ede794209ad6de9624f89077daed', '\n'),
(81, 'regtest8635954', 'regtest8635954', 'regtest8635954@gmail.com', '7dc28bb5bc0119a23ac236b82837586e:vBNJaILgct7EzdE4wmJANFeLuVSTLHdh', 'Publisher', 0, 0, 21, '2009-12-03 08:16:26', '0000-00-00 00:00:00', '1ebc22393cc2619be62d28fe7c960e5a', '\n');;

TRUNCATE TABLE `#__xipt_profiletypes` ;;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`) VALUES
(1, 'PROFILETYPE-1', 2, 1, 'PROFILETYPE-ONE-TIP', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 1, '', ''),
(2, 'PROFILETYPE-2', 1, 1, 'PROFILETYPE-TWO-TIP', 'public', 'blueface', 'Editor', 'components/com_community/assets/group.jpg', 0, 0, 0, '', ''),
(3, 'PROFILETYPE-3', 3, 1, 'PROFILETYPE-THREE-TIP', 'members', 'blackout', 'Publisher', 'components/com_community/assets/default.jpg', 0, 0, 4, '', ''),
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
(30, 'users', '82', 0, 'regtest8774090', 0);;


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
(25, '', 10);;

TRUNCATE TABLE `#__xipt_aclrules`;;
INSERT INTO `#__xipt_aclrules` (`id`, `rulename`, `aclname`, `coreparams`, `aclparams`, `published`) VALUES
(2, 'access  profile video', 'accessprofilevideo', 'core_profiletype=1\ncore_display_message=YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE\ncore_redirect_url=index.php?option=com_community\n\n', 'other_profiletype=2\nacl_applicable_to_friend=0\n\n', 1),
(3, 'access  profile video', 'accessprofilevideo', 'core_profiletype=2\ncore_display_message=YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE\ncore_redirect_url=index.php?option=com_community\n\n', 'other_profiletype=3\nacl_applicable_to_friend=1\n\n', 1);;

TRUNCATE TABLE `#__community_videos`;;
INSERT INTO `#__community_videos` (`id`, `title`, `type`, `video_id`, `description`, `creator`, `creator_type`, `created`, `permissions`, `category_id`, `hits`, `published`, `featured`, `duration`, `status`, `thumb`, `path`, `groupid`, `filesize`, `storage`) VALUES
(1, 'Kites Song Fire |  Kites Fire  |  Hrithik Roshan Fire  |  Kites Song Promo  Fire  |  Fire |', 'youtube', 'PN626ZXD204', 'Kites Song Promo -  Fire  \r\nChoreographer - Flexy        Music - Rajesh Roshan\r\n\r\nKITES Releasing Worldwide on 21st May (2010)', 85, 'user', '2010-05-25 11:57:38', '0', 1, 5, 1, 0, 62, 'ready', 'images/videos/88/thumbs/BeYcKnpwhj9.jpg', 'http://www.youtube.com/watch?v=PN626ZXD204', 0, 0, 'file'),
(2, 'PHP Tutorial: Installation and The Basics', 'youtube', 'afgyNp5HueQ', 'PHP', 86, 'user', '2010-05-25 12:19:16', '0', 1, 9, 1, 0, 654, 'ready', 'images/videos/89/thumbs/RyQFKAMfQuS.jpg', 'http://www.youtube.com/watch?v=afgyNp5HueQ', 0, 0, 'file'),
(3, 'Hrithik Roshan''s Superb Dancing in Kites (2010) *HD*', 'youtube', 'luXxeIlOoKU', 'Hrithik Roshan, Dance, Kites, Hindi Movie, Watch Online, SominalTv, Kangana Ranawat, Fire, Full Song, Music Video', 87, 'user', '2010-05-25 12:28:01', '0', 1, 7, 1, 0, 189, 'ready', 'images/videos/90/thumbs/gQ1sAuG34du.jpg', 'http://www.youtube.com/watch?v=luXxeIlOoKU', 0, 0, 'file'),
(4, 'Build a Joomla Website', 'youtube', 'lGub1u8v8i8', 'http:www.buildajoomlawebsite.com\r\nIf you have ever wanted to build a Joomla website...you need to see this', 79, 'user', '2010-06-15 09:21:24', '0', 1, 1, 1, 0, 298, 'ready', 'images/videos/79/thumbs/O6iK9kZPqFt.jpg', 'http://www.youtube.com/watch?v=lGub1u8v8i8&feature=related', 0, 0, 'file'),
(5, 'Build easy websites using Joomla tutorials', 'youtube', 'fVr7huePbIA', 'Its a clip that shows you ways to build a website using joomla..a powerful open source...\r\n\r\nYou can create websites in 10 mins..that too with features and a database that supports..and gives you access to admin..enjoy!!\r\n\r\nfind more information from joomlasuccess.com', 80, 'user', '2010-06-15 09:23:09', '0', 1, 1, 1, 0, 15, 'ready', 'images/videos/80/thumbs/SsnDTqPD89x.jpg', 'http://www.youtube.com/watch?v=fVr7huePbIA&feature=related', 0, 0, 'file'),
(6, 'How to Build and Manage Your Own Website - (Joomla Editors)', 'youtube', 'ESEU8XqyrZE', 'http:www.MakeYourWebsite123.com\r\n\r\nEasily Edit, Design And Format Your Pages Using WYSIWYG Editor, Without Ever Messing With HTML And Other Programming Languages\r\nMake you own website\r\nmake a website\r\nhow to make a website\r\nhow to make your own website for free', 81, 'user', '2010-06-15 09:25:14', '0', 1, 1, 1, 0, 272, 'ready', 'images/videos/81/thumbs/rSG2g8pNIYc.jpg', 'http://www.youtube.com/watch?v=ESEU8XqyrZE&feature=related', 0, 0, 'file'),
(7, 'How to createmake your own website 4 free', 'youtube', 'qB6zTgMWcDA', 'this is how to create youre own website first: go to www.freeservers.com and then click the box with the free on the top. and then follow the steps and fill the blanks and in no time you have you''re website!\r\n\r\n AXLPOGI Productions-MADE IN PHILIPPINES', 95, 'user', '2010-06-15 10:11:53', '0', 1, 1, 1, 0, 226, 'ready', 'images/videos/95/thumbs/HW82lNd9oWo.jpg', 'http://www.youtube.com/watch?v=qB6zTgMWcDA&feature=related', 0, 0, 'file'),
(8, 'Make a free website!!', 'youtube', '8aaNngwsY3c', 'its cool free and fast!! great for gamers, for clans yada yada yada\r\nmy site: www.valenciascape.ucoz.com\r\nto register for a site:www.ucoz.com', 96, 'user', '2010-06-15 10:15:12', '0', 1, 1, 1, 0, 220, 'ready', 'images/videos/96/thumbs/BN4EaRT8955.jpg', 'http://www.youtube.com/watch?v=8aaNngwsY3c&feature=related', 0, 0, 'file'),
(9, 'Best Free Website Hosting: With FTP, PHP, and MySQL!', 'youtube', 'whPYvGuqviI', 'Free website hosting.\r\nhttp:www.podserver.info\r\nHost your own message board forum, blog, CMS, image gallery, Commerce, wiki, and more. Unlike other free hosting plans, this includes full access to FTP, PHP, MySQL, Apache and Control Panel.\r\n\r\nFree web hosting services:\r\n• 300 MB disk space\r\n• 10 GB monthly transfer\r\n• 7 MySQL databases\r\n• Free 247 tech support and instant activation\r\n• FTP, file manager, MySQL, Ion Cube, Zend Optimizer, and Apache\r\n• PHP with ''safe_mode'' off and GD enabled\r\n• Password protect directories\r\n• Control panel and Fantastico® like automatic script installer\r\n• 6 Addon domains, 6 parked domains, and 6 sub-domains\r\n• Webmail, sendmail and POP email\r\n• Quad Xeon grid servers with multiple fiber optic connections\r\n\r\nMusic: Kevin MacLeod', 97, 'user', '2010-06-15 10:20:07', '0', 1, 1, 1, 0, 32, 'ready', 'images/videos/97/thumbs/gNRmYbqgB33.jpg', 'http://www.youtube.com/watch?v=whPYvGuqviI&feature=related', 0, 0, 'file'),
(10, 'Best Free Website Hosting: With FTP, PHP, and MySQL!', 'youtube', 'whPYvGuqviI', 'Free website hosting.\r\nhttp://www.podserver.info/\r\nHost your own message board forum, blog, CMS, image gallery, Commerce, wiki, and more. Unlike other free hosting plans, this includes full access to FTP, PHP, MySQL, Apache and Control Panel.\r\n\r\nFree web hosting services:\r\n• 300 MB disk space\r\n• 10 GB monthly transfer\r\n• 7 MySQL databases\r\n• Free 24/7 tech support and instant activation\r\n• FTP, file manager, MySQL, Ion Cube, Zend Optimizer, and Apache\r\n• PHP with ''safe_mode'' off and GD enabled\r\n• Password protect directories\r\n• Control panel and Fantastico® like automatic script installer\r\n• 6 Addon domains, 6 parked domains, and 6 sub-domains\r\n• Webmail, sendmail and POP email\r\n• Quad Xeon grid servers with multiple fiber optic connections\r\n\r\nMusic: Kevin MacLeod', 82, 'user', '2010-07-02 17:14:45', '0', 1, 0, 1, 0, 32, 'ready', 'images/videos/82/thumbs/P88mJYo0EzM.jpg', 'http://www.youtube.com/watch?v=whPYvGuqviI&feature=related', 0, 0, 'file'),
(11, 'Best Free Website Hosting: With FTP, PHP, and MySQL!', 'youtube', 'whPYvGuqviI', 'Free website hosting.\r\nhttp://www.podserver.info/\r\nHost your own message board forum, blog, CMS, image gallery, Commerce, wiki, and more. Unlike other free hosting plans, this includes full access to FTP, PHP, MySQL, Apache and Control Panel.\r\n\r\nFree web hosting services:\r\n• 300 MB disk space\r\n• 10 GB monthly transfer\r\n• 7 MySQL databases\r\n• Free 24/7 tech support and instant activation\r\n• FTP, file manager, MySQL, Ion Cube, Zend Optimizer, and Apache\r\n• PHP with ''safe_mode'' off and GD enabled\r\n• Password protect directories\r\n• Control panel and Fantastico® like automatic script installer\r\n• 6 Addon domains, 6 parked domains, and 6 sub-domains\r\n• Webmail, sendmail and POP email\r\n• Quad Xeon grid servers with multiple fiber optic connections\r\n\r\nMusic: Kevin MacLeod', 83, 'user', '2010-07-02 17:15:40', '0', 1, 1, 1, 0, 32, 'ready', 'images/videos/83/thumbs/2DgmjqgM1pe.jpg', 'http://www.youtube.com/watch?v=whPYvGuqviI&feature=related', 0, 0, 'file'),
(12, 'How to get free web hosting with FTP access', 'youtube', 'OwhASSD1nPs', 'LINK http://www.000webhost.com/159318.html', 84, 'user', '2010-07-02 17:39:46', '0', 1, 0, 1, 0, 156, 'ready', 'images/videos/84/thumbs/jH1RT5MmfFr.jpg', 'http://www.youtube.com/watch?v=OwhASSD1nPs&feature=related', 0, 0, 'file');;

TRUNCATE TABLE `#__community_connection`;;
INSERT INTO `#__community_connection` (`connection_id`, `connect_from`, `connect_to`, `status`, `group`, `created`, `msg`) VALUES
(1, 85, 84, 1, 0, NULL, ''),
(2, 84, 82, 1, 0, NULL, ''),
(13, 79, 81, 1, 0, '2010-06-15 09:30:42', ''),
(8, 79, 80, 1, 0, '2010-06-15 09:29:15', ''),
(9, 80, 79, 1, 0, '2010-06-15 09:29:15', ''),
(11, 80, 81, 1, 0, '2010-06-15 09:30:40', ''),
(12, 81, 80, 1, 0, '2010-06-15 09:30:40', ''),
(14, 81, 79, 1, 0, '2010-06-15 09:30:42', ''),
(20, 96, 80, 1, 0, '2010-06-15 10:24:25', ''),
(22, 97, 81, 1, 0, '2010-06-15 10:25:01', ''),
(18, 79, 95, 1, 0, '2010-06-15 10:23:19', ''),
(19, 95, 79, 1, 0, '2010-06-15 10:23:19', ''),
(21, 80, 96, 1, 0, '2010-06-15 10:24:25', ''),
(23, 81, 97, 1, 0, '2010-06-15 10:25:01', ''),
(29, 82, 83, 1, 0, '2010-07-02 16:58:12', ''),
(28, 83, 82, 1, 0, '2010-07-02 16:58:12', ''),
(31, 84, 83, 1, 0, '2010-07-02 17:40:26', ''),
(32, 83, 84, 1, 0, '2010-07-02 17:40:26', '');;



