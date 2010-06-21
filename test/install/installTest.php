<?php

class InstallTest extends XiSelTestCase 
{ 
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

   /**
   */
  function testXiptInstall()
  {
    // setup default location 
    $this->adminLogin();
    
    // first copy a dummy old AEC MI, so that we can test that file 
    // does not exist after the migration
    jimport( 'joomla.filesystem.file' );
    jimport( 'joomla.filesystem.folder' );
    $AEC_MI_PATH = dirname( JPATH_ROOT ) . DS. 'components' . DS . 'com_acctexp' . DS . 'micro_integration';
	$AEC_MI_FILE = $AEC_MI_PATH .DS.'mi_jomsocialjspt.php';
	if(JFolder::exists($AEC_MI_PATH))
		$this->assertTrue(JFile::write($AEC_MI_FILE, "Dummy files"));
    
    // go to installation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad("60000");
      
	// add profiletype-one
    $this->type("install_url", COM_XIPT_PKG);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
   
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Component Success"));
    $this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));
    
    //check migration tables
    $this->_DBO->addTable('#__community_fields');
    $this->_DBO->addTable('#__community_register');
    $this->_DBO->addTable('#__community_users');
    $this->_DBO->addTable('#__xipt_aclrules');
    $this->_DBO->addTable('#__xipt_aec');
    $this->_DBO->addTable('#__xipt_applications');
    $this->_DBO->addTable('#__xipt_profilefields');
    $this->_DBO->addTable('#__xipt_profiletypes');
    $this->_DBO->filterColumn('#__xipt_profiletypes','watermarkparams');
    $this->_DBO->filterColumn('#__xipt_profiletypes','visible');
    $this->_DBO->filterColumn('#__xipt_profilefields','category');
    $this->_DBO->addTable('#__xipt_users');
    $this->_DBO->addTable('#__xipt_users');
    $this->_DBO->addTable('#__components');
    $this->_DBO->filterRow('#__components',"`parent`='0' AND `option` ='com_xipt'");
    $this->_DBO->filterColumn('#__components','id');
    $this->_DBO->filterColumn('#__community_register','profiletypes');
    $this->_DBO->filterColumn('#__community_users','template');
    $this->_DBO->filterColumn('#__community_users','profiletype');
    //now compare that AEC MI deleted or not
	$this->assertFalse(JFile::exists($AEC_MI_FILE));
  }
  
  
  /**
   * We will upgrade JomSocial from existing 1.5.248 + JSPT installation
   * @return unknown_type
   */
  function testCommunityInstall()
  {
	    // setup default location 
	    $this->adminLogin();
	    
	    // go to installation
	    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
	    $this->waitPageLoad("60000");
	      
		// add profiletype-one
	    $this->type("install_url", JOMSOCIAL_PKG);
	    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
	    $this->waitPageLoad();

	  $this->click("//div[@id='element-box']/div[2]/table/tbody/tr[2]/td/table/tbody/tr[2]/td/input");
	  $this->waitForPageToLoad("60000");
	  $this->click("//form[@id='installform']/div/div/input");
	
	  $this->waitForPageToLoad("60000");
	  $this->click("//form[@id='installform']/div/div/input");
	  $this->waitForPageToLoad("60000");
	  $this->click("//form[@id='installform']/div/div/input");
	  $this->waitForPageToLoad("60000");
	  $this->click("//form[@id='installform']/div/div/input");
	  $this->waitForPageToLoad("60000");
	  $this->click("//form[@id='installform']/div/div/input");
	  $this->waitForPageToLoad("60000");
	  $this->click("//form[@id='installform']/div/div/input");
	  $this->waitForPageToLoad("60000");
	  $this->click("//form[@id='installform']/div/div/input");
	  $this->waitForPageToLoad("60000");
	  $this->click("//form[@id='installform']/div/div/input");
	  $this->waitForPageToLoad("60000");
	  $this->click("//form[@id='installform']/div/div/input");
	  $this->waitForPageToLoad("60000");
	  $this->click("//form[@id='installform']/div/div/input");
	  $this->waitForPageToLoad("60000");
	  $this->assertTrue($this->isTextPresent("Jom Social"));
  }
  
  function testCommunityAppsInstall()
  {
    // setup default location 
    $this->adminLogin();
    
    // go to installation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad("60000");
      
	// add profiletype-one
    $this->type("install_url", JOMSOCIAL_APPS1);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
    
    $this->type("install_url", JOMSOCIAL_APPS2);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
    
    $this->type("install_url", JOMSOCIAL_APPS3);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
    
    
    $this->type("install_url", JOMSOCIAL_APPS4);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
    
    $this->type("install_url", JOMSOCIAL_APPS5);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
    
    $this->type("install_url", JOMSOCIAL_APPS6);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
       
    $this->type("install_url", PLG_XIPT_SYS_PKG);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
    $this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));
    
    	// add profiletype-one
    $this->type("install_url", PLG_XIPT_COM_PKG);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
    $this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));
    
    //enable xipt plugins also, uninstallation will again disable them
    $sql = "UPDATE `#__plugins` SET `published` = '1' WHERE `folder` ='community';";
    $this->_DBO->execSql($sql);

		// install modules
    $this->type("install_url", MOD_XIPT_MEMBERS_PKG);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Module Success"));
    $this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));
  }
      
  
