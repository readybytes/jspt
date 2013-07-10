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

        
        $user = JFactory::getUser(82); // type1
        $this->frontLogin($user->username,$user->username);
        $this->open("index.php?option=com_community&view=apps&task=browse&Itemid=53");
        $this->waitPageLoad();
        $this->click("link=Add");
        sleep(2);
        $this->assertTrue($this->isElementPresent("//div[@id='cWindowContent']/p"));
        $this->click("cwin_close_btn");
       $this->frontLogout();


        $user = JFactory::getUser(83); // type1
        $this->frontLogin($user->username,$user->username);
        $this->open("index.php?option=com_community&view=apps&Itemid=53");
        
        $this->waitPageLoad();
        $this->click("//div[@id='community-wrap']/div[3]/div[2]/div[4]/a/span");
         sleep(2);
         $this->assertTrue($this->isElementPresent("//div[@id='cWindowContent']/div"));
         $this->click("cwin_close_btn");
   		 $this->frontLogout();
  }
  
}