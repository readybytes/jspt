<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

class XiptModelApplications extends XiptModel
{	
	/**
	 * Returns the Query Object if exist
	 * else It builds the object
	 * @return XiQuery
	 */
	public function getQuery()
	{
		//query already exist
		if($this->_query)
			return $this->_query;

		//create a new query
		$this->_query = new XiptQuery();
		
		$this->_query->select('*'); 
		$this->_query->from('#__plugins');
		$this->_query->where(" `folder` = 'community' ");
		$this->_query->order('ordering');
		
		return $this->_query;
	}
	
	/**
	 * Returns the Fields
	 *
	 * @return object	JParameter object
	 **/
	function getFields()
	{
		return $this->loadRecords();
	}
	
	/**
	 * Returns the Application name
	 * @return string
	 **/
	function getPluginNamefromId($pluginId)
	{	
		//XITODO : Load all records indexed by plugin ID, and return one object
		$query 	= new XiptQuery();
		$query->select('*');
		$query->from('#__plugins');
		$query->where(" `id` = $pluginId ");		
       	$result = $query->dbLoadQuery("", "")
						->loadObject();
									
		if(!empty($result))
			return $result->name;
		else
			return false;
	}
}