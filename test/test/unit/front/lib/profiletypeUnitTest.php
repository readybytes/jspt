<?php
class ProfiletypeUnitTest extends XiUnitTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
	
  function testDefaultProfiletype()
  {		
  	
	$filter['defaultProfiletypeID']=1;
	$this->changeJSPTConfig($filter);
	$this->resetCacheData();
    $this->assertEquals(XiptLibProfiletypes::getDefaultProfiletype(),1);
    
    $filter['defaultProfiletypeID']=5;
	$this->changeJSPTConfig($filter);
	$this->resetCacheData();
    $this->assertEquals(XiptLibProfiletypes::getDefaultProfiletype(),5);    
  }
  
  function testProfiletypeName()
  {		
  
	$name = XiptLibProfiletypes::getProfiletypeName(1);
	$this->assertEquals($name,'PROFILETYPE-1');
	
	$name = XiptLibProfiletypes::getProfiletypeName(2);
	$this->assertEquals($name,'PROFILETYPE-2');
	
	$name = XiptLibProfiletypes::getProfiletypeName(3);
	$this->assertEquals($name,'PROFILETYPE-3');
	
	$name = XiptLibProfiletypes::getProfiletypeName(4);
	$this->assertEquals($name,'PROFILETYPE-4');
	
	$name = XiptLibProfiletypes::getProfiletypeName(5);
	$this->assertEquals($name,'PROFILETYPE-5');
	
	$name = XiptLibProfiletypes::getProfiletypeName(6);
	$this->assertEquals($name,'PROFILETYPE-6');
	
	$name = XiptLibProfiletypes::getProfiletypeName(7);
	$this->assertEquals($name,'PROFILETYPE-7');
	
	$name = XiptLibProfiletypes::getProfiletypeName(8);
	$this->assertEquals($name,'PROFILETYPE-8');
	
	$name = XiptLibProfiletypes::getProfiletypeName(9);
	$this->assertEquals($name,'PROFILETYPE-9');
	
	$name = XiptLibProfiletypes::getProfiletypeName(10);
	$this->assertEquals($name,'PROFILETYPE-10');
	
//	$name = XiptLibProfiletypes::getProfiletypeName(0);
//	$this->assertEquals($name,'PROFILETYPE-2');
	       
  }
  function testProfiletypeArray()
  {
  	
  	//this will return array of stdClass objects. 
  	$array = XiptLibProfiletypes::getProfiletypeArray();
  	
  	$obj1 = new stdClass();
  	$obj1->id = 2;
  	$obj1->name = 'PROFILETYPE-2';
  	$obj1->ordering = 1;
  	$obj1->published = 1;
  	$obj1->tip = 'PROFILETYPE-TWO-TIP';
  	$obj1->privacy = 'friends';
  	$obj1->template = 'blueface';
  	$obj1->jusertype = 'Editor';
  	$obj1->avatar = 'components/com_community/assets/group.jpg';
  	$obj1->approve = 0;
  	$obj1->allowt = 0;
  	$obj1->group = 0;
  	$obj1->watermark = '';
  	$obj1->params = '';
  	$obj1->watermarkparams = '';
  	$obj1->visible = 1;
  	$obj1->config = '';
  	
  	
  	$obj2 = new stdClass();
  	$obj2->id = 1;
  	$obj2->name = 'PROFILETYPE-1';
  	$obj2->ordering = 2;
  	$obj2->published = 1;
  	$obj2->tip = 'PROFILETYPE-ONE-TIP';
  	$obj2->privacy = 'public';
  	$obj2->template = 'default';
  	$obj2->jusertype = 'Registered';
  	$obj2->avatar = 'components/com_community/assets/default.jpg';
  	$obj2->approve = 0;
  	$obj2->allowt = 0;
  	$obj2->group = 1;
  	$obj2->watermark = '';
  	$obj2->params = '';
  	$obj2->watermarkparams = '';
  	$obj2->visible = 1;
  	$obj2->config = '';
  	
  	
  	$obj3 = new stdClass();
  	$obj3->id = 3;
  	$obj3->name = 'PROFILETYPE-3';
  	$obj3->ordering = 3;
  	$obj3->published = 1;
  	$obj3->tip = 'PROFILETYPE-THREE-TIP';
  	$obj3->privacy = 'members';
  	$obj3->template = 'blackout';
  	$obj3->jusertype = 'Publisher';
  	$obj3->avatar = 'components/com_community/assets/default.jpg';
  	$obj3->approve = 0;
  	$obj3->allowt = 0;
  	$obj3->group = 4;
  	$obj3->watermark = '';
  	$obj3->params = '';
  	$obj3->watermarkparams = '';
  	$obj3->visible = 1;
  	$obj3->config = '';
  	
  	
  	$obj4 = new stdClass();
  	$obj4->id = 4;
  	$obj4->name = 'PROFILETYPE-4';
  	$obj4->ordering = 4;
  	$obj4->published = 0;
  	$obj4->tip = 'PROFILETYPE-THREE-TIP';
  	$obj4->privacy = 'members';
  	$obj4->template = 'blackout';
  	$obj4->jusertype = 'Registered';
  	$obj4->avatar = 'components/com_community/assets/default.jpg';
  	$obj4->approve = 0;
  	$obj4->allowt = 0;
  	$obj4->group = 0;
  	$obj4->watermark = '';
  	$obj4->params = '';
  	$obj4->watermarkparams = '';
  	$obj4->visible = 1;
  	$obj4->config = '';
  	
  	
  	$result = array(2=>$obj1,1=>$obj2,3=>$obj3,4=>$obj4);
  	
  	$this->assertEquals($array,$result);
  }
  
  function testUserData()
  {
  	//this will return Profiletype of user.
  	$userData = XiptLibProfiletypes::getUserData(62);
  	$this->assertEquals($userData,1);
  	
  	//this will return template of user.
  	$userData = XiptLibProfiletypes::getUserData(62,'TEMPLATE');
  	$this->assertEquals($userData,'default');
  	
  	//this will return Profiletype of user.
  	$userData = XiptLibProfiletypes::getUserData(80);
  	$this->assertEquals($userData,2);
  	
  	//this will return template of user.
  	$userData = XiptLibProfiletypes::getUserData(80,'TEMPLATE');
  	$this->assertEquals($userData,'blueface');
  	
  	//this will return Profiletype of user.
  	$userData = XiptLibProfiletypes::getUserData(81);
  	$this->assertEquals($userData,3);
  	
  	//this will return template of user.
  	$userData = XiptLibProfiletypes::getUserData(81,'TEMPLATE');
  	$this->assertEquals($userData,'blackout');
  	
  	//this will return Profiletype of user.
  	$userData = XiptLibProfiletypes::getUserData(0);
  	$this->assertEquals($userData,2);
  	
  	//this will return template of user.
  	$userData = XiptLibProfiletypes::getUserData(0,'TEMPLATE');
  	$this->assertEquals($userData,'blueface');
  }
  
  function testProfiletypeData()
  {
  	//this will return Profiletype name.
  	$profileData = XiptLibProfiletypes::getProfiletypeData(1);
  	$this->assertEquals($profileData,'PROFILETYPE-1');
  	
  	//this will return Profiletype name.
  	//$profileData = XiptLibProfiletypes::getProfiletypeData(2,'privacy');
  	//$this->assertEquals($profileData,'friends');
  	
  	//this will return Profiletype name.
  	$profileData = XiptLibProfiletypes::getProfiletypeData(3,'template');
  	$this->assertEquals($profileData,'blackout');
  	
  	//this will return Profiletype name.
  	$profileData = XiptLibProfiletypes::getProfiletypeData(4,'jusertype');
  	$this->assertEquals($profileData,'Registered');
  	
  	//this will return Profiletype name.
  	$profileData = XiptLibProfiletypes::getProfiletypeData(1,'avatar');
  	$this->assertEquals($profileData,'components/com_community/assets/default.jpg');
  	
  	//this will return Profiletype name.
  	$profileData = XiptLibProfiletypes::getProfiletypeData(2,'watermark');
  	$this->assertEquals($profileData,'');
  	
  	//this will return Profiletype name.
  	$profileData = XiptLibProfiletypes::getProfiletypeData(3,'approve');
  	$this->assertEquals($profileData,0);
  	
  	//this will return Profiletype name.
  	$profileData = XiptLibProfiletypes::getProfiletypeData(4,'allowt');
  	$this->assertEquals($profileData,0);
  	
  	//this will return Profiletype name.
  	$profileData = XiptLibProfiletypes::getProfiletypeData(1,'group');
  	$this->assertEquals($profileData,1);
  	
  	//this will return Profiletype name.
  	$profileData = XiptLibProfiletypes::getProfiletypeData(10);
  	$this->assertEquals($profileData,'PROFILETYPE-10');
  	
  	//this will return Profiletype name.
  	$profileData = XiptLibProfiletypes::getProfiletypeData(10,'template');
  	$this->assertEquals($profileData,'default');
  }
  
  function testAllUser()
  {
  	//this will return userId of all users of Profiletype 1.
  	$userid = XiptLibProfiletypes::getAllUsers(1);
  	$result =array(62,85,82,79);
  	$this->assertEquals($userid,$result);
  	
	
  	//this will return userId of all users of Profiletype 2.
  	$userid = XiptLibProfiletypes::getAllUsers(2);
  	$result =array(86,83,80,99);
  	$this->assertEquals($userid,$result);
  	
  	//this will return userId of all users of Profiletype 3.
  	$userid = XiptLibProfiletypes::getAllUsers(3);
  	$result =array(87,84,81);
  	$this->assertEquals($userid,$result);
  	
  	//this will return userId of all users of Profiletype 4.
  	$userid = XiptLibProfiletypes::getAllUsers(4);
  	$result =array();
  	$this->assertEquals($userid,$result);
  	
  	//this will return userId of all users of Profiletype 10.
  	$userid = XiptLibProfiletypes::getAllUsers(10);
  	$result =array(89);
  	$this->assertEquals($userid,$result);
 
  }
  
    function testIsDefaultAvatarOfProfileType()
  	{
  		
  		$this->assertEquals(XiptLibProfiletypes::isDefaultAvatarOfProfileType('components/com_community/assets/default.jpg'),'components/com_community/assets/default.jpg');
  		
  		$this->assertEquals(XiptLibProfiletypes::isDefaultAvatarOfProfileType('components/com_community/assets/default.jpg',true),'components/com_community/assets/default.jpg');
  		
  		$this->assertEquals(XiptLibProfiletypes::isDefaultAvatarOfProfileType('components/com_community/assets/group.jpg'),'components/com_community/assets/group.jpg');
  		
  		$this->assertEquals(XiptLibProfiletypes::isDefaultAvatarOfProfileType('components/com_community/assets/default_thumb.jpg'),'components/com_community/assets/default_thumb.jpg');
  		
  		$this->assertEquals(XiptLibProfiletypes::isDefaultAvatarOfProfileType('components/com_community/assets/group_thumb.jpg'),'components/com_community/assets/group_thumb.jpg');
  		
  		$this->assertEquals(XiptLibProfiletypes::isDefaultAvatarOfProfileType('components/com_community/assets/default_thumb.jpg',true),'components/com_community/assets/default_thumb.jpg');
  		
  	}
  	
  	function testValidateProfiletype()
 	{
 		//validate published Profiletypes
 		$this->assertEquals(XiptLibProfiletypes::validateProfiletype(1),true);
 		
 		$this->assertEquals(XiptLibProfiletypes::validateProfiletype(2),true);
 		
 		$this->assertEquals(XiptLibProfiletypes::validateProfiletype(3),true);
 		
 		$this->assertEquals(XiptLibProfiletypes::validateProfiletype(4),false);
 		
 		$this->assertEquals(XiptLibProfiletypes::validateProfiletype(10),true);
 		
 		$filter=array('published'=>0);
 		//validate unpublished Profiletypes
 		$this->assertEquals(XiptLibProfiletypes::validateProfiletype(4, $filter),true);
 		$this->assertEquals(XiptLibProfiletypes::validateProfiletype(1, $filter),false);
 		
 	}
 	
 	function testParams()
 	{
 		//get value of params by default.
 		$params = XiptLibProfiletypes::getParams(1);
 		$this->assertNotEquals($params, null);
 		
 		$params = XiptLibProfiletypes::getParams(4);
 		$this->assertNotEquals($params, null);
 		
 		$params = XiptLibProfiletypes::getParams(2);
		
 		$strconfig = "enableterms=0\nregistrationTerms=\nrecaptcha=0\nrecaptchapublic=\nrecaptchaprivate=\nrecaptchatheme=red\nrecaptchalang=en\nenablereporting=1\nmaxReport=50\nnotifyMaxReport=\nenableguestreporting=0\npredefinedreports=Spamming / Advertisement\nprivacyprofile=0\nprivacyfriends=0\nprivacyphotos=0\nprivacyemail=1\nprivacyapps=1\nprivacywallcomment=0\nenablepm=1\npmperday=30\nwallediting=1\nlockprofilewalls=1\nlockvideoswalls=1\nlockgroupwalls=1\nenablegroups=0\nmoderategroupcreation=1\ncreategroups=0\ngroupcreatelimit=1\ngroupphotouploadlimit=500\ngroupvideouploadlimit=500\ncreatediscussion=1\ngroupphotos=1\ngroupvideos=1\ngroupdiscussnotification=0\ngroupdiscussionmaxlist=5\nenablevideos=1\nenablevideosupload=0\nvideouploadlimit=1\ndeleteoriginalvideos=0\nvideofolder=images\nmaxvideouploadsize=8\nffmpegPath=\nflvtool2=\nqscale=11\nvideosSize=400x300\ncustomCommandForVideo=\nenablevideopseudostream=0\nvideodebug=0\nfolderpermissionsvideo=0755\nenablephotos=1\nphotouploadlimit=1\nmaxuploadsize=8\ndeleteoriginalphotos=0\nmagickPath=\nflashuploader=0\nfolderpermissionsphoto=0755\nautoalbumcover=1\nenablemyblogicon=0\n\n";
 		$watermarkxml = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'watermark.xml';
		$config	= new JParameter( $strconfig,$watermarkxml);
		$this->assertEquals($params,$config);
 	}
 	
 	function testRemoveCustomAvatar()
 	{
 		$profiletype	=XiptFactory::getInstance('profiletypes', 'model');
 		$newavatar 		= DEFAULT_AVATAR ;
 		
 		//remove custom avatar for pid 2
		$profiletype->save( array('avatar' => $newavatar), 2 );
		$this->_DBO->addTable('#__xipt_profiletypes');
 	}
 	
 	function testResetUserAvatar()
 	{
 		$profiletype	= XiptFactory::getInstance('profiletypes', 'model');
		$newavatar 		= DEFAULT_AVATAR ;
		$newavatarthumb	= DEFAULT_AVATAR_THUMB;
		$oldAvatar      = 'components/com_community/assets/group.jpg';

		$profiletype->resetUserAvatar(2, $newavatar, $oldAvatar, $newavatarthumb);
		$this->_DBO->addTable('#__community_users');
 	}
}