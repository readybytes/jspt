<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

class XiptModelProfiletypes extends XiptModel
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
		$this->_query->from('#__xipt_profiletypes');
		$this->_query->order('ordering');
		
		return $this->_query;
	}	
	
	function resetUserAvatar($pid, $newavatar, $oldavatar, $newavatarthumb)
	{
		//get all users for profiletype
		$users = XiptLibProfiletypes::getAllUsers($pid);
		
		$cnt = count($users);
		for($i=0; $i < $cnt; $i++)
		{
			//if user is admin unset value
			if(XiptLibUtils::isAdmin($users[$i]))
				unset($users[$i]);
		}
		
		$users = array_values($users);
		
		$cnt = count($users);
		if($cnt>0)
		{
			//update user avatar and thumb of all users who doesn't have custom avatar 
//			$this->_query = new XiptQuery();
//			$this->_query->update('#__xipt_profiletypes');
//			$this->_query->set('avatar',$newavatar);
//			$this->_query->set('thumb',$newavatarthumb);
//			$this->_query->where('avatar',$oldavatar);
			// XITODO : need to improve
			$db 	=& JFactory::getDBO();
			$query 	= 'UPDATE #__community_users'
					. ' SET `avatar` ='.$db->Quote($newavatar).''
					.', `thumb` =' .$db->Quote($newavatarthumb).''
					. ' WHERE `avatar` ='.$db->Quote($oldavatar)
					."AND `userid` IN (" .implode(",", $users).")";
			$db->setQuery( $query );
					
			if (!$db->query()) {
						return XiptError::raiseWarning( 500, $db->getError() );
					}	
		}
	}
	
}