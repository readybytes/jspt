TRUNCATE TABLE `#__community_users`;;
INSERT INTO `#__community_users` (`userid`, `params`) VALUES
(62,''),
(83,'{"profileVideo":"3"}'),
(84,''),
(85,''),
(86,''),
(87,''),
(79,''),
(80,''),
(81,''),
(82,'')
;;
TRUNCATE TABLE `#__users`;;
INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Super User', 'admin', 'shyam@readybytes.in', '6a8c2b2fbc4ee1b4f3f042009d8a22f3:K5wzjZ3SlgIYTVPMaKt0wE0w6JUEJ2Bm', 'deprecated', 0, 1, '2009-10-27 14:21:57', '2010-06-15 10:40:57', '', '\n'),
(82, 'regtest8774090', 'regtest8774090', 'regtest8774090@gmail.com', 'f478ff7ef92fcb7a7cb62d4c1f08e43a:7rptUeQifMIkdyqE59fnxb0o74NE4sk8', 'Registered', 0, 0, '2009-12-03 08:16:35', '2010-06-15 08:36:29', 'a3a9fc5ff08868ee458cda29142e6e36', '\n'),
(83, 'regtest1789672', 'regtest1789672', 'regtest1789672@gmail.com', 'c33a3ac03bfbc13368383edc0e6ae42d:bUwtJXMI49daOhAPzdaLBdRY1IOOgm0D', 'Editor', 0, 0, '2009-12-03 08:16:44', '0000-00-00 00:00:00', 'a25e8cbbf5a534e0d5b934589be66756', '\n'),
(84, 'regtest6461827', 'regtest6461827', 'regtest6461827@gmail.com', '56f606098f0631341e8c398eaae179c6:aOJ5ghvQqtSCPnIH8SwFw90001MNaRI6', 'Publisher', 0, 0, '2009-12-03 08:16:52', '0000-00-00 00:00:00', 'd8e2cc8000b17d6791a451354a281937', '\n'),
(85, 'regtest3843261', 'regtest3843261', 'regtest3843261@gmail.com', '0f2e8c8f8433fd1604880e9ac0d33fc1:d4b8PHWIkuHEI4AfHM1XWkFh4sR4t1gj', 'Registered', 0, 0, '2009-12-03 08:17:00', '0000-00-00 00:00:00', '0e11cd0ed924846a11c84e3618f2c5eb', '\n'),
(86, 'regtest1504555', 'regtest1504555', 'regtest1504555@gmail.com', '78c3901d9d2c31108f9f758a18ee7f89:UIbbRXlJUORtEqogoLPr9ZP0bouM0lLT', 'Editor', 0, 0, '2009-12-03 08:17:09', '2010-06-15 08:26:38', '77981cae5948a5be5e553db5dcb8d00f', '\n'),
(87, 'regtest1674526', 'regtest1674526', 'regtest1674526@gmail.com', '948b72e649363975c49ba818d6880843:PezoDwP9dbIXQETtPbG0IfkpE0jogLi2', 'Publisher', 0, 0, '2009-12-03 08:17:17', '0000-00-00 00:00:00', '51bcf29e8ec7bbaf00dc2160257b8987', '\n'),
(79, 'regtest7046025', 'regtest7046025', 'regtest7046025@gmail.com', '64d5a5a65e0433fefad4d52255857f59:rBhZVyCqDIKioTNuCNBkpQNhRXsCHb1t', 'Registered', 0, 0, '2009-12-03 08:16:09', '2010-06-15 10:22:52', 'd45373ce0b2c4bfa6065235a5c353add', '\n'),
(80, 'regtest6208627', 'regtest6208627', 'regtest6208627@gmail.com', '73e7830c01e705a5adeaaa3e278fbdec:uQb0sUh0KdTyybJuHnYHAtpOmtfVNxr2', 'Editor', 0, 0, '2009-12-03 08:16:18', '2010-06-15 10:24:28', '0e24ede794209ad6de9624f89077daed', '\n'),
(81, 'regtest8635954', 'regtest8635954', 'regtest8635954@gmail.com', '7dc28bb5bc0119a23ac236b82837586e:vBNJaILgct7EzdE4wmJANFeLuVSTLHdh', 'Publisher', 0, 0, '2009-12-03 08:16:26', '2010-06-15 10:24:50', '1ebc22393cc2619be62d28fe7c960e5a', '\n')
;;
TRUNCATE TABLE `#__user_usergroup_map`;;
INSERT INTO `#__user_usergroup_map` (`user_id`, `group_id`) 
VALUES
('62','8'),
('82','2'),
('83','2'),
('84','2'),
('85','2'),
('86','2'),
('87','2'),
('79','2'),
('80','2'),
('81','2');;
TRUNCATE TABLE `#__community_events`;;
INSERT INTO `#__community_events` (`id`, `catid`, `contentid`, `type`, `title`, `location`, `description`, `creator`, `startdate`, `enddate`, `permission`, `avatar`, `thumb`, `invitedcount`, `confirmedcount`, `declinedcount`, `maybecount`, `wallcount`, `ticket`, `allowinvite`, `created`, `hits`, `published`, `latitude`, `longitude`, `offset`) VALUES
(2, 2, 0, 'profile', 'myevent1', '', '', 82, '2012-03-02 12:00:00', '2012-03-03 06:00:00', 0, NULL, NULL, 0, 0, 0, 0, 0, 0, 1, NULL, 3, 1, 25.3463, 74.6364, '0'),
(3, 2, 0, 'profile', 'myevent2', '', '', 83, '2012-03-02 12:00:00', '2012-03-03 06:00:00', 0, NULL, NULL, 0, 0, 0, 0, 0, 0, 1, NULL, 1, 1, 25.3463, 74.6364, '0');;

