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
(44, 2),
(44, 3),
(44, 4),
(44, 5),
(45, 1),
(45, 3),
(45, 4),
(45, 5),
(46, 3),
(46, 4),
(46, 5),
(49, 2),
(49, 3),
(49, 4),
(49, 5),
(50, 1),
(50, 3),
(50, 4),
(50, 5);;
