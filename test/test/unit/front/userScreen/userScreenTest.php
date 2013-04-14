<?php
require_once(JPATH_BASE .DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'base'.DS.'view.php');
class userScreenTest extends XiUnitTestCase
{
 //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  	
  	function testProfiletypeFilter()
  	{
  		$selectedPtypeData = array();
  		$data=array(80=>array('regtest6208627','regtest6208627','PROFILETYPE-1','default','Registered','80'),
  		            81=>array('regtest6208628','regtest6208628','PROFILETYPE-1','default','Registered','81'),
  		            82=>array('regtest6208629','regtest6208629','PROFILETYPE-1','default','Registered','82'));
  		$userModel	= XiptView::getModel('users');
		$users		= $userModel->getUsers(0);
		foreach ($users as $id => $userInfo){
			$ptype   = XiptViewUsers::getUserInfo($userInfo->id,'PROFILETYPE');
			$template= XiptViewUsers::getUserInfo($userInfo->id,'TEMPLATE');
			$selectedPtypeData[$userInfo->id] = array($userInfo->name,$userInfo->name,$ptype,$template,$userInfo->usertype,$userInfo->id);
			//$a[$userInfo->id]=$selectedPtypeData;
		}
		$this->assertEquals($data, $selectedPtypeData);
  	}
}