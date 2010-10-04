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
	 * Returns the Application name
	 * @return string
	 **/
	function getPluginFromId($pluginId)
	{			
		$result = $this->loadRecords();
									
		if(!empty($result[$pluginId]))
			return $result[$pluginId];
		else
			return false;
	}
	
	//XITODO : remove this wrapper
	function resetApplicationId( $aid )
	{
		return $this->delete(array('applicationid'=> $aid));
	}
}