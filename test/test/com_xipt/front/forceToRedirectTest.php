<?php

class ForceToRedirectTest extends XiSelTestCase 
{
  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

   function testForceToRedirect()
      {
        $users[1]=array(79,82,85);
        $users[2]=array(80,83,86);
        $users[3]=array(81,84,87);
        $version = XiSelTestCase::get_js_version();
  
    if(Jstring::stristr($version,'1.8')){
        $url =  dirname(__FILE__).'/sql/ForceToRedirectTest/testForceToRedirect.1.8.sql';
        $this->_DBO->loadSql($url);
        //XITODO: bug ,not showing pop up window.
        
   
        }
        
        $user = JFactory::getUser(82); // type1
        $this->frontLogin($user->username,$user->username);
        $this->open("index.php?option=com_community&view=apps&task=browse&Itemid=53");
        $this->waitPageLoad();
        $this->click("link=Add");
        sleep(2);
        $this->click("//input[@value='Close']");
        $this->waitPageLoad();
        $this->assertTrue($this->isElementPresent("//div[@id='community-wrap']/div[3]/ul/li[1]/a"));
        $this->frontLogout();
        
        if(!Jstring::stristr($version,'1.8'))
        	return true;


        $user = JFactory::getUser(83); // type1
        $this->frontLogin($user->username,$user->username);
        $this->open("index.php?option=com_community&view=apps&Itemid=53");
        
        $this->waitPageLoad();
        $this->click("//div[@id='community-wrap']/div[4]/div[2]/div[4]/a/span");
         sleep(2);
        $this->click("link=Add");
         sleep(2);
   		$this->click("//input[@value='Close']");
   		$this->waitPageLoad();
        $this->assertTrue($this->isElementPresent("//div[@id='community-wrap']/div[3]/ul/li[1]/a"));
        $this->frontLogout();
  }
  
}