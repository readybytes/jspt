<?php

class SearchProfileType extends XiSelTestCase {
	
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testSearchByProfileTypes() {
		//$url = dirname(__FILE__).'/sql/'.__CLASS__.DS.__FUNCTION__.'.start.sql';
		//$this->_DBO->loadSql($url);
		$this->frontLogin();
		//$this->waitPageLoad();
		
		$this->open(JOOMLA_LOCATION."/index.php?option=com_community&view=search&task=advancesearch");
		$this->waitPageLoad();
		
		 $this->select("field0", "label=Profiletype");
		 $this->assertTrue($this->isElementPresent("//select[@id='profiletypes']"));
         if(TEST_XIPT_JOOMLA_15){
         	$this->click("//div[@id='optionContainer']/div[2]/input[5]");
          }
       else {
        	$this->click("//div[@id='optionContainer']/div[2]/input[2]");
          }
		 $this->waitPageLoad();
		 	 
		 $textArray= array("regtest8635954", "regtest1674526","regtest6208627","regtest8774090");
		 // XiTODO:: joomla 1.6 admin is not searchable
		 if(TEST_XIPT_JOOMLA_15)
		 	$textArray= array_merge($textArray,array("Administrator"));
		 
		 $this->userPresent($textArray);
		 
		 $this->click("link=Add Criteria");
		 sleep(2);
		 $this->select("field1", "label=Profiletype");
		 $this->select("//div[@id='valueinput1']/select", "label=PROFILETYPE-1"); 
		 $this->click("operator_any");
        
         if(TEST_XIPT_JOOMLA_15){
         $this->click("//div[@id='optionContainer']/div[2]/input[5]");
          }
       else {
        $this->click("//div[@id='optionContainer']/div[2]/input[2]");
          }
		 $this->waitPageLoad();
		 
		 array_unshift($textArray,"regtest1504555","regtest3843261", "regtest7046025");
		 $this->userPresent($textArray);
		 
		$this->click("link=Add Criteria");
		sleep(2);
		$this->select("field2", "label=Profiletype");
		$this->select("//div[@id='valueinput2']/select", "label=PROFILETYPE-3");
	
         if(TEST_XIPT_JOOMLA_15){
         $this->click("//div[@id='optionContainer']/div[2]/input[5]");
          }
       else {
        $this->click("//div[@id='optionContainer']/div[2]/input[2]");
          }
		$this->waitPageLoad();
		
		array_unshift($textArray, "regtest1789672", "regtest6461827");
		$this->userPresent($textArray); 
	}
	
	function userPresent($uname)
	{
		foreach ($uname as $name)
		  $this->assertTrue($this->isTextPresent($name), "$name should be here, but not available");
	}
	
}
