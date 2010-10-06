TRUNCATE TABLE `#__xipt_profiletypes`;;
DROP TABLE IF EXISTS `au_#__xipt_profiletypes`;;
CREATE TABLE `au_#__xipt_profiletypes` SELECT * FROM `#__xipt_profiletypes`;;

INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`, `config`) VALUES
(1, 'ProfileType1', 1, 1, '', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=5\n\n', 1, ''),
(2, 'ProfileType2', 2, 1, '', 'friends', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=6\n\n', 1, ''),
(3, 'ProfileType3', 3, 1, '', 'friends', 'default', 'Registered', 'components/com_community/assets/group.jpg', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=7\n\n', 1, '');;


CREATE TABLE IF NOT EXISTS `au_#__xipt_profiletypes` 
	SELECT * FROM `#__xipt_profiletypes` ;; 
TRUNCATE TABLE `au_#__xipt_profiletypes` ;;

INSERT INTO `au_#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`, `config`) VALUES
(1, 'ProfileType1', 1, 1, '', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=5\n\n', 1, 'jspt_restrict_reg_check=1\njspt_prevent_username=admin;moderator;\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(2, 'ProfileType2', 2, 1, '', 'friends', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=6\n\n', 1, ''),
(3, 'ProfileType3', 3, 1, '', 'friends', 'default', 'Registered', 'components/com_community/assets/group.jpg', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=7\n\n', 1, '');;
