<?php

class AclRulesUITest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	function checkAccess()
	{
		$value  = !($this->isTextPresent("YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE"));
		//echo "Value is [$value]";
		return $value;
	}


	function checkCreateGroup()
	{
		$this->open("index.php?option=com_community&view=groups&task=create&Itemid=53");
		$this->waitPageLoad();
		return $this->checkAccess();
	}

	function checkJoinGroup($groupid)
	{
		$this->open("index.php?option=com_community&view=groups&task=viewgroup&groupid=$groupid&Itemid=53");
		$this->waitPageLoad();
		$this->click("//a[@onclick=\"javascript:joms.groups.joinWindow('$groupid');\"]");
		$this->waitForElement("cwin_tm");
		sleep(1);
		return $this->checkAccess();
	}

	function checkAccessGroup($groupid)
	{
		$this->open("index.php?option=com_community&view=groups&task=viewgroup&groupid=$groupid&Itemid=53");
		$this->waitPageLoad();
		return $this->checkAccess();
	}

	function checkCreateEvent()
	{
		$this->open("index.php?option=com_community&view=events&task=create&Itemid=53");
		$this->waitPageLoad();
		return $this->checkAccess();
	}

	function checkAccessEvent($id)
	{
		$this->open("index.php?option=com_community&view=events&task=viewevent&eventid=$id&Itemid=53");
		$this->waitPageLoad();
		return $this->checkAccess();
	}



	function checkCreateAlbum($from)
	{
		$this->open("index.php?option=com_community&view=photos&task=newalbum&userid=$from&Itemid=53");
		$this->waitPageLoad();
		return $this->checkAccess();
	}

	function checkAddPhotos($from, $albumid)
	{
		$this->open("index.php?option=com_community&view=photos&task=uploader&albumid=$albumid&userid=$from&Itemid=53");
		$this->waitPageLoad();
		return $this->checkAccess();
	}

	function checkAddVideos($from)
	{
		$this->open("index.php?option=com_community&view=videos&task=myvideos&userid=$from&Itemid=53");
		$this->waitPageLoad();
		$this->click("//a[@onclick=\"joms.videos.addVideo()\"]");
		$this->waitForElement("cwin_tm");
		sleep(1);
		return $this->checkAccess();
	}

	function checkAccessVideo($to,$vid)
	{
		$this->open("index.php?option=com_community&view=videos&task=video&userid=$to&videoid=$vid&Itemid=53");
		$this->waitPageLoad();
		return $this->checkAccess();
	}


	function checkChangeAvatar()
	{
		$this->open("index.php?option=com_community&view=profile&task=uploadAvatar&Itemid=53");
		$this->waitPageLoad();
		return $this->checkAccess();
	}

	function checkChangePrivacy()
	{
		$this->open("index.php?option=com_community&view=profile&task=privacy&Itemid=53");
		$this->waitPageLoad();
		return $this->checkAccess();
	}

	function checkEditProfile()
	{
		$this->open("index.php?option=com_community&view=profile&task=edit&Itemid=53");
		$this->waitPageLoad();
		return $this->checkAccess();
	}

	function checkEditProfileDetails()
	{
		$this->open("index.php?option=com_community&view=profile&task=editDetails&Itemid=53");
		$this->waitPageLoad();
		return $this->checkAccess();
	}

	function checkVisitProfile($to)
	{
		$this->open("index.php?option=com_community&view=profile&userid=$to&Itemid=53");
		$this->waitPageLoad();
		return $this->checkAccess();
	}

	function checkStatusBox()
	{
		$this->open("index.php?option=com_community&view=profile&Itemid=53");
		$this->waitPageLoad();
		$this->type("statustext", "TESTING CHANGE STATUS");
		$this->click("save-status");
		sleep(1);
		return $this->isTextPresent("TESTING CHANGE STATUS");
	}


	function checkSendMessage($to)
	{
		//go to user profile
		$this->open("index.php?option=com_community&view=profile&userid=$to&Itemid=53");
		$this->waitPageLoad();
		$this->click("//a[@onclick=\"joms.messaging.loadComposeWindow('$to')\"]");
		$this->waitForElement("cwin_tm");
		sleep(1);
		return $this->checkAccess();
	}

	function checkAddAsFriend($userid)
	{
		$this->open("index.php?option=com_community&view=profile&userid=$userid&Itemid=53");
		$this->waitPageLoad();
		$this->click("//a[@onclick=\"joms.friends.connect('$userid')\"]");
		$this->waitForElement("cwin_tm");
		sleep(1);
		return $this->checkAccess();
	}



	function checkAddProfileVideo($vid)
	{
		$this->open("index.php?option=com_community&view=profile&task=linkVideo&Itemid=53");
		$this->waitPageLoad();

		$this->click("//div[@id='video-$vid']/div/div[2]/div[3]/a/span");
		$this->waitForElement("cwin_tm");
		sleep(1);
		$this->click("//button[@onclick='joms.videos.linkProfileVideo($vid);']");
		sleep(1);
		return $this->checkAccess();
	}

	function checkDeleteProfileVideo($id,$vid)
	{
		$this->open("index.php?option=com_community&view=profile&task=linkVideo&Itemid=53");
		$this->waitPageLoad();
		$this->click("//a[@class='icon-videos-remove']");
		$this->waitForElement("cwin_tm");
		sleep(2);
		$this->click("//button[@onclick='joms.videos.removeLinkProfileVideo($id, $vid);']");
		sleep(2);
		return $this->checkAccess();
	}

	function checkAccessProfileVideo($id)
	{
		$this->open("index.php?option=com_community&view=profile&userid=$id&Itemid=53");
		$this->waitPageLoad();
		$this->click("link=My Profile Video");
		sleep(1);
		return $this->checkAccess();
	}
	
	function checkRedirectToAec($id)
	{
		$this->open("index.php?option=com_community&view=profile&userid=$id&Itemid=53");
		$this->waitPageLoad();
		sleep(1);
		return $this->checkAccess();
	}
	
	function checkAddApplication($id)
	{
		$this->open("index.php?option=com_community&view=profile&Itemid=53");
		$this->click("link=Applications");
  		$this->waitForPageToLoad("30000");
  		$this->click("//div[@id='community-wrap']/div[4]/div[1]/div[2]/a/span");
		$this->waitForElement("cwin_tm");
		sleep(5);
  		$this->click('//a[@class="app-action-add"][@onclick="joms.editLayout.addApp(\'myarticles\', \'sidebar-top\');"]');
  		$this->waitForElement("cwin_tm");
  		sleep(5);
  		return $this->checkAccess();
	}
	
	function enableACLRule($id)
	{
		$acl = new XiptModelAclrules();
		if($id) $acl->boolean($id,'published',1);
		for($i=11; $i <=33; $i++)
		{
			if($i != $id)
			$acl->boolean($i,'published',0);
		}
	}

	function testAclRulesUI()
	{
		$filter['floodLimit']=1;
		$this->changeJomSocialConfig($filter);

		// Blocking rules for PType -1
		$user = JFactory::getUser(82);//regtest8774090
		$this->frontLogin($user->username,$user->username);
		$userid = 82;

		$this->enableACLRule(11);
		$this->assertFalse($this->checkCreateGroup());

		$this->enableACLRule(12);
		$this->assertFalse($this->checkJoinGroup(3));

		$this->enableACLRule(13);
		$this->assertFalse($this->checkAccessGroup(2));

		$this->enableACLRule(14);
		$this->assertFalse($this->checkCreateEvent());

//		$this->enableACLRule(15);
//		$this->assertFalse($this->checkDeleteEvent(2));

		$this->enableACLRule(16);
		$this->assertFalse($this->checkAccessEvent(2));

		$this->enableACLRule(17);
		$this->assertFalse($this->checkCreateAlbum($userid));

		$this->enableACLRule(18);
		$this->assertFalse($this->checkAddPhotos($userid,2));

		$this->enableACLRule(19);
		$this->assertFalse($this->checkChangeAvatar());

		$this->enableACLRule(20);
		$this->assertFalse($this->checkChangePrivacy());

		$this->enableACLRule(21);
		$this->assertFalse($this->checkEditProfile());

		$this->enableACLRule(22);
		$this->assertFalse($this->checkEditProfileDetails());

		$this->enableACLRule(23);
		$this->assertFalse($this->checkVisitProfile(83));

		$this->enableACLRule(24);
		$this->assertFalse($this->checkAddVideos($userid));

		$this->enableACLRule(25);
		$this->assertFalse($this->checkAccessVideo($userid, 2));

		$this->enableACLRule(26);
		$this->assertFalse($this->checkAddProfileVideo(2));

		$this->enableACLRule(27);
		$this->assertTrue($this->checkAddProfileVideo(2));
		$this->assertFalse($this->checkDeleteProfileVideo($userid,2));

		$this->enableACLRule(28);
		$this->assertFalse($this->checkAccessProfileVideo(83));

		$this->enableACLRule(29);
		$this->assertFalse($this->checkSendMessage(83));
		//$this->assertFalse($this->checkReplyMessage($userid));

		$this->enableACLRule(30);
		$this->assertFalse($this->checkAddAsFriend(83));

		$this->enableACLRule(31);
		$this->assertFalse($this->checkRedirectToAec(82));

		$this->enableACLRule(32);
		$this->assertFalse($this->checkAddApplication(85));
		
		$this->enableACLRule(33);
		$this->assertFalse($this->checkStatusBox($userid));
		// Nothing should be blocked for PType -2

		$user = JFactory::getUser(83);
		$userid = 83;
		$this->frontLogout();
		$this->frontLogin($user->username,$user->username);

		$this->enableACLRule(0);//enable all rules
		$this->assertTrue($this->checkCreateGroup());
		$this->assertTrue($this->checkJoinGroup(2));
		$this->assertTrue($this->checkAccessGroup(2));
		$this->assertTrue($this->checkCreateEvent());
		$this->assertTrue($this->checkAccessEvent(2));
		$this->assertTrue($this->checkCreateAlbum($userid));
		$this->assertTrue($this->checkAddPhotos($userid,3));
		$this->assertTrue($this->checkChangeAvatar());
		$this->assertTrue($this->checkChangePrivacy());
		$this->assertTrue($this->checkEditProfile());
		$this->assertTrue($this->checkEditProfileDetails());
		$this->assertTrue($this->checkVisitProfile(82));
		$this->assertTrue($this->checkAddVideos($userid));
		$this->assertTrue($this->checkAccessVideo($userid, 2));
		$this->assertTrue($this->checkAddProfileVideo(3));
		//$this->assertTrue($this->checkDeleteProfileVideo($userid,3));
		$this->assertTrue($this->checkAccessProfileVideo(82));
		$this->assertTrue($this->checkSendMessage(82));
		//$this->assertTrue($this->checkReplyMessage($userid));
		$this->assertTrue($this->checkAddAsFriend(82));
		$this->assertTrue($this->checkRedirectToAec(82));
		$this->assertTrue($this->checkAddApplication(85));
		$this->assertTrue($this->checkStatusBox($userid));
	}


}
