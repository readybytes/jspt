<?php
defined('_JEXEC') or die('Restricted access');

require_once dirname(JPATH_BASE).DS.'administrator'.DS.'components'.DS.'com_xipt' .DS. 'jspt_functions.php';

function check_version()
{
	$SUPPORTED =  array ();
	// $SUPPORTED[0] = it should contain the latest supported release
	$SUPPORTED[]='1.5.248';
	
	$version = get_js_version();
	if(in_array($version,$SUPPORTED)==false)
	{
	?>
		<div> ERROR : The JomSocial Version [<?php echo $version; ?>] used by you is not supported for ProfileTypes. The JSPT 2.0.xxx will only supports newer version of JomSocial since JomSocial 1.5.248. If you wish to use older version of JomSocial, then you need to use JSPT 1.4.xx. If it is a newer version then JomSocial <?php echo $SUPPORTED[0] ; ?>, then please goto support forum and ask us for compatibility. 
			<div> Forum : <a href="http://www.joomlaxi.com/support/forum.html" target="_blank"> JoomlaXi Official Support Forum</a> <br />
			</div>
		</div>	
	<?php
		return false;
	}
	return true;
}

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
	if(check_jomsocial_existance() == false)
		JError::raiseError('INSTERR', "JomSocial does not exist, JomSocial is required for JSPT");
		
	if(setup_database() == false)
		JError::raiseError('INSTERR', "Not able to setup JSPT database correctly");

	copy_files();
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
	if($migrationRequired && migrate_data() == false)
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
	$query 	= " SHOW TABLES LIKE '#__xipt_users'";
	$db->setQuery( $query );
	$newTables = $db->loadObjectList();

	if($db->getErrorNum()){
		JError::raiseError( 500, $db->stderr());		
	}

	$query 	= " SHOW TABLES LIKE '#__community_profiletypes' ";
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
			. ' SELECT * FROM #__community_myapplications ' ;
	#4
	$allQueries[]	= ' INSERT `#__xipt_aec` ' 
			. ' SELECT * FROM #__community_jspt_aec ' ;
	#3
	$allQueries[]	= ' INSERT `#__xipt_aclrules` ' 
			. ' SELECT * FROM #__community_jsptacl ' ;
	#6
	$allQueries[]	= ' INSERT `#__xipt_users` ' 
			. ' SELECT `userid`, `profiletype` as `profiletypes`, `template` FROM #__community_users ' ;

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
		  if(in_array($ptype,$allPIDs)==false){
			// add to our list
			$query	= ' INSERT INTO `#__xipt_profilefields` '
				. " (`fid`,`pid`) VALUES ('".$field."' , '".$ptype."' )";
		  }
	    	}			
	  }
	}

	#7,8
	remove_column('community_fields','reg_show');
	remove_column('community_register','profiletypes');
	remove_table('#__community_profiletypes');
	remove_table('#__community_myapplications');
	remove_table('#__community_jspt_aec');
	remove_table('#__community_jsptacl');
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
	$query 	= ' SHOW TABLE LIKE '. $db->nameQuote($tableName); 
	$db->setQuery( $query );
	$tables = $db->loadObjectList();

	if($db->getErrorNum()){
		JError::raiseError( 500, $db->stderr());
		return false;
	}

	if($tables==NULL || $tables[0] == NULL){
		return false;
	}

	//remove table
	$query 	= ' DROP TABLE '. $db->nameQuote($tableName);
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