
TRUNCATE TABLE `#__community_groups_members` ;;

INSERT INTO `#__community_groups_members` (`groupid`, `memberid`, `approved`, `permissions`) VALUES
(1, 62, 1, 1),
(2, 62, 1, 1),
(3, 62, 1, 1),
(4, 62, 1, 1),
(4, 81, 1, 0),
(1, 79, 1, 0),
(1, 82, 1, 0),
(4, 84, 1, 0),
(1, 85, 1, 0),
(4, 87, 1, 0);;

CREATE TABLE IF NOT EXISTS `au_#__community_groups_members` (
  `groupid` int(11) NOT NULL,
  `memberid` int(11) NOT NULL,
  `approved` int(11) NOT NULL,
  `permissions` int(1) NOT NULL,
  KEY `groupid` (`groupid`),
  KEY `idx_memberid` (`memberid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;;

TRUNCATE TABLE `au_#__community_groups_members` ;;

INSERT INTO `au_#__community_groups_members` (`groupid`, `memberid`, `approved`, `permissions`) VALUES
(1, 62, 1, 1),
(2, 62, 1, 1),
(3, 62, 1, 1),
(4, 62, 1, 1),
(4, 81, 1, 0),
(1, 79, 1, 0),
(2, 82, 1, 0),
(4, 84, 1, 0),
(1, 85, 1, 0),
(4, 87, 1, 0);;