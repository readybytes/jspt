TRUNCATE TABLE `#__xipt_aclrules`;
INSERT INTO `#__xipt_aclrules` (`id`, `rulename`, `aclname`, `coreparams`, `aclparams`, `published`) VALUES
(1, 'create event', 'createvent', 'core_profiletype=1\ncore_display_message=YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE\ncore_redirect_url=index.php?option=com_community\n\n', 'createvent_limit=2\n\n', 1),
(2, 'create event', 'createvent', 'core_profiletype=2\ncore_display_message=YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE\ncore_redirect_url=index.php?option=com_community\n\n', 'createvent_limit=0\n\n', 1);


TRUNCATE TABLE `#__community_events`;

CREATE TABLE IF NOT EXISTS `au_#__community_events` SELECT * FROM `#__community_events`;
TRUNCATE TABLE `au_#__community_events`;
INSERT INTO `au_#__community_events` (`id`, `catid`, `contentid`, `type`, `title`, `location`, `description`, `creator`, `startdate`, `enddate`, `permission`, `avatar`, `thumb`, `invitedcount`, `confirmedcount`, `declinedcount`, `maybecount`, `wallcount`, `ticket`, `allowinvite`, `created`, `hits`, `published`, `latitude`, `longitude`) VALUES
(1, 2, 0, 'profile', 'myevent1', 'india', 'myevent', 82, '2010-06-23 21:00:00', '2010-06-23 22:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, '2010-06-23 10:26:54', 0, 1, 20.5937, 78.9629),
(2, 2, 0, 'profile', 'myevent2', 'india', 'myevent', 82, '2010-06-23 22:00:00', '2010-06-23 23:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, '2010-06-23 10:27:02', 0, 1, 20.5937, 78.9629);


TRUNCATE TABLE `#__community_events`;

TRUNCATE TABLE `#__core_acl_aro`;
INSERT INTO `#__core_acl_aro` (`id`, `section_value`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', '62', 0, 'Administrator', 0),
(31, 'users', '83', 0, 'regtest1789672', 0),
(28, 'users', '80', 0, 'regtest6208627', 0),
(32, 'users', '84', 0, 'regtest6461827', 0),
(35, 'users', '87', 0, 'regtest1674526', 0),
(33, 'users', '85', 0, 'regtest3843261', 0),
(34, 'users', '86', 0, 'regtest1504555', 0),
(29, 'users', '81', 0, 'regtest8635954', 0),
(27, 'users', '79', 0, 'regtest7046025', 0),
(30, 'users', '82', 0, 'regtest8774090', 0);

TRUNCATE TABLE`#__core_acl_groups_aro_map`;
INSERT INTO `#__core_acl_groups_aro_map` (`group_id`, `section_value`, `aro_id`) VALUES
(18, '', 27),
(18, '', 30),
(18, '', 33),
(20, '', 28),
(20, '', 31),
(20, '', 34),
(21, '', 29),
(21, '', 32),
(21, '', 35),
(25, '', 10);