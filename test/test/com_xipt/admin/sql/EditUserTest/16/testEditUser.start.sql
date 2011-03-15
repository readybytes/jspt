TRUNCATE TABLE `#__users`;;
INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`,  `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES(62, 'Super User', 'admin', 'shyam@readybytes.in', '35ff015820e855e542547b46ecd2fb54:g2sehkMwUHKLlDleBYGhBEcmKA559DQW', 'deprecated', 0, 1, '2011-03-02 07:11:44', '2011-03-02 08:04:31', '', ''),
(82, 'regtest8774090', 'regtest8774090', 'regtest8774090@gmail.com', 'f478ff7ef92fcb7a7cb62d4c1f08e43a:7rptUeQifMIkdyqE59fnxb0o74NE4sk8', 'Registered', 0, 0,  '2009-12-03 08:16:35', '0000-00-00 00:00:00', 'a3a9fc5ff08868ee458cda29142e6e36', '\n'),
(83, 'regtest1789672', 'regtest1789672', 'regtest1789672@gmail.com', 'c33a3ac03bfbc13368383edc0e6ae42d:bUwtJXMI49daOhAPzdaLBdRY1IOOgm0D', 'Editor', 0, 0,  '2009-12-03 08:16:44', '0000-00-00 00:00:00', 'a25e8cbbf5a534e0d5b934589be66756', '\n'),
(84, 'regtest6461827', 'regtest6461827', 'regtest6461827@gmail.com', '56f606098f0631341e8c398eaae179c6:aOJ5ghvQqtSCPnIH8SwFw90001MNaRI6', 'Publisher', 0, 0,  '2009-12-03 08:16:52', '0000-00-00 00:00:00', 'd8e2cc8000b17d6791a451354a281937', '\n'),
(85, 'regtest3843261', 'regtest3843261', 'regtest3843261@gmail.com', '0f2e8c8f8433fd1604880e9ac0d33fc1:d4b8PHWIkuHEI4AfHM1XWkFh4sR4t1gj', 'Registered', 0, 0,  '2009-12-03 08:17:00', '0000-00-00 00:00:00', '0e11cd0ed924846a11c84e3618f2c5eb', '\n'),
(86, 'regtest1504555', 'regtest1504555', 'regtest1504555@gmail.com', '78c3901d9d2c31108f9f758a18ee7f89:UIbbRXlJUORtEqogoLPr9ZP0bouM0lLT', 'Editor', 0, 0,  '2009-12-03 08:17:09', '0000-00-00 00:00:00', '77981cae5948a5be5e553db5dcb8d00f', '\n'),
(87, 'regtest1674526', 'regtest1674526', 'regtest1674526@gmail.com', '948b72e649363975c49ba818d6880843:PezoDwP9dbIXQETtPbG0IfkpE0jogLi2', 'Publisher', 0, 0,  '2009-12-03 08:17:17', '0000-00-00 00:00:00', '51bcf29e8ec7bbaf00dc2160257b8987', '\n'),
(79, 'regtest7046025', 'regtest7046025', 'regtest7046025@gmail.com', '64d5a5a65e0433fefad4d52255857f59:rBhZVyCqDIKioTNuCNBkpQNhRXsCHb1t', 'Registered', 0, 0,  '2009-12-03 08:16:09', '0000-00-00 00:00:00', 'd45373ce0b2c4bfa6065235a5c353add', '\n'),
(80, 'regtest6208627', 'regtest6208627', 'regtest6208627@gmail.com', '73e7830c01e705a5adeaaa3e278fbdec:uQb0sUh0KdTyybJuHnYHAtpOmtfVNxr2', 'Editor', 0, 0,  '2009-12-03 08:16:18', '0000-00-00 00:00:00', '0e24ede794209ad6de9624f89077daed', '\n'),
(81, 'regtest8635954', 'regtest8635954', 'regtest8635954@gmail.com', '7dc28bb5bc0119a23ac236b82837586e:vBNJaILgct7EzdE4wmJANFeLuVSTLHdh', 'Publisher', 0, 0,  '2009-12-03 08:16:26', '0000-00-00 00:00:00', '1ebc22393cc2619be62d28fe7c960e5a', '\n');;

TRUNCATE TABLE `#__community_fields` ;;
INSERT INTO `#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`, `params`) VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basicr', 1, 1, 1, 1, '', '',''),
(2, 'text', 2, 1, 5, 250, 'Hometown2', 'Hometown2', 1, 1, 1, 1, '', 'FIELD_HOMETOWN2',''),
(3, 'text', 3, 1, 5, 250, 'Hometown3', 'Hometown3', 1, 0, 1, 1, '', 'FIELD_HOMETOWN3',''),
(4, 'text', 4, 1, 5, 250, 'Hometown4', 'Hometown4', 1, 0, 1, 1, '', 'FIELD_HOMETOWN4',''),
(5, 'text', 5, 1, 5, 250, 'Hometown5', 'Hometown5', 1, 0, 1, 1, '', 'FIELD_HOMETOWN5',''),
(6, 'text', 6, 1, 5, 250, 'Hometown6', 'Hometown6', 0, 0, 1, 1, '', 'FIELD_HOMETOWN6',''),
(7, 'text', 7, 1, 5, 250, 'Hometown7', 'Hometown7', 1, 0, 1, 0, '', 'FIELD_HOMETOWN7',''),
(8, 'text', 8, 1, 5, 250, 'Hometown8', 'Hometown8', 1, 0, 1, 1, '', 'FIELD_HOMETOWN8',''),
(9, 'text', 9, 1, 5, 250, 'Hometown9', 'Hometown9', 1, 0, 0, 1, '', 'FIELD_HOMETOWN9',''),
(16, 'templates', 10, 1, 10, 100, 'Template', 'Template Of User', 1, 1, 1, 1, '', 'XIPT_TEMPLATE',''),
(17, 'profiletypes', 11, 1, 10, 100, 'Profiletype', 'Profiletype Of User', 1, 1, 1, 1, '', 'XIPT_PROFILETYPE','');;
