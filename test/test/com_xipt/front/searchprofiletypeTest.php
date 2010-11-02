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
		 $this->click("//input[@value='Search']");
		 $this->waitPageLoad();
		 	 
		 $textArray= array("Administrator", "regtest8635954", "regtest1674526","regtest6208627","regtest8774090");
		 $this->userPresent($textArray);
		 
		 $this->click("link=Add Criteria");
		 sleep(2);
		 $this->select("field1", "label=Profiletype");
		 $this->select("//div[@id='valueinput1']/select", "label=PROFILETYPE-1"); 
		 $this->click("operator_any");
		 $this->click("//input[@value='Search']");
		 $this->waitPageLoad();
		 
		 array_unshift($textArray,"regtest1504555","regtest3843261", "regtest7046025");
		 $this->userPresent($textArray);
		 
		$this->click("link=Add Criteria");
		sleep(2);
		$this->select("field2", "label=Profiletype");
		$this->select("//div[@id='valueinput2']/select", "label=PROFILETYPE-3");
		$this->click("//input[@value='Search']");
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
