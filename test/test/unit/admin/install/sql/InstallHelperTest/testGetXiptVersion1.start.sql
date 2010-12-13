DROP TABLE IF EXISTS `bk_#__xipt_settings`;;
DROP TABLE IF EXISTS `au_#__xipt_settings`;;
CREATE TABLE IF NOT EXISTS `bk_#__xipt_settings` SELECT * FROM `#__xipt_settings`;;
CREATE TABLE IF NOT EXISTS `au_#__xipt_settings` SELECT * FROM `#__xipt_settings`;;

TRUNCATE TABLE `#__xipt_settings`;;
INSERT INTO `#__xipt_settings` (`name`, `params`) VALUES
('settings', 'show_ptype_during_reg=1\nallow_user_to_change_ptype_after_reg=1\ndefaultProfiletypeID=1\nguestProfiletypeID=1\njspt_show_radio=1\njspt_fb_show_radio=1\njspt_block_dis_app=1\nuser_reg=jomsocial\naec_integrate=0\naec_message=b\n\n');;