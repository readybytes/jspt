INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Super User', 'admin', 'shyam@readybytes.in', 'be95af2bcc51aa6e81a9924155176d1a:Sqw3m1pYS6nnyKaY68lqAMKzM9tvpR3R', 'Super Administrator', 0, 1, '2011-03-03 06:53:07', '2011-04-30 09:47:53', '', '{"admin_style":"","admin_language":"","language":"","editor":"","helpsite":"","timezone":""}'),
(63, 'user-1', 'user-1', 'user1@xyz.com', '3334b9a22c5f4050155a3dedcb985c86:EYnPl96mAD7rIMEZwLMSJZ1MdLHSC2kd', 'Registered', 0, 0, '2011-03-03 07:14:21', '2011-03-03 07:24:35', '', '{}'),
(64, 'user-2', 'user-2', 'user2@xyz.com', '29a623753e24f72192628540400ca182:Ks2qT6luQ7X6KU2NTrIJ5vg6hjqK7M3q', 'Registered', 0, 0, '2011-03-03 07:15:13', '0000-00-00 00:00:00', '', '{}'),
(65, 'user-3', 'user-3', 'user3@xyz.com', 'aadb4a979a6050d4ac05b250994d0b46:YGJJVJrhiCervgeNuAj0zZIa2pFPyEC4', 'Registered', 0, 0, '2011-03-03 07:16:37', '2011-03-03 07:46:19', '', '{"admin_style":"","admin_language":"","language":"","editor":"","helpsite":"","timezone":""}'),
(66, 'user-4', 'user-4', 'user4@xyz.com', 'c16fb4326c20deab8b5e8f62030b2290:Mrr1cLcWVohlETwavt6y9S1tkflI19kj', 'Registered', 0, 0, '2011-03-03 07:17:30', '0000-00-00 00:00:00', '', '{"admin_style":"","admin_language":"","language":"","editor":"","helpsite":"","timezone":""}'),
(67, 'user-5', 'user-5', 'user5@xyz.com', '34603e69f6487908cc70eef5f1141778:jAvCyL7Yms593cLS7IyjZRskDAUrW05f', 'Registered', 0, 0, '2011-03-03 07:18:17', '0000-00-00 00:00:00', '', '{"admin_style":"","admin_language":"","language":"","editor":"","helpsite":"","timezone":""}'),
(68, 'user-6', 'user-6', 'user-6@xyz.com', '3d75de7015b0c3945c296123974b17fb:NqCfLQFkWfTCeZuBxF4z5Y0o8JToAZ6I', 'Registered', 0, 0, '2011-03-03 07:19:17', '2011-03-03 07:26:12', '', '{"admin_style":"","admin_language":"","language":"","editor":"","helpsite":"","timezone":""}');;

TRUNCATE TABLE `#__core_acl_aro`;;
INSERT INTO `#__core_acl_aro` (`id`, `section_value`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', '62', 0, 'Super User', 0),
(31, 'users', '63', 0, 'user-1', 0),
(28, 'users', '64', 0, 'user-2', 0),
(32, 'users', '65', 0, 'user-3', 0),
(35, 'users', '66', 0, 'user-4', 0),
(33, 'users', '67', 0, 'user-5', 0),
(34, 'users', '86', 0, 'user-6', 0);;

TRUNCATE TABLE `#__core_acl_groups_aro_map`;;
INSERT INTO `#__core_acl_groups_aro_map` (`group_id`, `section_value`, `aro_id`) VALUES
(18, '', 34),
(18, '', 33),
(18, '', 28),
(18, '', 31),
(18, '', 32),
(18, '', 35),
(25, '', 10);;

