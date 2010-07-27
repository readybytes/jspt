TRUNCATE TABLE `#__session`;; /* Clean session */

TRUNCATE TABLE `#__xipt_profiletypes`;;
DROP TABLE IF EXISTS `au_#__xipt_profiletypes`;;
INSERT INTO `#__xipt_profiletypes`  (`name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`)  
VALUES ('PROFILETYPE-1', 2, '1', 'PROFILETYPE-ONE-TIP', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '0');;
INSERT INTO `#__xipt_profiletypes`  (`name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`)  
VALUES ('PROFILETYPE-2', 1, '1', 'PROFILETYPE-TWO-TIP', 'friends', 'blueface', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '0');;
INSERT INTO `#__xipt_profiletypes`  (`name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`)  
VALUES ('PROFILETYPE-3', 3, '1', 'PROFILETYPE-THREE-TIP', 'members', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '0');;
INSERT INTO `#__xipt_profiletypes`  (`name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`)  
VALUES ('PROFILETYPE-4', 4, '0', 'PROFILETYPE-THREE-TIP', 'members', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '0');;