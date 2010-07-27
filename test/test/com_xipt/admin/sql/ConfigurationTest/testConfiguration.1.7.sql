TRUNCATE TABLE `#__xipt_profiletypes`;;
CREATE TABLE IF NOT EXISTS `au_#__xipt_profiletypes` SELECT * FROM `#__xipt_profiletypes`;;


INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`) VALUES
(1, 'PROFILETYPE-1', NULL, 1, '', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', '', 1),
(2, 'PROFILETYPE-2', NULL, 1, '', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', 'enableterms=0\nregistrationTerms=\nrecaptcha=0\nrecaptchapublic=\nrecaptchaprivate=\nrecaptchatheme=red\nrecaptchalang=en\nenablereporting=0\nmaxReport=50\nnotifyMaxReport=\nenableguestreporting=0\npredefinedreports=Spamming / Advertisement\nprivacyprofile=0\nprivacyfriends=0\nprivacyphotos=0\nprivacyemail=1\nprivacyapps=1\nprivacywallcomment=0\nenablepm=1\npmperday=30\nwallediting=1\nlockprofilewalls=1\nlockvideoswalls=1\nlockgroupwalls=1\nenablegroups=0\nmoderategroupcreation=0\ncreategroups=1\ngroupcreatelimit=300\ngroupphotouploadlimit=500\ngroupvideouploadlimit=500\ncreatediscussion=1\ngroupphotos=1\ngroupvideos=1\ngroupdiscussnotification=0\ngroupdiscussionmaxlist=5\nenablevideos=0\nenablevideosupload=0\nvideouploadlimit=500\ndeleteoriginalvideos=0\nvideofolder=images\nmaxvideouploadsize=8\nffmpegPath=\nflvtool2=\nqscale=11\nvideosSize=400x300\ncustomCommandForVideo=\nenablevideopseudostream=0\nvideodebug=0\nfolderpermissionsvideo=0755\nenablephotos=0\nphotouploadlimit=500\nmaxuploadsize=8\ndeleteoriginalphotos=0\nmagickPath=\nflashuploader=0\nfolderpermissionsphoto=0755\nautoalbumcover=1\nenablemyblogicon=0\n\n', '', 1),
(3, 'PROFILETYPE-3', NULL, 1, '', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', 'enableterms=0\nregistrationTerms=\nrecaptcha=0\nrecaptchapublic=\nrecaptchaprivate=\nrecaptchatheme=red\nrecaptchalang=en\nenablereporting=1\nmaxReport=50\nnotifyMaxReport=\nenableguestreporting=0\npredefinedreports=Spamming / Advertisement\nprivacyprofile=0\nprivacyfriends=0\nprivacyphotos=0\nprivacyemail=1\nprivacyapps=1\nprivacywallcomment=0\nenablepm=1\npmperday=30\nwallediting=1\nlockprofilewalls=1\nlockvideoswalls=1\nlockgroupwalls=1\nenablegroups=1\nmoderategroupcreation=0\ncreategroups=1\ngroupcreatelimit=300\ngroupphotouploadlimit=500\ngroupvideouploadlimit=500\ncreatediscussion=1\ngroupphotos=1\ngroupvideos=1\ngroupdiscussnotification=0\ngroupdiscussionmaxlist=5\nenablevideos=1\nenablevideosupload=0\nvideouploadlimit=500\ndeleteoriginalvideos=0\nvideofolder=images\nmaxvideouploadsize=8\nffmpegPath=\nflvtool2=\nqscale=11\nvideosSize=400x300\ncustomCommandForVideo=\nenablevideopseudostream=0\nvideodebug=0\nfolderpermissionsvideo=0755\nenablephotos=1\nphotouploadlimit=500\nmaxuploadsize=8\ndeleteoriginalphotos=0\nmagickPath=\nflashuploader=0\nfolderpermissionsphoto=0755\nautoalbumcover=1\nenablemyblogicon=0\n\n', '', 1),
(4, 'PROFILETYPE-4', NULL, 1, '', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', '', 1),
(5, 'PROFILETYPE-5', NULL, 1, '', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', '', 1);;


CREATE TABLE IF NOT EXISTS `au_#__xipt_profiletypes` SELECT * FROM `#__xipt_profiletypes`;;
TRUNCATE TABLE `au_#__xipt_profiletypes`;;


