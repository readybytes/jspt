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
	
	function getUsers($userid=0, $useLimit = true)
	{
		$db			= JFactory::getDBO();

		$app				= JFactory::getApplication();
		$globalListLimit	= $app->getCfg('list_limit');

		//limit should be used from global space
        $limit 			= $app->getUserStateFromRequest('global.list.limit', 'limit', $globalListLimit, 'int');
        $limitstart 	= JRequest::getVar('limitstart', 0);
		$search			= $app->getUserStateFromRequest( 'com_xipt.users.search' , 'search', '', 'string');
		$ptype			= $app->getUserStateFromRequest( 'com_xipt.users.profiletype' , 'profiletype', 0, 'int');
		$orderDirection	= $app->getUserStateFromRequest( 'com_xipt.users.filter_order_Dir', 'filter_order_Dir', '', 'word');
		$ordering		= $app->getUserStateFromRequest( 'com_xipt.users.filter_order', 'filter_order', 'name', 'cmd');
		
		$searchQuery	= '';
		$joinQuery		= '';
		
		$orderby 		= 'ORDER BY '. $ordering .' '. $orderDirection;
		
		if(!empty($search))
		{
			$searchQuery	= ' WHERE (name LIKE ' . $db->Quote( '%' . $search . '%' )
							. ' OR username LIKE ' . $db->Quote( '%' . $search . '%' ) . ' ) '; 
		}
		
		if($ptype != 0 || $ptype != XIPT_PROFILETYPE_ALL)
		{
			$joinQuery	.= ' INNER JOIN ' . $db->quoteName( '#__xipt_users' ) . ' AS c '
						. ' ON a.id = c.userid ';

			if(!empty($search))
				$searchQuery	.= ' AND c.profiletype=' . $db->Quote( $ptype );
			else
				$searchQuery	.= ' WHERE c.profiletype=' . $db->Quote( $ptype );		
		}
		
		$new_join = ' LEFT JOIN ' . $db->quoteName('#__user_usergroup_map') . " AS map on (a.id = map.user_id)"
						. " LEFT JOIN " . $db->quoteName('#__usergroups') . " As ug "
						. " ON map.group_id=ug.id ";
						
		$query	= 'SELECT * FROM ' . $db->quoteName( '#__users' ) .' AS a '
				. $new_join
				. $joinQuery
				. $searchQuery
				. $orderby;

		if($useLimit){
				if ( empty($this->_pagination))
	            {
	                jimport('joomla.html.pagination');
	                $this->_pagination = new JPagination( $this->_getListCount( $query ) , $limitstart, $limit);
	            }
			$result	= $this->_getList( $query , $limitstart, $limit);
		}
		else{
			$db->setQuery( $query );
			$result	 = $db->loadObjectList('user_id');
			
			if(isset($result[$userid]))
				return $result[$userid];
		}
		
		return $result;
	}
	
	function getPagination()
	{
		return $this->_pagination;
	}
}
