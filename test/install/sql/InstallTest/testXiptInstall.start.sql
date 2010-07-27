TRUNCATE TABLE `#__community_config`;;
INSERT INTO `#__community_config` (`name`, `params`) VALUES
('dbversion', '5'),
('config', 'enablegroups=1\nmoderategroupcreation=0\ncreategroups=1\ncreatediscussion=1\ngroupphotos=1\ngroupvideos=1\npoint0=50\npoint1=50\npoint2=100\npoint3=200\npoint4=350\npoint5=600\nlockprofilewalls=1\nlockgroupwalls=1\nlockvideoswalls=1\nenablephotos=1\nenablepm=1\nnotifyby=1\nsitename=JSPT 2.0 Development\nprivacyemail=1\nprivacyemailpm=1\nprivacyapps=1\nsef=feature\ndisplayname=name\ntemplate=default\ntask=saveconfig\nview=configuration\noption=com_community\nprivacyprofile=0\nprivacyfriends=0\nprivacyphotos=0\nphotomaxwidth=600\noriginalphotopath=originalphotos\narchive_activity_days= 21\ndisplayhome=1\nmaxacitivities=20\nshowactivityavatar=1\nenablereporting=1\nmaxReport=50\nenablecustomviewcss=0\nfrontpageusers=20\njsnetwork_path=http://updates.jomsocial.com/index.php?option=com_jsnetwork&view=submit&task=update\ngroupnewseditor=1\nimageengine=auto\ndbversion=1.1\npredefinedreports=Spamming / Advertisement\nactivitiestimeformat=%I:%M %p\nactivitiesdayformat=%b %d\nflashuploader=0\nmaxuploadsize=8\nenablevideos=1\nenablevideosupload=0\nvideosSize=400x300\nvideosThumbSize=112x84\nfrontpagevideos=3\ndeleteoriginalvideos=0\nvideofolder=images\nmaxvideouploadsize=8\nvideodebug=0\nguestsearch=0\nfloodLimit=1\npmperday=30\nsendemailonpageload=0\nshowlatestvideos=1\nshowlatestgroups=1\nshowlatestphotos=1\nshowactivitystream=1\nshowlatestmembers=1\ndaylightsavingoffset=0\nsingularnumber=1\nusepackedjavascript=1\nfolderpermissionsphoto=0755\nfolderpermissionsvideo=0755\niphoneactivitiesapps=photos,groups,profile,walls\nsessionexpiryperiod=600\nactivationresetpassword=0\ngroupdiscussnotification=0\ntagboxwidth=150\ntagboxheight=150\nfrontpagephotos=20\nautoalbumcover=1\nenablesharethis=1\nenablekarma=1\nprivacywallcomment=0\nphotouploadlimit=1\nvideouploadlimit=1\ngroupcreatelimit=1\ngroupphotouploadlimit=500\ngroupvideouploadlimit=500\nphotospath=/var/www/root4739/images\nnotifyMaxReport=\nenableguestreporting=0\nenableterms=0\nregistrationTerms=\nrecaptcha=0\nrecaptchapublic=\nrecaptchaprivate=\nrecaptchatheme=red\nrecaptchalang=en\nfeatureduserslimit=10\nfeaturedvideoslimit=10\nfeaturedgroupslimit=10\nhtmlemail=1\nmagickPath=\nffmpegPath=\nflvtool2=\nqscale=11\ncustomCommandForVideo=\nvideoskey=\nenablevideopseudostream=0\nhtmleditor=\nprofileDateFormat=%d/%m/%Y\nfrontpagegroups=5\nnetwork_enable=0\nnetwork_description=Joomla! - the dynamic portal engine and content management system\nnetwork_keywords=joomla, Joomla\nnetwork_join_url=http://localhost/root4739/index.php?option=com_community&view=register&Itemid=53\nnetwork_cron_freq=24\nnetwork_cron_last_run=0\nfbconnectkey=\nfbconnectsecret=\nfbsignupimport=1\nfbwatermark=1\nfbloginimportprofile=1\nfbloginimportavatar=1\nfbconnectupdatestatus=1\nphotostorage=file\nvideostorage=file\nstorages3bucket=\nstorages3accesskey=\nstorages3secretkey=\nenablemyblogicon=0\njspt_during_reg=1\njspt_allow_typechange=0\nprofiletypes=1\njspt_show_radio=1\njspt_allow_templatechange=0\njspt_restrict_reg_check=1\njspt_prevent_username=moderator, admin, support, owner, employee\njspt_allowed_email=\njspt_prevent_email=\njspt_captcha_during_reg=0\njspt_recaptcha_public_key=\njspt_recaptcha_private_key=\njspt_reg_page2=0\njspt_reg_avatar=0\nforceAecPlan=0\naecmessage=b\n\n');;

