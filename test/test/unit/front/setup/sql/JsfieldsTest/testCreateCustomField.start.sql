
TRUNCATE TABLE `#__community_fields`;;

INSERT INTO `#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`) VALUES
(1, 'group', 0, 1, 0, 0, 'Basic Information', 'Basicr', 0, 0, 1, 1, NULL, ''),
(2, 'text', 0, 1, 0, 0, 'Hometown2', 'Hometown2', 0, 0, 1, 1, NULL, 'FIELD_HOMETOWN2');;

DROP TABLE IF EXISTS `au_#__community_fields`;;

CREATE TABLE IF NOT EXISTS `au_#__community_fields` (
  `id` int(10) NOT NULL DEFAULT '0',
  `type` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ordering` int(11) DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `min` int(5) NOT NULL,
  `max` int(5) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `tips` text CHARACTER SET utf8 NOT NULL,
  `visible` tinyint(1) DEFAULT '0',
  `required` tinyint(1) DEFAULT '0',
  `searchable` tinyint(1) DEFAULT '1',
  `registration` tinyint(1) DEFAULT '1',
  `options` text CHARACTER SET utf8,
  `fieldcode` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;


INSERT INTO `au_#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`) VALUES
(1, 'group', 0, 1, 0, 0, 'Basic Information', 'Basicr', 0, 0, 1, 1, NULL, ''),
(2, 'text', 0, 1, 0, 0, 'Hometown2', 'Hometown2', 0, 0, 1, 1, NULL, 'FIELD_HOMETOWN2'),
(3, 'profiletypes', 0, 1, 10, 100, 'Profiletype', 'Profiletype Of User', 1, 1, 1, 1, '', 'XIPT_PROFILETYPE'),
(4, 'templates', 0, 1, 10, 100, 'Template', 'Template Of User', 1, 1, 1, 1, '', 'XIPT_TEMPLATE');;