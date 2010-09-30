<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

class XiptModelConfiguration extends XiptModel
{

	/**
	 * Returns the configuration object
	 * @return object	JParameter object
	 **/	 
	function getParams($id)
	{
		// Test if the config is already loaded.
		static $params=null;
		if( isset($params) && array_key_exists($id,$params))
			return $params;
		
		$db = & JFactory::getDBO();
 		$this->_query = new XiptQuery();
		
		$this->_query->select('params'); 
		$this->_query->from('#__xipt_profiletypes');
		$this->_query->where("`id` = $id");
		
		$db->setQuery((string) $this->_query);
		$pTypeConfig = $db->loadResult();
		
		// if config not found from tabale then load default config of jom social
		if(!$pTypeConfig)
			$config = & CFactory::getConfig();
		else
			$config	= new JParameter( $pTypeConfig );
			
		$params[$id] = $config;
		return $params[$id];		
	}
	
	/**
	 * Save the configuration to the config file
	 * 
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
		$row = XiptFactory::getInstance('profiletypes','model');	
		return $row->save(array('params'=>''),$id);
	}
}