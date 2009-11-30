<?php

class RegisterTest extends XiSelTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__);
  }
  
  function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl( JOOMLA_LOCATION."/index.php?option=com_community&view=register");
  }

  //cross check page exists and comes
  function avtestRegisterPage()
  {
  	//Prerequiste = clean session + No AEC + Our system plugin is working
  	//1. session cleaned via SQL
    // go to register location 
    $this->open(JOOMLA_LOCATION."/index.php?option=com_community&view=register");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("PROFILETYPE-1"));
    $this->assertTrue($this->isTextPresent("PROFILETYPE-2"));
    $this->assertTrue($this->isTextPresent("PROFILETYPE-3"));
    $this->assertFalse($this->isTextPresent("PROFILETYPE-4"));//unpublished

    //now click on next without selecting any profiletype
    $this->click("ptypesavebtn");
    $this->waitPageLoad();
    // a system message sud be there
    $this->assertTrue($this->isElementPresent("//dl[@id='system-message']"));
    
    //now select profiletype-2
    $this->click("profiletypes2");
    $this->click("ptypesavebtn");
    $this->waitPageLoad();
    $this->assertTrue($this->isElementPresent("//dl[@id='system-message']"));
    $this->assertTrue($this->isTextPresent("Register new user"));
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
    $this->assertTrue($this->isTextPresent("Register new user"));
    $username =  $this->fillDataPT($ptype);
    $this->click("btnSubmit");
    $this->waitPageLoad();
    
    //avatar page
    $this->assertTrue($this->isTextPresent("Change profile picture"));
    // verify user's attributes in Joomla User and JomSocial User tables 
    // verify default avatar
    $this->click("link=[Skip]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("User Registered."));
    
    //verify users
    $this->assertTrue($this->verifyUser($username, $ptype));
  	
  }
  
  function fillDataPT($ptype)
  {
  	
  	
  	$randomNo  = rand(1234567,9234567);
    $randomStr = "regtest".$randomNo;
    
    // fill some random values in register page
    $this->type("jsname", $randomStr);
    sleep(1);
    $this->type("jsusername", $randomStr);
    sleep(1);
    $this->type("jsemail", $randomStr.'@gmail.com');
    sleep(1);
    $this->type("jspassword", $randomStr);
    sleep(1);
    $this->type("jspassword2", $randomStr);
    // wait for some time for ajax checks
    sleep(1);
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
    
    	//return username
    return $randomStr;
  }
  
  function verifyUser($username, $ptype)
  {
  	// find userid 
  	// check Joomla table for correct user type
  	// check JomSocual table for correct avatar + privacy + group + approval 
  	return true;
  }
}