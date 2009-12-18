TRUNCATE TABLE `#__xipt_profiletypes`;
INSERT INTO `#__xipt_profiletypes`  (`id`,`name`)  VALUES (1,'PROFILETYPE-1');
INSERT INTO `#__xipt_profiletypes`  (`id`,`name`)  VALUES (2,'PROFILETYPE-2');
INSERT INTO `#__xipt_profiletypes`  (`id`,`name`)  VALUES (3,'PROFILETYPE-3');
INSERT INTO `#__xipt_profiletypes`  (`id`,`name`)  VALUES (4,'PROFILETYPE-4');
INSERT INTO `#__xipt_profiletypes`  (`id`,`name`)  VALUES (5,'PROFILETYPE-5');


TRUNCATE TABLE `#__xipt_applications`;
DROP TABLE IF EXISTS `au_#__xipt_applications`;
CREATE TABLE `au_#__xipt_applications` SELECT * FROM `#__xipt_applications`;

INSERT INTO `au_#__xipt_applications` (`applicationid`, `profiletype`) VALUES
(38, 2),
(38, 3),
(38, 4),
(38, 5),
(39, 1),
(39, 3),
(39, 4),
(39, 5),
(40, 3),
(40, 4),
(40, 5)
;
