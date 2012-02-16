<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

class XiptModelUsers extends XiptModel
{
	
	function save($data, $pk=null)
	{
		if(isset($data)===false || count($data)<=0)
		{			
			XiptError::raiseError(__CLASS__.'.'.__LINE__,XiptText::_("NO_DATA_TO_SAVE_IN_USER_TABLE_KINDLY_RE-LOGIN_AND_RETRY_TO_SAVE_DATA"));
			return false;
		}

		//load the table row
		$table = $this->getTable();
		if(!$table){
			XiptError::raiseError(__CLASS__.'.'.__LINE__,sprintf(XiptText::_("TABLE_DOES_NOT_EXIST"),$table));
			return false;
		}

		$table->load($pk);	
		
		//to clean cached data, reset record list
		$this->_recordlist = array();
		//bind, and then save
	    if($table->bind($data) && $table->store())
			return true;

		//some error occured
		XiptError::raiseError(__CLASS__.'.'.__LINE__, sprintf(XiptText::_("NOT_ABLE_TO_SAVE_DATA_IN_TABLE_PLEASE_RE-TRY"),$table));
		return false;
	}
	
	function getUsers($userid=0, $limit=null, $limitstart=null)
	{
		$db			= JFactory::getDBO();

		$search			= JRequest::getVar( 'search' , '' );
		$ptype			= JRequest::getVar( 'profiletype' , 0);
		$orderDirection	= JRequest::getVar( 'filter_order_Dir' , 'name' );
		$ordering		= JRequest::getVar( 'filter_order' , '' );
		
		$searchQuery	= '';
		$joinQuery		= '';
		$limitby		= '';
		$orderby 		= 'ORDER BY '. $ordering .' '. $orderDirection;
		
		if($limit != null)
			$limitby	 	= ' LIMIT ' . $limitstart .' , '. $limit;
		
		if(!empty($search))
		{
			$searchQuery	= ' WHERE name LIKE ' . $db->Quote( '%' . $search . '%' )
							. ' OR username LIKE ' . $db->Quote( '%' . $search . '%' ); 
		}
		
		if($ptype != 0 || $ptype != XIPT_PROFILETYPE_ALL)
		{
			$joinQuery	.= ' INNER JOIN ' . $db->nameQuote( '#__xipt_users' ) . ' AS c '
						. ' ON a.id = c.userid ';

			if(!empty($search))
				$searchQuery	.= ' AND c.profiletype=' . $db->Quote( $ptype );
			else
				$searchQuery	.= ' WHERE c.profiletype=' . $db->Quote( $ptype );		
		}
		
		$query	= 'SELECT * FROM ' . $db->nameQuote( '#__users' ) . ' AS a '
				. $joinQuery
				. $searchQuery
				. $orderby
				. $limitby;
				
		$db->setQuery( $query );
		$result	 = $db->loadObjectList('id');

		
		if(isset($result[$userid]))
			return $result[$userid];
		
		return $result;
	}
}
