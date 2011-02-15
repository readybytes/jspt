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
(10003, 1),
(10003, 2),
(10003, 3),
(10003, 4),
(10003, 5),
(10007, 1),
(10007, 2),
(10007, 3),
(10007, 4),
(10007, 5);;
