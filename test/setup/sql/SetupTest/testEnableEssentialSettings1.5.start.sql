UPDATE `#__plugins` SET `published` = '0' WHERE `element` ='xipt_system' LIMIT 1 ;;
UPDATE `#__plugins` SET `published` = '0' WHERE `element` ='xipt_community' LIMIT 1 ;;

TRUNCATE TABLE `#__community_fields`;;

INSERT INTO `#__community_fields` 
(`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`) VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basicr', 1, 1, 1, 1, '', ''),
(2, 'text', 2, 1, 5, 250, 'Hometown2', 'Hometown2', 1, 1, 1, 1, '', 'FIELD_HOMETOWN2');;

DROP TABLE IF EXISTS `au_#__community_fields`;; /*Create fields*/
CREATE TABLE `au_#__community_fields` SELECT * FROM  `#__community_fields`  ;;

INSERT INTO `au_#__community_fields` 
(`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`) VALUES
(3, 'templates', 10, 1, 10, 100, 'Template', 'Template Of User', 1, 1, 1, 1, '', 'XIPT_TEMPLATE'),
(4, 'profiletypes', 11, 1, 10, 100, 'Profiletype', 'Profiletype Of User', 1, 1, 1, 1, '', 'XIPT_PROFILETYPE');;