INSERT INTO `au_#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`) VALUES
(1, 'PROFILETYPE-1', NULL, 1, '', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', '', 1),
(2, 'PROFILETYPE-2', NULL, 1, '', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', 'enableterms=0\nregistrationTerms=\nrecaptcha=0\nrecaptchapublic=\nrecaptchaprivate=\nrecaptchatheme=red\nrecaptchalang=en\nenablereporting=0\nmaxReport=50\nnotifyMaxReport=\nenableguestreporting=0\npredefinedreports=Spamming / Advertisement\nprivacyprofile=0\nprivacyfriends=0\nprivacyphotos=0\nprivacyemail=1\nprivacyapps=1\nprivacywallcomment=0\nenablepm=1\npmperday=30\nwallediting=1\nlockprofilewalls=1\nlockvideoswalls=1\nlockgroupwalls=1\nenablegroups=0\nmoderategroupcreation=0\ncreategroups=1\ngroupcreatelimit=300\ngroupphotouploadlimit=500\ngroupvideouploadlimit=500\ncreatediscussion=1\ngroupphotos=1\ngroupvideos=1\ngroupdiscussnotification=0\ngroupdiscussionmaxlist=5\nenablevideos=0\nenablevideosupload=0\nvideouploadlimit=500\ndeleteoriginalvideos=0\nvideofolder=images\nmaxvideouploadsize=8\nffmpegPath=\nflvtool2=\nqscale=11\nvideosSize=400x300\ncustomCommandForVideo=\nenablevideopseudostream=0\nvideodebug=0\nfolderpermissionsvideo=0755\nenablephotos=0\nphotouploadlimit=500\nmaxuploadsize=8\ndeleteoriginalphotos=0\nmagickPath=\nflashuploader=0\nfolderpermissionsphoto=0755\nautoalbumcover=1\nenablemyblogicon=0\n\n', '', 1),
(3, 'PROFILETYPE-3', NULL, 1, '', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', 'enableterms=0\nregistrationTerms=\nrecaptcha=0\nrecaptchapublic=\nrecaptchaprivate=\nrecaptchatheme=red\nrecaptchalang=en\nenablereporting=1\nmaxReport=50\nnotifyMaxReport=\nenableguestreporting=0\npredefinedreports=Spamming / Advertisement\nprivacyprofile=0\nprivacyfriends=0\nprivacyphotos=0\nprivacyemail=1\nprivacyapps=1\nprivacywallcomment=0\nenablepm=1\npmperday=30\nwallediting=1\nlockprofilewalls=1\nlockvideoswalls=1\nlockgroupwalls=1\nenablegroups=1\nmoderategroupcreation=0\ncreategroups=1\ngroupcreatelimit=300\ngroupphotouploadlimit=500\ngroupvideouploadlimit=500\ncreatediscussion=1\ngroupphotos=1\ngroupvideos=1\ngroupdiscussnotification=0\ngroupdiscussionmaxlist=5\nenablevideos=1\nenablevideosupload=0\nvideouploadlimit=500\ndeleteoriginalvideos=0\nvideofolder=images\nmaxvideouploadsize=8\nffmpegPath=\nflvtool2=\nqscale=11\nvideosSize=400x300\ncustomCommandForVideo=\nenablevideopseudostream=0\nvideodebug=0\nfolderpermissionsvideo=0755\nenablephotos=1\nphotouploadlimit=500\nmaxuploadsize=8\ndeleteoriginalphotos=0\nmagickPath=\nflashuploader=0\nfolderpermissionsphoto=0755\nautoalbumcover=1\nenablemyblogicon=0\n\n', '', 1),
(4, 'PROFILETYPE-4', NULL, 1, '', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', '', 1),
(5, 'PROFILETYPE-5', NULL, 1, '', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '', '', 1);;