CREATE TABLE IF NOT EXISTS `au_#__components` SELECT * FROM `#__components`;;
TRUNCATE TABLE `au_#__components`;;
INSERT INTO `au_#__components` (`id`, `name`, `link`, `menuid`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`, `iscore`, `params`, `enabled`) VALUES
(263, 'JomSocial Profile Types', 'option=com_xipt', 0, 0, 'option=com_xipt', 'JomSocial Profile Types', 'com_xipt', 0, 'components/com_xipt/images/icon-profiletypes.gif', 0, 'show_ptype_during_reg=1\nallow_user_to_change_ptype_after_reg=0\ndefaultProfiletypeID=1\njspt_show_radio=1\nallow_templatechange=0\naec_integrate=0\naec_message=b\njspt_restrict_reg_check=1\njspt_prevent_username=moderator, admin, support, owner, employee\njspt_allowed_email=\njspt_prevent_email=\n', 1);;

TRUNCATE TABLE  `#__community_fields` ;;
INSERT INTO `#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`) VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basic information for user', 1, 1, 1, 1, '', ''),
(2, 'select', 2, 1, 10, 100, 'Gender', 'Select gender', 1, 1, 1, 1, 'Male\nFemale', 'FIELD_GENDER'),
(3, 'date', 3, 1, 10, 100, 'Birthday', 'Enter your date of birth so other users can know when to wish you happy birthday ', 1, 1, 1, 1, '', 'FIELD_BIRTHDAY'),
(4, 'text', 4, 1, 5, 250, 'Hometown', 'Hometown', 1, 1, 1, 1, '', 'FIELD_HOMETOWN'),
(5, 'textarea', 5, 1, 1, 800, 'About me', 'Tell us more about yourself', 1, 1, 1, 1, '', 'FIELD_ABOUTME'),
(6, 'group', 6, 1, 10, 100, 'Contact Information', 'Specify your contact details', 1, 1, 1, 1, '', ''),
(7, 'text', 7, 1, 10, 100, 'Mobile phone', 'Mobile carrier number that other users can contact you.', 1, 0, 1, 1, '', 'FIELD_MOBILE'),
(8, 'text', 8, 1, 10, 100, 'Land phone', 'Contact number that other users can contact you.', 1, 0, 1, 1, '', 'FIELD_LANDPHONE'),
(9, 'textarea', 9, 1, 10, 100, 'Address', 'Address', 1, 1, 1, 1, '', 'FIELD_ADDRESS'),
(10, 'text', 10, 1, 10, 100, 'State', 'State', 1, 1, 1, 1, '', 'FIELD_STATE'),
(11, 'text', 11, 1, 10, 100, 'City / Town', 'City / Town', 1, 1, 1, 1, '', 'FIELD_CITY'),
(12, 'select', 12, 1, 10, 100, 'Country', 'Country', 1, 1, 1, 1, 'Afghanistan\nAlbania\nAlgeria\nAmerican Samoa\nAndorra\nAngola\nAnguilla\nAntarctica\nAntigua and Barbuda\nArgentina\nArmenia\nAruba\nAustralia\nAustria\nAzerbaijan\nBahamas\nBahrain\nBangladesh\nBarbados\nBelarus\nBelgium\nBelize\nBenin\nBermuda\nBhutan\nBolivia\nBosnia and Herzegovina\nBotswana\nBouvet Island\nBrazil\nBritish Indian Ocean Territory\nBrunei Darussalam\nBulgaria\nBurkina Faso\nBurundi\nCambodia\nCameroon\nCanada\nCape Verde\nCayman Islands\nCentral African Republic\nChad\nChile\nChina\nChristmas Island\nCocos (Keeling) Islands\nColombia\nComoros\nCongo\nCook Islands\nCosta Rica\nCote D''Ivoire (Ivory Coast)\nCroatia (Hrvatska)\nCuba\nCyprus\nCzechoslovakia (former)\nCzech Republic\nDenmark\nDjibouti\nDominica\nDominican Republic\nEast Timor\nEcuador\nEgypt\nEl Salvador\nEquatorial Guinea\nEritrea\nEstonia\nEthiopia\nFalkland Islands (Malvinas)\nFaroe Islands\nFiji\nFinland\nFrance\nFrance, Metropolitan\nFrench Guiana\nFrench Polynesia\nFrench Southern Territories\nGabon\nGambia\nGeorgia\nGermany\nGhana\nGibraltar\nGreat Britain (UK)\nGreece\nGreenland\nGrenada\nGuadeloupe\nGuam\nGuatemala\nGuinea\nGuinea-Bissau\nGuyana\nHaiti\nHeard and McDonald Islands\nHonduras\nHong Kong\nHungary\nIceland\nIndia\nIndonesia\nIran\nIraq\nIreland\nIsrael\nItaly\nJamaica\nJapan\nJordan\nKazakhstan\nKenya\nKiribati\nKorea, North\nSouth Korea\nKuwait\nKyrgyzstan\nLaos\nLatvia\nLebanon\nLesotho\nLiberia\nLibya\nLiechtenstein\nLithuania\nLuxembourg\nMacau\nMacedonia\nMadagascar\nMalawi\nMalaysia\nMaldives\nMali\nMalta\nMarshall Islands\nMartinique\nMauritania\nMauritius\nMayotte\nMexico\nMicronesia\nMoldova\nMonaco\nMongolia\nMontserrat\nMorocco\nMozambique\nMyanmar\nNamibia\nNauru\nNepal\nNetherlands\nNetherlands Antilles\nNeutral Zone\nNew Caledonia\nNew Zealand\nNicaragua\nNiger\nNigeria\nNiue\nNorfolk Island\nNorthern Mariana Islands\nNorway\nOman\nPakistan\nPalau\nPanama\nPapua New Guinea\nParaguay\nPeru\nPhilippines\nPitcairn\nPoland\nPortugal\nPuerto Rico\nQatar\nReunion\nRomania\nRussian Federation\nRwanda\nSaint Kitts and Nevis\nSaint Lucia\nSaint Vincent and the Grenadines\nSamoa\nSan Marino\nSao Tome and Principe\nSaudi Arabia\nSenegal\nSeychelles\nS. Georgia and S. Sandwich Isls.\nSierra Leone\nSingapore\nSlovak Republic\nSlovenia\nSolomon Islands\nSomalia\nSouth Africa\nSpain\nSri Lanka\nSt. Helena\nSt. Pierre and Miquelon\nSudan\nSuriname\nSvalbard and Jan Mayen Islands\nSwaziland\nSweden\nSwitzerland\nSyria\nTaiwan\nTajikistan\nTanzania\nThailand\nTogo\nTokelau\nTonga\nTrinidad and Tobago\nTunisia\nTurkey\nTurkmenistan\nTurks and Caicos Islands\nTuvalu\nUganda\nUkraine\nUnited Arab Emirates\nUnited Kingdom\nUnited States\nUruguay\nUS Minor Outlying Islands\nUSSR (former)\nUzbekistan\nVanuatu\nVatican City State (Holy Sea)\nVenezuela\nViet Nam\nVirgin Islands (British)\nVirgin Islands (U.S.)\nWallis and Futuna Islands\nWestern Sahara\nYemen\nYugoslavia\nZaire\nZambia\nZimbabwe', 'FIELD_COUNTRY'),
(13, 'text', 13, 1, 10, 100, 'Website', 'Website', 1, 1, 1, 1, '', 'FIELD_WEBSITE'),
(14, 'group', 14, 1, 10, 100, 'Education', 'Educations', 1, 1, 1, 1, '', ''),
(15, 'text', 15, 1, 10, 200, 'College / University', 'College / University', 1, 1, 1, 1, '', 'FIELD_COLLEGE'),
(16, 'text', 16, 1, 5, 100, 'Graduation Year', 'Graduation year', 1, 1, 1, 1, '', 'FIELD_GRADUATION'),
(17, 'profiletypes', 17, 1, 5, 100, 'Profiletype', 'Profiletypes', 1, 1, 1, 1, '', 'FIELD_PT');;