function testXiptUninstallReinstall()
  {
    // setup default location 
    $this->adminLogin();

    // go to installation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad();

     $this->click("//a[@onclick=\"javascript:document.adminForm.type.value='components';submitbutton('manage');\"]");
     $this->waitPageLoad();
     
     //now find the component order in uninstall list
     $order = $this->getUninstallOrder('com_xipt');
     $this->click("cb$order");
     $this->click("link=Uninstall");
     $this->waitPageLoad();
     $this->assertTrue($this->isTextPresent("Uninstall Component Success"));
     $this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));
     $this->verifyUninstall();
     // now reinstallation
     $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
     $this->waitPageLoad();
     
	// add profiletype-one
    $this->type("install_url", COM_XIPT_PKG);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Component Success"));
    $this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));
  }
  
  function verifyUninstall()
  {
  		//1. Plugins are disabled
  		//2. Files are properly unpatched
  		//3. Custom Fields have been unpublished
  		//4. AEC MI should not apply any action

  		//1.
  		$this->verifyPluginState('plg_xipt_community',false);
  		$this->verifyPluginState('plg_xipt_system',false);

  		//2.
  		$CMP_PATH_FRNTEND = JPATH_ROOT .DS. 'components' . DS . 'com_community';
  		$CMP_PATH_ADMIN	  = JPATH_ROOT .DS. 'administrator' .DS.'components' . DS . 'com_community';
  		$hackedFiles[]=$CMP_PATH_FRNTEND.DS.'libraries' .DS.'fields'.DS.'customfields.xml';
  		$hackedFiles[]=$CMP_PATH_FRNTEND.DS.'models'	.DS.'profile.php';
  		$hackedFiles[]=$CMP_PATH_ADMIN  .DS.'models'	.DS.'users.php';
  		foreach($hackedFiles as $file)
  			$this->assertFalse(JFile::exists($file.".jxibak"));
  		
  		//3.
  		$db			=& JFactory::getDBO();		
  		$query	= " SELECT *  FROM `#__community_fields` " 
	          	. " WHERE `published` = '1' "
	          	. " AND (`type` = 'profiletypes' OR `type` = 'templates') ";
	    $db->setQuery($query);
	    $result = $db->loadResult();
	    $this->assertTrue($result === null);
  }
  
  function getUninstallOrder($component, $what = "COMPONENT")
  {
  	$db = JFactory::getDBO();
  	$sql = "SELECT * FROM `#__components`
  			WHERE `parent` = '0'
  			ORDER BY `iscore`, `name`";
  	$db->setQuery($sql);
    $results = $db->loadAssocList();
    
    $i=0;
    foreach($results as $r)
    {
    	if($r['option']==$component)
    		return $i;
    	
    	$i++;
    }
    
    return -1;
  }
}

