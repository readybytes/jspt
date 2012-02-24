TRUNCATE TABLE `#__community_msg_recepient`;;
TRUNCATE TABLE `#__community_msg`;;
TRUNCATE TABLE `#__community_photos_albums`;;

TRUNCATE TABLE `#__xipt_aclrules`;;
INSERT INTO `#__xipt_aclrules` (`id`, `rulename`, `aclname`, `coreparams`, `aclparams`, `published`) VALUES
(1, 'RULE-1', 'creategroup', 'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php?option=com_community\n\n', 'creategroup_limit=0\n\n', 1),
(2, 'RULE-2', 'joingroup', 'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php?option=com_community&view=profile\n\n', 'joingroup_limit=0\n\n', 1),
(3, 'RULE-3', 'addphotos', 'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php?option=com_community\n\n', 'addphotos_limit=0\n\n', 1),
(4, 'RULE-4', 'addalbums', 'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php?option=com_community\n\n', 'addalbums_limit=1\n\n', 1),
(5, 'RULE-5', 'addvideos', 'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php?option=com_community\n\n', 'addvideos_limit=0\n\n', 1),
(6, 'RULE-6', 'writemessages', 'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php?option=com_community\n\n', 'other_profiletype=0\nwritemessage_limit=0\n\n', 1),
(7, 'RULE-7', 'changeavatar', 'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php?option=com_community\n\n', '\n', 1),
(8, 'RULE-8', 'changeprivacy', 'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php?option=com_community\n\n', '\n', 1),
(9, 'RULE-9', 'editselfprofile', 'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php?option=com_community\n\n', '\n', 1),
(10, 'RULE-10', 'editselfprofiledetails', 'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php?option=com_community\n\n', '\n', 1),
(11, 'RULE-11', 'cantviewotherprofile', 'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php?option=com_community\n\n', 'other_profiletype=2\n\n', 1),
(12, 'RULE-12', 'addasfriends', 'core_profiletype=1\ncore_display_message=You are not allowed to access this resource\ncore_redirect_url=index.php?option=com_community&view=profile\n\n', 'other_profiletype=2\n\n', 1);;


TRUNCATE TABLE `#__community_fields` ;;
INSERT INTO `#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`) VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basicr', 1, 1, 1, 1, '', ''),
(2, 'text', 2, 1, 5, 250, 'Hometown2', 'Hometown2', 1, 1, 1, 1, '', 'FIELD_HOMETOWN2'),
(3, 'text', 3, 1, 5, 250, 'Hometown3', 'Hometown3', 1, 0, 1, 1, '', 'FIELD_HOMETOWN3'),
(4, 'text', 4, 1, 5, 250, 'Hometown4', 'Hometown4', 1, 0, 1, 1, '', 'FIELD_HOMETOWN4'),
(5, 'text', 5, 1, 5, 250, 'Hometown5', 'Hometown5', 1, 0, 1, 1, '', 'FIELD_HOMETOWN5'),
(6, 'text', 6, 1, 5, 250, 'Hometown6', 'Hometown6', 0, 0, 1, 1, '', 'FIELD_HOMETOWN6'),
(7, 'text', 7, 1, 5, 250, 'Hometown7', 'Hometown7', 1, 0, 1, 0, '', 'FIELD_HOMETOWN7'),
(8, 'text', 8, 1, 5, 250, 'Hometown8', 'Hometown8', 1, 0, 1, 1, '', 'FIELD_HOMETOWN8'),
(9, 'text', 9, 1, 5, 250, 'Hometown9', 'Hometown9', 1, 0, 0, 1, '', 'FIELD_HOMETOWN9'),
(16, 'templates', 10, 1, 10, 100, 'Template', 'Template Of User', 1, 1, 1, 1, '', 'XIPT_TEMPLATE'),
(17, 'profiletypes', 11, 1, 10, 100, 'Profiletype', 'Profiletype Of User', 1, 1, 1, 1, '', 'XIPT_PROFILETYPE');;


TRUNCATE TABLE `#__xipt_profilefields` ;;
INSERT INTO `#__xipt_profilefields` (`id`, `fid`, `pid`) VALUES
(1, 2, 1),
(2, 2, 3),
(3, 2, 4),
(4, 3, 2),
(5, 3, 3),
(6, 3, 4),
(7, 4, 3),
(8, 4, 4),
(9, 6, 1),
(10, 6, 3),
(11, 6, 4),
(12, 7, 2),
(13, 7, 3),
(14, 7, 4),
(15, 8, 3),
(16, 8, 4);;


TRUNCATE TABLE `#__xipt_profiletypes` ;;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`) VALUES
(1, 'PROFILETYPE-1', 2, 1, 'PROFILETYPE-ONE-TIP', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 1, '', ''),
(2, 'PROFILETYPE-2', 1, 1, 'PROFILETYPE-TWO-TIP', 'friends', 'blueface', 'Editor', 'components/com_community/assets/group.jpg', 0, 0, 0, '', ''),
(3, 'PROFILETYPE-3', 3, 1, 'PROFILETYPE-THREE-TIP', 'members', 'blackout', 'Publisher', 'components/com_community/assets/default.jpg', 0, 0, 4, '', ''),
(4, 'PROFILETYPE-4', 4, 0, 'PROFILETYPE-THREE-TIP', 'members', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '');;
