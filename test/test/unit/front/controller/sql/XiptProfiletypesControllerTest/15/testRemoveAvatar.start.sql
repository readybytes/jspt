TRUNCATE TABLE `#__core_acl_aro`;;
INSERT INTO `#__core_acl_aro` (`id`, `section_value`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', '62', 0, 'Administrator', 0),
(11, 'users', '63', 0, 'User1', 0),
(12, 'users', '64', 0, 'User2', 0),
(13, 'users', '65', 0, 'User11', 0),
(14, 'users', '66', 0, 'User22', 0);;

TRUNCATE TABLE `#__core_acl_groups_aro_map`;;
INSERT INTO `#__core_acl_groups_aro_map` (`group_id`, `section_value`, `aro_id`) VALUES
(18, '', 11),
(18, '', 12),
(18, '', 13),
(18, '', 14),
(25, '', 10);;
