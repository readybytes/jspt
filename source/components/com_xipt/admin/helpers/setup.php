<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class XiPTHelperSetup 
{


	//check existance of custome fields profiletype and template
	function checkExistanceOfCustomFields($what)
	{
		$db		=& JFactory::getDBO();
		
		$query	= 'SELECT * FROM ' . $db->nameQuote( '#__community_fields' ) . ' '
				. 'WHERE '.$db->nameQuote('fieldcode').'='. $db->Quote($what);
				
		$db->setQuery( $query );
		
		$result = $db->loadObject();
		if(!$result)
			return false;
			
		return true;
	}
	
	
	//create custome field
	function createCustomField($what)
	{
		$group = 0;
		//get first group name from community_fields_values table
		$allGroups = self::getGroups();
		if(!empty($allGroups))
			$group = $allGroups[0]->ordering;
		// Load the JTable Object.
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_community'.DS.'tables');
		$row	=& JTable::getInstance( 'profiles' , 'CommunityTable' );
		$row->load(0);
		switch($what) {
			case PROFILETYPE_CUSTOM_FIELD_CODE:
						$data['type']			= PROFILETYPE_FIELD_TYPE_NAME;
						$data['name']			= 'Profiletype';
						$data['tips']			= 'Profiletype Of User';
						break;
			case TEMPLATE_CUSTOM_FIELD_CODE:
						$data['type']			= TEMPLATE_FIELD_TYPE_NAME;
						$data['name']			= 'Template';
						$data['tips']			= 'Template Of User';
						break;
			default :
						assert(0);
						break;
		}
		$data['fieldcode']		= $what;
		$data['group']			= $group;
		
		$row->bind( $data );
		$groupOrdering	= isset($data['group']) ? $data['group'] : '';
		
		if($row->store( $groupOrdering ))
			return true;
			
		return false;
		
	}
	
	function checkCustomfieldRequired()
	{
		if(!self::checkExistanceOfCustomFields(PROFILETYPE_CUSTOM_FIELD_CODE)
			|| !self::checkExistanceOfCustomFields(TEMPLATE_CUSTOM_FIELD_CODE))
			return true;
			
		return false;
	}
	
	
	function getGroups()
	{
		$db		=& JFactory::getDBO();
		
		$query	= 'SELECT * '
				. 'FROM ' . $db->nameQuote( '#__community_fields' )
				. 'WHERE ' . $db->nameQuote( 'type' ) . '=' . $db->Quote( 'group' );

		$db->setQuery( $query );		
		
		$fieldGroups	= $db->loadObjectList();
		
		return $fieldGroups;
	}
	
	function isModelFilePatchRequired()
	{
		$filename = JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'models'.DS.'profile.php';
		if (file_exists($filename)) {
			
			if(!is_readable($filename)) 
				JError::raiseWarning(sprintf(JText::_('FILE IS NOT READABLE PLEASE CHECK PERMISSION'),$filename));
			
			$file = file_get_contents($filename);
			
			$searchString = '$pluginHandler=& XiPTFactory::getLibraryPluginHandler()';
			$count = substr_count($file,$searchString);
			if($count >= 3)
				return false;
				
			return true;
		}	
		return false;
	}
	
	
	function checkFilePatchRequired()
	{
		$modelPatch = self::isModelFilePatchRequired();
		$xmlPatch = self::isXMLFilePatchRequired();
		$libraryField = self::isCustomLibraryFieldRequired();
		
		if(!$modelPatch && !$xmlPatch && !$libraryField)
			return false;
			
		return true;
				
	}
	
	function isLibraryFieldExist($filename)
	{
		//CODREV check customfield patch required
		if (file_exists($filename))
			return true;
		else
			return false;
	}
	
	
	function isCustomLibraryFieldRequired()
	{
		global $mainframe;
		$pLibrary = false;
		$tLibrary = false;
		
		$pFileName = JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'fields'.DS.PROFILETYPE_FIELD_TYPE_NAME.'.php';
		$pLibrary = self::isLibraryFieldExist($pFileName);
    	$tFileName = JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'fields'.DS.TEMPLATE_FIELD_TYPE_NAME.'.php';
    	$tLibrary = self::isLibraryFieldExist($tFileName);

    	if($pLibrary && $tLibrary)
    		return false;
    		
    	return true;
	}
		
		
	function checkPluginInstallationRequired()
	{
		$system = false;
		$community = false;
		$msg = '';
		if(self::isPluginInstalledAndEnabled('xipt_system','system'))
			$system = true;
		
		if(self::isPluginInstalledAndEnabled('xipt_community','community'))
			$community = true;
			
		if($system && $community)
			$msg = '';
		else if(!$system && !$community)
			$msg = sprintf(JText::_("PLEASE CLICK HERE TO INSTALL PLUGIN"),'xipt_system and xipt_community');
		else if(!$system)
			$msg = sprintf(JText::_("PLEASE CLICK HERE TO INSTALL PLUGIN"),'xipt_system');
		else if(!$community)
			$msg = sprintf(JText::_("PLEASE CLICK HERE TO INSTALL PLUGIN"),'xipt_community');
		
		return $msg;
	}
	
	
	function checkPluginEnableRequired()
	{
		$sEnable = false;
		$cEnable = false;
		
		if(XiPTHelperSetup::isPluginInstalledAndEnabled('xipt_system','system')
				&& !XiPTHelperSetup::isPluginInstalledAndEnabled('xipt_system','system',true))
			$sEnable = true;

		if(XiPTHelperSetup::isPluginInstalledAndEnabled('xipt_community','community')
				&& !XiPTHelperSetup::isPluginInstalledAndEnabled('xipt_community','community',true))
			$cEnable = true;
		
		if($sEnable || $cEnable)
			return true;
			
		return false;
	}
	
	//retrun true if plugin is installed
	//type means plugin type eg :- community , system etc.
	function isPluginInstalledAndEnabled($pluginname,$type,$checkenable = false)
	{
		$db			=& JFactory::getDBO();
		
		$extraChecks = '';
		if($checkenable)
			$extraChecks = ' AND '.$db->nameQuote('published').'='.$db->Quote(true);
			
		$query	= 'SELECT * FROM ' . $db->nameQuote( '#__plugins' )
	          .' WHERE '.$db->nameQuote('folder').'='.$db->Quote($type)
	          .' AND '.$db->nameQuote('element').'='.$db->Quote($pluginname)
	          . $extraChecks;

		$db->setQuery($query);		
		
		$plugin	= $db->loadObjectList();
		
		if(!$plugin)
			return false;
			
		return true;
	}
	
	
	function enablePlugin($pluginname)
	{
		$db			=& JFactory::getDBO();
			
		$query	= 'UPDATE ' . $db->nameQuote( '#__plugins' )
				. ' SET '.$db->nameQuote('published').'='.$db->Quote('1')
	          	.' WHERE '.$db->nameQuote('element').'='.$db->Quote($pluginname);

		$db->setQuery($query);		
		if(!$db->query())
			return false;
			
		return true;
	}

	//$funcName name contain in which fn we want to replace datas
	function patchData($searchString,$replaceString,$filename,$funcName)
	{
		if (file_exists($filename)) {
		
			if(!is_readable($filename)) 
				JError::raiseWarning(sprintf(JText::_('FILE IS NOT READABLE PLEASE CHECK PERMISSION'),$filename));
			
			$file = file_get_contents($filename);
    			    	
	    	$fileParts = explode($funcName, $file);
    	    
	    	if(count($fileParts) >= 2) {
	    	    $firstPos = strpos($fileParts[1],$searchString);
	    	    $beforeStr = substr($fileParts[1],0,$firstPos);
	    	    $afterStr = substr($fileParts[1],$firstPos+strlen($searchString));
	    	    $fileParts[1]=$beforeStr . $replaceString . $afterStr;
	    	    $file = $fileParts[0].$funcName.$fileParts[1];
	    	    
	    	    file_put_contents($filename,$file);
	    	    return true;
	    	}
		}
		return false;
	}
	
	
	function isXMLFilePatchRequired()
	{
		$filename	= dirname( JPATH_BASE ) . DS. 'components' . DS . 'com_community'.DS.'libraries'.DS.'fields'.DS.'customfields.xml';
		if (file_exists($filename)) {
			
			if(!is_readable($filename)) 
				JError::raiseWarning(sprintf(JText::_('FILE IS NOT READABLE PLEASE CHECK PERMISSION'),$filename));
			
			$file = file_get_contents($filename);
			
			$searchString = PROFILETYPE_FIELD_TYPE_NAME;
			$count = substr_count($file,$searchString);
			if($count >= 1)
				return false;
				
			return true;
		}	
		return false;
	}
	

	function copyLibraryFiles()
	{
		$XIPT_PATH_ADMIN	  = dirname( JPATH_BASE ) .DS. 'administrator' .DS.'components' . DS . 'com_xipt';
	
		$COMMUNITY_PATH_FRNTEND = dirname( JPATH_BASE ) .DS. 'components' . DS . 'com_community';
		
		$sourceFile = $XIPT_PATH_ADMIN.DS.'hacks'.DS.'front_libraries_fields_profiletypes.php';
		$targetFile = $COMMUNITY_PATH_FRNTEND.DS.'libraries'.DS.'fields'.DS.'profiletypes.php';
		JFile::copy($sourceFile, $targetFile) || JError::raiseError('INSTERR', "Not able to copy file ".$sourceFile ." to ".$targetFile) ;
		
		$sourceFile = $XIPT_PATH_ADMIN.DS.'hacks'.DS.'front_libraries_fields_templates.php';
		$targetFile = $COMMUNITY_PATH_FRNTEND.DS.'libraries'.DS.'fields'.DS.'templates.php';
		JFile::copy($sourceFile, $targetFile) || JError::raiseError('INSTERR', "Not able to copy file ".$sourceFile ." to ".$targetFile) ;
		return;
	}
}