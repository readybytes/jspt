TRUNCATE TABLE `#__xipt_aclrules`;;
INSERT INTO `#__xipt_aclrules` (`id`, `rulename`, `aclname`, `coreparams`, `aclparams`, `published`) VALUES
(1, 'create event', 'createvent', 'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\nforce_to_redirect=0\ncore_redirect_url=index.php?option=com_community\n\n', 'createvent_limit=2\n\n', 1),
(2, 'create event', 'createvent', 'core_profiletype=2\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\nforce_to_redirect=0\ncore_redirect_url=index.php?option=com_community\n\n', 'createvent_limit=0\n\n', 1);;


DROP TABLE IF EXISTS `au_#__community_events`;;
CREATE TABLE IF NOT EXISTS `au_#__community_events` SELECT * FROM `#__community_events`;;
TRUNCATE TABLE `#__community_events`;;

INSERT INTO `au_#__community_events` (`id`, `catid`, `contentid`, `type`, `title`, `location`, `description`, `creator`, `startdate`, `enddate`, `permission`, `avatar`, `thumb`, `invitedcount`, `confirmedcount`, `declinedcount`, `maybecount`, `wallcount`, `ticket`, `allowinvite`, `created`, `hits`, `published`, `latitude`, `longitude`) VALUES
(1, 2, 0, 'profile', 'myevent1', 'india', '<p>myevent</p>', 82, '2010-06-23 21:00:00', '2010-06-23 22:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, '2010-06-23 10:26:54', 0, 1, 20.5937, 78.9629),
(2, 2, 0, 'profile', 'myevent2', 'india', '<p>myevent</p>', 82, '2010-06-23 22:00:00', '2010-06-23 23:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, '2010-06-23 10:27:02', 0, 1, 20.5937, 78.9629);;