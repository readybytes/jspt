<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class ProfileTypeTest extends PHPUnit_Extensions_SeleniumTestCase
{
  function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl('http://localhost/@joomla.folder@'."/administrator/index.php?option=com_login");
  }


  function adminLogin()
  {
    $this->open('http://localhost/@joomla.folder@'."/administrator/index.php?option=com_login");
    $this->waitForPageToLoad("30000");

    $this->type("modlgn_username", '@joomla.admin@');
    $this->type("modlgn_passwd", '@joomla.password@');
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
	{}

	//publish profiletypes
	function testPublishProfileTypes()
	{}

	// unpublish fed profiletypes
	function testPublishProfileTypes()
	{}

	// try to delete all
	function deleteProfileTypes()
	{}


}
?>
