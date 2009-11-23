<?php
// Check to ensure this file is within the rest of the framework
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.folder' );
jimport('joomla.filesystem.file');

require_once dirname(JPATH_BASE).DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'jspt_functions.php';
function com_uninstall()
{
	uncopyHackedFiles();
	// disable plugins
	disable_plugin('xipt_system');
	disable_plugin('xipt_plugin');
	
	//CODREV:TODO disable custom fields
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
