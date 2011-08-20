TRUNCATE TABLE `#__community_users`;;

INSERT INTO `#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`, `alias`, `latitude`, `longitude`) VALUES
(42, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(63, '', 4, '0000-00-00 00:00:00', 'test/test/unit/front/controller/images/avatar_1_1.7.gif', 'test/test/unit/front/controller/images/avatar_1_1.7_thumb.gif', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255),
(64, '', 2, '0000-00-00 00:00:00', 'images/avatar/77a4023572dee874956a16c5.jpg', 'images/avatar/thumb_77a4023572dee874956a16c5.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, '', 255, 255);;

TRUNCATE TABLE `#__users`;;

INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Super User', 'admin', 'shyam@readybytes.in', '6a8c2b2fbc4ee1b4f3f042009d8a22f3:K5wzjZ3SlgIYTVPMaKt0wE0w6JUEJ2Bm', 'deprecated', 0, 1,  '2009-10-27 14:21:57', '2010-07-20 15:33:59', '', '\n'),
(63, '123', '123', '123@gg.com', '37a7633c128d44bd93629348a746ee82:TVa8P2R0wf8tHDitikdUDOTpNMLj5jtG', 'Registered', 0, 0, '2010-12-03 12:08:03', '2010-12-04 05:52:26', 'b39ac6adf13f344ce78a26a7a8f14527', '\n'),
(64, '1234', '1234', '1234@gg.com', '53403598fcc62b2d65ecf9ce2a322a55:p495nv2jRhMwzrqh25Y9niFuED76tbtk', 'Registered', 0, 0, '2010-12-04 05:36:47', '2010-12-04 05:52:21', 'bb28b660e01fc9e1782d07aaec9045d3', '\n');;

TRUNCATE TABLE  `#__xipt_users` ;;

INSERT INTO `#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(42, 1, 'default'),
(63, 1, 'default'),
(64, 2, 'default');;
