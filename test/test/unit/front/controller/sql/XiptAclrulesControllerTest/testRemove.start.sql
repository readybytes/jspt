DROP TABLE IF EXISTS `bk_#__xipt_aclrules`;;
DROP TABLE IF EXISTS `au_#__xipt_aclrules`;;

CREATE TABLE IF NOT EXISTS `au_#__xipt_aclrules` 
	SELECT * FROM `#__xipt_aclrules`;;
CREATE TABLE IF NOT EXISTS `bk_#__xipt_aclrules` 
	SELECT * FROM `#__xipt_aclrules`;;

TRUNCATE TABLE `au_#__xipt_aclrules`;;
TRUNCATE TABLE `#__xipt_aclrules`;;

INSERT INTO `#__xipt_aclrules` (`id`, `rulename`, `aclname`, `coreparams`, `aclparams`, `published`) VALUES
(1, 'Can''t add Videos', 'addvideos', 'core_profiletype=1\ncore_display_message=YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE\ncore_redirect_url=index.php?option=com_community\n\n', 'addvideos_limit=10\n\n', 0),
(2, 'Can''t add Photos', 'addphotos', 'core_profiletype=3\ncore_display_message=YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE\ncore_redirect_url=index.php?option=com_community\n\n', 'addphotos_limit=10\n\n', 0),
(3, 'can''t create Group', 'creategroup', 'core_profiletype=0\ncore_display_message=YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE\ncore_redirect_url=index.php?option=com_community\n\n', 'creategroup_limit=20\n\n', 0),
(4, 'Can''t delete Event', 'deletevent', 'core_profiletype=4\ncore_display_message=YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE\ncore_redirect_url=index.php?option=com_community\n\n', '\n', 0),
(6, 'CAn''t add Friend', 'addasfriends', 'core_profiletype=2\ncore_display_message=YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE\ncore_redirect_url=index.php?option=com_community\n\n', 'other_profiletype=1\n\n', 0);;

INSERT INTO `au_#__xipt_aclrules` (`id`, `rulename`, `aclname`, `coreparams`, `aclparams`, `published`) VALUES
(1, 'Can''t add Videos', 'addvideos', 'core_profiletype=1\ncore_display_message=YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE\ncore_redirect_url=index.php?option=com_community\n\n', 'addvideos_limit=10\n\n', 0);;



