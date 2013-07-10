
TRUNCATE TABLE `#__community_fields`;;
DROP TABLE IF EXISTS `au_#__community_fields`;;
CREATE TABLE IF NOT EXISTS `au_#__community_fields`
	SELECT * FROM `#__community_fields`;;

INSERT INTO `#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`) VALUES
(1, 'group', 0, 1, 0, 0, 'Basic Information', 'Basicr', 0, 0, 1, 1, NULL, ''),
(2, 'text', 0, 1, 0, 0, 'Hometown2', 'Hometown2', 0, 0, 1, 1, NULL, 'FIELD_HOMETOWN2');;

INSERT INTO `au_#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`) VALUES
(1, 'group', 0, 1, 0, 0, 'Basic Information', 'Basicr', 0, 0, 1, 1, NULL, ''),
(2, 'text', 0, 1, 0, 0, 'Hometown2', 'Hometown2', 0, 0, 1, 1, NULL, 'FIELD_HOMETOWN2'),
(3, 'profiletypes', 0, 1, 10, 100, 'Profiletype', 'Profiletype Of User', 1, 1, 1, 1, '', 'XIPT_PROFILETYPE'),
(4, 'templates', 0, 1, 10, 100, 'Template', 'Template Of User', 1, 1, 1, 1, '', 'XIPT_TEMPLATE');;
