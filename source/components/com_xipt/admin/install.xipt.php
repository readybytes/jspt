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
	/*XITODO : check jomsocial version if it is less than 1.6 than show error message */
	if(check_version() == false)
		JError::raiseWarning('INSTERR', "XIPT Only support Jomsocial 1.6 or greater releases");
		
	if(setup_database() == false)
		JError::raiseError('INSTERR', "Not able to setup JSPT database correctly");
	
	if(copyAECfiles() == false)
		JError::raiseError('INSTERR', "Not able to replace MI files, Check permissions.");
		
	show_instruction();
	return true;
}


function setup_database()
{
	// check it before creating tables.
	$migrationRequired = isMigrationRequired();

	// now create tables
	if(create_tables() == false)
		return false;

	// do migrate if we need to migrate
	if($migrationRequired && migrate_tables() == false)
		return false;

	$migration2Required = isMigration2Required();

	if($migration2Required && migration2() == false)
		return false;

	//TO migrate old data we need to add these fields after migration only.
	add_column('watermark' , 'varchar(250) NOT NULL', '#__xipt_profiletypes');
	add_column('params' , 'text NOT NULL', '#__xipt_profiletypes');
	add_column('watermarkparams' , 'text NOT NULL', '#__xipt_profiletypes');
	
	//update global configuration data
	if(isTableExist('xipt_temp_globalconfiguration')){
		//insert data in #__component table
		$db = JFactory::getDBO();
		$query = 'SELECT `params` FROM `#__xipt_temp_globalconfiguration`';
		$db->setQuery($query);
		$params = $db->loadResult();
		$query = 'UPDATE '.$db->nameQuote('#__components')
				.' SET '.$db->nameQuote('params').'='.$db->Quote($params)
				.' WHERE  '.$db->nameQuote('link').'='.$db->Quote('option=com_xipt');
		$db->setQuery($query);
		$db->query();
	}
	// everything fine
	return true;
}

