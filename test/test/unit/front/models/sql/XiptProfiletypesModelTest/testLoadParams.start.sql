DROP TABLE IF EXISTS `bk_#__xipt_profiletypes`;;
CREATE TABLE IF NOT EXISTS `bk_#__xipt_profiletypes` SELECT * FROM `#__xipt_profiletypes`;;
TRUNCATE TABLE `#__xipt_profiletypes`;;

INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`, `config`) VALUES
(1, 'Profiletype1', 0, 1, '', 'privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, '0', 'images/profiletype/watermark_1.png', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=1\n\n', 1, 'jspt_restrict_reg_check=0\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(2, 'Profiletype2', 0, 1, '', 'privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, '0', 'images/profiletype/watermark_2.png', 'enableterms=1\nregistrationTerms=\nrecaptcha=0\nrecaptchapublic=\nrecaptchaprivate=\nrecaptchatheme=red\nrecaptchalang=en\nenablereporting=1\nmaxReport=50\nnotifyMaxReport=\nenableguestreporting=0\npredefinedreports=Spamming / Advertisement\\nProfanity / Inappropriate content.\\nAbusive.\nprivacyprofile=0\nprivacyfriends=0\nprivacyphotos=0\nprivacyemail=1\nprivacyapps=1\nprivacywallcomment=0\nenablepm=1\npmperday=30\nwallediting=1\nlockprofilewalls=1\nlockvideoswalls=1\nlockgroupwalls=1\nlockeventwalls=1\nenablegroups=0\nmoderategroupcreation=1\ncreategroups=1\ngroupcreatelimit=300\ngroupphotouploadlimit=500\ngroupvideouploadlimit=500\ncreatediscussion=1\ngroupphotos=0\ngroupvideos=0\ngroupdiscussnotification=0\ngroupdiscussionmaxlist=5\nenablevideos=0\nenableprofilevideo=0\nenablevideosupload=1\nvideouploadlimit=500\ndeleteoriginalvideos=0\nvideofolder=images\nmaxvideouploadsize=8\nffmpegPath=\nflvtool2=\nqscale=11\nvideosSize=400x300\ncustomCommandForVideo=\nenablevideopseudostream=0\nvideodebug=1\nenablephotos=1\nphotouploadlimit=500\nmaxuploadsize=8\ndeleteoriginalphotos=0\nmagickPath=\nflashuploader=0\nautoalbumcover=1\nenablemyblogicon=0\n\n', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=2\n\n', 1, 'jspt_restrict_reg_check=0\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=\njspt_prevent_email=\n\n');;


DROP TABLE IF EXISTS `bk_#__community_config`;;
CREATE TABLE IF NOT EXISTS `bk_#__community_config` SELECT * FROM `#__community_config`;;
TRUNCATE TABLE `#__community_config`;;

INSERT INTO `#__community_config` (`name`, `params`) VALUES
('dbversion', '7'),
('config', 'enablegroups=1\nmoderategroupcreation=0\ncreategroups=1\ncreatediscussion=1\ngroupphotos=1\ngroupvideos=1\npoint0=50\npoint1=50\npoint2=100\npoint3=200\npoint4=350\npoint5=600\nlockprofilewalls=1\nlockgroupwalls=1\nlockvideoswalls=1\nenablephotos=1\nenablepm=1\nnotifyby=1\nsitename=JSPT 2.0 Development\nprivacyemail=1\nprivacyemailpm=1\nprivacyapps=1\nsef=feature\ndisplayname=name\ntemplate=default\ntask=saveconfig\nview=configuration\noption=com_community\nprivacyprofile=0\nprivacyfriends=0\nprivacyphotos=0\nphotomaxwidth=600\noriginalphotopath=originalphotos\narchive_activity_days= 21\ndisplayhome=1\nmaxacitivities=20\nshowactivityavatar=1\nenablereporting=1\nmaxReport=50\nenablecustomviewcss=0\nfrontpageusers=20\njsnetwork_path=http://updates.jomsocial.com/index.php?option=com_jsnetwork&view=submit&task=update\ngroupnewseditor=1\nimageengine=auto\ndbversion=1.1\npredefinedreports=Spamming / Advertisement\\nProfanity / Inappropriate content.\\nAbusive.\nactivitiestimeformat=%I:%M %p\nactivitiesdayformat=%b %d\nflashuploader=0\nmaxuploadsize=8\nenablevideos=1\nenablevideosupload=0\nvideosSize=400x300\nvideosThumbSize=112x84\nfrontpagevideos=3\ndeleteoriginalvideos=0\nvideofolder=images\nmaxvideouploadsize=8\nvideodebug=0\nguestsearch=0\nfloodLimit=60\npmperday=30\nsendemailonpageload=0\nshowlatestvideos=1\nshowlatestgroups=1\nshowlatestphotos=1\nshowactivitystream=1\nshowlatestmembers=1\ndaylightsavingoffset=0\nsingularnumber=1\nusepackedjavascript=1\nfolderpermissionsphoto=0755\nfolderpermissionsvideo=0755\niphoneactivitiesapps=photos,groups,profile,walls\nsessionexpiryperiod=600\nactivationresetpassword=0\ngroupdiscussnotification=0\ntagboxwidth=150\ntagboxheight=150\nfrontpagephotos=20\nautoalbumcover=1\nenablesharethis=1\nenablekarma=1\nprivacywallcomment=0\nphotouploadlimit=500\nvideouploadlimit=500\ngroupcreatelimit=300\ngroupphotouploadlimit=500\ngroupvideouploadlimit=500\nphotospath=/var/www/jspt3642/images\n\n');

