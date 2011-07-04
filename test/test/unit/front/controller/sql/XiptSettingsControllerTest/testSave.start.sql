DROP TABLE IF EXISTS `bk_#__xipt_settings`;;
CREATE TABLE IF NOT EXISTS `bk_#__xipt_settings` SELECT * FROM `#__xipt_settings`;;

DROP TABLE IF EXISTS `au_#__xipt_settings`;;
CREATE TABLE IF NOT EXISTS `au_#__xipt_settings` SELECT * FROM `#__xipt_settings`;;

TRUNCATE TABLE `#__xipt_settings`;;
TRUNCATE TABLE `au_#__xipt_settings`;;

INSERT INTO `au_#__xipt_settings` (`name`, `params`) VALUES
('settings', 'show_ptype_during_reg=1\nallow_user_to_change_ptype_after_reg=1\ndefaultProfiletypeID=2\nguestProfiletypeID=2\njspt_show_radio=1\njspt_fb_show_radio=1\njspt_block_dis_app=2\nuser_reg=jomsocial\nsubscription_integrate=1\nsubscription_message=b\nintegrate_with=aec\n\n');;

INSERT INTO `#__xipt_settings` (`name`, `params`) VALUES
('settings', '');;

