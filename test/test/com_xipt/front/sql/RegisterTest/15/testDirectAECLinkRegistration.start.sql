TRUNCATE TABLE `#__xipt_profiletypes`;;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`, `config`) VALUES
(1, 'PROFILETYPE-1', 1, 1, '', 'privacyProfileView="10"\nprivacyFriendsView="0"\nprivacyPhotoView="0"\nnotifyEmailSystem="1"\nnotifyEmailApps="1"\nnotifyWallComment="0"', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 1, '1', 'images/profiletype/watermark_1.png', '', 'enableWaterMark="0"\nxiText="P"\nxiWidth="40"\nxiHeight="40"\nxiThumbWidth="20"\nxiThumbHeight="20"\nxiFontName="monofont"\nxiFontSize="26"\nxiTextColor="FFFFFF"\nxiBackgroundColor="9CD052"\nxiWatermarkPosition="tl"\ndemo=0', 1, 'jspt_restrict_reg_check="0"\njspt_prevent_username="moderator; admin; support; owner; employee"\njspt_allowed_email=""\njspt_prevent_email=""'),
(2, 'PROFILETYPE-2', 2, 1, '', 'privacyProfileView="30"\nprivacyFriendsView="0"\nprivacyPhotoView="0"\nnotifyEmailSystem="1"\nnotifyEmailApps="1"\nnotifyWallComment="0"', 'blueface', 'Editor', 'components/com_community/assets/group.jpg', 0, 1, '0', 'images/profiletype/watermark_2.png', '', 'enableWaterMark="0"\nxiText="P"\nxiWidth="40"\nxiHeight="40"\nxiThumbWidth="20"\nxiThumbHeight="20"\nxiFontName="monofont"\nxiFontSize="26"\nxiTextColor="FFFFFF"\nxiBackgroundColor="9CD052"\nxiWatermarkPosition="tl"\ndemo=0', 1, 'jspt_restrict_reg_check="0"\njspt_prevent_username="moderator; admin; support; owner; employee"\njspt_allowed_email=""\njspt_prevent_email=""'),
(3, 'PROFILETYPE-3', 3, 1, '', 'privacyProfileView="20"\nprivacyFriendsView="0"\nprivacyPhotoView="0"\nnotifyEmailSystem="1"\nnotifyEmailApps="1"\nnotifyWallComment="0"', 'blackout', 'Publisher', 'components/com_community/assets/default.jpg', 0, 1, '4', 'images/profiletype/watermark_3.png', '', 'enableWaterMark="0"\nxiText="P"\nxiWidth="40"\nxiHeight="40"\nxiThumbWidth="20"\nxiThumbHeight="20"\nxiFontName="monofont"\nxiFontSize="26"\nxiTextColor="FFFFFF"\nxiBackgroundColor="9CD052"\nxiWatermarkPosition="tl"\ndemo=0', 1, 'jspt_restrict_reg_check="0"\njspt_prevent_username="moderator; admin; support; owner; employee"\njspt_allowed_email=""\njspt_prevent_email=""'),
(4, 'PROFILETYPE-4', 4, 0, '', 'privacyProfileView="20"\nprivacyFriendsView="0"\nprivacyPhotoView="0"\nnotifyEmailSystem="1"\nnotifyEmailApps="1"\nnotifyWallComment="0"', 'blackout', 'Registered', 'components/com_community/assets/default.jpg', 0, 1, '0', 'images/profiletype/watermark_4.png', '', 'enableWaterMark="0"\nxiText="P"\nxiWidth="40"\nxiHeight="40"\nxiThumbWidth="20"\nxiThumbHeight="20"\nxiFontName="monofont"\nxiFontSize="26"\nxiTextColor="FFFFFF"\nxiBackgroundColor="9CD052"\nxiWatermarkPosition="tl"\ndemo=0', 1, 'jspt_restrict_reg_check="0"\njspt_prevent_username="moderator; admin; support; owner; employee"\njspt_allowed_email=""\njspt_prevent_email=""');;