

TRUNCATE TABLE `#__xipt_profiletypes` ;;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`) VALUES
(1, 'PROFILETYPE-1', 2, 1),
(2, 'PROFILETYPE-2', 1, 1),
(3, 'PROFILETYPE-3', 3, 1),
(4, 'PROFILETYPE-4', 4, 1),
(5, 'PROFILETYPE-5', 5, 1),
(6, 'PROFILETYPE-6', 6, 1),
(7, 'PROFILETYPE-7', 7, 1),
(9, 'PROFILETYPE-9', 8, 1)
;;

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
(79, 1, 'default')
;;

TRUNCATE TABLE `#__xipt_aclrules`;;
INSERT INTO `#__xipt_aclrules` (`id`, `rulename`, `aclname`, `coreparams`, `aclparams`, `published`) VALUES
(11, 'RULE-11', 'creategroup', 		'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(12, 'RULE-12', 'joingroup', 		'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(13, 'RULE-13', 'accessgroup', 		'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),

(14, 'RULE-14', 'createvent', 		'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(15, 'RULE-15', 'deletevent', 		'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(16, 'RULE-16', 'accessevent', 		'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),

(17, 'RULE-17', 'addalbums', 		'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(18, 'RULE-18', 'addphotos', 		'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),

(19, 'RULE-19', 'changeavatar', 	'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(20, 'RULE-20', 'changeprivacy', 	'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(21, 'RULE-21', 'editselfprofile', 	'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(22, 'RUL22', 'editselfprofiledetails', 'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(23, 'RULE-23', 'cantviewotherprofile', 'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),

(24, 'RULE-24', 'addvideos', 		'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(25, 'RULE-25', 'accessvideo', 		'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),

(26, 'RULE-26', 'addprofilevideo', 	'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(27, 'RULE-27', 'deleteprofilevideo', 	'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(28, 'RULE-28', 'accessprofilevideo', 	'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),

(29, 'RULE-29', 'writemessages', 	'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(30, 'RULE-20', 'addasfriends', 	'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(31, 'RULE-31', 'redirect',		'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(32, 'RULE-32', 'addapplication',	'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(33, 'RULE-33', 'statusbox', 		'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 1)
;;



TRUNCATE TABLE `#__community_groups`;;
INSERT INTO `#__community_groups` (`id`, `published`, `ownerid`, `categoryid`, `name`) VALUES
(2, 1, 82, 4, 'pt1'),
(3, 1, 83, 4, 'pt2')
;;

TRUNCATE TABLE `#__community_groups_members` ;;
INSERT INTO `#__community_groups_members` (`groupid`, `memberid`, `approved`, `permissions`) VALUES
(2, 82, 1, 0),
(3, 83, 1, 0)
;;

TRUNCATE TABLE `#__community_msg`;;
INSERT INTO `#__community_msg` (`id`, `from`, `parent`, `deleted`, `from_name`, `posted_on`, `subject`, `body`) 
VALUES
(2, 82, 2, 0, 'regtest1789672', '2010-09-15 07:55:30', 'testmessage', 'testmessage'),
(3, 83, 3, 0, 'regtest1789672', '2010-09-15 07:55:30', 'testmessage', 'testmessage')

;;

TRUNCATE TABLE `#__community_msg_recepient`;;
INSERT INTO `#__community_msg_recepient` (`msg_id`, `msg_parent`, `msg_from`, `to`, `bcc`, `is_read`, `deleted`) 
VALUES
(2, 2, 82, 83, 0, 1, 0),
(3, 3, 83, 82, 0, 1, 0)
;;

TRUNCATE TABLE `#__community_apps`;;

TRUNCATE TABLE `#__community_photos_albums`;;
INSERT INTO `#__community_photos_albums` 
(`id`, `photoid`, `creator`, `name`, `description`, `permissions`, `created`, `path`, `type`) VALUES
(2, 0, 82, 'a', 'a', '', '2010-10-17 10:22:01', 'images/photos/62/', 'user'),
(3, 0, 83, 'a', 'a', '', '2010-10-17 10:22:01', 'images/photos/62/', 'user')
;;

TRUNCATE TABLE `#__community_photos` ;;
INSERT INTO `#__community_photos` (`id`, `albumid`, `caption`, `published`, `creator`, `permissions`, `image`, `thumbnail`, `original`, `created`, `filesize`, `storage`, `ordering`) VALUES
(2, 2, 'IMG_1287', 1, 82, '', 'images/photos/62/7/df4fb2a38b6e2eeffdb5093b.jpg', 'images/photos/62/7/thumb_df4fb2a38b6e2eeffdb5093b.jpg', 'images/originalphotos/62/7/df4fb2a38b6e2eeffdb5093b.jpg', '2010-10-17 10:29:19', 4096, 'file', 0),
(3, 2, 'IMG_1287', 1, 83, '', 'images/photos/62/7/df4fb2a38b6e2eeffdb5093b.jpg', 'images/photos/62/7/thumb_df4fb2a38b6e2eeffdb5093b.jpg', 'images/originalphotos/62/7/df4fb2a38b6e2eeffdb5093b.jpg', '2010-10-17 10:29:19', 4096, 'file', 0)
;;


TRUNCATE TABLE `#__community_videos` ;;
INSERT INTO `#__community_videos` 
(`id`, `title`, `type`, `video_id`, `description`, `creator`, `creator_type`, `created`, `permissions`, `category_id`,`status`) 
VALUES
(2, 'Kites Song F', 'youtube', 'PN626ZXD204', 'Kites', 82, 'user', '2010-05-25 11:57:38', '0', 1,'ready'),
(3, 'PHP Tutorial', 'youtube', 'afgyNp5HueQ', 'PHP'  , 83, 'user', '2010-05-25 12:19:16', '0', 1,'ready'),
(4, 'Hrithik R*',   'youtube', 'luXxeIlOoKU', 'Hrit' , 84, 'user', '2010-05-25 12:28:01', '0', 1,'ready')
;;
