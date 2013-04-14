<?php
class AvatarTest extends XiSelTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  /*
   * Watr-mark Testing when Change Profile-Type from front-end
   */
  function testUpdateAvatar()
  {

	$this->preConditions();
	$user = JFactory::getUser(82); 
  	//login as profiletype 1
  	 $this->frontLogin($user->name,$user->name);
  	 $newAvatar = 'test/test/com_xipt/front/images/avatar_4.jpg';
  	 if(TEST_XIPT_JOOMLA_15)
  	   $newAvatarAU = 'test/test/com_xipt/front/images/avatar_4_AU.jpg';
  	 else
  	   $newAvatarAU = 'test/test/com_xipt/front/images/avatar_4_AU_1.7.jpg';
  	 
  	 $this->open(JOOMLA_LOCATION."/index.php?option=com_community&view=profile&task=uploadAvatar");
	 $this->waitPageLoad();
	 $this->assertTrue($this->isTextPresent("Change profile picture"));

	 //upload new avatar
	 $this->type("file-upload", JPATH_ROOT.DS.$newAvatar);
	 $this->click("file-upload-submit");
	 $this->waitPageLoad();
	 $this->click("link=Profile");
	 $this->waitPageLoad();
     
     //Check avatar uploaded and watr-mrk apply
     $this->verifyAvatar($newAvatarAU);
    
    //change profiletype 1 to pt 3
     if(TEST_XIPT_JOOMLA_15)
  	    $newAvatarAU = 'test/test/com_xipt/front/images/avatar_5_AU.jpg';
  	else 
       	$newAvatarAU = 'test/test/com_xipt/front/images/avatar_5_AU_1.7.jpg';
     $this->editProfiletype(3);  
  	//Test: Profile-Type change and watr-mrk remove 
	$this->verifyAvatar($newAvatarAU);

	//change profiletype 3 to pt 2
    if(TEST_XIPT_JOOMLA_15)
  	    $newAvatarAU = 'test/test/com_xipt/front/images/avatar_6_AU.jpg';
  	else 
       	$newAvatarAU = 'test/test/com_xipt/front/images/avatar_6_AU_1.7.jpg';
  	$this->editProfiletype(2); 
  	//Test Profile-Type Change and water-mark apply 
  	$this->verifyAvatar($newAvatarAU);

  	//change profiletype 2 to 1
  	if(TEST_XIPT_JOOMLA_15)
  	    $newAvatarAU = 'test/test/com_xipt/front/images/avatar_4_AU.jpg';
  	else 
       	$newAvatarAU = 'test/test/com_xipt/front/images/avatar_4_AU_1.7.jpg';
  	$this->editProfiletype(1);
  	//Test: Profile-type change and watr-mark position change 
  	$this->verifyAvatar($newAvatarAU);
  	
  	
  	$this->frontLogout();
	$this->postConditions();
  }
  
  function testUpdateavatarwithWatermrk()
  {
  	$this->preConditions();
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
	 $this->click("link=Profile");
	 $this->waitPageLoad();
     //Check avatar uploaded and watr-mrk apply
     // $this->verifyAvatar($newAvatarAU);

	 $watermrksrc='test/test/com_xipt/admin/images/watermark_4.png';
     $watrmrkdest='images/profiletype/watermark_4.png';
     $newAvatarAU = 'test/test/com_xipt/front/images/avatar_img_AU.jpg';
     Jfile::copy(JPATH_ROOT.DS.$watermrksrc,JPATH_ROOT.DS.$watrmrkdest);
     $this->editProfiletype(4);
     //Test: Profile-type change and watr-mark position change 
  	 //$this->verifyAvatar($newAvatarAU);
  	 $this->frontLogout();
	 $this->postConditions();
  }
  
  function verifyAvatar($newAvatarAU)
  {
  		$user = JFactory::getUser(82); 
		$db		= new XiptQuery();
		$cuser 	= $db->select('*')
				  	 ->from('#__community_users')
				  	 ->where("`userid`={$user->id}")
				  	 ->dbLoadQuery()
				  	 ->loadObject();

		//get md5 of Avatar and thumb
		$md5_avatar = md5_file(JPATH_ROOT.DS.$cuser->avatar);
	  	$md5_thumb  = md5_file(JPATH_ROOT.DS.$cuser->thumb);
	  	$md5_avatar_gold = md5_file(JPATH_ROOT.DS.$newAvatarAU);
	  	$md5_thumb_gold = md5_file(XiptHelperImage::getThumbAvatarFromFull(JPATH_ROOT.DS.$newAvatarAU));
  		
	  	// Compare image
	  	$this->assertEquals($md5_avatar, $md5_avatar_gold);
	  	$this->assertEquals($md5_thumb, $md5_thumb_gold);	    	
  }
  /*
   * change user profile type 
   */
  
  function editProfiletype($pid)
  {
	$this->click("link=[ Edit profile ]");
	$this->waitPageLoad();
	$this->select("field4", "label=PROFILETYPE-$pid");
	$this->click("//input[@value='Save']");
	$this->waitPageLoad();
	
	$this->click("link=Profile");
	$this->waitPageLoad();
  }
  /*
   * Full-fill all conditions which are required for testing
   */
    function preConditions()
  {
  	for($i=1; $i<4; $i++){
  		JFile::copy(JPATH_ROOT.DS."test/test/com_xipt/front/images/watermark_$i.png" , JPATH_ROOT.DS."images/profiletype/watermark_$i.png");
  		JFile::copy(JPATH_ROOT.DS."test/test/com_xipt/front/images/watermark_".$i."_thumb.png" , JPATH_ROOT.DS."images/profiletype/watermark_".$i."_thumb.png");
  		}
  }
  
  function postConditions() {
  	for($i=1; $i<4; $i++){
  		JFile::delete(JPATH_ROOT.DS."images/profiletype/watermark_$i.png");
  		JFile::delete(JPATH_ROOT.DS."images/profiletype/watermark_".$i."_thumb.png");
  		}
  }
  
}
