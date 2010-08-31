
DELETE FROM `#__menu` WHERE `id` = 61 OR `id` = 62;;

INSERT INTO `#__menu` (`id`, `menutype`, `name`, `alias`, `link`, `type`, `published`, `parent`, `componentid`, `sublevel`, `ordering`, `checked_out`, `checked_out_time`, `pollid`, `browserNav`, `access`, `utaccess`, `params`, `lft`, `rgt`, `home`) VALUES
(62, 'mainmenu', 'jsptview', 'jsptview', 'index.php?option=com_xipt&view=registration&ptypeid=2', 'component', 1, 0, 87, 0, 11, 62, '2010-08-31 09:11:37', 0, 0, 0, 0, 'page_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n', 0, 0, 0),
(61, 'mainmenu', 'Profile Type 1 Registration', 'profile-type-1-registration', 'index.php?option=com_xipt&view=registration&ptypeid=2', 'component', 1, 0, 87, 0, 10, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'page_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n', 0, 0, 0);;
