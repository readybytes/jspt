<?php

class RouterTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	function setUp()
	{
		parent::setUp();
	}


	function getURLs()
	{
		//XITODO: add more menus with task. 
		$url =
		array(
		/*with item id*/
		"index.php?option=com_xipt&view=registration&Itemid=61"
			=> "/usr/bin/index.php/profile-type-1-registration.html",
		"index.php?option=com_xipt&view=registration&Itemid=62"	
		    => "/usr/bin/index.php/jsptview.html",
		/*without item id*/
		"index.php?option=com_xipt&view=registration"
			=> "/usr/bin/index.php/profile-type-1-registration.html",
			
		/* preserve extra vars*/
		"index.php?option=com_xipt&view=registration&stupid=1"
			=> "/usr/bin/index.php/profile-type-1-registration.html?stupid=1"
		);

		return $url;
	}

	function testRoute()
	{
		$filter['sef'] = 1;
   		$filter['sef_suffix'] = 1;
   		$this->updateJoomlaConfig($filter);
   		
		$urls = $this->getURLs();
		foreach($urls as $url => $seoUrl)
			$this->assertEquals($seoUrl,JRoute::_($url,false), " Input URL was $url");

		$filter['sef'] = 0;
   		$filter['sef_suffix'] = 0;
   		$this->updateJoomlaConfig($filter);
	}

	function getSEOURLs()
	{
		$url =
		array(
		/*with item id*/
		"/usr/bin/index.php/profile-type-1-registration.html"
			=> array(
				"Itemid" => 61,
				"option" => "com_xipt",
				"view" 	 => "registration"
				),
		"/usr/bin/index.php/jsptview.html"
			=> array(
				"Itemid" => 62,
				"option" => "com_xipt",
				"view" 	 => "registration"
				)
		);

		return $url;
	}

	function testParse()
	{
		$urls = $this->getSEOURLs();
		foreach($urls as $url => $data)
		{
			$uri = new JURI($url);
			$output = JFactory::getApplication()->getRouter()->parse($uri);
			foreach($data as $key=> $value)
				$this->assertEquals($value, @$output[$key], " Parsing this $url => Output is ". var_export($output,true). " Expected was :".var_export($data, true));
		}
	}

	function getNoMenuURLs()
	{
		$url =
		array(
		/* preserve extra vars*/
		"index.php?option=com_xipt&view=registration"
			=> "/usr/bin/index.php/component/xipt/?view=registration"
		);

		return $url;
	}
	
	function xxxtestRouteWithNoMenu()
	{
		$filter['sef'] = 1;
   		$filter['sef_suffix'] = 1;
   		$this->updateJoomlaConfig($filter);
   		
		$urls = $this->getNoMenuURLs();
		foreach($urls as $url => $seoUrl)
			$this->assertEquals($seoUrl,JRoute::_($url,false), " Input URL was $url");
		
	}
	
}