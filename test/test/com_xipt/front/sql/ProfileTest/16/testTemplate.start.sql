TRUNCATE TABLE `#__users`;;
INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(42, 'Super User', 'admin', 'shyam@readybytes.in', '6a8c2b2fbc4ee1b4f3f042009d8a22f3:K5wzjZ3SlgIYTVPMaKt0wE0w6JUEJ2Bm', 'deprecated', 0, 1, '2009-10-27 14:21:57', '2010-02-20 12:01:33', '', '\n'),
(88, 'gaurav1', 'gaurav1', 'gaurav1@email.com', 'c7f09c095dae3543152f8d1a5b110577:9Yd42bb9NmtZPaVSaoOSZgukDTeqYw3T', 'Registered', 0, 0, '2010-02-20 12:21:30', '0000-00-00 00:00:00', '', '\n'),
(89, 'gaurav2', 'gaurav2', 'gaurav2@email.com', '3688599367fa4ccb75f1f82e0da4c3fa:TBJDUAeXQpYtcK95gacn0PRvMRtHsjwO', 'Registered', 0, 0, '2010-02-20 12:22:15', '0000-00-00 00:00:00', '', '\n'),
(90, 'gaurav3', 'gaurav3', 'gaurav3@email.com', '5aacacd8c3e381e61b32814decec70d4:v9wphm1c0mMlRfZkErrqVdqk4bqfhPDL', 'Registered', 0, 0, '2010-02-20 12:23:24', '0000-00-00 00:00:00', '', '\n');;

TRUNCATE TABLE `#__user_usergroup_map`;;
INSERT INTO `#__user_usergroup_map` (`user_id`, `group_id`) VALUES
(42, 7),
(88, 2),
(89, 2),
(90, 2);;

TRUNCATE TABLE `#__xipt_users`;;
INSERT INTO `#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(42, 1, 'default'),
(88, 1, 'default'),
(89, 1, 'blackout'),
(90, 1, 'default');;
