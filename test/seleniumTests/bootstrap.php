<?php

// Define expected Joomla constants.
define('JOOMLA_HTTP_LOCATION',	'@joomla.http.location@');
define('JOOMLA_FTP_LOCATION', 	'@joomla.ftp.location@');

define('TIMEOUT_SEC',30000);
define('JOOMLA_ADMIN_USERNAME', '@joomla.admin@');
define('JOOMLA_ADMIN_PASSWORD',	'@joomla.password@')

// Fix magic quotes.
@set_magic_quotes_runtime(0);

// Maximise error reporting.
@ini_set('zend.ze1_compatibility_mode', '0');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// now setup basic utils
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class selJUtils extends PHPUnit_Extensions_SeleniumTestCase
{

	function adminLogin()
	{
	    $this->open(JOOMLA_HTTP_LOCATION."/administrator/index.php?option=com_login");
	    $this->waitForPageToLoad(TIMEOUT_SEC);

	    $this->type("modlgn_username", JOOMLA_ADMIN_USERNAME);
	    $this->type("modlgn_passwd", JOOMLA_ADMIN_PASSWORD);
	    $this->click("link=Login");

	    $this->waitForPageToLoad(TIMEOUT_SEC);
	    $this->assertTrue($this->isTextPresent("Logout"));
  	}

	function siteLoginAsAdmin()
	{
	    $this->open(JOOMLA_HTTP_LOCATION."/administrator/index.php?option=com_login");
	    $this->waitForPageToLoad(TIMEOUT_SEC);

	    $this->type("modlgn_username", JOOMLA_ADMIN_USERNAME);
	    $this->type("modlgn_passwd", JOOMLA_ADMIN_PASSWORD);
	    $this->click("link=Login");

	    $this->waitForPageToLoad(TIMEOUT_SEC);
	    $this->assertTrue($this->isTextPresent("Logout"));
  	}



}
