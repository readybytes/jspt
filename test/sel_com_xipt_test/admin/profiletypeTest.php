<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

// it will be repalced by set script
require_once '@JOOMLA.ROOT.PATH@'.'@JOOMLA.FOLDER@'.'/test/selConfig.php';
require_once '@JOOMLA.ROOT.PATH@'.'@JOOMLA.FOLDER@'.'/test/selJAdmin.php';

class ProfileTypeTest extends PHPUnit_Extensions_SeleniumTestCase
{
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

	// profiletype page does exist
	$this->open("/root5687/administrator/index.php?option=com_xipt&view=profiletypes");
	$this->click("link=JomSocial Profile Types");
	$this->waitForPageToLoad("30000");
	$this->click("link=Profiletypes");
	$this->waitForPageToLoad("30000");
	$this->assertTrue($this->isTextPresent("Profiletypes"));

	// add profiletype-one
    $this->click("link=Add profiletypes");
    $this->waitForPageToLoad("30000");
    $this->type("name", "PROFILETYPE-ONE");
    $this->type("tip", "PROFILETYPE-TIP-ONE");
    $this->click("link=Save");
    $this->waitForPageToLoad("30000");
    $this->assertTrue($this->isTextPresent("PROFILETYPE-ONE"));
	// check for save string, do not assert only verify
     try {
        $this->assertTrue($this->isTextPresent("Profiletype saved"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }

	// add profiletype-two
    $this->click("link=Add profiletypes");
    $this->waitForPageToLoad("30000");
    $this->type("name", "PROFILETYPE-TWO");
    $this->type("tip", "PROFILETYPE-TIP-TWO");
    $this->click("link=Save");
    $this->waitForPageToLoad("30000");
    $this->assertTrue($this->isTextPresent("PROFILETYPE-TWO"));

	// add profiletype-one
    $this->click("link=Add profiletypes");
    $this->waitForPageToLoad("30000");
    $this->type("name", "PROFILETYPE-THREE");
    $this->type("tip", "PROFILETYPE-TIP-THREE");
    $this->click("link=Save");
    $this->waitForPageToLoad("30000");
    $this->assertTrue($this->isTextPresent("PROFILETYPE-THREE"));

	// add profiletype-one
    $this->click("link=Add profiletypes");
    $this->waitForPageToLoad("30000");
    $this->type("name", "PROFILETYPE-FOUR");
    $this->type("tip", "PROFILETYPE-TIP-FOUR");
    $this->click("link=Save");
    $this->waitForPageToLoad("30000");
	// check for message also
    $this->assertTrue($this->isTextPresent("Profiletype saved"));
    $this->assertTrue($this->isTextPresent("PROFILETYPE-FOUR"));

  }
	
	// try to order profiletypes
	function testOrderProfileTypes()
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

}
?>
