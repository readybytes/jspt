<?php

class ProfileTest extends XiSelTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl( JOOMLA_LOCATION."/index.php?option=com_community");
  }

  //cross check page exists and comes
  function testViewableProfilesAsAdmin()
  {
  	//login as pType 1 user
    $this->frontLogin();
    $this->open(JOOMLA_LOCATION."/index.php?option=com_community&view=register");
    
  }
  
  //cross check fields exists
  function testRegisterProfileFieldPage()
  {
		$this->userRegistrationForPT(1);
		$this->userRegistrationForPT(2);
		$this->userRegistrationForPT(3);
  }
  
  function userRegistrationForPT($ptype)
  {
  	//Prerequiste = clean session + No AEC + Our system plugin is working
  	//1. session cleaned via SQL
    // go to register location 
    $this->open(JOOMLA_LOCATION."/index.php?option=com_community&view=register");
    $this->waitPageLoad();
    $this->click("profiletypes".$ptype);
    $this->click("ptypesavebtn");
    
    $this->waitPageLoad();
    
    // now fille reg + field information
    
    $username =  $this->fillDataPT($ptype);
    
    //avatar page
    $this->assertTrue($this->isTextPresent("Change profile picture"));
    // verify user's attributes in Joomla User and JomSocial User tables 
    $this->assertTrue($this->verifyAvatar($ptype));
    $this->click("link=[Skip]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("User Registered."));
    
    //verify users
    $this->assertTrue($this->verifyUser($username, $ptype));
  	
  }
  
  function fillDataPT($ptype)
  {
  	$this->assertTrue($this->isTextPresent("Register new user"));
  	
  	$randomNo  = rand(1234567,9234567);
    $randomStr = "regtest".$randomNo;
    
    // fill some random values in register page
    $this->type("jsname", $randomStr);
    $this->type("jsusername", $randomStr);
    $this->type("jsemail", $randomStr.'@gmail.com');
    $this->type("jspassword", $randomStr);
    $this->type("jspassword2", $randomStr);
    // wait for some time for ajax checks
    $this->click("btnSubmit");
    sleep(1);
    $this->click("btnSubmit");
    $this->waitPageLoad();
    
    $this->assertTrue($this->isTextPresent("Basic Information"));
    
    $Avail[1] 	 = array(3,4,5,8,9);// 7 is not visible during reg
    $notAvail[1] = array(2,6);
    
    $Avail[2] 	 = array(2,4,5,6,8,9);
    $notAvail[2] = array(3,7);
    
    $Avail[3] 	 = array(5,9);
    $notAvail[3] = array(2,3,4,6,7,8);
    
    //verify and fill fields
    foreach ($Avail[$ptype] as $p)
    {
    	$this->assertTrue($this->isElementPresent("field".$p));
    	$this->type("field".$p, $randomStr);
    }
    
    foreach ($notAvail[$ptype] as $p)
    	$this->assertFalse($this->isElementPresent("field".$p));
    
   	$this->click("btnSubmit");
    $this->waitPageLoad();
    	//return username
    return $randomStr;
  }
  
  function verifyAvatar($ptype)
  {
  	
  	return true;
  }
  
  function verifyUser($username, $ptype)
  {
  	// find userid 
  	// check Joomla table for correct user type
  	// check JomSocual table for correct avatar + privacy + group + approval 
  	return true;
  }
}