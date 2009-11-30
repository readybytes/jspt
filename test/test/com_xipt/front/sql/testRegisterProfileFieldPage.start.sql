TRUNCATE TABLE `#__session`; /* Clean session */

TRUNCATE TABLE `#__xipt_profiletypes`; /* Create various types */
INSERT INTO `#__xipt_profiletypes`  (`id`,`name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`)   VALUES 
(1,'PROFILETYPE-1', 2, '1', 'PROFILETYPE-ONE-TIP', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '0'),
(2, 'PROFILETYPE-2', 1, '1', 'PROFILETYPE-TWO-TIP', 'friends', 'blueface', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '0'),
(3, 'PROFILETYPE-3', 3, '1', 'PROFILETYPE-THREE-TIP', 'members', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '0'),
(4, 'PROFILETYPE-4', 4, '0', 'PROFILETYPE-THREE-TIP', 'members', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', '0', '0', '0');

DROP TABLE IF EXISTS `#__community_fields`; /*Create fields*/

CREATE TABLE IF NOT EXISTS `#__community_fields` (
  `id` int(10) NOT NULL auto_increment,
  `type` varchar(255) NOT NULL,
  `ordering` int(11) default '0',
  `published` tinyint(1) NOT NULL default '0',
  `min` int(5) NOT NULL,
  `max` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tips` text NOT NULL,
  `visible` tinyint(1) default '0',
  `required` tinyint(1) default '0',
  `searchable` tinyint(1) default '1',
  `registration` tinyint(1) default '1',
  `options` text,
  `fieldcode` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fieldcode` (`fieldcode`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__community_fields`
--

INSERT INTO `#__community_fields` 
(`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`) VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basicr', 1, 1, 1, 1, '', ''),
(2, 'text', 2, 1, 5, 250, 'Hometown2', 'Hometown2', 1, 1, 1, 1, '', 'FIELD_HOMETOWN2'),
(3, 'text', 3, 1, 5, 250, 'Hometown3', 'Hometown3', 1, 0, 1, 1, '', 'FIELD_HOMETOWN3'),
(4, 'text', 4, 1, 5, 250, 'Hometown4', 'Hometown4', 1, 0, 1, 1, '', 'FIELD_HOMETOWN4'),
(5, 'text', 5, 1, 5, 250, 'Hometown5', 'Hometown5', 1, 0, 1, 1, '', 'FIELD_HOMETOWN5'),
(6, 'text', 6, 1, 5, 250, 'Hometown6', 'Hometown6', 0, 0, 1, 1, '', 'FIELD_HOMETOWN6'),
(7, 'text', 7, 1, 5, 250, 'Hometown7', 'Hometown7', 1, 0, 1, 0, '', 'FIELD_HOMETOWN7'),
(8, 'text', 8, 1, 5, 250, 'Hometown8', 'Hometown8', 1, 0, 1, 1, '', 'FIELD_HOMETOWN8'),
(9, 'text', 9, 1, 5, 250, 'Hometown9', 'Hometown9', 1, 0, 0, 1, '', 'FIELD_HOMETOWN9'),
(16, 'templates', 10, 1, 10, 100, 'Template', 'Template Of User', 1, 1, 1, 1, '', 'XIPT_TEMPLATE'),
(17, 'profiletypes', 11, 1, 10, 100, 'Profiletype', 'Profiletype Of User', 1, 1, 1, 1, '', 'XIPT_PROFILETYPE');


/*store profiletype v/s fields */
TRUNCATE TABLE `#__xipt_profilefields`;

INSERT INTO `#__xipt_profilefields` 
(`fid`, `pid`) VALUES
(2, 1),(2, 3),(2, 4), 	/*field 2 is for pt2*/
(3, 2),(3, 3),(3, 4), 	/*field 3 is for pt1*/
(4, 3),(4, 4), 			/*field 4 is for pt1,2*/
						/*5 is for all*/
(6, 1),(6, 3),(6, 4), 	/*field 6 is for pt2*/
(7, 2),(7, 3),(7, 4), 	/*field 7 is for pt1*/
(8, 3),(8, 4);			/*field 8 is for pt1,2*/
/*9 is for all*/
