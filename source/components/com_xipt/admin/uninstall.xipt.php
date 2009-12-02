<?php
// Check to ensure this file is within the rest of the framework
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.folder' );
jimport('joomla.filesystem.file');

require_once dirname(JPATH_BASE).DS.'includes'.DS.'application.php';

require_once dirname(JPATH_BASE).DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'jspt_functions.php';
function com_uninstall()
{
	uncopyHackedFiles();
	// disable plugins
	disable_plugin('xipt_system');
	disable_plugin('xipt_plugin');
	
	//CODREV:TODO disable custom fields
	disable_custom_fields();
	//CODREV : insert configuration data into new table
	//to preserve user global configuration settings
	store_globalconfiguration();
}

function disable_plugin($pluginname)
{
	$db			=& JFactory::getDBO();		
	$query	= 'UPDATE ' . $db->nameQuote( '#__plugins' )
			. ' SET '.$db->nameQuote('published').'='.$db->Quote('0')
          	.' WHERE '.$db->nameQuote('element').'='.$db->Quote($pluginname);

	$db->setQuery($query);		
	if(!$db->query())
		return false;
	return true;
} 


function disable_custom_fields()
{
	$db			=& JFactory::getDBO();		
	$query	= 'UPDATE ' . $db->nameQuote( '#__community_fields' )
			. ' SET '.$db->nameQuote('published').'='.$db->Quote('0')
          	.' WHERE '.$db->nameQuote('type').'='.$db->Quote('profiletypes')
          	.' OR '.$db->nameQuote('type').'='.$db->Quote('templates');

	$db->setQuery($query);		
	if(!$db->query())
		return false;
	return true;
} 


function uncopyHackedFiles()
{
	$filestoreplace = getJSPTFileList();
   
	if($filestoreplace) 
	foreach($filestoreplace AS $sourceFile => $targetFile)
	{
		$targetFileBackup = $targetFile.'.jxibak';
		// delete this file
		// Only delete if you have backup copy
		if(JFile::exists($targetFile) && JFile::exists($targetFileBackup))
		{
			JFile::delete($targetFile);
			JFile::move($targetFileBackup,$targetFile) || JError::raiseError('XIPT-UNINSTALL-ERROR','Not able to restore backup') ;
		}		
	}
}


function store_globalconfiguration()
{
	$db = JFactory::getDBO();
	//create global configuration table
	$query = 'CREATE TABLE IF NOT EXISTS `#__xipt_temp_globalconfiguration` (
				`params` text NOT NULL  
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8';
	
	$db->setQuery($query);
	if(!$db->query())
		JError::raiseError('XIPT-UNINSTALL-ERROR','Not able to create global configuration table') ;
		
	$query = 'TRUNCATE TABLE `#__xipt_temp_globalconfiguration`';
	$db->setQuery($query);
	if(!$db->query())
		JError::raiseError('XIPT-UNINSTALL-ERROR','Not able to truncate table') ;
	
	//insert data in table
	$jsite = new JSite();
	$params			=& $jsite->getParams('com_xipt');
	//$db->insertObject('#__xipt_temp_globalconfiguration',$data);
	$query = 'INSERT INTO '.$db->nameQuote('#__xipt_temp_globalconfiguration')
			.'('
			. $db->nameQuote('params').' '
			.') '
			.'VALUES('
			.$db->Quote($params->_raw)
			.') ';
	
	$db->setQuery( $query );
	$db->query();
			
	if($db->getErrorNum())
		JError::raiseError( 500, $db->stderr());
	
	return true;
}
