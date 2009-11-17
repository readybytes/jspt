TRUNCATE TABLE `#__xipt_profiletypes`;
DROP TABLE IF EXISTS `au_#__xipt_profiletypes`;

CREATE TABLE `au_#__xipt_profiletypes` SELECT * FROM `#__xipt_profiletypes`;

INSERT INTO `#__xipt_profiletypes`  (`name`, `tip`)  VALUES ('PROFILETYPE-1','PROFILETYPE-ONE-TIP');
INSERT INTO `#__xipt_profiletypes`  (`name`, `tip`)  VALUES ('PROFILETYPE-2','PROFILETYPE-ONE-TIP');
INSERT INTO `#__xipt_profiletypes`  (`name`, `tip`)  VALUES ('PROFILETYPE-3','PROFILETYPE-ONE-TIP');
INSERT INTO `#__xipt_profiletypes`  (`name`, `tip`)  VALUES ('PROFILETYPE-4','PROFILETYPE-ONE-TIP');
INSERT INTO `#__xipt_profiletypes`  (`name`, `tip`)  VALUES ('PROFILETYPE-5','PROFILETYPE-ONE-TIP');

INSERT INTO `au_#__xipt_profiletypes`  (`name`, `tip`)  VALUES ('PROFILETYPE-2','PROFILETYPE-ONE-TIP');
INSERT INTO `au_#__xipt_profiletypes`  (`name`, `tip`)  VALUES ('PROFILETYPE-4','PROFILETYPE-ONE-TIP');
