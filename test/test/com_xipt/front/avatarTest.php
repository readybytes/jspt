<?php
class AvatarTest extends XiSelTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function testUpdateAvatar()
  {
  	$users[1]=array(79,82,85);
  	$users[2]=array(80,83,86);
  	$users[3]=array(81,84,87);
  	
	$user = JFactory::getUser(82); 
  	//login as profiletype 1
  	 $this->frontLogin($user->name,$user->name);
  	 $newAvatar = 'test/test/com_xipt/front/images/avatar_4.jpg';
  	 $newAvatarAU = 'test/test/com_xipt/front/images/avatar_4_AU.jpg';
  	 
  	 $this->open(JOOMLA_LOCATION."/index.php?option=com_community&view=profile&task=uploadAvatar");
	 $this->waitPageLoad();
	 $this->assertTrue($this->isTextPresent("Change profile picture"));

	  	//upload new avatar
	 $this->type("file-upload", JPATH_ROOT.DS.$newAvatar);
	 $this->click("file-upload-submit");
	 $this->waitPageLoad();
	 $this->click("//li[@id='toolbar-item-profile']/a");
     $this->waitPageLoad();
	  	
 
    $this->verifyAvatar($newAvatarAU);
    
    //change profiletype 1 to pt 3
  	$newAvatarAU = 'test/test/com_xipt/front/images/avatar_5_AU.jpg';
  	$this->editProfiletype(3);  
	$this->verifyAvatar($newAvatarAU);

	//change profiletype 3 to pt 2
  	$newAvatarAU = 'test/test/com_xipt/front/images/avatar_6_AU.jpg';
  	$this->editProfiletype(2);  
  	$this->verifyAvatar($newAvatarAU);

  	//change profiletype 2 to 1
  	$newAvatarAU = 'test/test/com_xipt/front/images/avatar_4_AU.jpg';
  	$this->editProfiletype(1);
  	$this->verifyAvatar($newAvatarAU);
    
  	$this->frontLogout();
  }
  
  function verifyAvatar($newAvatarAU)
  {
  		$user = JFactory::getUser(82); 
  	  	$query = " SELECT * FROM `#__community_users` "
	  			." WHERE `userid`='$user->id' ";
	  	
	  	
		$db		=& JFactory::getDBO();
		$db->setQuery($query);
		$cuser =  $db->loadObject();

		$md5_avatar = md5(JFile::read(JPATH_ROOT.DS.$cuser->avatar));
	  	$md5_thumb  = md5(JFile::read(JPATH_ROOT.DS.$cuser->thumb));
	  	$md5_avatar_gold = md5(JFile::read(JPATH_ROOT.DS.$newAvatarAU));
	  	$md5_thumb_gold = md5(JFile::read(XiptLibUtils::getThumbAvatarFromFull(JPATH_ROOT.DS.$newAvatarAU)));
  		
	  	$this->assertEquals($md5_avatar, $md5_avatar_gold);
	  	$this->assertEquals($md5_thumb, $md5_thumb_gold);	    	
  }
  
  function editProfiletype($pid)
  {
  		$this->click("link=Edit profile");
		$this->waitPageLoad();
		$this->select("field17", "label=PROFILETYPE-$pid");
		$this->click("//input[@value='Save']");
		$this->waitPageLoad();
		$this->click("//li[@id='toolbar-item-profile']/a");
		$this->waitPageLoad();
  }
}
