<?php
/**
* @copyright		Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license			GNU/GPL, see LICENSE.php
* @package			XIPT
* @subpackage		Backend
*/
if(defined('_JEXEC')===false) die('Restricted access' );

class Com_xiptInstallerScript
{
	
	/**
	 * Runs on installation
	 * 
	 * @param JInstaller $parent 
	 */
	
	public function install($parent)
	{
		$this->installExtensions();
		return true;
	}

	function uninstall($parent)
	{
		$state=0;
		$extensions[] 	= array('type'=>'system', 'name'=>'xipt_system');
		$extensions[] 	= array('type'=>'community',   'name'=>'xipt_community');
		$this->changeExtensionState($extensions, $state);

		return true;
	}

	
	function update($parent)
	{
		self::install($parent);
	}

	function installExtensions($actionPath=null)
	{
		//if no path defined, use default path
		if($actionPath==null)
			$actionPath = dirname(dirname(__FILE__)).'/admin/install/extensions';

		//get instance of installer
		$installer =  new JInstaller();

		$extensions	= JFolder::folders($actionPath);

		//no extension to install
		if(empty($extensions))
			return true;

		//install all extensions
		foreach ($extensions as $extension)
		{
			$msg = " ". $extension . ' : Installed Successfully ';

			// Install the packages
			if($installer->install("{$actionPath}/{$extension}")==false){
				$msg = " ". $extension . ' : Installation Failed. Please try to reinstall. [Supportive plugin/module for PayInvoice]';
			}

			//enque the message
			JFactory::getApplication()->enqueueMessage($msg);
		}

		return true;
	}

	function changeExtensionState($extensions = array(), $state = 1)
	{
		if(empty($extensions)){
			return true;
		}

		$db		= JFactory::getDBO();
		$query		= 'UPDATE '. $db->quoteName( '#__extensions' )
				. ' SET   '. $db->quoteName('enabled').'='.$db->Quote($state);

		$subQuery = array();
		foreach($extensions as $extension => $value){
			$subQuery[] = '('.$db->quoteName('element').'='.$db->Quote($value['name'])
				    . ' AND ' . $db->quoteName('folder').'='.$db->Quote($value['type'])
			            .'  AND `type`="plugin"  )   ';
		}

		$query .= 'WHERE '.implode(' OR ', $subQuery);

		$db->setQuery($query);
		return $db->query();
	}
}
