DROP TABLE IF EXISTS `bk_#__xipt_profiletypes`;;

CREATE TABLE IF NOT EXISTS `bk_#__xipt_profiletypes`
		SELECT * FROM `#__xipt_profiletypes`;;
TRUNCATE TABLE `#__xipt_profiletypes`;;

INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`, `config`) VALUES
(1, 'PROFILETYPE-1', 2, 1, 'PROFILETYPE-ONE-TIP', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, '0', '', '', '', 1, ''),
(2, 'PROFILETYPE-2', 1, 1, 'PROFILETYPE-TWO-TIP', 'friends', 'blueface', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, '0', '', '', '', 1, '');;


DROP TABLE IF EXISTS `bk_#__users`;;

CREATE TABLE IF NOT EXISTS `bk_#__users`
		SELECT * FROM `#__users`;;
TRUNCATE TABLE `#__users`;;

INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(80, 'regtest6208627', 'regtest6208627', 'regtest6208627@gmail.com', 'c33a3ac03bfbc13368383edc0e6ae42d:bUwtJXMI49daOhAPzdaLBdRY1IOOgm0D', 'Registered', 0, 0, '2009-12-03 08:16:44', '0000-00-00 00:00:00', 'a25e8cbbf5a534e0d5b934589be66756', '{"update_cache_list":1}'),
(81, 'regtest6208628', 'regtest6208628', 'regtest6208628@gmail.com', '78c3901d9d2c31108f9f758a18ee7f89:UIbbRXlJUORtEqogoLPr9ZP0bouM0lLT', 'Registered', 0, 0, '2009-12-03 08:17:09', '0000-00-00 00:00:00', '77981cae5948a5be5e553db5dcb8d00f', '\n'),
(82, 'regtest6208629', 'regtest6208629', 'regtest6208629@gmail.com', '73e7830c01e705a5adeaaa3e278fbdec:uQb0sUh0KdTyybJuHnYHAtpOmtfVNxr2', 'Registered', 0, 0, '2009-12-03 08:16:18', '0000-00-00 00:00:00', '0e24ede794209ad6de9624f89077daed', '\n');;
DROP TABLE IF EXISTS `bk_#__xipt_users`;;

CREATE TABLE IF NOT EXISTS `bk_#__xipt_users`
		SELECT * FROM `#__xipt_users`;;
TRUNCATE TABLE `#__xipt_users`;;
INSERT INTO `#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(80, 1, 'default'),
(81, 1, 'default'),
(82, 1, 'default');;