CREATE TABLE IF NOT EXISTS `#__community_myapplication` (  
		`id` int(10) NOT NULL AUTO_INCREMENT,
		`applicationid` int(10) NOT NULL DEFAULT 0, 
		`profiletype` int(10) NOT NULL DEFAULT 0, 
		PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;;

CREATE TABLE IF NOT EXISTS `#__community_jsptacl` (
  `id` int(31) NOT NULL auto_increment,
  `pid` int(31) NOT NULL,
  `rulename` varchar(250) NOT NULL,
  `feature` varchar(128) NOT NULL,
  `taskcount` int(31) NOT NULL,
  `redirecturl` varchar(250) NOT NULL default 'index.php?option=com_community',
  `message` varchar(250) NOT NULL default 'You are not allowed to access this resource',
  `published` tinyint(1) NOT NULL,
  `otherpid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;;

TRUNCATE TABLE `#__community_jsptacl`;;
INSERT INTO `#__community_jsptacl` (`id`, `pid`, `rulename`, `feature`, `taskcount`, `redirecturl`, `message`, `published`, `otherpid`) VALUES
(1, 2, 'PT1 ', 'aclFeatureAddPhotos', 35, 'index.php?option=com_community', 'DO NOT ADD PHOTOS', 1, 0),
(2, 2, 'PT2', 'aclFeatureWriteMessages', 10, 'index.php?option=com_community', 'DO NOT MORE MESSAGE', 1, 0);;


CREATE TABLE IF NOT EXISTS `#__community_jspt_aec` (
  `id` int(11) NOT NULL auto_increment,
  `planid` int(11) NOT NULL,
  `profiletype` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;;

TRUNCATE TABLE `#__community_jspt_aec`;;

CREATE TABLE IF NOT EXISTS `#__community_profiletypefields` (
  `id` int(10) NOT NULL auto_increment,
  `fid` int(10) NOT NULL default '0',
  `pid` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;;

TRUNCATE TABLE `#__community_profiletypefields`;;
INSERT INTO `#__community_profiletypefields` (`id`, `fid`, `pid`) VALUES
(1, 1, 0),
(17, 2, 1),
(18, 3, 2),
(19, 4, 3),
(5, 5, 0),
(6, 6, 0),
(7, 7, 0),
(8, 8, 0),
(9, 9, 0),
(10, 10, 0),
(11, 11, 0),
(12, 12, 0),
(13, 13, 0),
(14, 14, 0),
(15, 15, 0),
(16, 16, 0);;


CREATE TABLE IF NOT EXISTS `#__community_profiletypes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `ordering` int(10) default NULL,
  `published` tinyint(1) NOT NULL default '1',
  `tip` text NOT NULL,
  `privacy` varchar(20) NOT NULL default 'friends',
  `template` varchar(50) NOT NULL default 'default',
  `jusertype` varchar(50) NOT NULL default 'Registered',
  `avatar` varchar(250) NOT NULL default 'components/com_community/assets/default.jpg',
  `approve` tinyint(1) NOT NULL default '0',
  `allowt` tinyint(1) NOT NULL default '0',
  `group` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;;

TRUNCATE TABLE `#__community_profiletypes`;;
INSERT INTO `#__community_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`) VALUES
(1, 'PT1', 0, 1, 'PT1', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0),
(2, 'PT2', 1, 1, 'PT2', 'members', 'blackout', 'Editor', 'components/com_community/assets/group.jpg', 0, 0, 0),
(3, 'PT3', 2, 0, 'PT3', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 1, 1, 0);;


DROP TABLE IF EXISTS `#__community_register`;;
CREATE TABLE IF NOT EXISTS `#__community_register` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `token` varchar(200) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created` datetime default NULL,
  `ip` varchar(25) NOT NULL,
  `profiletypes` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;;


DROP TABLE IF EXISTS `#__community_users`;;
CREATE TABLE IF NOT EXISTS `#__community_users` (
  `userid` int(11) NOT NULL,
  `status` text NOT NULL,
  `points` int(11) NOT NULL,
  `posted_on` datetime NOT NULL,
  `avatar` text NOT NULL,
  `thumb` text NOT NULL,
  `invite` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  `view` int(11) NOT NULL default '0',
  `friendcount` int(11) NOT NULL default '0',
  `profiletype` int(10) NOT NULL default '0',
  `template` varchar(80) NOT NULL default 'NOT_DEFINED',
  PRIMARY KEY  (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;;


INSERT INTO `#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`, `profiletype`, `template`) VALUES
(62, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n', 0, 0, 0, 'NOT_DEFINED'),
(63, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n', 1, 0, 0, 'NOT_DEFINED'),
(64, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, 1, 'default'),
(65, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0, 2, 'blackout');;




/*Prepare au tables */
CREATE TABLE IF NOT EXISTS `au_#__community_fields` (
  `id` int(10) NOT NULL auto_increment,
  `type` varchar(255) NOT NULL,
  `ordering` int(11) default '0',
  `published` tinyint(1) NOT NULL default '0',
  `min` int(5) NOT NULL,
  `max` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tips` text NOT NULL,
  `visible` tinyint(1) default '0',
  `required` tinyint(1) default '0',
  `searchable` tinyint(1) default '1',
  `registration` tinyint(1) default '1',
  `options` text,
  `fieldcode` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fieldcode` (`fieldcode`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;;

TRUNCATE TABLE  `au_#__community_fields` ;;
INSERT INTO `au_#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`) VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basic information for user', 1, 1, 1, 1, '', ''),
(2, 'select', 2, 1, 10, 100, 'Gender', 'Select gender', 1, 1, 1, 1, 'Male\nFemale', 'FIELD_GENDER'),
(3, 'date', 3, 1, 10, 100, 'Birthday', 'Enter your date of birth so other users can know when to wish you happy birthday ', 1, 1, 1, 1, '', 'FIELD_BIRTHDAY'),
(4, 'text', 4, 1, 5, 250, 'Hometown', 'Hometown', 1, 1, 1, 1, '', 'FIELD_HOMETOWN'),
(5, 'textarea', 5, 1, 1, 800, 'About me', 'Tell us more about yourself', 1, 1, 1, 1, '', 'FIELD_ABOUTME'),
(6, 'group', 6, 1, 10, 100, 'Contact Information', 'Specify your contact details', 1, 1, 1, 1, '', ''),
(7, 'text', 7, 1, 10, 100, 'Mobile phone', 'Mobile carrier number that other users can contact you.', 1, 0, 1, 1, '', 'FIELD_MOBILE'),
(8, 'text', 8, 1, 10, 100, 'Land phone', 'Contact number that other users can contact you.', 1, 0, 1, 1, '', 'FIELD_LANDPHONE'),
(9, 'textarea', 9, 1, 10, 100, 'Address', 'Address', 1, 1, 1, 1, '', 'FIELD_ADDRESS'),
(10, 'text', 10, 1, 10, 100, 'State', 'State', 1, 1, 1, 1, '', 'FIELD_STATE'),
(11, 'text', 11, 1, 10, 100, 'City / Town', 'City / Town', 1, 1, 1, 1, '', 'FIELD_CITY'),
(12, 'select', 12, 1, 10, 100, 'Country', 'Country', 1, 1, 1, 1, 'Afghanistan\nAlbania\nAlgeria\nAmerican Samoa\nAndorra\nAngola\nAnguilla\nAntarctica\nAntigua and Barbuda\nArgentina\nArmenia\nAruba\nAustralia\nAustria\nAzerbaijan\nBahamas\nBahrain\nBangladesh\nBarbados\nBelarus\nBelgium\nBelize\nBenin\nBermuda\nBhutan\nBolivia\nBosnia and Herzegovina\nBotswana\nBouvet Island\nBrazil\nBritish Indian Ocean Territory\nBrunei Darussalam\nBulgaria\nBurkina Faso\nBurundi\nCambodia\nCameroon\nCanada\nCape Verde\nCayman Islands\nCentral African Republic\nChad\nChile\nChina\nChristmas Island\nCocos (Keeling) Islands\nColombia\nComoros\nCongo\nCook Islands\nCosta Rica\nCote D''Ivoire (Ivory Coast)\nCroatia (Hrvatska)\nCuba\nCyprus\nCzechoslovakia (former)\nCzech Republic\nDenmark\nDjibouti\nDominica\nDominican Republic\nEast Timor\nEcuador\nEgypt\nEl Salvador\nEquatorial Guinea\nEritrea\nEstonia\nEthiopia\nFalkland Islands (Malvinas)\nFaroe Islands\nFiji\nFinland\nFrance\nFrance, Metropolitan\nFrench Guiana\nFrench Polynesia\nFrench Southern Territories\nGabon\nGambia\nGeorgia\nGermany\nGhana\nGibraltar\nGreat Britain (UK)\nGreece\nGreenland\nGrenada\nGuadeloupe\nGuam\nGuatemala\nGuinea\nGuinea-Bissau\nGuyana\nHaiti\nHeard and McDonald Islands\nHonduras\nHong Kong\nHungary\nIceland\nIndia\nIndonesia\nIran\nIraq\nIreland\nIsrael\nItaly\nJamaica\nJapan\nJordan\nKazakhstan\nKenya\nKiribati\nKorea, North\nSouth Korea\nKuwait\nKyrgyzstan\nLaos\nLatvia\nLebanon\nLesotho\nLiberia\nLibya\nLiechtenstein\nLithuania\nLuxembourg\nMacau\nMacedonia\nMadagascar\nMalawi\nMalaysia\nMaldives\nMali\nMalta\nMarshall Islands\nMartinique\nMauritania\nMauritius\nMayotte\nMexico\nMicronesia\nMoldova\nMonaco\nMongolia\nMontserrat\nMorocco\nMozambique\nMyanmar\nNamibia\nNauru\nNepal\nNetherlands\nNetherlands Antilles\nNeutral Zone\nNew Caledonia\nNew Zealand\nNicaragua\nNiger\nNigeria\nNiue\nNorfolk Island\nNorthern Mariana Islands\nNorway\nOman\nPakistan\nPalau\nPanama\nPapua New Guinea\nParaguay\nPeru\nPhilippines\nPitcairn\nPoland\nPortugal\nPuerto Rico\nQatar\nReunion\nRomania\nRussian Federation\nRwanda\nSaint Kitts and Nevis\nSaint Lucia\nSaint Vincent and the Grenadines\nSamoa\nSan Marino\nSao Tome and Principe\nSaudi Arabia\nSenegal\nSeychelles\nS. Georgia and S. Sandwich Isls.\nSierra Leone\nSingapore\nSlovak Republic\nSlovenia\nSolomon Islands\nSomalia\nSouth Africa\nSpain\nSri Lanka\nSt. Helena\nSt. Pierre and Miquelon\nSudan\nSuriname\nSvalbard and Jan Mayen Islands\nSwaziland\nSweden\nSwitzerland\nSyria\nTaiwan\nTajikistan\nTanzania\nThailand\nTogo\nTokelau\nTonga\nTrinidad and Tobago\nTunisia\nTurkey\nTurkmenistan\nTurks and Caicos Islands\nTuvalu\nUganda\nUkraine\nUnited Arab Emirates\nUnited Kingdom\nUnited States\nUruguay\nUS Minor Outlying Islands\nUSSR (former)\nUzbekistan\nVanuatu\nVatican City State (Holy Sea)\nVenezuela\nViet Nam\nVirgin Islands (British)\nVirgin Islands (U.S.)\nWallis and Futuna Islands\nWestern Sahara\nYemen\nYugoslavia\nZaire\nZambia\nZimbabwe', 'FIELD_COUNTRY'),
(13, 'text', 13, 1, 10, 100, 'Website', 'Website', 1, 1, 1, 1, '', 'FIELD_WEBSITE'),
(14, 'group', 14, 1, 10, 100, 'Education', 'Educations', 1, 1, 1, 1, '', ''),
(15, 'text', 15, 1, 10, 200, 'College / University', 'College / University', 1, 1, 1, 1, '', 'FIELD_COLLEGE'),
(16, 'text', 16, 1, 5, 100, 'Graduation Year', 'Graduation year', 1, 1, 1, 1, '', 'FIELD_GRADUATION');;


CREATE TABLE IF NOT EXISTS `au_#__community_register` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `token` varchar(200) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created` datetime default NULL,
  `ip` varchar(25) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;;

CREATE TABLE IF NOT EXISTS `au_#__community_users` (
  `userid` int(11) NOT NULL,
  `status` text NOT NULL,
  `points` int(11) NOT NULL,
  `posted_on` datetime NOT NULL,
  `avatar` text NOT NULL,
  `thumb` text NOT NULL,
  `invite` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  `view` int(11) NOT NULL default '0',
  `friendcount` int(11) NOT NULL default '0',
  PRIMARY KEY  (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;;

TRUNCATE TABLE  `au_#__community_users` ;;
INSERT INTO `au_#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`) VALUES
(62, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n', 0, 0),
(63, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n', 1, 0),
(64, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(65, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0);;


CREATE TABLE IF NOT EXISTS `au_#__xipt_aclrules` (
  `id` int(31) NOT NULL auto_increment,
  `rulename` varchar(250) NOT NULL,
  `aclname` varchar(128) NOT NULL,
  `coreparams` text NOT NULL,
  `aclparams` text NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;;


TRUNCATE TABLE  `au_#__xipt_aclrules`;;
INSERT INTO `au_#__xipt_aclrules` (`id`, `rulename`, `aclname`, `coreparams`, `aclparams`, `published`) VALUES
(1, 'PT1 ', 'addphotos', 'core_profiletype=2\ncore_display_message=DO NOT ADD PHOTOS\ncore_redirect_url=index.php?option=com_community\n\n', 'addphotos_limit=35\n\n', 1),
(2, 'PT2', 'writemessages', 'core_profiletype=2\ncore_display_message=DO NOT MORE MESSAGE\ncore_redirect_url=index.php?option=com_community\n\n', 'writemessage_limit=10\nother_profiletype=0\n\n', 1);;

CREATE TABLE IF NOT EXISTS `au_#__xipt_aec` (
  `id` int(11) NOT NULL auto_increment,
  `planid` int(11) NOT NULL,
  `profiletype` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  ;;


CREATE TABLE IF NOT EXISTS `au_#__xipt_applications` (
  `id` int(10) NOT NULL auto_increment,
  `applicationid` int(10) NOT NULL default '0',
  `profiletype` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;;

TRUNCATE TABLE  `au_#__xipt_applications`;;

CREATE TABLE IF NOT EXISTS `au_#__xipt_profilefields` (
  `id` int(10) NOT NULL auto_increment,
  `fid` int(10) NOT NULL default '0',
  `pid` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;;
TRUNCATE TABLE  `au_#__xipt_profilefields`;;
INSERT INTO `au_#__xipt_profilefields` (`id`, `fid`, `pid`) VALUES
(1, 2, 2),
(2, 2, 3),
(3, 3, 1),
(4, 3, 3),
(5, 4, 1),
(6, 4, 2);;



CREATE TABLE IF NOT EXISTS `au_#__xipt_profiletypes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `ordering` int(10) default NULL,
  `published` tinyint(1) NOT NULL default '1',
  `tip` text NOT NULL,
  `privacy` varchar(20) NOT NULL default 'friends',
  `template` varchar(50) NOT NULL default 'default',
  `jusertype` varchar(50) NOT NULL default 'Registered',
  `avatar` varchar(250) NOT NULL default 'components/com_community/assets/default.jpg',
  `approve` tinyint(1) NOT NULL default '0',
  `allowt` tinyint(1) NOT NULL default '0',
  `group` int(11) NOT NULL default '0',
  `watermark` varchar(250) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;;

TRUNCATE TABLE  `au_#__xipt_profiletypes` ;;
INSERT INTO `au_#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`) VALUES
(1, 'PT1', 0, 1, 'PT1', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', ''),
(2, 'PT2', 1, 1, 'PT2', 'members', 'blackout', 'Editor', 'components/com_community/assets/group.jpg', 0, 0, 0, '', ''),
(3, 'PT3', 2, 0, 'PT3', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 1, 1, 0, '', '');;

CREATE TABLE IF NOT EXISTS `au_#__xipt_users` (
  `userid` int(11) NOT NULL,
  `profiletype` int(10) NOT NULL default '0',
  `template` varchar(80) NOT NULL default 'NOT_DEFINED',
  PRIMARY KEY  (`userid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;;

TRUNCATE TABLE `au_#__xipt_users` ;;
INSERT INTO `au_#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 0, 'NOT_DEFINED'),
(63, 0, 'NOT_DEFINED'),
(64, 1, 'default'),
(65, 2, 'blackout');;
