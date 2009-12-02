TRUNCATE TABLE `#__xipt_profiletypes`;

INSERT INTO `#__xipt_profiletypes`  (`id`,`name`, `ordering`)  
VALUES (1,'PROFILETYPE-1', 1),(2,'PROFILETYPE-2', 2);

UPDATE `#__components` 
SET `params` = 'show_ptype_during_reg=1 
allow_user_to_change_ptype_after_reg=1 
defaultProfiletypeID=0 
jspt_show_radio=1 allow_templatechange=1 
aec_integrate=0 aec_message=b 
jspt_restrict_reg_check=0 
jspt_prevent_username= 
jspt_allowed_email= '
 WHERE `option` ='com_xipt' LIMIT 1 ;