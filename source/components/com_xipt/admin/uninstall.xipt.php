<?php
// Check to ensure this file is within the rest of the framework
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.folder' );
jimport('joomla.filesystem.file');

require_once dirname(JPATH_BASE).DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'jspt_functions.php';
function com_uninstall()
{
	uncopyHackedFiles();
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
			JFile::move($targetFileBackup,$targetFile) or J ;
		}		
	}
}
