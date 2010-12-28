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
(82);;

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

TRUNCATE TABLE `#__xipt_profiletypes` ;;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`) VALUES
(1, 'PROFILETYPE-1', 2, 1),
(2, 'PROFILETYPE-2', 1, 1),
(3, 'PROFILETYPE-3', 3, 1);;

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
INSERT INTO `#__xipt_aclrules` (`id`, `rulename`, `aclname`, `coreparams`, `published`) VALUES
(1, 'RULE-AccessPhoto', 'accessphoto', 'core_profiletype=2\ncore_display_message=NotAllowed\ncore_redirect_url=index.php\n\n', 1)
;;


TRUNCATE TABLE `#__community_photos_albums`;;
INSERT INTO `#__community_photos_albums` 
(`id`, `photoid`, `creator`, `name`, `description`, `permissions`, `created`, `path`, `type`) VALUES
(1, 0, 80, 'a', 'a', '', '2010-10-17 10:22:01', 'images/photos/62/', 'user'),
(2, 0, 83, 'a', 'a', '', '2010-10-17 10:22:01', 'images/photos/62/', 'user'),
(3, 0, 86, 'a', 'a', '', '2010-10-17 10:22:01', 'images/photos/62/', 'user')
;;

TRUNCATE TABLE `#__community_photos` ;;
INSERT INTO `#__community_photos` (`id`, `albumid`, `caption`, `published`, `creator`, `permissions`, `image`, `thumbnail`, `original`, `created`, `filesize`, `storage`, `ordering`) VALUES
(1, 1, 'IMG_1287', 1, 80, '', 'images/photos/62/7/df4fb2a38b6e2eeffdb5093b.jpg', 'images/photos/62/7/thumb_df4fb2a38b6e2eeffdb5093b.jpg', 'images/originalphotos/62/7/df4fb2a38b6e2eeffdb5093b.jpg', '2010-10-17 10:29:19', 4096, 'file', 0),

(2, 2, 'IMG_1287', 1, 83, '', 'images/photos/62/7/df4fb2a38b6e2eeffdb5093b.jpg', 'images/photos/62/7/thumb_df4fb2a38b6e2eeffdb5093b.jpg', 'images/originalphotos/62/7/df4fb2a38b6e2eeffdb5093b.jpg', '2010-10-17 10:29:19', 4096, 'file', 0),
(3, 2, 'IMG_1287', 1, 83, '', 'images/photos/62/7/df4fb2a38b6e2eeffdb5093b.jpg', 'images/photos/62/7/thumb_df4fb2a38b6e2eeffdb5093b.jpg', 'images/originalphotos/62/7/df4fb2a38b6e2eeffdb5093b.jpg', '2010-10-17 10:29:19', 4096, 'file', 0),

(4, 3, 'IMG_1287', 1, 86, '', 'images/photos/62/7/df4fb2a38b6e2eeffdb5093b.jpg', 'images/photos/62/7/thumb_df4fb2a38b6e2eeffdb5093b.jpg', 'images/originalphotos/62/7/df4fb2a38b6e2eeffdb5093b.jpg', '2010-10-17 10:29:19', 4096, 'file', 0),
(5, 3, 'IMG_1287', 1, 86, '', 'images/photos/62/7/df4fb2a38b6e2eeffdb5093b.jpg', 'images/photos/62/7/thumb_df4fb2a38b6e2eeffdb5093b.jpg', 'images/originalphotos/62/7/df4fb2a38b6e2eeffdb5093b.jpg', '2010-10-17 10:29:19', 4096, 'file', 0),
(6, 3, 'IMG_1287', 1, 86, '', 'images/photos/62/7/df4fb2a38b6e2eeffdb5093b.jpg', 'images/photos/62/7/thumb_df4fb2a38b6e2eeffdb5093b.jpg', 'images/originalphotos/62/7/df4fb2a38b6e2eeffdb5093b.jpg', '2010-10-17 10:29:19', 4096, 'file', 0)
;;

