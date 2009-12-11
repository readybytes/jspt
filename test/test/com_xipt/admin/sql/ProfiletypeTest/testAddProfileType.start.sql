TRUNCATE TABLE `#__xipt_profiletypes`;
DROP TABLE IF EXISTS `au_#__xipt_profiletypes`;
CREATE TABLE `au_#__xipt_profiletypes` SELECT * FROM `#__xipt_profiletypes`;
INSERT INTO `au_#__xipt_profiletypes`  (`name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`)  VALUES ('PROFILETYPE-ONE', NULL, '1', '', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '0');
