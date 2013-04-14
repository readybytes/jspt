TRUNCATE TABLE `#__users`;;
INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'shyam@readybytes.in', '6a8c2b2fbc4ee1b4f3f042009d8a22f3:K5wzjZ3SlgIYTVPMaKt0wE0w6JUEJ2Bm', 'Super Administrator', 0, 1, 25, '2009-10-27 14:21:57', '2010-02-20 12:01:33', '', '\n'),
(88, 'gaurav1', 'gaurav1', 'gaurav1@email.com', 'c7f09c095dae3543152f8d1a5b110577:9Yd42bb9NmtZPaVSaoOSZgukDTeqYw3T', 'Registered', 0, 0, 18, '2010-02-20 12:21:30', '0000-00-00 00:00:00', '', '\n'),
(89, 'gaurav2', 'gaurav2', 'gaurav2@email.com', '3688599367fa4ccb75f1f82e0da4c3fa:TBJDUAeXQpYtcK95gacn0PRvMRtHsjwO', 'Registered', 0, 0, 18, '2010-02-20 12:22:15', '0000-00-00 00:00:00', '', '\n'),
(90, 'gaurav3', 'gaurav3', 'gaurav3@email.com', '5aacacd8c3e381e61b32814decec70d4:v9wphm1c0mMlRfZkErrqVdqk4bqfhPDL', 'Registered', 0, 0, 18, '2010-02-20 12:23:24', '0000-00-00 00:00:00', '', '\n');;
TRUNCATE TABLE `#__core_acl_aro`;;
INSERT INTO `#__core_acl_aro` (`id`, `section_value`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', '62', 0, 'Administrator', 0),
(36, 'users', '88', 0, 'gaurav1', 0),
(37, 'users', '89', 0, 'gaurav2', 0),
(38, 'users', '90', 0, 'gaurav3', 0);;

TRUNCATE TABLE `#__core_acl_aro_groups`;;
INSERT INTO `#__core_acl_aro_groups` (`id`, `parent_id`, `name`, `lft`, `rgt`, `value`) VALUES
(17, 0, 'ROOT', 1, 22, 'ROOT'),
(28, 17, 'USERS', 2, 21, 'USERS'),
(29, 28, 'Public Frontend', 3, 12, 'Public Frontend'),
(18, 29, 'Registered', 4, 11, 'Registered'),
(19, 18, 'Author', 5, 10, 'Author'),
(20, 19, 'Editor', 6, 9, 'Editor'),
(21, 20, 'Publisher', 7, 8, 'Publisher'),
(30, 28, 'Public Backend', 13, 20, 'Public Backend'),
(23, 30, 'Manager', 14, 19, 'Manager'),
(24, 23, 'Administrator', 15, 18, 'Administrator'),
(25, 24, 'Super Administrator', 16, 17, 'Super Administrator');;

TRUNCATE TABLE `#__core_acl_aro_sections`;;
INSERT INTO `#__core_acl_aro_sections` (`id`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', 1, 'Users', 0);;

TRUNCATE TABLE `#__core_acl_groups_aro_map`;;
INSERT INTO `#__core_acl_groups_aro_map` (`group_id`, `section_value`, `aro_id`) VALUES
(18, '', 36),
(18, '', 37),
(18, '', 38),
(25, '', 10);;


TRUNCATE TABLE `#__xipt_users`;;
INSERT INTO `#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 1, 'default'),
(88, 1, 'default'),
(89, 1, 'blackout'),
(90, 1, 'default');;

