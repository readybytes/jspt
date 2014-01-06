<?php
/**
* @copyright		Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license			GNU/GPL, see LICENSE.php
* @package			XIPT
* @subpackage		Backend
*/
if(defined('_JEXEC')===false) die('Restricted access' );

defined('XIPT_VERSION') or define('XIPT_VERSION','4.0.6');
	

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

	function postflight($type, $parent)
	{
		return $this->_addScript();
	}

	//Redirects After Installation
	function _addScript()
	{
		
		?>
			<script type="text/javascript">
				window.onload = function(){	
				  setTimeout("location.href = 'index.php?option=com_xipt&view=install';", 100);
				}
			</script>
		<?php
	}

	function uninstall($parent)
	{
		require_once JPATH_ROOT.'/components/com_xipt/includes.php';

		
		$setupNames = XiptSetupHelper::getOrderedRules();
		
		foreach($setupNames as $setup)
		{
			//get object of class
			$setupObject = XiptFactory::getSetupRule($setup['name']);
			$setupObject->doRevert();
		}

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

	public function preflight($type, $parent)
	{
		if($type == 'update' && version_compare(XIPT_VERSION,'4.0','<')){
			self::_migrateProfiletypeFields();
			self::_migrateACLFields();
			self::_migrateSettings();
		}
		
		//add coverimage field in profiletype table
		if('update' == $type) {
			$db = JFactory::getDbo();
			$fields = $db->getTableColumns('#__xipt_profiletypes');
			
			if(!isset($fields['coverimage'])) {
				$query = "ALTER TABLE  `#__xipt_profiletypes` 
							ADD  `coverimage` VARCHAR( 255 ) NULL 
							COMMENT  'store cover image stuff'
						";
				try{
					$db->setQuery($query)->execute();	
				} catch (Exception $e) {
					JFactory::getApplication()->enqueueMessage($e->getMessage(),'error');
				}
			}
		} 
	}
	
	//convert all INI field values into JSON
	function _convertToJSON($data = '', $what = '')
	{
		if($data == ''){
			return '';
		}
		
		$registry =new JRegistry(addslashes($data));
		return json_encode($registry->toObject());
		
	}

	//convert all INI field values into JSON
	function _migrateProfiletypeFields()
	{
		$db = JFactory::getDbo();
		$query = " SELECT * FROM `#__xipt_profiletypes` ";
		
		$db->setQuery($query);
		$pt_record = $db->loadObjectList('id');
		
		foreach($pt_record as $record){
			$privacy 		 = self::_convertToJSON($record->privacy, 'privacy');
			$watermarkparams = self::_convertToJSON($record->watermarkparams, 'watermarkparams');
			$config 		 = self::_convertToJSON($record->config, 'config');
			$params 		 = self::_convertToJSON($record->params, 'params');
			
			$update_query = " UPDATE `#__xipt_profiletypes` "
						. " SET " .$db->quoteName('privacy').' = '.$db->quote($privacy) .' , '
						. $db->quoteName('watermarkparams').' = '.$db->quote($watermarkparams) .' , '
						. $db->quoteName('config').' = '.$db->quote($config) .' , '
						. $db->quoteName('params').' = '.$db->quote($params)
						. " WHERE " .$db->quoteName('id').' = '.$db->quote($record->id);
						
			$db->setQuery($update_query)->query();
		}
	}

	//convert all INI field values into JSON
	function _migrateACLFields()
	{
		$db = JFactory::getDbo();
		$query = " SELECT * FROM `#__xipt_aclrules` ";
		
		$db->setQuery($query);
		$acl_record = $db->loadObjectList('id');
				
		foreach($acl_record as $record){
			$coreparams 	= self::_convertToJSON($record->coreparams, 'coreparams');
			$aclparams 		= self::_convertToJSON($record->aclparams, 'aclparams');
			
			$update_query = " UPDATE `#__xipt_aclrules` "
						. " SET " .$db->quoteName('coreparams').' = '.$db->quote($coreparams) .' , '
						. $db->quoteName('aclparams').' = '.$db->quote($aclparams)
						. " WHERE " .$db->quoteName('id').' = '.$db->quote($record->id);
						
			$db->setQuery($update_query)->query();
		}
	}

	//convert all INI field values into JSON
	function _migrateSettings()
	{
		$db = JFactory::getDbo();
		$query  = " SELECT `params` FROM `#__xipt_settings` WHERE `name`='settings' ";
		$db->setQuery($query);
		
		$settings = $db->loadResult();

		$params = self::_convertToJSON($settings, 'settings');
		
		$update_query = " UPDATE `#__xipt_settings` "
						. " SET " .$db->quoteName('params').' = '.$db->quote($params)
						. " WHERE " .$db->quoteName('name').' = '.$db->quote('settings');
						
		$db->setQuery($update_query)->query();
	}
}