TRUNCATE TABLE `#__acctexp_microintegrations`;;
INSERT INTO `#__acctexp_microintegrations` (`id`, `active`, `system`, `hidden`, `ordering`, `name`, `desc`, `class_name`, `params`, `auto_check`, `on_userchange`, `pre_exp_check`) VALUES
(1, 1, 0, 0, 1, 'jspt plans', 'Choose the default profile type for a user.', 'mi_jomsocialjspt', 'YTo1OntzOjExOiJfYWVjX2FjdGlvbiI7czoxOiIxIjtzOjIwOiJfYWVjX29ubHlfZmlyc3RfYmlsbCI7czoxOiIxIjtzOjE5OiJfYWVjX2dsb2JhbF9leHBfYWxsIjtzOjE6IjEiO3M6MTE6InByb2ZpbGV0eXBlIjthOjE6e2k6MDtzOjE6IjEiO31zOjIxOiJwcm9maWxldHlwZV9hZnRlcl9leHAiO2E6MTp7aTowO3M6MToiMSI7fX0=', 1, 1, 0),
(2, 1, 0, 0, 2, 'Jspt MicroIntegration', 'Choose the default profile type for a user.', 'mi_jomsocialjspt', 'YTo1OntzOjExOiJfYWVjX2FjdGlvbiI7czoxOiIxIjtzOjIwOiJfYWVjX29ubHlfZmlyc3RfYmlsbCI7czoxOiIxIjtzOjE5OiJfYWVjX2dsb2JhbF9leHBfYWxsIjtzOjE6IjEiO3M6MTE6InByb2ZpbGV0eXBlIjthOjE6e2k6MDtzOjE6IjIiO31zOjIxOiJwcm9maWxldHlwZV9hZnRlcl9leHAiO2E6MTp7aTowO3M6MToiMiI7fX0=', 1, 1, 0);;

