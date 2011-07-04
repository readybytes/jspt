DROP TABLE IF EXISTS `bk_#__xipt_profiletypes`;;
DROP TABLE IF EXISTS `au_#__xipt_profiletypes`;;

CREATE TABLE IF NOT EXISTS `au_#__xipt_profiletypes` 
	SELECT * FROM `#__xipt_profiletypes`;;
CREATE TABLE IF NOT EXISTS `bk_#__xipt_profiletypes` 
	SELECT * FROM `#__xipt_profiletypes`;;

TRUNCATE TABLE `au_#__xipt_profiletypes`;;
TRUNCATE TABLE `#__xipt_profiletypes`;;

INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`) VALUES
(1, 'PROFILETYPE-1', 2, 1),
(2, 'PROFILETYPE-2', 1, 1),
(3, 'PROFILETYPE-3', 3, 1),
(4, 'PROFILETYPE-4', 4, 1),
(6, 'PROFILETYPE-6', 6, 1);;

INSERT INTO `au_#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`) VALUES
(1, 'PROFILETYPE-1', 2, 1);;

DROP TABLE IF EXISTS `bk_#__xipt_settings`;;
CREATE TABLE IF NOT EXISTS `bk_#__xipt_settings` 
	SELECT * FROM `#__xipt_settings`;;

TRUNCATE TABLE `#__xipt_settings`;;
INSERT INTO `#__xipt_settings` (`name`, `params`) VALUES
('settings', 'show_ptype_during_reg=1\nallow_user_to_change_ptype_after_reg=1\ndefaultProfiletypeID=1\nguestProfiletypeID=1\njspt_show_radio=1\njspt_fb_show_radio=1\nallow_templatechange=0\nshow_watermark=1\njspt_block_dis_app=1\nuser_reg=joomla\nsubscription_integrate=0\nsubscription_message=b\n\n');

