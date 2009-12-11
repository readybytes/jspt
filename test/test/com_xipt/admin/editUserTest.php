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
  	 $sql = "UPDATE `#__components` 
SET `params`=
'show_ptype_during_reg=".$ptype." 
allow_user_to_change_ptype_after_reg=0 
defaultProfiletypeID=1 
jspt_show_radio=1 
allow_templatechange=".$temp." 
aec_integrate=0 aec_message=b 
jspt_restrict_reg_check=0 
jspt_prevent_username= 
jspt_allowed_email= '
WHERE `parent`='0' AND `option` ='com_xipt' LIMIT 1 ;";
    $this->_DBO->execSql($sql);
  }
  
  function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl( JOOMLA_LOCATION."/administrator/index.php?option=com_login");
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
    $this->click("Basic Information-page");
    
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
	  	
	$this->click("//td[@id='toolbar-save']/a/span");
	$this->waitPageLoad();
	$this->assertTrue($this->isTextPresent("User updated successfully"));

	//verify
	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_community&view=users&layout=edit&id=".$userid);
    $this->waitPageLoad();
    $this->click("Basic Information-page");
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
  	$this->click("Basic Information-page");
    
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
	$this->click("//td[@id='toolbar-save']/a/span");
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
    $this->editUserTemp(83,2);
    $this->editUserTemp(84,3);
    
    //set configuration to allow to edit
	$this->updateConfig(0,1);
	
    $this->editUserTemp(82,2);
    $this->editUserTemp(83,3);
    $this->editUserTemp(84,1);
    
  }
  
  function editUserTemp($userid,$ptype)
  {
  	//load editing page
  	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_community&view=users&layout=edit&id=".$userid);
    $this->waitPageLoad();
    $this->click("Basic Information-page");
	  		
	// template field id is 16 (from sql)
	// existing template : default-82, blueface-83, blackout-84
	$newTemplate[82]='blueface';
	$newTemplate[83]='blackout';
	$newTemplate[84]='default';

	$this->select("field16", "value=".$newTemplate[$userid]);
	$this->click("//td[@id='toolbar-save']/a/span");
	$this->waitPageLoad();
	$this->assertTrue($this->isTextPresent("User updated successfully"));
	
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
    
    $this->updateConfig(1,0);
    $this->editUserTempPT(83,2);
    
    $this->updateConfig(1,0);
   	$this->editUserTempPT(84,3);
    
	$this->updateConfig(1,1);
   	$this->editUserTempPT(85,1);
  }
  
  function editUserTempPT($userid, $ptype) {
  	//load editing page
  	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_community&view=users&layout=edit&id=".$userid);
  	$this->waitPageLoad();
  	$this->click("Basic Information-page");
    
	
	//update profiletype and see effect 1->2, 2->3, 3->1
	// profiletype field id is 17 (from sql)
	$newPType[1]=2;
	$newPType[2]=3;
	$newPType[3]=1;
	$this->select("field17", "value=".$newPType[$ptype]);

	$newTemplate[82]='blueface';
	$newTemplate[83]='blackout';
	$newTemplate[84]='default';
	$newTemplate[85]='bubble';
	$this->select("field16", "value=".$newTemplate[$userid]);
		
	$this->click("//td[@id='toolbar-save']/a/span");
	$this->waitPageLoad();
	$this->assertTrue($this->isTextPresent("User updated successfully"));
	
	// now verify settings as per new profiletype
	require_once (JPATH_BASE . '/components/com_xipt/api.xipt.php' );
	$this->assertEquals($newPType[$ptype], XiptAPI::getUserInfo($userid,'PROFILETYPE'));
	
	//also check effect on template
		// now verify settings as per new template
	require_once (JPATH_BASE . '/components/com_xipt/api.xipt.php' );
	$this->assertEquals($newTemplate[$userid], XiptAPI::getUserInfo($userid,'TEMPLATE'));
  }
  
}
?>
