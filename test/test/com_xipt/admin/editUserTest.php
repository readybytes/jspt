<?php
/*
 * We are testing here backend user editing
 * - check information is updating or not
 * - fields are correctly shown
 * - able to edit profiletype seperatey and collectively with Template
 * - able to edit template seperatey and collectively with PT
 * - user are not supposed to edit Profiletype and Information collectively
 * */
class EditUserTest extends XiSelTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function updateConfig($ptype, $temp)
  {
  	$filter['show_ptype_during_reg']=$ptype;
  	$filter['allow_templatechange']=$temp;
  	$this->changeJSPTConfig($filter);
  }
  

  function testEditUser()
  {
      //    setup default location 
    $this->adminLogin();
	$this->updateConfig(1,0);   	
    //set configuration to not allow to edit
    $this->editUser(82,1);
    $this->editUser(83,2);
    $this->editUser(84,3);
  }

  
  
  function editUser($userid,$ptype)
  {
  	//load editing page
  	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_community&view=users&layout=edit&id=".$userid);
    $this->waitPageLoad();
    if(TEST_XIPT_JOOMLA_15)
    	$this->click("Basic Information-page");
    else
    	$this->click("//dl[@id='profile-fields']/dt[2]/span");
    
    //
    //check fields
    $Avail[1] 	 = array(3,4,5,7,8,9); // 7 have no infor
    $notAvail[1] = array(2,6);
    
    $Avail[2] 	 = array(2,4,5,6,8,9);//6 is visible set to false
    $notAvail[2] = array(3,7);
    
    $Avail[3] 	 = array(5,9);
    $notAvail[3] = array(2,3,4,6,7,8);
  
    foreach ($Avail[$ptype] as $p)
	  	$this->assertTrue($this->isElementPresent("field".$p));
	    
    foreach ($notAvail[$ptype] as $p)
	  	$this->assertFalse($this->isElementPresent("field".$p));
    
	// now check profiletype and template fields have correct information
	// and must be editable
	$this->assertTrue($this->isElementPresent("field16"));
	$this->assertTrue($this->isElementPresent("field17"));
	  		
	//update information and see effect
	$randomStr = "UpdateAdmin_".$userid."_".$ptype;
	foreach ($Avail[$ptype] as $p)
	  	$this->type("field".$p, $randomStr);

	if(TEST_XIPT_JOOMLA_15)
		$this->click("//td[@id='toolbar-save']/a/span");

	else
	    $this->click("//li[@id='toolbar-save']/a/span");
	
	$this->waitPageLoad();
	$this->assertTrue($this->isTextPresent("User updated successfully"));

	//verify
	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_community&view=users&layout=edit&id=".$userid);
    $this->waitPageLoad();
     
    if(TEST_XIPT_JOOMLA_15)
    	$this->click("Basic Information-page");
    	
    else
    	$this->click("//dl[@id='profile-fields']/dt[2]/span");
    
    foreach ($Avail[$ptype] as $p){
	  	$this->assertElementValueEquals("field".$p,$randomStr );
    } 
  }
  
  function testEditUserProfiletype()
  {
    //    setup default location 
    $this->adminLogin();
	
    $this->updateConfig(0,0);   	   
    $this->editUserPT(82,1);
    $this->editUserPT(83,2);
    $this->editUserPT(84,3);
    
    // IMP, profiletype have been changed
    $this->updateConfig(1,0);
    
    $this->editUserPT(82,2);
    $this->editUserPT(83,3);
    $this->editUserPT(84,1);
    
  }

  
  function editUserPT($userid,$ptype)
  {
  	//load editing page
  	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_community&view=users&layout=edit&id=".$userid);
  	$this->waitPageLoad();
  	
    if(TEST_XIPT_JOOMLA_15)
    	$this->click("Basic Information-page");
    	
    else
    	$this->click("//dl[@id='profile-fields']/dt[2]/span"); 
    	
    XiptLibJomsocial::cleanStaticCache(true);
	$Avail[1] 	 = array(3,4,5,7,8,9); // 7 have no infor
    $notAvail[1] = array(2,6);
    
    $Avail[2] 	 = array(2,4,5,6,8,9);//6 is visible set to false
    $notAvail[2] = array(3,7);
    
    $Avail[3] 	 = array(5,9);
    $notAvail[3] = array(2,3,4,6,7,8);
  
	//update information and see effect
	$randomStr = "UpdateAdmin_".$userid."_".$ptype;
	foreach ($Avail[$ptype] as $p)
	  	$this->type("field".$p, $randomStr);
	  	
	  	
	//update profiletype and see effect 1->2, 2->3, 3->1
	// profiletype field id is 17 (from sql)
	$newPType[1]=2;
	$newPType[2]=3;
	$newPType[3]=1;
	$this->select("field17", "value=".$newPType[$ptype]);
	
	if(TEST_XIPT_JOOMLA_15)
		$this->click("//td[@id='toolbar-save']/a/span");
	    	
    else
    	$this->click("link=Save & Close");
	
	$this->waitPageLoad();
	$this->assertTrue($this->isTextPresent("User updated successfully"));
	
	// now verify settings as per new profiletype
	require_once (JPATH_BASE . '/components/com_xipt/api.xipt.php' );
	$this->assertEquals($newPType[$ptype], XiptAPI::getUserInfo($userid,'PROFILETYPE'));
	
	//also check effect on template
  }
  
  
   function testEditUserTemplate()
  {
  	//    setup default location 
    $this->adminLogin();

    //set configuration to not allow to edit
    $this->updateConfig(0,0);
    
    $this->editUserTemp(82,1);
    //$this->editUserTemp(83,2);
    $this->editUserTemp(84,3);
    
    //set configuration to allow to edit
	$this->updateConfig(0,1);
	
    $this->editUserTemp(82,2);
    //$this->editUserTemp(83,3);
    $this->editUserTemp(84,1);
    
  }
  
  function editUserTemp($userid,$ptype)
  {
  	//load editing page
  	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_community&view=users&layout=edit&id=".$userid);
    $this->waitPageLoad();
    if(TEST_XIPT_JOOMLA_15)
    	$this->click("Basic Information-page");
    	
    else
    	$this->click("//dl[@id='profile-fields']/dt[2]/span"); 
	  		
	// template field id is 16 (from sql)
	// existing template : default-82, blueface-83, blackout-84
	$newTemplate[82]='default';
	//$newTemplate[83]='blueface';
	$newTemplate[84]='blackout';

	$this->select("field16", "value=".$newTemplate[$userid]);
	if (TEST_XIPT_JOOMLA_15)
		$this->click("//td[@id='toolbar-save']/a/span");
	else
		$this->click("//li[@id='toolbar-save']/a/span");
	$this->waitPageLoad();
	$this->assertTrue($this->isTextPresent("User updated successfully"));
	
	XiptLibJomsocial::cleanStaticCache(true);
	// now verify settings as per new template
	require_once (JPATH_BASE . '/components/com_xipt/api.xipt.php' );
	$this->assertEquals($newTemplate[$userid], XiptAPI::getUserInfo($userid,'TEMPLATE'));
  }
  
