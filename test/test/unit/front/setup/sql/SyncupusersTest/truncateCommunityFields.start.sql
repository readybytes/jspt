
TRUNCATE TABLE `#__community_fields`;;

INSERT INTO `#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`) VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basicr', 1, 1, 1, 1, '', ''),
(2, 'text', 4, 1, 5, 250, 'Hometown2', 'Hometown2', 1, 1, 1, 1, '', 'FIELD_HOMETOWN2');;