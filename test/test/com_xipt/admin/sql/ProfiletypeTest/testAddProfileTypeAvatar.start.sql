TRUNCATE TABLE `#__xipt_profiletypes`;

DROP TABLE IF EXISTS `au_#__xipt_profiletypes`;
CREATE TABLE `au_#__xipt_profiletypes` SELECT * FROM `#__xipt_profiletypes`;

ALTER TABLE `#__xipt_profiletypes` AUTO_INCREMENT = 1;
INSERT INTO `au_#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`) VALUES
(1, 'PROFILETYPE-1', 1, 1, '', 'friends', 'default', 'Registered', 'images/profiletype/avatar_1.gif', 0, 0, 0, 'images/profiletype/watermark_1.png', ''),
(2, 'PROFILETYPE-2', 2, 1, '', 'friends', 'default', 'Registered', 'images/profiletype/avatar_2.png', 0, 0, 0, 'images/profiletype/watermark_2.gif', ''),
(3, 'PROFILETYPE-3', 3, 1, '', 'friends', 'default', 'Registered', 'images/profiletype/avatar_3.png', 0, 0, 0, 'images/profiletype/watermark_3.jpg', '');

