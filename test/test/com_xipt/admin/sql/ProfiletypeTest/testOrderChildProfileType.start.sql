TRUNCATE TABLE `#__xipt_profiletypes`;;
DROP TABLE IF EXISTS `au_#__xipt_profiletypes`;;
CREATE TABLE `au_#__xipt_profiletypes` SELECT * FROM `#__xipt_profiletypes`;;

INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `parent`) VALUES
(1, 'PROFILETYPE-1', 1, 1, 0),
(2, 'PROFILETYPE-2', 8, 1, 0),
(3, 'PROFILETYPE-3', 9, 1, 0),
(4, 'PROFILETYPE-4', 10, 0,  0),
(5, 'PROFILETYPE-5-CHILD-of-1', 2, 1,  1),
(6, 'PROFILETYPE-6-CHILD-of-4', 11, 1,  4),
(7, 'PROFILETYPE-7-CHILD-of-5', 3, 1,  5),
(8, 'PROFILETYPE-8-CHILD-of-NONE', 12, 1,  0),
(9, 'PROFILETYPE-9-CHILD-of-5', 4, 1,  5),
(10, 'PROFILETYPE-10-CHILD-of-1', 5, 1,  1),
(11, 'PROFILETYPE-11-CHILD-of-10', 6, 1,  10),
(12, 'PROFILETYPE-12-CHILD-of-10', 7, 1,  10);;

INSERT INTO `au_#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `parent`) VALUES
(1, 'PROFILETYPE-1', 2, 1,  0),
(2, 'PROFILETYPE-2', 1, 1,  0),
(3, 'PROFILETYPE-3', 11, 1,  0),
(4, 'PROFILETYPE-4', 9, 0,  0),
(5, 'PROFILETYPE-5-CHILD-of-1', 3, 1,  1),
(6, 'PROFILETYPE-6-CHILD-of-4', 10, 1,  4),
(7, 'PROFILETYPE-7-CHILD-of-5', 5, 1,  5),
(8, 'PROFILETYPE-8-CHILD-of-NONE', 12, 1,  0),
(9, 'PROFILETYPE-9-CHILD-of-5', 4, 1,  5),
(10, 'PROFILETYPE-10-CHILD-of-1', 6, 0,  1),
(11, 'PROFILETYPE-11-CHILD-of-10', 7, 1,  10),
(12, 'PROFILETYPE-12-CHILD-of-10', 8, 0,  10);;