TRUNCATE TABLE `#__acctexp_plans`;;
INSERT INTO `#__acctexp_plans` (`id`, `active`, `visible`, `ordering`, `name`, `desc`, `email_desc`, `params`, `custom_params`, `restrictions`, `micro_integrations`) VALUES
(1, 1, 1, 999999, 'Basic', '<p> </p>\r\n<hr />\r\n<p>Basic plan for Profile type 1.</p>\r\n<p> </p>', 'tut5uitiutititititititi', 'YToyOTp7czo5OiJmdWxsX2ZyZWUiO3M6MToiMSI7czoxMToiZnVsbF9hbW91bnQiO3M6NToiMjAuMDAiO3M6MTE6ImZ1bGxfcGVyaW9kIjtzOjE6IjEiO3M6MTU6ImZ1bGxfcGVyaW9kdW5pdCI7czoxOiJNIjtzOjEwOiJ0cmlhbF9mcmVlIjtzOjE6IjAiO3M6MTI6InRyaWFsX2Ftb3VudCI7czowOiIiO3M6MTI6InRyaWFsX3BlcmlvZCI7czowOiIiO3M6MTY6InRyaWFsX3BlcmlvZHVuaXQiO3M6MToiRCI7czoxMToiZ2lkX2VuYWJsZWQiO3M6MToiMSI7czozOiJnaWQiO3M6MToiMiI7czo4OiJsaWZldGltZSI7czoxOiIwIjtzOjE1OiJzdGFuZGFyZF9wYXJlbnQiO3M6MToiMCI7czo4OiJmYWxsYmFjayI7czoxOiIwIjtzOjE5OiJmYWxsYmFja19yZXFfcGFyZW50IjtzOjE6IjAiO3M6MTE6Im1ha2VfYWN0aXZlIjtzOjE6IjEiO3M6MTI6Im1ha2VfcHJpbWFyeSI7czoxOiIxIjtzOjE1OiJ1cGRhdGVfZXhpc3RpbmciO3M6MToiMSI7czoxMjoiY3VzdG9tdGhhbmtzIjtzOjA6IiI7czozMDoiY3VzdG9tdGV4dF90aGFua3Nfa2VlcG9yaWdpbmFsIjtzOjE6IjEiO3M6MTg6ImN1c3RvbWFtb3VudGZvcm1hdCI7czozNzM6InthZWNqc29ufXsiY21kIjoiY29uZGl0aW9uIiwidmFycyI6W3siY21kIjoiZGF0YSIsInZhcnMiOiJwYXltZW50LmZyZWV0cmlhbCJ9LHsiY21kIjoiY29uY2F0IiwidmFycyI6W3siY21kIjoiY29uc3RhbnQiLCJ2YXJzIjoiX0NPTkZJUk1fRlJFRVRSSUFMIn0sIsKgIix7ImNtZCI6ImRhdGEiLCJ2YXJzIjoicGF5bWVudC5tZXRob2RfbmFtZSJ9XX0seyJjbWQiOiJjb25jYXQiLCJ2YXJzIjpbeyJjbWQiOiJkYXRhIiwidmFycyI6InBheW1lbnQuYW1vdW50In0seyJjbWQiOiJkYXRhIiwidmFycyI6InBheW1lbnQuY3VycmVuY3lfc3ltYm9sIn0sIsKgIix7ImNtZCI6ImRhdGEiLCJ2YXJzIjoicGF5bWVudC5tZXRob2RfbmFtZSJ9XX1dfXsvYWVjanNvbn0iO3M6MTc6ImN1c3RvbXRleHRfdGhhbmtzIjtzOjE2OiI8cD5pdXRpdGl0aXQ8L3A+IjtzOjE5OiJvdmVycmlkZV9hY3RpdmF0aW9uIjtzOjE6IjAiO3M6MTY6Im92ZXJyaWRlX3JlZ21haWwiO3M6MToiMCI7czoxNjoibm90YXV0aF9yZWRpcmVjdCI7czowOiIiO3M6MTQ6ImZpeGVkX3JlZGlyZWN0IjtzOjA6IiI7czoyMjoiaGlkZV9kdXJhdGlvbl9jaGVja291dCI7czoxOiIwIjtzOjE4OiJhZGR0b2NhcnRfcmVkaXJlY3QiO3M6MDoiIjtzOjEzOiJjYXJ0X2JlaGF2aW9yIjtzOjE6IjAiO3M6MTA6InByb2Nlc3NvcnMiO2E6MDp7fX0=', 'YToxOntzOjk6ImFkZF9ncm91cCI7czoxOiIwIjt9', 'YTo0MTp7czoxNDoibWluZ2lkX2VuYWJsZWQiO3M6MToiMCI7czoxNDoiZml4Z2lkX2VuYWJsZWQiO3M6MToiMCI7czoxNDoibWF4Z2lkX2VuYWJsZWQiO3M6MToiMCI7czoyNDoicHJldmlvdXNwbGFuX3JlcV9lbmFibGVkIjtzOjE6IjAiO3M6MTY6InByZXZpb3VzcGxhbl9yZXEiO2E6MTp7aTowO3M6MToiMCI7fXM6MjM6ImN1cnJlbnRwbGFuX3JlcV9lbmFibGVkIjtzOjE6IjAiO3M6MTU6ImN1cnJlbnRwbGFuX3JlcSI7YToxOntpOjA7czoxOiIwIjt9czoyMzoib3ZlcmFsbHBsYW5fcmVxX2VuYWJsZWQiO3M6MToiMCI7czoxNToib3ZlcmFsbHBsYW5fcmVxIjthOjE6e2k6MDtzOjE6IjAiO31zOjMzOiJwcmV2aW91c3BsYW5fcmVxX2VuYWJsZWRfZXhjbHVkZWQiO3M6MToiMCI7czoyNToicHJldmlvdXNwbGFuX3JlcV9leGNsdWRlZCI7YToxOntpOjA7czoxOiIwIjt9czozMjoiY3VycmVudHBsYW5fcmVxX2VuYWJsZWRfZXhjbHVkZWQiO3M6MToiMCI7czoyNDoiY3VycmVudHBsYW5fcmVxX2V4Y2x1ZGVkIjthOjE6e2k6MDtzOjE6IjAiO31zOjMyOiJvdmVyYWxscGxhbl9yZXFfZW5hYmxlZF9leGNsdWRlZCI7czoxOiIwIjtzOjI0OiJvdmVyYWxscGxhbl9yZXFfZXhjbHVkZWQiO2E6MTp7aTowO3M6MToiMCI7fXM6MjE6InVzZWRfcGxhbl9taW5fZW5hYmxlZCI7czoxOiIwIjtzOjIwOiJ1c2VkX3BsYW5fbWluX2Ftb3VudCI7czoxOiIwIjtzOjEzOiJ1c2VkX3BsYW5fbWluIjthOjE6e2k6MDtzOjE6IjAiO31zOjIxOiJ1c2VkX3BsYW5fbWF4X2VuYWJsZWQiO3M6MToiMCI7czoyMDoidXNlZF9wbGFuX21heF9hbW91bnQiO3M6MToiMCI7czoxMzoidXNlZF9wbGFuX21heCI7YToxOntpOjA7czoxOiIwIjt9czoyNzoiY3VzdG9tX3Jlc3RyaWN0aW9uc19lbmFibGVkIjtzOjE6IjAiO3M6MTk6ImN1c3RvbV9yZXN0cmljdGlvbnMiO3M6MDoiIjtzOjI1OiJwcmV2aW91c2dyb3VwX3JlcV9lbmFibGVkIjtzOjE6IjAiO3M6MTc6InByZXZpb3VzZ3JvdXBfcmVxIjthOjE6e2k6MDtzOjE6IjAiO31zOjM0OiJwcmV2aW91c2dyb3VwX3JlcV9lbmFibGVkX2V4Y2x1ZGVkIjtzOjE6IjAiO3M6MjY6InByZXZpb3VzZ3JvdXBfcmVxX2V4Y2x1ZGVkIjthOjE6e2k6MDtzOjE6IjAiO31zOjI0OiJjdXJyZW50Z3JvdXBfcmVxX2VuYWJsZWQiO3M6MToiMCI7czoxNjoiY3VycmVudGdyb3VwX3JlcSI7YToxOntpOjA7czoxOiIwIjt9czozMzoiY3VycmVudGdyb3VwX3JlcV9lbmFibGVkX2V4Y2x1ZGVkIjtzOjE6IjAiO3M6MjU6ImN1cnJlbnRncm91cF9yZXFfZXhjbHVkZWQiO2E6MTp7aTowO3M6MToiMCI7fXM6MjQ6Im92ZXJhbGxncm91cF9yZXFfZW5hYmxlZCI7czoxOiIwIjtzOjE2OiJvdmVyYWxsZ3JvdXBfcmVxIjthOjE6e2k6MDtzOjE6IjAiO31zOjMzOiJvdmVyYWxsZ3JvdXBfcmVxX2VuYWJsZWRfZXhjbHVkZWQiO3M6MToiMCI7czoyNToib3ZlcmFsbGdyb3VwX3JlcV9leGNsdWRlZCI7YToxOntpOjA7czoxOiIwIjt9czoyMjoidXNlZF9ncm91cF9taW5fZW5hYmxlZCI7czoxOiIwIjtzOjIxOiJ1c2VkX2dyb3VwX21pbl9hbW91bnQiO3M6MToiMCI7czoxNDoidXNlZF9ncm91cF9taW4iO2E6MTp7aTowO3M6MToiMCI7fXM6MjI6InVzZWRfZ3JvdXBfbWF4X2VuYWJsZWQiO3M6MToiMCI7czoyMToidXNlZF9ncm91cF9tYXhfYW1vdW50IjtzOjE6IjAiO3M6MTQ6InVzZWRfZ3JvdXBfbWF4IjthOjE6e2k6MDtzOjE6IjAiO319', 'YToxOntpOjA7czoxOiIxIjt9'),
(2, 1, 1, 999999, 'Bronz', '<p>Bronz Plan for ProfileType 2.</p>', 'jjfgjfjfj', 'YToyOTp7czo5OiJmdWxsX2ZyZWUiO3M6MToiMSI7czoxMToiZnVsbF9hbW91bnQiO3M6NToiNDkuMDAiO3M6MTE6ImZ1bGxfcGVyaW9kIjtzOjE6IjMiO3M6MTU6ImZ1bGxfcGVyaW9kdW5pdCI7czoxOiJNIjtzOjEwOiJ0cmlhbF9mcmVlIjtzOjE6IjAiO3M6MTI6InRyaWFsX2Ftb3VudCI7czowOiIiO3M6MTI6InRyaWFsX3BlcmlvZCI7czowOiIiO3M6MTY6InRyaWFsX3BlcmlvZHVuaXQiO3M6MToiRCI7czoxMToiZ2lkX2VuYWJsZWQiO3M6MToiMSI7czozOiJnaWQiO3M6MToiMiI7czo4OiJsaWZldGltZSI7czoxOiIwIjtzOjE1OiJzdGFuZGFyZF9wYXJlbnQiO3M6MToiMCI7czo4OiJmYWxsYmFjayI7czoxOiIwIjtzOjE5OiJmYWxsYmFja19yZXFfcGFyZW50IjtzOjE6IjAiO3M6MTE6Im1ha2VfYWN0aXZlIjtzOjE6IjEiO3M6MTI6Im1ha2VfcHJpbWFyeSI7czoxOiIxIjtzOjE1OiJ1cGRhdGVfZXhpc3RpbmciO3M6MToiMSI7czoxMjoiY3VzdG9tdGhhbmtzIjtzOjA6IiI7czozMDoiY3VzdG9tdGV4dF90aGFua3Nfa2VlcG9yaWdpbmFsIjtzOjE6IjEiO3M6MTg6ImN1c3RvbWFtb3VudGZvcm1hdCI7czozNzM6InthZWNqc29ufXsiY21kIjoiY29uZGl0aW9uIiwidmFycyI6W3siY21kIjoiZGF0YSIsInZhcnMiOiJwYXltZW50LmZyZWV0cmlhbCJ9LHsiY21kIjoiY29uY2F0IiwidmFycyI6W3siY21kIjoiY29uc3RhbnQiLCJ2YXJzIjoiX0NPTkZJUk1fRlJFRVRSSUFMIn0sIsKgIix7ImNtZCI6ImRhdGEiLCJ2YXJzIjoicGF5bWVudC5tZXRob2RfbmFtZSJ9XX0seyJjbWQiOiJjb25jYXQiLCJ2YXJzIjpbeyJjbWQiOiJkYXRhIiwidmFycyI6InBheW1lbnQuYW1vdW50In0seyJjbWQiOiJkYXRhIiwidmFycyI6InBheW1lbnQuY3VycmVuY3lfc3ltYm9sIn0sIsKgIix7ImNtZCI6ImRhdGEiLCJ2YXJzIjoicGF5bWVudC5tZXRob2RfbmFtZSJ9XX1dfXsvYWVjanNvbn0iO3M6MTc6ImN1c3RvbXRleHRfdGhhbmtzIjtzOjE0OiI8cD5qaHJocnVqPC9wPiI7czoxOToib3ZlcnJpZGVfYWN0aXZhdGlvbiI7czoxOiIwIjtzOjE2OiJvdmVycmlkZV9yZWdtYWlsIjtzOjE6IjAiO3M6MTY6Im5vdGF1dGhfcmVkaXJlY3QiO3M6MDoiIjtzOjE0OiJmaXhlZF9yZWRpcmVjdCI7czowOiIiO3M6MjI6ImhpZGVfZHVyYXRpb25fY2hlY2tvdXQiO3M6MToiMCI7czoxODoiYWRkdG9jYXJ0X3JlZGlyZWN0IjtzOjA6IiI7czoxMzoiY2FydF9iZWhhdmlvciI7czoxOiIwIjtzOjEwOiJwcm9jZXNzb3JzIjthOjA6e319', 'YToxOntzOjk6ImFkZF9ncm91cCI7czoxOiIwIjt9', 'YTo0MTp7czoxNDoibWluZ2lkX2VuYWJsZWQiO3M6MToiMCI7czoxNDoiZml4Z2lkX2VuYWJsZWQiO3M6MToiMCI7czoxNDoibWF4Z2lkX2VuYWJsZWQiO3M6MToiMCI7czoyNDoicHJldmlvdXNwbGFuX3JlcV9lbmFibGVkIjtzOjE6IjAiO3M6MTY6InByZXZpb3VzcGxhbl9yZXEiO2E6MTp7aTowO3M6MToiMCI7fXM6MjM6ImN1cnJlbnRwbGFuX3JlcV9lbmFibGVkIjtzOjE6IjAiO3M6MTU6ImN1cnJlbnRwbGFuX3JlcSI7YToxOntpOjA7czoxOiIwIjt9czoyMzoib3ZlcmFsbHBsYW5fcmVxX2VuYWJsZWQiO3M6MToiMCI7czoxNToib3ZlcmFsbHBsYW5fcmVxIjthOjE6e2k6MDtzOjE6IjAiO31zOjMzOiJwcmV2aW91c3BsYW5fcmVxX2VuYWJsZWRfZXhjbHVkZWQiO3M6MToiMCI7czoyNToicHJldmlvdXNwbGFuX3JlcV9leGNsdWRlZCI7YToxOntpOjA7czoxOiIwIjt9czozMjoiY3VycmVudHBsYW5fcmVxX2VuYWJsZWRfZXhjbHVkZWQiO3M6MToiMCI7czoyNDoiY3VycmVudHBsYW5fcmVxX2V4Y2x1ZGVkIjthOjE6e2k6MDtzOjE6IjAiO31zOjMyOiJvdmVyYWxscGxhbl9yZXFfZW5hYmxlZF9leGNsdWRlZCI7czoxOiIwIjtzOjI0OiJvdmVyYWxscGxhbl9yZXFfZXhjbHVkZWQiO2E6MTp7aTowO3M6MToiMCI7fXM6MjE6InVzZWRfcGxhbl9taW5fZW5hYmxlZCI7czoxOiIwIjtzOjIwOiJ1c2VkX3BsYW5fbWluX2Ftb3VudCI7czoxOiIwIjtzOjEzOiJ1c2VkX3BsYW5fbWluIjthOjE6e2k6MDtzOjE6IjAiO31zOjIxOiJ1c2VkX3BsYW5fbWF4X2VuYWJsZWQiO3M6MToiMCI7czoyMDoidXNlZF9wbGFuX21heF9hbW91bnQiO3M6MToiMCI7czoxMzoidXNlZF9wbGFuX21heCI7YToxOntpOjA7czoxOiIwIjt9czoyNzoiY3VzdG9tX3Jlc3RyaWN0aW9uc19lbmFibGVkIjtzOjE6IjAiO3M6MTk6ImN1c3RvbV9yZXN0cmljdGlvbnMiO3M6MDoiIjtzOjI1OiJwcmV2aW91c2dyb3VwX3JlcV9lbmFibGVkIjtzOjE6IjAiO3M6MTc6InByZXZpb3VzZ3JvdXBfcmVxIjthOjE6e2k6MDtzOjE6IjAiO31zOjM0OiJwcmV2aW91c2dyb3VwX3JlcV9lbmFibGVkX2V4Y2x1ZGVkIjtzOjE6IjAiO3M6MjY6InByZXZpb3VzZ3JvdXBfcmVxX2V4Y2x1ZGVkIjthOjE6e2k6MDtzOjE6IjAiO31zOjI0OiJjdXJyZW50Z3JvdXBfcmVxX2VuYWJsZWQiO3M6MToiMCI7czoxNjoiY3VycmVudGdyb3VwX3JlcSI7YToxOntpOjA7czoxOiIwIjt9czozMzoiY3VycmVudGdyb3VwX3JlcV9lbmFibGVkX2V4Y2x1ZGVkIjtzOjE6IjAiO3M6MjU6ImN1cnJlbnRncm91cF9yZXFfZXhjbHVkZWQiO2E6MTp7aTowO3M6MToiMCI7fXM6MjQ6Im92ZXJhbGxncm91cF9yZXFfZW5hYmxlZCI7czoxOiIwIjtzOjE2OiJvdmVyYWxsZ3JvdXBfcmVxIjthOjE6e2k6MDtzOjE6IjAiO31zOjMzOiJvdmVyYWxsZ3JvdXBfcmVxX2VuYWJsZWRfZXhjbHVkZWQiO3M6MToiMCI7czoyNToib3ZlcmFsbGdyb3VwX3JlcV9leGNsdWRlZCI7YToxOntpOjA7czoxOiIwIjt9czoyMjoidXNlZF9ncm91cF9taW5fZW5hYmxlZCI7czoxOiIwIjtzOjIxOiJ1c2VkX2dyb3VwX21pbl9hbW91bnQiO3M6MToiMCI7czoxNDoidXNlZF9ncm91cF9taW4iO2E6MTp7aTowO3M6MToiMCI7fXM6MjI6InVzZWRfZ3JvdXBfbWF4X2VuYWJsZWQiO3M6MToiMCI7czoyMToidXNlZF9ncm91cF9tYXhfYW1vdW50IjtzOjE6IjAiO3M6MTQ6InVzZWRfZ3JvdXBfbWF4IjthOjE6e2k6MDtzOjE6IjAiO319', 'YToxOntpOjA7czoxOiIyIjt9');;

