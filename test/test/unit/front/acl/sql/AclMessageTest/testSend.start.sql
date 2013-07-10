TRUNCATE TABLE `#__community_users`;;
INSERT INTO `#__community_users` (`userid`) VALUES
(62),
(83),
(84),
(85),
(86),
(87),
(79),
(80),
(81),
(82)
;;

TRUNCATE TABLE `#__xipt_profiletypes` ;;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`) VALUES
(1, 'PROFILETYPE-1', 2, 1),
(2, 'PROFILETYPE-2', 1, 1),
(3, 'PROFILETYPE-3', 3, 1);;

TRUNCATE TABLE `#__xipt_users`;;
INSERT INTO `#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 1, 'default'),
(87, 3, 'blackout'),
(86, 2, 'blueface'),
(85, 1, 'default'),
(84, 3, 'blackout'),
(83, 2, 'blueface'),
(82, 1, 'default'),
(81, 3, 'blackout'),
(80, 2, 'blueface'),
(79, 1, 'default');;

TRUNCATE TABLE `#__xipt_aclrules`;;
INSERT INTO `#__xipt_aclrules` (`id`, `rulename`, `aclname`, `coreparams`, `aclparams`, `published`) VALUES
(11, 'RULE-11', 'writemessages', 'core_profiletype=1\ncore_display_message=NotAllowed\ncore_redirect_url=index.php\n\n', 'other_profiletype=2\nwritemessage_limit=0\nacl_applicable_to_friend=1\n\n', 1),
(12, 'RULE-12', 'writemessages', 'core_profiletype=0\ncore_display_message=NotAllowed\ncore_redirect_url=index.php\n\n', 'other_profiletype=3\nwritemessage_limit=0\n\n', 1),
(13, 'RULE-13', 'writemessages', 'core_profiletype=1\ncore_display_message=NotAllowed\ncore_redirect_url=index.php\n\n', 'other_profiletype=2\nwritemessage_limit=4\n\n', 1),
(14, 'RULE-14', 'writemessages', 'core_profiletype=1\ncore_display_message=NotAllowed\ncore_redirect_url=index.php\n\n', 'other_profiletype=2\nwritemessage_limit=3\n\n', 1),
(15, 'RULE-15', 'writemessages', 'core_profiletype=1\ncore_display_message=NotAllowed\ncore_redirect_url=index.php\n\n', 'other_profiletype=2\nwritemessage_limit=2\n\n', 1)
;;

TRUNCATE TABLE `#__community_msg`;;
INSERT INTO `#__community_msg` (`id`, `from`, `parent`, `deleted`, `from_name`, `posted_on`, `subject`, `body`) 
VALUES
(1, 85, 1, 0, 'regtest1789672', '2010-09-15 07:55:30', 'testmessage', 'testmessage'),
(2, 85, 2, 0, 'regtest1789672', '2010-09-15 07:55:30', 'testmessage', 'testmessage'),
(3, 85, 3, 0, 'regtest1789672', '2010-09-15 07:55:30', 'testmessage', 'testmessage');;

TRUNCATE TABLE `#__community_msg_recepient`;;
INSERT INTO `#__community_msg_recepient` (`msg_id`, `msg_parent`, `msg_from`, `to`, `bcc`, `is_read`, `deleted`) 
VALUES
(1, 1, 85, 83, 0, 1, 0),
(2, 2, 85, 83, 0, 1, 0),
(3, 3, 85, 83, 0, 1, 0);;

TRUNCATE TABLE  `#__community_connection` ;;
INSERT INTO `#__community_connection` (`connection_id`, `connect_from`, `connect_to`, `status`, `group`, `created`, `msg`) VALUES
(1, 85, 83, 1, 0, NULL, ''),
(2, 83, 85, 1, 0, NULL, '');;
