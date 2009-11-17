TRUNCATE TABLE `#__xipt_profiletypes`;
DROP TABLE IF EXISTS `au_#__xipt_profiletypes`;

CREATE TABLE `au_#__xipt_profiletypes` SELECT * FROM `#__xipt_profiletypes`;

INSERT INTO `#__xipt_profiletypes`  (`name`, `ordering`, `published`, `tip` )  VALUES ('PROFILETYPE-1', 1, '1', 'PROFILETYPE-ONE-TIP');
INSERT INTO `#__xipt_profiletypes`  (`name`, `ordering`, `published`, `tip` )  VALUES ('PROFILETYPE-2', 2, '0', 'PROFILETYPE-ONE-TIP');
INSERT INTO `#__xipt_profiletypes`  (`name`, `ordering`, `published`, `tip` )  VALUES ('PROFILETYPE-3', 3, '1', 'PROFILETYPE-ONE-TIP');
INSERT INTO `#__xipt_profiletypes`  (`name`, `ordering`, `published`, `tip` )  VALUES ('PROFILETYPE-4', 4, '0', 'PROFILETYPE-ONE-TIP');

INSERT INTO `au_#__xipt_profiletypes`  (`name`, `ordering`, `published`, `tip` )  VALUES ('PROFILETYPE-1', 1, '0', 'PROFILETYPE-ONE-TIP');
INSERT INTO `au_#__xipt_profiletypes`  (`name`, `ordering`, `published`, `tip` )  VALUES ('PROFILETYPE-2', 2, '1', 'PROFILETYPE-ONE-TIP');
INSERT INTO `au_#__xipt_profiletypes`  (`name`, `ordering`, `published`, `tip` )  VALUES ('PROFILETYPE-3', 3, '0', 'PROFILETYPE-ONE-TIP');
INSERT INTO `au_#__xipt_profiletypes`  (`name`, `ordering`, `published`, `tip` )  VALUES ('PROFILETYPE-4', 4, '1', 'PROFILETYPE-ONE-TIP');