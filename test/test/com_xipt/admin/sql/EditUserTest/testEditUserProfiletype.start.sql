TRUNCATE TABLE `#__xipt_profilefields` ;;
INSERT INTO `#__xipt_profilefields` (`id`, `fid`, `pid`) VALUES
(1, 2, 1),
(2, 2, 3),
(3, 2, 4),
(4, 3, 2),
(5, 3, 3),
(6, 3, 4),
(7, 4, 3),
(8, 4, 4),
(9, 6, 1),
(10, 6, 3),
(11, 6, 4),
(12, 7, 2),
(13, 7, 3),
(14, 7, 4),
(15, 8, 3),
(16, 8, 4);;


TRUNCATE TABLE `#__xipt_profiletypes` ;;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`) VALUES
(1, 'PROFILETYPE-1', 2, 1, 'PROFILETYPE-ONE-TIP', 'public', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 1, '', '', 'enableWaterMark=0\nxiText=Profiletype1\nxiWidth=150\nxiHeight=30\nxiFontName=monofont\nxiFontSize=24\nxiTextColor=FFFFFF\nxiBackgroundColor=0F15D0\nxiWatermarkPosition=tr\ndemo=1\n\n'),
(2, 'PROFILETYPE-2', 1, 1, 'PROFILETYPE-TWO-TIP', 'friends', 'blueface', 'Editor', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=Profiletype2\nxiWidth=160\nxiHeight=40\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=2\n\n'),
(3, 'PROFILETYPE-3', 3, 1, 'PROFILETYPE-THREE-TIP', 'members', 'blackout', 'Publisher', 'components/com_community/assets/default.jpg', 0, 0, 4, '', '', 'enableWaterMark=0\nxiText=Profiletype3\nxiWidth=100\nxiHeight=40\nxiFontName=monofont\nxiFontSize=18\nxiTextColor=FFFFFF\nxiBackgroundColor=0F15D0\nxiWatermarkPosition=rb\ndemo=3\n\n'),
(4, 'PROFILETYPE-4', 4, 0, 'PROFILETYPE-FOUR-TIP', 'members', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', 'enableWaterMark=0\nxiText=Profiletype4\nxiWidth=100\nxiHeight=40\nxiFontName=monofont\nxiFontSize=18\nxiTextColor=FFFFFF\nxiBackgroundColor=0F15D0\nxiWatermarkPosition=rb\ndemo=4\n\n');;

TRUNCATE TABLE `#__xipt_users`;;
INSERT INTO `#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 1, 'default'),
(87, 3, 'blackout'),
(86, 2, 'blueface'),
(85, 1, 'default'),
(84, 3, 'blackout'),
(83, 2, 'blueface'),
(82, 1, 'default'),
(81, 3, 'blackout'),
(80, 2, 'blueface'),
(79, 1, 'default');;
