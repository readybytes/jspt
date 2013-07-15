DROP TABLE IF EXISTS `#__xipt_polls`;;
CREATE TABLE IF NOT EXISTS `#__xipt_polls` (
  `polls_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `voters` int(9) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`polls_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;;

TRUNCATE TABLE `#__xipt_polls`;;
INSERT INTO `#__xipt_polls` (`polls_id`, `title`, `alias`, `voters`, `checked_out`, `checked_out_time`, `published`) VALUES
(1, 'poll-1', 'joomla-is-used', 11, 0, '0000-00-00 00:00:00', 1),
(2, 'poll-2', 'joomla-is-used-for', 5, 1, '0000-00-00 00:00:00', 1),
(3, 'poll-3', 'joomla-is-used-for', 9, 0, '0000-00-00 00:00:00', 1),
(4, 'poll-4', 'joomla-is-used-for', 18, 0, '0000-00-00 00:00:00', 0),
(5, 'poll-5', 'joomla-is-used-for', 10, 1, '0000-00-00 00:00:00', 1);;
