<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

class XiptModelConfiguration extends XiptModel
{
	function getTable()
	{
		return parent::getTable('profiletypes');
	}
	/**
	 * Returns the configuration object
	 * @return object	JParameter object
	 **/	 
	function getParams($id)
	{
		// Test if the config is already loaded.
		
		if( isset($this->_params))
			return $this->_params;
 		
		$row	= XiptFactory::getInstance('profiletypes','model');
		$record = $row->loadRecords();
		
		// if config not found from tabale then load default config of jom social
		if(!$record[$id]->params)
			$this->_params = CFactory::getConfig();
		else
			$this->_params = new JParameter( $record[$id]->params );
			
		return $this->_params;		
	}
	
	/**
	 * Save the configuration to the config file	 * 
	 * @return boolean	True on success false on failure.
	 **/
	function save($postData,$id)
	{
		//XITODO : Assert THIS $id should be valid
		//XiptError:assert($id);
		
		unset($postData[JUtility::getToken()]);
		unset($postData['option']);
		unset($postData['task']);
		unset($postData['view']);
		unset($postData['id']);
		
		$registry	= JRegistry::getInstance('xipt');
		$registry->loadArray($postData,'xipt');
		
		// Get the complete INI string
		$data = array();
		$data['params']	= $registry->toString( 'INI' , 'xipt' );

		// get model of profile type
		$row	= XiptFactory::getInstance('profiletypes','model');
		// Save it
		return $row->save($data,$id);
	}
	
	function reset($id)
	{		
		//XITODO : assert for $id should be valid		
		return  XiptFactory::getInstance('profiletypes','model')
							->save(array('params'=>''),$id);;
		
	}
}