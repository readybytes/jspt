TRUNCATE TABLE `#__xipt_profiletypes`;;
INSERT INTO `#__xipt_profiletypes`  (`id`,`name`)  VALUES (1,'PROFILETYPE-1');;
INSERT INTO `#__xipt_profiletypes`  (`id`,`name`)  VALUES (2,'PROFILETYPE-2');;
INSERT INTO `#__xipt_profiletypes`  (`id`,`name`)  VALUES (3,'PROFILETYPE-3');;
INSERT INTO `#__xipt_profiletypes`  (`id`,`name`)  VALUES (4,'PROFILETYPE-4');;
INSERT INTO `#__xipt_profiletypes`  (`id`,`name`)  VALUES (5,'PROFILETYPE-5');;


TRUNCATE TABLE `#__xipt_applications`;;
DROP TABLE IF EXISTS `au_#__xipt_applications`;;
CREATE TABLE `au_#__xipt_applications` SELECT * FROM `#__xipt_applications`;;

INSERT INTO `au_#__xipt_applications` (`applicationid`, `profiletype`) VALUES
(42, 2),
(42, 3),
(42, 4),
(42, 5),
(43, 1),
(43, 3),
(43, 4),
(43, 5),
(44, 3),
(44, 4),
(44, 5),
(47, 2),
(47, 3),
(47, 4),
(47, 5),
(48, 1),
(48, 3),
(48, 4),
(48, 5);;