function testEditUserTemplateProfiletype()
  {
  	//    setup default location 
    $this->adminLogin();

    $this->updateConfig(0,0);
    $this->editUserTempPT(82,1);
    
    // avoid caching issue
  	XiptLibJomsocial::cleanStaticCache(true);
  	
    $this->updateConfig(1,0);
//    $this->editUserTempPT(83,2);
    
    $this->updateConfig(1,0);
	$this->editUserTempPT(84,3);
    
	$this->updateConfig(1,1);
	//$this->editUserTempPT(85,1);
  }
  
  function editUserTempPT($userid, $ptype) {
  	//load editing page
  	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_community&view=users&layout=edit&id=".$userid);
  	$this->waitPageLoad();
  	
    if(TEST_XIPT_JOOMLA_15)
    	$this->click("Basic Information-page");
    	
    else 
    	$this->click("//dl[@id='profile-fields']/dt[2]/span"); 
    
	
	//update profiletype and see effect 1->2, 2->3, 3->1
	// profiletype field id is 17 (from sql)
	$newPType[1]='1';
	$newPType[2]='2';
	$newPType[3]='3';
	$this->select("field17", "value=".$newPType[$ptype]);

	$newTemplate[82]='default';
	//$newTemplate[83]='blueface';
	$newTemplate[84]='blackout';
	//$newTemplate[85]='bubble';
	$this->select("field16", "value=".$newTemplate[$userid]);

	if (TEST_XIPT_JOOMLA_15)
		$this->click("//td[@id='toolbar-save']/a/span");
	else
		$this->click("//li[@id='toolbar-save']/a/span");
	$this->waitPageLoad();
	$this->assertTrue($this->isTextPresent("User updated successfully"));
	
	// now verify settings as per new profiletype
	require_once (JPATH_ROOT . '/components/com_xipt/api.xipt.php' );
	$this->assertEquals($newPType[$ptype], XiptAPI::getUserInfo($userid,'PROFILETYPE'));
	
	// also check effect on template
	// now verify settings as per new template
	require_once (JPATH_ROOT . '/components/com_xipt/api.xipt.php' );
	$this->assertEquals($newTemplate[$userid], XiptAPI::getUserInfo($userid,'TEMPLATE'));
  }
  
  
  function testDeleteUser()
  {
  	 //setup default location 
    $this->adminLogin(); 	
    
    $this->deleteUser(82);
    $this->deleteUser(83);
    $this->deleteUser(84);
  }

  
  
  function deleteUser($userid)
  {
  	//load editing page
  	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_users");
    $this->waitPageLoad();
   
    $this->click("//input[contains(@type,'checkbox')][contains(@value,'".$userid."')]");
    if(TEST_XIPT_JOOMLA_15)
       $this->click("//td[@id='toolbar-delete']/a/span");
    else
       $this->click("//li[@id='toolbar-delete']/a/span");
    $this->waitPageLoad();
    $this->assertTrue($this->checkDeletedUser($userid));
  }
  
  
	function checkDeletedUser($userid)
	{
	  	$db	= JFactory::getDBO();
	  	$query	= " SELECT * FROM #__xipt_users"
	  			." WHERE `userid`='". $userid ."'"
	  			." LIMIT 1";
	  	$db->setQuery($query);
	  	$userPtypeInfo = $db->loadObject();
	  	
	  	if(empty($userPtypeInfo))
	  		return true;
	  		
	  	return false;
	 }
}
?>
