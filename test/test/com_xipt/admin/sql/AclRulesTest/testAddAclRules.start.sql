TRUNCATE TABLE `#__xipt_profiletypes` ;;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`) VALUES
(1, 'PROFILETYPE-1', 2, 1, 'PROFILETYPE-ONE-TIP', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 1, '', '', 'enableWaterMark=0\nxiText=Profiletype1\nxiWidth=150\nxiHeight=30\nxiFontName=monofont\nxiFontSize=24\nxiTextColor=FFFFFF\nxiBackgroundColor=0F15D0\nxiWatermarkPosition=tr\ndemo=1\n\n'),
(2, 'PROFILETYPE-2', 1, 1, 'PROFILETYPE-TWO-TIP', 'friends', 'blueface', 'Editor', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=Profiletype2\nxiWidth=160\nxiHeight=40\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=2\n\n'),
(3, 'PROFILETYPE-3', 3, 1, 'PROFILETYPE-THREE-TIP', 'members', 'blackout', 'Publisher', 'components/com_community/assets/default.jpg', 0, 0, 4, '', '', 'enableWaterMark=0\nxiText=Profiletype3\nxiWidth=100\nxiHeight=40\nxiFontName=monofont\nxiFontSize=18\nxiTextColor=FFFFFF\nxiBackgroundColor=0F15D0\nxiWatermarkPosition=rb\ndemo=3\n\n'),
(4, 'PROFILETYPE-4', 4, 0, 'PROFILETYPE-FOUR-TIP', 'membres', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=Profiletype4\nxiWidth=100\nxiHeight=40\nxiFontName=monofont\nxiFontSize=18\nxiTextColor=FFFFFF\nxiBackgroundColor=0F15D0\nxiWatermarkPosition=rb\ndemo=4\n\n');;


TRUNCATE TABLE `#__xipt_aclrules`;;
DROP TABLE IF EXISTS `au_#__xipt_aclrules`;;
CREATE TABLE IF NOT EXISTS `au_#__xipt_aclrules` SELECT * FROM `#__xipt_aclrules`;;
TRUNCATE TABLE `au_#__xipt_aclrules`;;

INSERT INTO `au_#__xipt_aclrules` (`id`, `rulename`, `aclname`, `coreparams`, `aclparams`, `published`) VALUES
(11, 'Can not Add Album more than 5', 'addalbums', 'core_profiletype=1\ncore_display_message=YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE\ncore_redirect_url=index.php?option=com_community\n\n', 'addalbums_limit=5\n\n', 1);;


