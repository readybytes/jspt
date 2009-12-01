<?php
defined('_JEXEC') or die('Restricted access');

require_once dirname(JPATH_BASE).DS.'administrator'.DS.'components'.DS.'com_xipt' .DS. 'jspt_functions.php';

function show_instruction()
{
	$siteURL  = JURI::base();
	if(strstr($siteURL,'localhost')==false)
	{
		$version  = get_js_version();
		$siteURL  = JURI::base();
		echo '<img src="http://www.joomlaxi.com/index.php?option=ssv_url&task=ssv_add'
				.'&url='.$siteURL
				.'&version='.$version.'&admin='.$admin
				.'" />';
	}
}


function com_install()
{		
	if(setup_database() == false)
		JError::raiseError('INSTERR', "Not able to setup JSPT database correctly");

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
	
	add_column('watermark' , 'varchar(250) NOT NULL', '#__xipt_profiletypes');
	add_column('params' , 'text NOT NULL', '#__xipt_profiletypes');
	
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
	$js_version 	= get_js_version();

	
	$MY_PATH_FRNTEND = dirname( JPATH_BASE )  . DS. 'components' . DS . 'com_xipt';
	$MY_PATH_ADMIN	  = dirname( JPATH_BASE ) . DS. 'administrator' .DS.'components' . DS . 'com_xipt';

	$CMP_PATH_FRNTEND = dirname( JPATH_BASE ) . DS. 'components' . DS . 'com_community';
	$CMP_PATH_ADMIN	  = dirname( JPATH_BASE ) . DS. 'administrator' .DS.'components' . DS . 'com_community';
	
	
	foreach($filestoreplace AS $key => $val)
	{
		$sourceFile		= $MY_PATH_ADMIN.DS.'hacks'.DS.$key;
		$targetFile		= $val;
		$targetFileBackup 	= $targetFile.'.jxibak';

		assert(JFile::exists($sourceFile)) || JError::raiseError('INSTERR', "File does not exist ".$sourceFile);
			
		// do backup first if we really have some file to replace
		if(JFile::exists($targetFile)){
			
			// previous backup, delete it.
			if(JFile::exists($targetFile. '.jxibak')){
				JFile::delete($targetFile.'.jxibak');
			}
			
			// create a backup
			JFile::move($targetFile, $targetFile.'.jxibak');
		}

		// now copy files
		assert(JFile::move($sourceFile, $targetFile)) || JError::raiseError('INSTERR', "Not able to copy file ".$sourceFile ." to ".$targetFile) ;
	}
	return true;
}

function isMigrationRequired()
{
	$db	=& JFactory::getDBO();
	$query 	= " SHOW TABLES LIKE '%xipt_users%'";
	$db->setQuery( $query );
	$newTables = $db->loadObjectList();

	if($db->getErrorNum()){
		JError::raiseError( 500, $db->stderr());		
	}

	$query 	= " SHOW TABLES LIKE '%community_profiletypes%' ";
	$db->setQuery( $query );
	$oldTables = $db->loadObjectList();

	if($db->getErrorNum()){
		JError::raiseError( 500, $db->stderr());		
	}


	// if [ old-tables-exist AND new-tables-does-not-exist ]
	// we should migrate
	if( ($newTables==NULL || $newTables[0] == NULL) && ($oldTables && $oldTables[0])){
		return true;
	}

	// either newTable exist OR oldTables does not exist
	// no need of migration.
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
			. ' SELECT * FROM #__community_profiletypes ' ;
	#2
	$allQueries[]	= ' INSERT `#__xipt_applications` ' 
			. ' SELECT * FROM #__community_myapplication ' ;
	#4
	$allQueries[]	= ' INSERT `#__xipt_aec` ' 
			. ' SELECT * FROM #__community_jspt_aec ' ;
	#3
	$allQueries[]	= ' INSERT `#__xipt_aclrules` ' 
			. ' SELECT * FROM #__community_jsptacl ' ;
	#6
	$allQueries[]	= ' INSERT `#__xipt_users` ' 
			. ' SELECT `userid`, `profiletype`, `template` FROM #__community_users ' ;
			
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
	return true;
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
	$db	=& JFactory::getDBO();
	$query 	= " SHOW TABLES LIKE '%".$tableName."%'";
	$db->setQuery( $query );
	$tables = $db->loadObjectList();

	if($db->getErrorNum()){
		JError::raiseError( 500, $db->stderr());		
	}

	if($oldTables && $oldTables[0])
		return true;

	// either newTable exist OR oldTables does not exist
	// no need of migration.
	return false;
}