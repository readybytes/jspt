<?php

class XiptUnhookHelperTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	function testDisableCustomFields()
	{
		$cfields = $this->getCustomFieldsStatus();
		if(count($cfields) < 2)
			$this->assertFalse(1,"JSPT setup required");
			
		$this->enableCustomFields();
		
		XiptHelperUnhook::disableCustomFields();
		$cfields = $this->getCustomFieldsStatus();
		$this->assertEquals($cfields[0]['published'],0);
		$this->assertEquals($cfields[1]['published'],0);
		
		$this->enableCustomFields();
	}
	
	function getCustomFieldsStatus()
	{
		$db		= JFactory::getDBO();		
		$query	= 'SELECT * FROM ' . $db->nameQuote( '#__community_fields' )				
	          	  .' WHERE '.$db->nameQuote('type').'='.$db->Quote('profiletypes')
	          	  .' OR '.$db->nameQuote('type').'='.$db->Quote('templates');
	
		$db->setQuery($query);		
		return $db->loadAssocList();		
	}

	function enableCustomFields()
	{
		$db		=& JFactory::getDBO();		
		$query	= 'UPDATE ' . $db->nameQuote( '#__community_fields' )
				. ' SET '.$db->nameQuote('published').'='.$db->Quote('1')
	          	.' WHERE '.$db->nameQuote('type').'='.$db->Quote('profiletypes')
	          	.' OR '.$db->nameQuote('type').'='.$db->Quote('templates');
	
		$db->setQuery($query);		
		if(!$db->query())
			return false;
		return true;
	} 
	
	function xtestUncopyHackedFiles()
	{
		require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'install'.DS.'helper.php';		
		$filestoreplace = XiptHelperInstall::_getJSPTFileList();
		
		XiptHelperUnhook::uncopyHackedFiles();
		$this->assertTrue($this->isModelFilePatchRequired());
		$this->assertTrue($this->isAdminUserModelPatchRequired());
		$this->assertTrue($this->isXMLFilePatchRequired());
		$this->assertTrue($this->isCustomLibraryFieldRequired());
		
		XiptHelperInstall::copy_files();		
	}
	
	function isModelFilePatchRequired()
	{
		$filename = JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'models'.DS.'profile.php';
		if (JFile::exists($filename)) {
			
			if(!is_readable($filename)) 
				XiptError::raiseWarning(sprintf(JText::_('FILE IS NOT READABLE PLEASE CHECK PERMISSION'),$filename));
			
			$file = JFile::read($filename);
			
			$searchString = '$pluginHandler=& XiptFactory::getLibraryPluginHandler()';
			$count = substr_count($file,$searchString);
			if($count >= 3)
				return false;
				
			return true;
		}	
		return false;
	}
	
	function isAdminUserModelPatchRequired()
	{
		// return false;
		// we need to patch User Model
		$filename = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_community'.DS.'models'.DS.'users.php';
		if (JFile::exists($filename)) {
			
			if(!is_readable($filename)) 
				XiptError::raiseWarning(sprintf(JText::_('FILE IS NOT READABLE PLEASE CHECK PERMISSION'),$filename));
			
			$file =JFile::read($filename);
			
			$searchString = '$pluginHandler->onProfileLoad($userId, $result, __FUNCTION__);';
			$count = substr_count($file,$searchString);
			if($count >= 1)
				return false;
				
			return true;
		}	
		return false;
	}
	
	function isXMLFilePatchRequired()
	{
		$filename	= JPATH_ROOT . DS. 'components' . DS . 'com_community'.DS.'libraries'.DS.'fields'.DS.'customfields.xml';
		if (JFile::exists($filename)) {
			
			if(!is_readable($filename)) 
				XiptError::raiseWarning(sprintf(JText::_('FILE IS NOT READABLE PLEASE CHECK PERMISSION'),$filename));
			
			$file = JFile::read($filename);
			
			if(!$file)
				return false;
				
			$searchString = PROFILETYPE_FIELD_TYPE_NAME;
			$count = substr_count($file,$searchString);
			if($count >= 1)
				return false;
				
			return true;
		}	
		return false;
	}
	
	function isCustomLibraryFieldRequired()
	{
		$pFileName = JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'fields'.DS.PROFILETYPE_FIELD_TYPE_NAME.'.php';
		$pLibrary = JFile::exists($pFileName);
    	$tFileName = JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'fields'.DS.TEMPLATE_FIELD_TYPE_NAME.'.php';
    	$tLibrary = JFile::exists($tFileName);

    	if($pLibrary && $tLibrary)
    		return false;
    		
    	return true;
	}
}

