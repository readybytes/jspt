<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class XiPTHelperSetup 
{


	//check existance of custom fields profiletype and template
	function checkExistanceOfCustomFields($what,$checkenable=false)
	{
		$db		=& JFactory::getDBO();
		
		$extraChk = '';
		if($checkenable)
			$extraChk = ' AND '.$db->nameQuote('published').'='.$db->Quote(1);
			
		$query	= 'SELECT * FROM ' . $db->nameQuote( '#__community_fields' ) . ' '
				. 'WHERE '.$db->nameQuote('fieldcode').'='. $db->Quote($what)
				. $extraChk;
				
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
						XiPTLibraryUtils::XAssert(0);
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
	
	//call fn don't write update query here
	function enableField($fieldcode)
	{
		$db			=& JFactory::getDBO();
			
		$query	= 'UPDATE ' . $db->nameQuote( '#__community_fields' )
				. ' SET '.$db->nameQuote('published').'='.$db->Quote('1')
	          	.' WHERE '.$db->nameQuote('fieldcode').'='.$db->Quote($fieldcode);

		$db->setQuery($query);		
		if(!$db->query())
			return false;
			
		return true;
	}
	
	
	function checkCustomfieldRequired()
	{
		if(!self::checkExistanceOfCustomFields(PROFILETYPE_CUSTOM_FIELD_CODE)
			|| !self::checkExistanceOfCustomFields(TEMPLATE_CUSTOM_FIELD_CODE))
			return true;

		//check field enable required
		if(!self::checkExistanceOfCustomFields(PROFILETYPE_CUSTOM_FIELD_CODE,true)
			|| !self::checkExistanceOfCustomFields(TEMPLATE_CUSTOM_FIELD_CODE,true))
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
		if (JFile::exists($filename)) {
			
			if(!is_readable($filename)) 
				JError::raiseWarning(sprintf(JText::_('FILE IS NOT READABLE PLEASE CHECK PERMISSION'),$filename));
			
			$file = JFile::read($filename);
			
			$searchString = '$pluginHandler=& XiPTFactory::getLibraryPluginHandler()';
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
				JError::raiseWarning(sprintf(JText::_('FILE IS NOT READABLE PLEASE CHECK PERMISSION'),$filename));
			
			$file =JFile::read($filename);
			
			$searchString = '$pluginHandler->onProfileLoad($userId, $result, __FUNCTION__);';
			$count = substr_count($file,$searchString);
			if($count >= 1)
				return false;
				
			return true;
		}	
		return false;
	}
	
	function checkFilePatchRequired()
	{
		$modelPatch = self::isModelFilePatchRequired();
		$userPatch  = self::isAdminUserModelPatchRequired();
		$xmlPatch   = self::isXMLFilePatchRequired();
		$libraryField = self::isCustomLibraryFieldRequired();
		
		if(!$modelPatch && !$userPatch
				&& !$xmlPatch && !$libraryField)
			return false;
			
		return true;
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
	
	//retrun true if plugin is installed or enabled
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
		
		if (JFile::exists($filename)) {
		
			if(!is_readable($filename)) 
				JError::raiseWarning(sprintf(JText::_('FILE IS NOT READABLE PLEASE CHECK PERMISSION'),$filename));
			
			$file = JFile::read($filename);
			if(!$file)
				return false;
			
	    	$fileParts = explode($funcName, $file);
    	    
	    	if(count($fileParts) >= 2) {
	    	    $firstPos = strpos($fileParts[1],$searchString);
	    	    $beforeStr = substr($fileParts[1],0,$firstPos);
	    	    $afterStr = substr($fileParts[1],$firstPos+strlen($searchString));
	    	    $fileParts[1]=$beforeStr . $replaceString . $afterStr;
	    	    $file = $fileParts[0].$funcName.$fileParts[1];
	    	    JFile::write($filename,$file);
	    	    return true;
	    	}
		}
		return false;
	}
	
	
	function isXMLFilePatchRequired()
	{
		$filename	= JPATH_ROOT . DS. 'components' . DS . 'com_community'.DS.'libraries'.DS.'fields'.DS.'customfields.xml';
		if (JFile::exists($filename)) {
			
			if(!is_readable($filename)) 
				JError::raiseWarning(sprintf(JText::_('FILE IS NOT READABLE PLEASE CHECK PERMISSION'),$filename));
			
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
	

	function copyLibraryFiles()
	{
		$XIPT_PATH_ADMIN	  = JPATH_ROOT .DS. 'administrator' .DS.'components' . DS . 'com_xipt';
	
		$COMMUNITY_PATH_FRNTEND = JPATH_ROOT .DS. 'components' . DS . 'com_community';
		
		$sourceFile = $XIPT_PATH_ADMIN.DS.'hacks'.DS.'front_libraries_fields_profiletypes.php';
		$targetFile = $COMMUNITY_PATH_FRNTEND.DS.'libraries'.DS.'fields'.DS.'profiletypes.php';
		JFile::copy($sourceFile, $targetFile) || JError::raiseError('INSTERR', "Not able to copy file ".$sourceFile ." to ".$targetFile) ;
		
		$sourceFile = $XIPT_PATH_ADMIN.DS.'hacks'.DS.'front_libraries_fields_templates.php';
		$targetFile = $COMMUNITY_PATH_FRNTEND.DS.'libraries'.DS.'fields'.DS.'templates.php';
		JFile::copy($sourceFile, $targetFile) || JError::raiseError('INSTERR', "Not able to copy file ".$sourceFile ." to ".$targetFile) ;
		return;
	}
	
	function isAECMIRequired(){
		if(!XiPTLibraryAEC::_checkAECExistance())
			return false;
		
		$miFilename = JPATH_ROOT.DS.'components'.DS.'com_acctexp'.DS.'micro_integration'.DS.'mi_jomsocialjspt.php';
		if(JFile::exists($miFilename))
			return false;
		else
			return true;
	}

	function copyAECfiles(){
		$miFilename = JPATH_ROOT.DS.'components'.DS.'com_acctexp'.DS.'micro_integration'.DS.'mi_jomsocialjspt.php';
		$sourceMIFilename = JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'hacks'.DS.'mi_jomsocialjspt.php';

		if(JFile::exists($miFilename))
			return true;
		else 
			return JFile::copy($sourceMIFilename , $miFilename);
	}
	
	
	function syncUpUserPTRequired()
	{
		$params = XiPTLibraryUtils::getParams('', 0);
		$defaultProfiletypeID = $params->get('defaultProfiletypeID',0);
		if(!$defaultProfiletypeID){
			global $mainframe;
			$mainframe->enqueueMessage(JText::_("FIRST SELECT THE DEFAULT PROFILE TYPE"));
			return false;
		}

		//for every user
		$db 	=& JFactory::getDBO();
		$query	= ' SELECT `id` FROM `#__community_fields` '
				. ' WHERE `fieldcode`=\''.PROFILETYPE_CUSTOM_FIELD_CODE.'\' ';
		$db->setQuery($query);
		$PTFieldId=$db->loadResult();
		
		$query	= ' SELECT `id` FROM `#__community_fields` '
				. ' WHERE `fieldcode`=\''.TEMPLATE_CUSTOM_FIELD_CODE.'\' ';
		$db->setQuery($query);
		$TMFieldId=$db->loadResult();
		
		// we need first these fields to be exist
		if(!($PTFieldId && $TMFieldId))
			return true;
			
		$query 	= ' SELECT u.`userid` as id, vPT.`value` AS vptype, vTM.`value` AS vtemp, xUser.* '
				.' FROM `#__community_users` AS u '
				.' LEFT JOIN `#__community_fields_values` AS vPT'
        		.' ON ( vPT.`user_id` = u.`userid` AND  vPT.`field_id`='.$db->Quote($PTFieldId).')'
				.' LEFT JOIN `#__community_fields_values` AS vTM'
        		.' ON ( vTM.`user_id` = u.`userid` AND  vTM.`field_id`='.$db->Quote($TMFieldId).')'
				.' LEFT JOIN `#__xipt_users` AS '.'xUser'
        		.' ON ( xUser.`userid` = u.`userid` )';
        			
		$db->setQuery($query);
		$result = $db->loadObjectList();

		if(empty($result))
		{
			//not required XiPTLibraryUtils::XAssert b'coz from backend fisrt time admin will not have entry in community table
			//and that time it will XiPTLibraryUtils::XAssert
			//when admin login from front-end commuity create entry for admin in community_users table
			//XiPTLibraryUtils::XAssert(0);
			return false;
		}
		
		foreach ($result as $r){
			if(!($r->vptype && $r->profiletype && $r->vtemp && $r->template) 
					|| XiPTLibraryProfiletypes::validateProfiletype($r->profiletype)==false)
				return true;
				
			if($r->vptype != $r->profiletype)
				return true;
			if($r->vtemp != $r->template)
				return true;
		}
		
		return false;
	}
	
	function syncUpUserPT($start, $limit)
	{
		
		//	for every user
		$db 	=& JFactory::getDBO();
		$query	= ' SELECT `id` FROM `#__community_fields` '
				. ' WHERE `fieldcode`=\''.PROFILETYPE_CUSTOM_FIELD_CODE.'\' ';
		$db->setQuery($query);
		$PTFieldId=$db->loadResult();
		
		$query	= ' SELECT `id` FROM `#__community_fields` '
				. ' WHERE `fieldcode`=\''.TEMPLATE_CUSTOM_FIELD_CODE.'\' ';
		$db->setQuery($query);
		$TMFieldId=$db->loadResult();
		
		// we need first these fields to be exist
		if(!($PTFieldId && $TMFieldId))
			return false;
			
		$query 	= ' SELECT u.`userid` as id, vPT.`value` AS vptype, vTM.`value` AS vtemp, xUser.* '
				.' FROM `#__community_users` AS u '
				.' LEFT JOIN `#__community_fields_values` AS vPT'
        		.' ON ( vPT.`user_id` = u.`userid` AND  vPT.`field_id`='.$db->Quote($PTFieldId).')'
				.' LEFT JOIN `#__community_fields_values` AS vTM'
        		.' ON ( vTM.`user_id` = u.`userid` AND  vTM.`field_id`='.$db->Quote($TMFieldId).')'
				.' LEFT JOIN `#__xipt_users` AS '.'xUser'
        		.' ON ( xUser.`userid` = u.`userid` ) '
        		.' LIMIT '.$start.','.$limit;
        			
		$db->setQuery($query);
		$result = $db->loadObjectList();
					
		 $i=0;
		foreach ($result as $r){
			
			//skip correct users
			if($r->vptype && $r->profiletype && $r->vtemp && $r->template && XiPTLibraryProfiletypes::validateProfiletype($r->profiletype)==true)
			{
				if(($r->vptype == $r->profiletype) && ($r->vtemp == $r->template))
					continue;
			}
			
			//It ensure that system will pickup correct data
			$profiletype = XiPTLibraryProfiletypes::getUserData($r->id,'PROFILETYPE');
			if(XiPTLibraryProfiletypes::validateProfiletype($profiletype)==true)
			{
				$template	 = XiPTLibraryProfiletypes::getUserData($r->id,'TEMPLATE');
			}
			else
			{
				$profiletype = XiPTLibraryProfiletypes::getDefaultProfiletype();
				$template	 = XiPTLibraryProfiletypes::getProfileTypeData($profiletype,'template');;
			}
			XiPTLibraryProfiletypes::updateUserProfiletypeData($r->id, $profiletype, $template, 'ALL');
			$i++;
		}
		global $mainframe;
		if(sizeof($result)== $limit){			
			$start+=$limit;
    		$mainframe->redirect(JRoute::_("index.php?option=com_xipt&view=setup&task=syncUpUserPT&start=$start",false));
		}
		
		$msg = 'Total '. ($start+$i) . ' users '.JText::_('synchornized');
		$mainframe->enqueueMessage($msg);
		return true;
	}
	
	
	function migrateAvatarRequired()
	{
		//check for avatar
		$imgPrefix 			= 'avatar_';
		$profiletypes = XiPTLibraryProfiletypes::getProfiletypeArray();
		
		if(!$profiletypes)
			return false;
			
		//get avatars of all profileype 
		foreach($profiletypes as $profiletype)
		{
			$pId 	= $profiletype->id;
			$avatar = $profiletype->avatar;

			//if avatar is default then skip
			if($avatar == DEFAULT_AVATAR)
				continue;
			
			//create proper names 
			$type = JFile::getExt($avatar);
			$storageImage= PROFILETYPE_AVATAR_STORAGE_REFERENCE_PATH. DS .$imgPrefix. $pId .".$type" ;
			
			//if avatar is already in new format 
			if($avatar == $storageImage)
				continue;
			else
				return true;
		}
		
		return false;
	}
	
	function get_js_version()
	{	
		$CMP_PATH_ADMIN	= JPATH_ROOT . DS. 'administrator' .DS.'components' . DS . 'com_community';
	
		$parser		=& JFactory::getXMLParser('Simple');
		$xml		= $CMP_PATH_ADMIN . DS . 'community.xml';
	
		$parser->loadFile( $xml );
	
		$doc		=& $parser->document;
		$element	=& $doc->getElementByPath( 'version' );
		$version	= $element->data();
	
		return $version;
	}
	
	function isWaterMarkingRequired()
	{
		$ptypeArray	= XiPTHelperProfiletypes::getProfileTypeArray();
		$globalWM	= XiPTLibraryUtils::getParams('show_watermark',0);
		if($globalWM)
			return false;
		foreach($ptypeArray as $ptype)
		{
			$watermarkParams = XiPTLibraryProfiletypes::getParams($ptype,'watermarkparams');
			if($watermarkParams == false)
				continue;
			if($watermarkParams->get('enableWaterMark',0) == true)
				return true;
		}
		
		return false;		
	}
}
