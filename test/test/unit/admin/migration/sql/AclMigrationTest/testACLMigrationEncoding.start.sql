DROP TABLE IF EXISTS `bk_#__xipt_settings`;;
DROP TABLE IF EXISTS `au_#__xipt_aclrules`;;
DROP TABLE IF EXISTS `bk_#__xipt_aclrules`;;
CREATE TABLE IF NOT EXISTS `bk_#__xipt_settings` SELECT * FROM `#__xipt_settings`;;
CREATE TABLE IF NOT EXISTS `bk_#__xipt_aclrules` SELECT * FROM `#__xipt_aclrules`;;
CREATE TABLE IF NOT EXISTS `au_#__xipt_aclrules` SELECT * FROM `#__xipt_aclrules`;;

TRUNCATE TABLE `#__xipt_settings`;;
INSERT INTO `#__xipt_settings` (`name`, `params`) VALUES
('settings', 'show_ptype_during_reg=1\nallow_user_to_change_ptype_after_reg=1\ndefaultProfiletypeID=1\nguestProfiletypeID=1\njspt_show_radio=1\njspt_fb_show_radio=1\njspt_block_dis_app=1\nuser_reg=jomsocial\naec_integrate=0\naec_message=b\n\n'),
('version', '3.0.458');;


TRUNCATE TABLE `#__xipt_aclrules`;;
INSERT INTO `#__xipt_aclrules` (`id`, `rulename`, `aclname`, `coreparams`, `aclparams`, `published`) VALUES
(11, 'RULE-11', 'creategroup', 		'core_profiletype=1\ncore_display_message=<p>YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE</p>\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(12, 'RULE-12', 'joingroup', 		'core_profiletype=1\ncore_display_message=<p>YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE</p>\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(13, 'RULE-13', 'accessgroup', 		'core_profiletype=1\ncore_display_message=<p>YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE</p>\ncore_redirect_url=index.php\n\n', '\n\n', 0),

(14, 'RULE-14', 'createvent', 		'core_profiletype=1\ncore_display_message=<p>YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE</p>\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(15, 'RULE-15', 'deletevent', 		'core_profiletype=1\ncore_display_message=<p>YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE</p>\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(16, 'RULE-16', 'accessevent', 		'core_profiletype=1\ncore_display_message=<p>YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE</p>\ncore_redirect_url=index.php\n\n', '\n\n', 0),

(17, 'RULE-17', 'addalbums', 		'core_profiletype=1\ncore_display_message=<p>YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE</p>\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(18, 'RULE-18', 'addphotos', 		'core_profiletype=1\ncore_display_message=<p>YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE</p>\ncore_redirect_url=index.php\n\n', '\n\n', 0),

(19, 'RULE-19', 'changeavatar', 	'core_profiletype=1\ncore_display_message=<p>YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE</p>\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(20, 'RULE-20', 'changeprivacy', 	'core_profiletype=1\ncore_display_message=<p>YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE</p>\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(21, 'RULE-21', 'editselfprofile', 	'core_profiletype=1\ncore_display_message=<p>YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE</p>\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(22, 'RUL22', 'editselfprofiledetails', 'core_profiletype=1\ncore_display_message=<p>YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE</p>\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(23, 'RULE-23', 'cantviewotherprofile', 'core_profiletype=1\ncore_display_message=<p>YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE</p>\ncore_redirect_url=index.php\n\n', '\n\n', 0),

(24, 'RULE-24', 'addvideos', 		'core_profiletype=1\ncore_display_message=<p>YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE</p>\ncore_redirect_url=index.php\n\n', '\n\n', 0),
(25, 'RULE-25', 'accessvideo', 		'core_profiletype=1\ncore_display_message=<p>YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE</p>\ncore_redirect_url=index.php\n\n', '\n\n', 0),

(26, 'RULE-26', 'addprofilevideo', 	'core_profiletype=1\ncore_display_message=<p>YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE</p>\ncore_redirect_url=index.php\n\n', '\n\n', 0);;

TRUNCATE TABLE `au_#__xipt_aclrules`;;
INSERT INTO `au_#__xipt_aclrules` (`id`, `rulename`, `aclname`, `coreparams`, `aclparams`, `published`) VALUES
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

(26, 'RULE-26', 'addprofilevideo', 	'core_profiletype=1\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\ncore_redirect_url=index.php\n\n', '\n\n', 0);;
