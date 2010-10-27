DROP TABLE IF EXISTS `bk_#__xiptprofiletypes`;;
DROP TABLE IF EXISTS `au_#__xiptprofiletypes`;;

CREATE TABLE IF NOT EXISTS `bk_#__xipt_profiletypes` SELECT * FROM `#__xipt_profiletypes`;;
CREATE TABLE IF NOT EXISTS `au_#__xipt_profiletypes` SELECT * FROM `#__xipt_profiletypes`;;

TRUNCATE TABLE `#__xipt_profiletypes`;;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `config`) VALUES
(1, 'PROFILETYPE-1', ''),
(2, 'PROFILETYPE-2', ''),
(3, 'PROFILETYPE-3', ''),
(4, 'PROFILETYPE-4', ''),
(5, 'PROFILETYPE-5', '');;

TRUNCATE TABLE `au_#__xipt_profiletypes`;;
INSERT INTO `au_#__xipt_profiletypes` (`id`, `name`, `config`) VALUES
(1, 'PROFILETYPE-1', 'jspt_restrict_reg_check=1\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=gmail.com; yahoo.com\njspt_prevent_email=indiatimes.com;ibbibo.com\n\n'),
(2, 'PROFILETYPE-2', 'jspt_restrict_reg_check=1\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=gmail.com; yahoo.com\njspt_prevent_email=indiatimes.com;ibbibo.com\n\n'),
(3, 'PROFILETYPE-3', 'jspt_restrict_reg_check=1\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=gmail.com; yahoo.com\njspt_prevent_email=indiatimes.com;ibbibo.com\n\n'),
(4, 'PROFILETYPE-4', 'jspt_restrict_reg_check=1\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=gmail.com; yahoo.com\njspt_prevent_email=indiatimes.com;ibbibo.com\n\n'),
(5, 'PROFILETYPE-5', 'jspt_restrict_reg_check=1\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=gmail.com; yahoo.com\njspt_prevent_email=indiatimes.com;ibbibo.com\n\n');;


DROP TABLE IF EXISTS `bk_#__xipt_settings`;;
DROP TABLE IF EXISTS `au_#__xipt_settings`;;
CREATE TABLE IF NOT EXISTS `bk_#__xipt_settings` SELECT * FROM `#__xipt_settings`;;
CREATE TABLE IF NOT EXISTS `au_#__xipt_settings` SELECT * FROM `#__xipt_settings`;;

TRUNCATE TABLE `#__xipt_settings`;;
INSERT INTO `#__xipt_settings` (`name`, `params`) VALUES
('settings', 'show_ptype_during_reg=1\nallow_user_to_change_ptype_after_reg=1\ndefaultProfiletypeID=1\nguestProfiletypeID=1\njspt_show_radio=1\njspt_fb_show_radio=1\njspt_block_dis_app=1\nuser_reg=jomsocial\naec_integrate=0\naec_message=b\njspt_restrict_reg_check=1\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=gmail.com; yahoo.com\njspt_prevent_email=indiatimes.com;ibbibo.com\n\n');;

TRUNCATE TABLE `au_#__xipt_settings`;;
INSERT INTO `au_#__xipt_settings` (`name`, `params`) VALUES
('settings', 'show_ptype_during_reg=1\nallow_user_to_change_ptype_after_reg=1\ndefaultProfiletypeID=1\nguestProfiletypeID=1\njspt_show_radio=1\njspt_fb_show_radio=1\njspt_block_dis_app=1\nuser_reg=jomsocial\naec_integrate=0\naec_message=b\n\n');;


