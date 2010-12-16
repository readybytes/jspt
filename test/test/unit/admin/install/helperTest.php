<?php
class InstallHelperTest extends XiUnitTestCase 
{
	//define this function if you require DB setup
  	function getSqlPath()
  	{
      	return dirname(__FILE__).'/sql/'.__CLASS__;
  	}
  	
  	
	function testEnsureXiptVersion()
	{
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'install'.DS.'helper.php');
		XiptHelperInstall::ensureXiptVersion();
  		$this->_DBO->addTable('#__xipt_settings');
	}

	function testEnsureXiptVersion2()
	{
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'install'.DS.'helper.php');
		XiptHelperInstall::ensureXiptVersion();
		XiptHelperInstall::ensureXiptVersion();
  		$this->_DBO->addTable('#__xipt_settings');
	}
	
	function testEnsureXiptVersion3()
	{
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'install'.DS.'helper.php');
		$this->assertTrue(XiptHelperInstall::ensureXiptVersion());
	}

	function testUpdateXiptVersion()
	{
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'install'.DS.'helper.php');
		XiptHelperInstall::updateXiptVersion();

		require_once JPATH_ROOT .DS. 'components' .DS. 'com_xipt' .DS. 'defines.php';
	
		$db		= JFactory::getDBO();
		$query	= 'UPDATE au_#__xipt_settings'
				.' SET '. $db->nameQuote('params') .' = '.$db->Quote(XIPT_VERSION)
				.' WHERE '. $db->nameQuote('name') .' = '.$db->Quote('version');
		$db->setQuery($query);
		return $db->query();

  		$this->_DBO->addTable('#__xipt_settings');
	}
	
	function testGetXiptVersion()
	{
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'install'.DS.'helper.php');
		$this->assertFalse(XiptHelperInstall::getXiptVersion());
	}

	function testGetXiptVersion1()
	{
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'install'.DS.'helper.php');
		require_once JPATH_ROOT .DS. 'components' .DS. 'com_xipt' .DS. 'defines.php';
		
		$db		= JFactory::getDBO();
			$query ='INSERT INTO `#__xipt_settings` ('
				. $db->nameQuote('name'). ','.$db->nameQuote('params').') VALUES ('
				 .$db->Quote('version').','.$db->Quote(XIPT_VERSION).');';
			$db->setQuery($query);	 
			$db->query();

		list($main, $mid, $svn) = explode(".", XIPT_VERSION);
		$this->assertEquals(XiptHelperInstall::getXiptVersion(), $svn);
	}
	
}