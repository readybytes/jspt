<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class Com_XiPT extends PHPUnit_Extensions_SeleniumTestCase
{
  function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl("http://localhost");
  }

  function testInstallXiPT()
  {
	$this->open("http://localhost/@joomla.folder@/administrator/index.php?option=com_login");
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

    $this->assertTrue($this->isTextPresent("Install Component Success"));
    $this->assertEquals("Install Component Success", $this->getText("//dl[@id='system-message']/dd/ul/li"));
  }
}
?>
