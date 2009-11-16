<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

define('JOOMLA_LOCATION',	'http://localhost/root4181/');
define('JOOMLA_FTP_LOCATION', 	'/var/www/root4181');

define('TIMEOUT_SEC',30000);
define('JOOMLA_ADMIN_USERNAME', 'admin');
define('JOOMLA_ADMIN_PASSWORD',	'ssv445');


class ProfileTypeTest extends PHPUnit_Extensions_SeleniumTestCase 
{

  var  $_DBO;

  function getSqlPath()
  {
      return dirname(__FILE__);
  }
  
  function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl( JOOMLA_LOCATION."/administrator/index.php?option=com_login");
  }


  function adminLogin()
  {
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_login");
    $this->waitForPageToLoad("30000");

    $this->type("modlgn_username", JOOMLA_ADMIN_USERNAME);
    $this->type("modlgn_passwd", JOOMLA_ADMIN_PASSWORD);
    $this->click("link=Login");

    $this->waitForPageToLoad("30000");
    $this->assertTrue($this->isTextPresent("Logout"));
    
  }


  function testAddProfileType()
  {
     $this->adminLogin();
    //ensure tables xipt_profiletypes are clean
	// profiletype page does exist
	$this->open("/root4181/administrator/index.php?option=com_xipt&view=profiletypes");
	$this->waitForPageToLoad("30000");

	// add profiletype-one
    $this->click("//td[@id='toolbar-new']/a");
    $this->waitForPageToLoad("30000");
    $this->type("name", "PROFILETYPE-ONE");
    $this->type("tip", "PROFILETYPE-TIP-ONE");
    $this->click("//td[@id='toolbar-save']/a");
    $this->waitForPageToLoad("30000");
    $this->assertTrue($this->isTextPresent("PROFILETYPE-ONE"));

    $this->_DBO->addTable('#__xipt_profiletypes');
    $this->_DBO->filterColumn('#__xipt_profiletypes','id');
    $this->_DBO->filterColumn('#__xipt_profiletypes','ordering');
    $this->assertTrue($this->_DBO->verify());
  }
	
/*	function testOrderProfileTypes()
	{
		// mv 2 to 3 (down)
		$this->click("//tr[@id='rowid4']/td[12]/span[1]/a/img");
		$this->waitForPageToLoad("30000");
		$this->assertTrue($this->isTextPresent("3 		PROFILETYPE-TWO"));
		
		// mv 4 to 2 (up)
		$this->click("//tr[@id='rowid5']/td[12]/span[1]/a/img");
		$this->waitForPageToLoad("30000");
		$this->assertTrue($this->isTextPresent("4 		PROFILETYPE-TWO"));
	}


	// unpublish fed profiletypes
	function testPublishUnpublishProfileTypes()
	{
		// publish
		$this->click("//td[@id='published3']/a/img");
		$this->waitForPageToLoad("30000");
		$this->assertTrue($this->isTextPresent("1 Items unpublished."));
		
		// same link now refers to unpublish
		$this->click("//td[@id='published3']/a/img");
		$this->waitForPageToLoad("30000");
		$this->assertTrue($this->isTextPresent("1 Items published."));

	}

	// try to delete all
	function testDeleteProfileTypes()
	{
		// delete profiletype 3		
		$this->click("cb3");
		$this->click("//td[@id='toolbar-trash']/a/span");
		// proivde yes to popup box.
		$this->waitForPageToLoad("30000");
		$this->assertTrue($this->isTextPresent("1 Profiletype removed"));
	}
*/
}
?>