TRUNCATE TABLE `#__acctexp_config`;;
INSERT INTO `#__acctexp_config` (`id`, `settings`) VALUES
(1,'YToxMjg6e3M6MjA6InJlcXVpcmVfc3Vic2NyaXB0aW9uIjtpOjA7czoxMToiYWxlcnRsZXZlbDIiO2k6NztzOjExOiJhbGVydGxldmVsMSI7aTozO3M6MTg6ImV4cGlyYXRpb25fY3VzaGlvbiI7aToxMjtzOjE1OiJoZWFydGJlYXRfY3ljbGUiO2k6MjQ7czoyMzoiaGVhcnRiZWF0X2N5Y2xlX2JhY2tlbmQiO2k6MTtzOjExOiJwbGFuc19maXJzdCI7aTowO3M6MTA6InNpbXBsZXVybHMiO2k6MDtzOjIxOiJkaXNwbGF5X2RhdGVfZnJvbnRlbmQiO3M6MDoiIjtzOjIwOiJkaXNwbGF5X2RhdGVfYmFja2VuZCI7czowOiIiO3M6MTQ6ImVuYWJsZV9jb3Vwb25zIjtpOjA7czoxMzoiZGlzcGxheWNjaW5mbyI7aToxO3M6MzE6ImN1c3RvbXRleHRfY29uZmlybV9rZWVwb3JpZ2luYWwiO2k6MTtzOjMyOiJjdXN0b210ZXh0X2NoZWNrb3V0X2tlZXBvcmlnaW5hbCI7aToxO3M6MzQ6ImN1c3RvbXRleHRfbm90YWxsb3dlZF9rZWVwb3JpZ2luYWwiO2k6MTtzOjMxOiJjdXN0b210ZXh0X3BlbmRpbmdfa2VlcG9yaWdpbmFsIjtpOjE7czozMToiY3VzdG9tdGV4dF9leHBpcmVkX2tlZXBvcmlnaW5hbCI7aToxO3M6MTc6ImJ5cGFzc2ludGVncmF0aW9uIjtzOjA6IiI7czoxMToiY3VzdG9taW50cm8iO3M6MDoiIjtzOjEyOiJjdXN0b210aGFua3MiO3M6MDoiIjtzOjEyOiJjdXN0b21jYW5jZWwiO3M6MDoiIjtzOjE2OiJjdXN0b21ub3RhbGxvd2VkIjtzOjA6IiI7czozOiJ0b3MiO3M6MDoiIjtzOjE2OiJjdXN0b210ZXh0X3BsYW5zIjtzOjA6IiI7czoxODoiY3VzdG9tdGV4dF9jb25maXJtIjtzOjA6IiI7czoxOToiY3VzdG9tdGV4dF9jaGVja291dCI7czowOiIiO3M6MjE6ImN1c3RvbXRleHRfbm90YWxsb3dlZCI7czowOiIiO3M6MTg6ImN1c3RvbXRleHRfcGVuZGluZyI7czowOiIiO3M6MTg6ImN1c3RvbXRleHRfZXhwaXJlZCI7czowOiIiO3M6MTE6ImFkbWluYWNjZXNzIjtpOjE7czo4OiJub2VtYWlscyI7aTowO3M6MTc6Im5vam9vbWxhcmVnZW1haWxzIjtpOjA7czo5OiJkZWJ1Z21vZGUiO2k6MDtzOjE1OiJvdmVycmlkZV9yZXFzc2wiO2k6MDtzOjE5OiJpbnZvaWNlbnVtX2RvZm9ybWF0IjtpOjA7czoyMToiaW52b2ljZW51bV9mb3JtYXR0aW5nIjtzOjE3MDoie2FlY2pzb259eyJjbWQiOiJjb25jYXQiLCJ2YXJzIjpbeyJjbWQiOiJkYXRlIiwidmFycyI6WyJZIix7ImNtZCI6InJ3X2NvbnN0YW50IiwidmFycyI6Imludm9pY2VfY3JlYXRlZF9kYXRlIn1dfSwiLSIseyJjbWQiOiJyd19jb25zdGFudCIsInZhcnMiOiJpbnZvaWNlX2lkIn1dfXsvYWVjanNvbn0iO3M6MTM6InVzZV9yZWNhcHRjaGEiO2k6MDtzOjIwOiJyZWNhcHRjaGFfcHJpdmF0ZWtleSI7czowOiIiO3M6MTk6InJlY2FwdGNoYV9wdWJsaWNrZXkiO3M6MDoiIjtzOjEwOiJzc2xfc2lnbnVwIjtpOjA7czoyNDoiZXJyb3Jfbm90aWZpY2F0aW9uX2xldmVsIjtpOjMyO3M6MjQ6ImVtYWlsX25vdGlmaWNhdGlvbl9sZXZlbCI7aToxMjg7czoxMzoidGVtcF9hdXRoX2V4cCI7aToxNTtzOjE3OiJza2lwX2NvbmZpcm1hdGlvbiI7aTowO3M6MTg6InNob3dfZml4ZWRkZWNpc2lvbiI7aTowO3M6MjA6ImNvbmZpcm1hdGlvbl9jb3Vwb25zIjtpOjA7czoxNjoiYnJlYWtvbl9taV9lcnJvciI7aTowO3M6MTI6ImN1cmxfZGVmYXVsdCI7aToxO3M6MjI6ImFtb3VudF9jdXJyZW5jeV9zeW1ib2wiO2k6MDtzOjI3OiJhbW91bnRfY3VycmVuY3lfc3ltYm9sZmlyc3QiO2k6MDtzOjE2OiJhbW91bnRfdXNlX2NvbW1hIjtpOjA7czoxMDoidG9zX2lmcmFtZSI7aTowO3M6OToidXNlX3Byb3h5IjtpOjA7czo1OiJwcm94eSI7czowOiIiO3M6MTA6InByb3h5X3BvcnQiO3M6MDoiIjtzOjExOiJzc2xfcHJvZmlsZSI7aTowO3M6MzA6ImN1c3RvbXRleHRfdGhhbmtzX2tlZXBvcmlnaW5hbCI7aToxO3M6MTc6ImN1c3RvbXRleHRfdGhhbmtzIjtzOjA6IiI7czozMDoiY3VzdG9tdGV4dF9jYW5jZWxfa2VlcG9yaWdpbmFsIjtpOjE7czoxNzoiY3VzdG9tdGV4dF9jYW5jZWwiO3M6MDoiIjtzOjE4OiJyZW5ld19idXR0b25fbmV2ZXIiO2k6MDtzOjMyOiJyZW5ld19idXR0b25fbm9saWZldGltZXJlY3VycmluZyI7aToxO3M6MTU6ImNvbnRpbnVlX2J1dHRvbiI7aToxO3M6MTE6Im92ZXJyaWRlSjE1IjtpOjA7czoyODoiY3VzdG9tdGV4dF9ob2xkX2tlZXBvcmlnaW5hbCI7aToxO3M6MTU6ImN1c3RvbXRleHRfaG9sZCI7czowOiIiO3M6MTQ6InByb3h5X3VzZXJuYW1lIjtzOjA6IiI7czoxNDoicHJveHlfcGFzc3dvcmQiO3M6MDoiIjtzOjEzOiJnZXRob3N0YnlhZGRyIjtpOjE7czoxMDoicm9vdF9ncm91cCI7aToxO3M6MTM6InJvb3RfZ3JvdXBfcnciO3M6MDoiIjtzOjIyOiJpbnRlZ3JhdGVfcmVnaXN0cmF0aW9uIjtpOjE7czoxODoiY3VzdG9taW50cm9fdXNlcmlkIjtpOjA7czoxOToiZW5hYmxlX3Nob3BwaW5nY2FydCI7aTowO3M6Mjc6ImN1c3RvbWxpbmtfY29udGludWVzaG9wcGluZyI7czowOiIiO3M6MTg6ImFkZGl0ZW1fc3RheW9ucGFnZSI7czowOiIiO3M6MTg6ImN1c3RvbWludHJvX2Fsd2F5cyI7aToxO3M6MzM6ImN1c3RvbXRleHRfZXhjZXB0aW9uX2tlZXBvcmlnaW5hbCI7aToxO3M6MjA6ImN1c3RvbXRleHRfZXhjZXB0aW9uIjtzOjA6IiI7czo2OiJnd2xpc3QiO2E6MDp7fXM6Mjk6ImNoZWNrb3V0X2Rpc3BsYXlfZGVzY3JpcHRpb25zIjtpOjA7czo5OiJhbHRzc2x1cmwiO3M6MDoiIjtzOjE2OiJjaGVja291dF9hc19naWZ0IjtpOjA7czoyMzoiY2hlY2tvdXRfYXNfZ2lmdF9hY2Nlc3MiO2k6MjM7czoxNToiaW52b2ljZV9jdXNoaW9uIjtpOjEwO3M6MjQ6ImFsbG93X2Zyb250ZW5kX2hlYXJ0YmVhdCI7aTowO3M6MjU6ImRpc2FibGVfcmVndWxhcl9oZWFydGJlYXQiO2k6MDtzOjI3OiJjdXN0b21faGVhcnRiZWF0X3NlY3VyZWhhc2giO3M6MDoiIjtzOjE1OiJxdWlja3NlYXJjaF90b3AiO2k6MDtzOjE4OiJpbnZvaWNlX3BhZ2VfdGl0bGUiO3M6NzoiSW52b2ljZSI7czoyMToiaW52b2ljZV9iZWZvcmVfaGVhZGVyIjtzOjA6IiI7czoxNDoiaW52b2ljZV9oZWFkZXIiO3M6NzoiSW52b2ljZSI7czoyMDoiaW52b2ljZV9hZnRlcl9oZWFkZXIiO3M6MDoiIjtzOjIyOiJpbnZvaWNlX2JlZm9yZV9jb250ZW50IjtzOjIwOiJJbnZvaWNlL1JlY2VpcHQgZm9yOiI7czoyMToiaW52b2ljZV9hZnRlcl9jb250ZW50IjtzOjQ1OiJUaGFuayB5b3UgdmVyeSBtdWNoIGZvciBjaG9vc2luZyBvdXIgc2VydmljZSEiO3M6MjE6Imludm9pY2VfYmVmb3JlX2Zvb3RlciI7czowOiIiO3M6MTQ6Imludm9pY2VfZm9vdGVyIjtzOjM5OiIgLSBBZGQgeW91ciBjb21wYW55IGluZm9ybWF0aW9uIGhlcmUgLSAiO3M6MTU6Imludm9pY2VfYWRkcmVzcyI7czo2MDoiRW50ZXIgeW91ciBBZGRyZXNzIGhlcmUgLSBpdCB3aWxsIHRoZW4gc2hvdyBvbiB0aGUgcHJpbnRvdXQuIjtzOjI2OiJpbnZvaWNlX2FkZHJlc3NfYWxsb3dfZWRpdCI7aToxO3M6MjA6Imludm9pY2VfYWZ0ZXJfZm9vdGVyIjtzOjA6IiI7czoxMzoiZGVsZXRlX3RhYmxlcyI7czowOiIiO3M6MTg6ImRlbGV0ZV90YWJsZXNfc3VyZSI7czowOiIiO3M6MTc6InN0YW5kYXJkX2N1cnJlbmN5IjtzOjM6IlVTRCI7czoyNzoiY29uZmlybWF0aW9uX2NoYW5nZXVzZXJuYW1lIjtpOjE7czoyNDoiY29uZmlybWF0aW9uX2NoYW5nZXVzYWdlIjtpOjE7czoxMzoibWFuYWdlcmFjY2VzcyI7aTowO3M6MTI6InBlcl9wbGFuX21pcyI7aTowO3M6MTM6ImludHJvX2V4cGlyZWQiO2k6MDtzOjI2OiJjdXN0b21fY29uZmlybV91c2VyZGV0YWlscyI7czowOiIiO3M6MjA6ImVtYWlsX2RlZmF1bHRfYWRtaW5zIjtpOjE7czoxODoiZW1haWxfZXh0cmFfYWRtaW5zIjtzOjA6IiI7czoxOToiY291bnRyaWVzX2F2YWlsYWJsZSI7czowOiIiO3M6MTM6ImNvdW50cmllc190b3AiO3M6MDoiIjtzOjI1OiJjaGVja291dGZvcm1fanN2YWxpZGF0aW9uIjtpOjA7czozMDoiYWxsb3dfaW52b2ljZV91bnB1Ymxpc2hlZF9pdGVtIjtpOjA7czoxNDoiaXRlbWlkX2RlZmF1bHQiO3M6MDoiIjtzOjExOiJpdGVtaWRfY2FydCI7czowOiIiO3M6MTU6Iml0ZW1pZF9jaGVja291dCI7czowOiIiO3M6MTk6Iml0ZW1pZF9jb25maXJtYXRpb24iO3M6MDoiIjtzOjE2OiJpdGVtaWRfc3Vic2NyaWJlIjtzOjA6IiI7czoxNjoiaXRlbWlkX2V4Y2VwdGlvbiI7czowOiIiO3M6MTM6Iml0ZW1pZF90aGFua3MiO3M6MDoiIjtzOjE0OiJpdGVtaWRfZXhwaXJlZCI7czowOiIiO3M6MTE6Iml0ZW1pZF9ob2xkIjtzOjA6IiI7czoxNzoiaXRlbWlkX25vdGFsbG93ZWQiO3M6MDoiIjtzOjE0OiJpdGVtaWRfcGVuZGluZyI7czowOiIiO3M6MjY6Iml0ZW1pZF9zdWJzY3JpcHRpb25kZXRhaWxzIjtzOjA6IiI7czoyNDoic3Vic2NyaXB0aW9uZGV0YWlsc19tZW51IjtpOjE7fQ==');;
