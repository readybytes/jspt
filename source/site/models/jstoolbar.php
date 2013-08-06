<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
if(!defined('_JEXEC')) die('Restricted access');

class XiptModelJSToolbar extends XiptModel
{
	/**
	 * Returns the Application name
	 * @return string
	 **/
	function getMenu($menuId=null, $limit=null, $limitstart=null, $condition=true)
	{
		$query = new XiptQuery();

		$result = $query->select('*')
			    ->from('#__menu')
			    ->where(" `menutype` = 'jomsocial' and `parent_id` = 1")
				->order('id')
				->limit($limit,$limitstart)
				->dbLoadQuery("","")
				->loadObjectList('id');	
		
		if($menuId == null && $result)
			return $result;
			
		if(isset($result[$menuId]) && !empty($result[$menuId]))
			return $result[$menuId];
		else
			return false;
	}
	
	function getProfileTypes($menuid)
	{
		if(isset($this->_ptypes[$menuid]))
			return $this->_ptypes[$menuid];
			
		$query = new XiptQuery();
		return  $this->_ptypes[$menuid] = $query->select('profiletype')
					 						 ->from('#__xipt_jstoolbar')
					 						 ->where(" `menuid` = $menuid ")
					 						 ->dbLoadQuery("", "")
			  		 						 ->loadColumn();
	}
	
	/*
	 * Count number of total records as per current query
	 */
	public function getTotal()
	{
		if($this->_total)
			return $this->_total;

		$menus 			= $this->getMenu();
        $this->_total 	= count($menus);

		return $this->_total;
	}
}