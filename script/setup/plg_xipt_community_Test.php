<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';



class Plg_XiPT_community extends PHPUnit_Extensions_SeleniumTestCase
{
  function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl('http://localhost/@joomla.folder@'."/administrator/index.php?option=com_login");
  }

  function testInstall_plg_community_xipt()
  {
	
	$this->open('http://localhost/@joomla.folder@'."/administrator/index.php?option=com_login");
    $this->waitForPageToLoad("30000");

    $this->type("modlgn_username", '@joomla.admin@');
    $this->type("modlgn_passwd", '@joomla.password@');
    $this->click("link=Login");

    $this->waitForPageToLoad("30000");

    $this->click("link=Install/Uninstall");

    $this->waitForPageToLoad("30000");

    $this->type("install_package", '@PKG.PATH@');
    $this->click("//input[@value='Upload File & Install']");
    $this->waitForPageToLoad("30000");

    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
    $this->assertEquals("Install Plugin Success", $this->getText("//dl[@id='system-message']/dd/ul/li"));
  }
}
?>
