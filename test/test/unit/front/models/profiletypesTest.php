<?php

//require_once(JPATH_ROOT.DS.'components'.DS.'com_xiec'.DS.'libraries'.DS.'base'.DS.'table.php');

class XiptProfiletypesModelTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testLoadParams()
	{
		$model 	= new XiptModelProfiletypes();
		$this->assertEquals($model->loadParams(1), CFactory::getConfig());
		
		$str= "enableterms=1\nregistrationTerms=\nrecaptcha=0\nrecaptchapublic=\nrecaptchaprivate=\nrecaptchatheme=red\nrecaptchalang=en\nenablereporting=1\nmaxReport=50\nnotifyMaxReport=\nenableguestreporting=0\npredefinedreports=Spamming / Advertisement\\nProfanity / Inappropriate content.\\nAbusive.\nprivacyprofile=0\nprivacyfriends=0\nprivacyphotos=0\nprivacyemail=1\nprivacyapps=1\nprivacywallcomment=0\nenablepm=1\npmperday=30\nwallediting=1\nlockprofilewalls=1\nlockvideoswalls=1\nlockgroupwalls=1\nlockeventwalls=1\nenablegroups=0\nmoderategroupcreation=1\ncreategroups=1\ngroupcreatelimit=300\ngroupphotouploadlimit=500\ngroupvideouploadlimit=500\ncreatediscussion=1\ngroupphotos=0\ngroupvideos=0\ngroupdiscussnotification=0\ngroupdiscussionmaxlist=5\nenablevideos=0\nenableprofilevideo=0\nenablevideosupload=1\nvideouploadlimit=500\ndeleteoriginalvideos=0\nvideofolder=images\nmaxvideouploadsize=8\nffmpegPath=\nflvtool2=\nqscale=11\nvideosSize=400x300\ncustomCommandForVideo=\nenablevideopseudostream=0\nvideodebug=1\nenablephotos=1\nphotouploadlimit=500\nmaxuploadsize=8\ndeleteoriginalphotos=0\nmagickPath=\nflashuploader=0\nautoalbumcover=1\nenablemyblogicon=0\n\n";
		$compareParams = new JParameter($str);		
		$this->assertEquals($model->loadParams(2), $compareParams );
	}
	
	function testSaveParams()
	{
		$model 	= new XiptModelProfiletypes();
		$postData = array('enableterms'=>1,'registrationTerms'=>'','recaptcha'=>0,
						'recaptchapublic'=>'','recaptchaprivate'=>'','recaptchatheme'=>'red',
						'recaptchalang'=>'en','enablereporting'=>1,'maxReport'=>50,'notifyMaxReport'=>'',
						'enableguestreporting'=>0,'predefinedreports'=>"Spamming / Advertisement\\nProfanity / Inappropriate content.\\nAbusive.",
						'privacyprofile'=>0,'privacyfriends'=>0,'option'=>'com_xipt','task'=>'registration');
		
		$this->assertFalse($model->saveParams('',1));
		$model->saveParams($postData,2);
		
		$this->_DBO->addTable('#__xipt_profiletypes');
	}	
	
	function testResetUserAvatar()
	{
		$model 	= new XiptModelProfiletypes();
		$model->resetUserAvatar(1,'components/com_community/assets/avatar1.jpg','components/com_community/assets/default.jpg','components/com_community/assets/avatar1_thumb.jpg');
		$model->resetUserAvatar(2,'components/com_community/assets/avatar2.jpg','components/com_community/assets/default.jpg','components/com_community/assets/avatar2_thumb.jpg');
		$model->resetUserAvatar(2,'components/com_community/assets/avatar22.jpg','components/com_community/assets/default1.jpg','components/com_community/assets/avatar22_thumb.jpg');
		
		$this->_DBO->addTable('#__community_users');
	}
}