function create_tables()
{
	$allQueries  	= array();
	
	$allQueries[]	='CREATE TABLE IF NOT EXISTS `#__xipt_profilefields` (
				`id` int(10) NOT NULL auto_increment,  
				`fid` int(10) NOT NULL default \'0\',
				`pid` int(10) NOT NULL default \'0\', 
				PRIMARY KEY  (`id`) 
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8';
	
	$allQueries[]	= 'CREATE TABLE IF NOT EXISTS `#__xipt_profiletypes` (
				`id` int(10) unsigned NOT NULL auto_increment, 
				`name` varchar(255) NOT NULL, 
				`ordering` int(10) default NULL, 
				`published` tinyint(1) NOT NULL default \'1\',  
				`tip` text NOT NULL,  
				`privacy` varchar(20) NOT NULL default \'friends\',
				`template` varchar(50) NOT NULL default \'default\', 
				`jusertype` varchar(50) NOT NULL default \'Registered\', 
				`avatar` varchar(250) NOT NULL default \'components/com_community/assets/default.jpg\',
				`approve` tinyint(1) NOT NULL default \'0\',
				`allowt` tinyint(1) NOT NULL default \'0\',
				`group` int(11) NOT NULL default \'0\',
				PRIMARY KEY  (`id`) 
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8';
	
	$allQueries[]	= 'CREATE TABLE IF NOT EXISTS `#__xipt_applications` (  
				`id` int(10) NOT NULL AUTO_INCREMENT,
				`applicationid` int(10) NOT NULL DEFAULT 0, 
				`profiletype` int(10) NOT NULL DEFAULT 0, 
				PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8';
	

	$allQueries[]	= 'CREATE TABLE IF NOT EXISTS `#__xipt_aclrules` (
				`id` int(31) NOT NULL auto_increment,
				`pid` int(31) NOT NULL,
				`rulename` varchar(250) NOT NULL,
				`feature` varchar(128) NOT NULL,
				`taskcount` int(31) NOT NULL,
				`redirecturl` varchar(250) NOT NULL default \'index.php?option=com_community\',
				`message` varchar(250) NOT NULL default \'You are not allowed to access this resource\',
				`published` tinyint(1) NOT NULL,
				`otherpid` int(31) NOT NULL default -1,
				PRIMARY KEY  (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8';
	
	
	
	$allQueries[] = 'CREATE TABLE IF NOT EXISTS `#__xipt_users` (
	 			 `userid` int(11) NOT NULL,
  				 `profiletype` int(10) NOT NULL default \'0\',
  				 `template` varchar(80) NOT NULL default \'NOT_DEFINED\',
  				  PRIMARY KEY  (`userid`),
	  			  KEY `userid` (`userid`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8';
	
	$allQueries[] = 'CREATE TABLE IF NOT EXISTS `#__xipt_aec` (
				  `id` int(11) NOT NULL auto_increment,
				  `planid` int(11) NOT NULL,
				  `profiletype` int(11) NOT NULL,
				  PRIMARY KEY  (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8';
	
	$db=& JFactory::getDBO();
	foreach($allQueries as $query) {
		$db->setQuery( $query );
		$db->query();
	}
	
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


function isMigrationRequired()
{
	$newTables = isTableExist('xipt_users');
	$oldTables = isTableExist('community_profiletypes');

	// if [ old-tables-exist AND new-tables-does-not-exist ]
	// we should migrate
	if( $newTables==NULL  && $oldTables){
		return true;
	}

	// either newTable exist OR oldTables does not exist
	// no need of migration.
	return false;
}


function isMigration2Required()
{
	if(isTableExist('xipt_aclrules')) {
		if(!check_column_exist('#__xipt_aclrules','coreparams')) 
			return true;
	}

	return false;
}


// we will migrate the old tables information to new tables
// IMP : this function will remove all the previous table additions
function migrate_tables()
{
/*
	User have done it first--
	1. Upgrade JomSocial to 1.5.248
	2. Upgrade JSPT to 1.4.233

	// add data from existing tables to new tables
	#1. community_profiletypes  	==> xipt_profiletypes (just a copy)
	#2. community_myapplication 	==> xipt_applications (copy)
	#3. community_jsptacl	    	==> xipt_aclrules (copy)
	#4. community_jspt_aec	   	==> xipt_aec (copy)

	#5. community_profiletypefields ==> xipt_profilefields (reverse stats)
	#6. community_user		==> xipt_users(add pt,temp) , remove profiletypes and templates
	#7. community_fields		==> remove reg_show
	#8. community_register		==> remove profiletypes
*/

	$allQueries	= array();
	
	#1
	$allQueries[]	= ' INSERT `#__xipt_profiletypes` ' 
			. ' SELECT * FROM `#__community_profiletypes` ' ;
	#2
	$allQueries[]	= ' INSERT `#__xipt_applications` ' 
			. ' SELECT * FROM `#__community_myapplication` ' ;
	#4
	$allQueries[]	= ' INSERT `#__xipt_aec` ' 
			. ' SELECT * FROM `#__community_jspt_aec` ' ;
	#3
	$allQueries[]	= ' INSERT `#__xipt_aclrules` ' 
			. ' SELECT * FROM `#__community_jsptacl` ' ;
	#6
	$allQueries[]	= ' INSERT `#__xipt_users` ' 
			. ' SELECT `userid`, `profiletype`, `template` FROM `#__community_users` ' ;
			
	$db	=& JFactory::getDBO();
	foreach ( $allQueries as $query){

		$db->setQuery($query);
		$db->query();

		if($db->getErrorNum()){
			JError::raiseError( 500, $db->stderr());
			return false;
		}
	}

	#5 requires little more works.
	//5.1 find all profile types
	$query		= ' SELECT `id` FROM `#__xipt_profiletypes ';
	$db->setQuery($query);
	$ptypes		= $db->loadResultArray();

	//5.2 find all fields
	$query		= ' SELECT `id` FROM `#__community_fields`';
	$db->setQuery($query);
	$allFields	= $db->loadResultArray();
	
	//5.3 find all field and pid relations from old tables
	
	//5.4 now migrate data, we need to add all missing ptypes only.
	if($ptypes && $allFields){
	  foreach($allFields as $field){

		$query		= ' SELECT `pid` FROM `#__community_profiletypefields` WHERE `fid`='.$field;
		$db->setQuery($query);
		$allPIDs	= $db->loadResultArray();

	    	foreach($ptypes as $ptype){
		   // if we do not have an entry in previous table for the ptype
		   // then we should add that fid v/s pid, as we now store the reverse
		  if(in_array($ptype,$allPIDs)==false && !in_array(0,$allPIDs)){
			// add to our list
			$query	= ' INSERT INTO `#__xipt_profilefields` '
				. " (`fid`,`pid`) VALUES ('".$field."' , '".$ptype."' )";
			$db->setQuery($query);
			$db->Query();
		  }
	    	}			
	  }
	}

	#7,8
	//backup tabels before drop
	backup_table('#__community_users','#__xiptbak_users');
	backup_table('#__community_fields','#__xiptbak_fields');
	backup_table('#__community_register','#__xiptbak_register');
	backup_table('#__community_profiletypes','#__xiptbak_profiletypes');
	backup_table('#__community_profiletypefields','#__xiptbak_profiletypefields');
	backup_table('#__community_myapplication','#__xiptbak_myapplication');
	backup_table('#__community_jspt_aec','#__xiptbak_jspt_aec');
	backup_table('#__community_jsptacl','#__xiptbak_jsptacl');
	
	remove_column('#__community_users','profiletype');
	remove_column('#__community_users','template');
	remove_column('#__community_fields','reg_show');
	remove_column('#__community_register','profiletypes');
	remove_table('#__community_profiletypes');
	remove_table('#__community_profiletypefields');
	remove_table('#__community_myapplication');
	remove_table('#__community_jspt_aec');
	remove_table('#__community_jsptacl');

	// This is required to fix the issue of previous JSPT versions field
	// also delete the fields fom JomSocial of 'profiletypes'
	$query	= ' DELETE FROM `#__community_fields` '
			. " WHERE `type`='profiletypes' ";
	$db->setQuery($query);
	$db->Query();
	
	//also migrate configuration
	migrate_configuration();
	
	//also delete old MI of AEC if exist
	$AEC_MI_PATH = JPATH_ROOT . DS. 'components' . DS . 'com_acctexp' . DS . 'micro_integration';
	$AEC_MI_FILE = $AEC_MI_PATH .DS.'mi_jomsocialjspt.php';
	
	if(JFolder::exists($AEC_MI_PATH) && JFile::exists($AEC_MI_FILE ))
	{
		if(!JFile::delete($AEC_MI_FILE))
		{
			global $mainframe;
			$mainframe->enqueueMessage("Unable to delete $AEC_MI_FILE, Please delete it manually.");
		}
	}
	return true;
}


function migration2()
{

	$allQueries	= array();
	
	#1
	$isContentMigrationRequired = false;
	if(isTableExist('xipt_aclrules')){
		if(!check_column_exist('#__xipt_aclrules','coreparams')) {
			$allQueries[] = 'RENAME TABLE `#__xipt_aclrules`  TO `bak_#__xipt_aclrules`' ;
			
			$isContentMigrationRequired = true;
		}
	}
	
	$allQueries[]	= 'CREATE TABLE IF NOT EXISTS `#__xipt_aclrules` (
				  `id` int(31) NOT NULL auto_increment,
				  `rulename` varchar(250) NOT NULL,
				  `aclname` varchar(128) NOT NULL,
				  `coreparams` text NOT NULL,
				  `aclparams` text NOT NULL,
				  `published` tinyint(1) NOT NULL,
				  PRIMARY KEY  (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8' ;
	
			
	$db	=& JFactory::getDBO();
	foreach ( $allQueries as $query){

		$db->setQuery($query);
		$db->query();

		if($db->getErrorNum()){
			JError::raiseError( 500, $db->stderr());
			return false;
		}
	}
	
	if($isContentMigrationRequired == true) {
		$migrationQuery = 'SELECT * FROM '.$db->nameQuote('bak_#__xipt_aclrules');
		$db->setQuery($migrationQuery);
		$oldAclRules = $db->loadObjectList();
		if(empty($oldAclRules))
			return true;

		$contentMigrationQuery = array();
		foreach($oldAclRules as $oldAcl) {
			$coreparams = array();
			$coreparams['core_profiletype'] = $oldAcl->pid;
			$coreparams['core_display_message'] = $oldAcl->message;
			$coreparams['core_redirect_url'] = $oldAcl->redirecturl;

			$coreparamsString = generateParamsString($coreparams);
			
			$aclName = calculateAclName($oldAcl->feature);
			
			$aclParams = generateAclParams($aclName,$oldAcl->taskcount,$oldAcl->otherpid);
			
			$contentMigrationQuery[] = 'INSERT INTO `#__xipt_aclrules` (`id`, `rulename`, `aclname`, `aclparams`,`coreparams`, `published`)'
									.' VALUES ('
									. $db->Quote($oldAcl->id).','
									. $db->Quote($oldAcl->rulename).','
									. $db->Quote($aclName).','
									. $db->Quote($aclParams).','
									. $db->Quote($coreparamsString).','
									. $db->Quote($oldAcl->published)
									. ' )';
		}
		
		foreach ( $contentMigrationQuery as $cquery){
	
			$db->setQuery($cquery);
			$db->query();
	
			if($db->getErrorNum()){
				JError::raiseError( 500, $db->stderr());
				return false;
			}
		}
	}

	return true;
}




function migrate_configuration()
{
	//
	$query = "SELECT params FROM `#__community_config` WHERE `name`='config'";
	$db	=& JFactory::getDBO();
	$db->setQuery($query);
	$params=$db->loadResult();
	$JSParams = new JParameter($params);
	
	$JSPTConfig['jspt_during_reg']='show_ptype_during_reg';
	$JSPTConfig['jspt_allow_typechange']='allow_user_to_change_ptype_after_reg';
	$JSPTConfig['profiletypes']='defaultProfiletypeID';
	$JSPTConfig['jspt_show_radio']='jspt_show_radio';
	$JSPTConfig['jspt_allow_templatechange']='allow_templatechange';
	$JSPTConfig['forceAecPlan']='aec_integrate';
	$JSPTConfig['aecmessage']='aec_message';
	$JSPTConfig['jspt_restrict_reg_check']='jspt_restrict_reg_check';
	$JSPTConfig['jspt_prevent_username']='jspt_prevent_username';
	$JSPTConfig['jspt_allowed_email']='jspt_allowed_email';
	$JSPTConfig['jspt_prevent_email']='jspt_prevent_email';
	
	//insert data in #__component table
	$paraStr = '';
	foreach ($JSPTConfig as $oldkey => $newkey)
	{
		$value = $JSParams->get($oldkey);
		$paraStr .= "$newkey=$value\n";
	}
		
	$query = "UPDATE `#__components` SET `params`='".$paraStr."' WHERE `parent`='0' AND `option` ='com_xipt' LIMIT 1";	
	$db->setQuery($query);
	$db->query();
}

function check_column_exist($tableName, $columnName)
{
	assert($tableName  != '');
	assert($columnName != '');

	$db	=& JFactory::getDBO();
	$query	=  'SHOW COLUMNS FROM ' 
		   . $db->nameQuote($tableName)
		   . ' LIKE \'%'.$columnName.'%\' ';

	$db->setQuery( $query );
	$columns= $db->loadObjectList();

	if($db->getErrorNum()){
		JError::raiseError( 500, $db->stderr());
		return false;
	}

	if($columns==NULL || $columns[0] == NULL){
		return false;
	}
	return true;
}

function remove_table($tableName)
{
	assert($tableName != '' ) ;
	$db	=& JFactory::getDBO();
	//remove table
	$query 	= ' DROP TABLE IF EXISTS '. $db->nameQuote($tableName);
	$db->setQuery( $query );
	$db->query();

	if($db->getErrorNum()){
		JError::raiseError( 500, $db->stderr());
		return false;
	}
	return true;
}

function remove_column($tableName, $columnName)
{
	if(check_column_exist($tableName,$columnName)==false)
		return false;

	$db	=& JFactory::getDBO();
	$query 	= ' ALTER TABLE '. $db->nameQuote($tableName) 
		. ' DROP COLUMN '. $db->nameQuote($columnName);

	$db->setQuery( $query );
	$db->query();

	return true;
}

function backup_table($oldtableName,$newtableName)
{
	$db	=& JFactory::getDBO();
	$query 	= 'CREATE TABLE IF NOT EXISTS '. $db->nameQuote($newtableName) 
		. ' SELECT * FROM '. $db->nameQuote($oldtableName);

	$db->setQuery( $query );
	$db->query();

	return true;
}


function add_column($name, $specstr, $tname)
{
	$db		=& JFactory::getDBO();
	$query	= 	'SHOW COLUMNS FROM ' 
				. $db->nameQuote($tname)
				. ' LIKE \'%'.$name.'%\' ';
	$db->setQuery( $query );
	$columns	= $db->loadObjectList();
	if($db->getErrorNum())
	{
		JError::raiseError( 500, $db->stderr());
		return false;
	}

	if($columns==NULL || $columns[0] == NULL)
	{
		$query =' ALTER TABLE '. $db->nameQuote($tname) 
				. ' ADD COLUMN ' . $db->nameQuote($name)
				. ' ' . $specstr;
		$db->setQuery( $query );
		$db->query();
		return true;
	}
	return false;
}



function isTableExist($tableName)
{
	global $mainframe;

	$tables	= array();
	
	$database = &JFactory::getDBO();
	$tables	= $database->getTableList();

	return in_array( $mainframe->getCfg( 'dbprefix' ) . $tableName, $tables );
}
