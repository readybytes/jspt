<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');


require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt' .DS. 'jspt_functions.php';

function show_instruction()
{
	$siteURL  = JURI::base();
	if(strstr($siteURL,'localhost')==false)
	{
		$version  = get_js_version();
		
		$siteURL  = JURI::base();
	}
}


function check_version()
{
	$version = get_js_version();
	
	if(Jstring::stristr($version,'1.5'))
	{?>
		<div>
			ERROR : The JomSocial Version [<?php echo $version; ?>] used by you is not supported for ProfileTypes.
			The JSPT 2.x.x release will only supports newer version of JomSocial since JomSocial 1.6.184.
		</div>	
		<?php
		return false;
	}
	return true;
}

function copyAECfiles()
{
	$miFilename = JPATH_ROOT.DS.'components'.DS.'com_acctexp'.DS.'micro_integration'.DS.'mi_jomsocialjspt.php';
	$sourceMIFilename = JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'hacks'.DS.'mi_jomsocialjspt.php';

	if(JFile::exists($miFilename))
		return JFile::copy($sourceMIFilename , $miFilename);	
	
	return true;	
}

function com_install()
{	
	if(check_version() == false)
		JError::raiseWarning('INSTERR', "XIPT Only support Jomsocial 1.6 or greater releases");
		
	if(copyAECfiles() == false)
		JError::raiseError('INSTERR', "Not able to replace MI files, Check permissions.");
	
	if(installExtensions() == false){
		JError::raiseError('INSTERR', XiptText::_("NOT ABLE TO INSTALL EXTENSIONS"));
		return false;
	}	
	show_instruction();
	
	changePluginState('xipt_system',true);
	changePluginState('xipt_community',true);
	return true;
}




function check_jomsocial_existance()
{
	$jomsocial_admin = JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_community';
	$jomsocial_front = JPATH_ROOT . DS . 'components' . DS . 'com_community';
	
	if(!is_dir($jomsocial_admin))
		return false;
	
	if(!is_dir($jomsocial_front))
		return false;
	
	return true;
}


function copy_files() 
{
	$filestoreplace = getJSPTFileList();
	$MY_PATH_ADMIN	  = JPATH_ROOT . DS. 'administrator' .DS.'components' . DS . 'com_xipt';
	
	foreach($filestoreplace AS $key => $val)
	{
		$sourceFile		= $MY_PATH_ADMIN.DS.'hacks'.DS.$key;
		$targetFile		= $val;
		$targetFileBackup 	= $targetFile.'.jxibak';

		assert(JFile::exists($sourceFile)) || JError::raiseError('INSTERR', "File does not exist ".$sourceFile);
			
		// do backup first if we really have some file to replace
		if(JFile::exists($targetFile)){
			
			// previous backup, delete it.
			if(JFile::exists($targetFileBackup)){
				JFile::delete($targetFileBackup);
			}
			
			// create a backup
			JFile::move($targetFile, $targetFileBackup);
		}

		// now copy files
		assert(JFile::move($sourceFile, $targetFile)) || JError::raiseError('INSTERR', "Not able to copy file ".$sourceFile ." to ".$targetFile) ;
	}
	return true;
}

function installExtensions($extPath=null)
{
	//if no path defined, use default path
	if($extPath==null)
		$extPath = dirname(__FILE__).DS.'extensions';

	if(!JFolder::exists($extPath))
		return false;
	
	$extensions	= JFolder::folders($extPath);
	
	//no apps there to install
	if(empty($extensions))
		return true;

	//get instance of installer
	$installer =  new JInstaller();
	$installer->setOverwrite(true);

	//install all apps
	foreach ($extensions as $ext)
	{
		$msg = "Supportive Plugin/Module $ext Installed Successfully";

		// Install the packages
		if($installer->install($extPath.DS.$ext)==false)
			$msg = "Supportive Plugin/Module $ext Installation Failed";

		//enque the message
		JFactory::getApplication()->enqueueMessage($msg);
	}

	return true;
}	

function changePluginState($pluginname, $action=1)
{
  
	$db			=& JFactory::getDBO();
	$query	= 'UPDATE ' . $db->nameQuote( '#__plugins' )
			. ' SET '.$db->nameQuote('published').'='.$db->Quote($action)
	          .' WHERE '.$db->nameQuote('element').'='.$db->Quote($pluginname);
	
	$db->setQuery($query);		
	
	if(!$db->query())
		return false;
		
	return true;
}


