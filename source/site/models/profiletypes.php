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
		
	function visible($id)
	{		
		return $this->save( array('visible'=>1), $id );		
	}
	
	function invisible($id)
	{		
		return $this->save( array('visible'=>0), $id );		
	}
	
	/**
	 * Save the configuration to the config file	 * 
	 * @return boolean	True on success false on failure.
	 **/
	function saveParams($postData,$id)
	{
		//XITODO : Assert THIS $id should be valid
		//XiptError:assert($id);
		if(empty($postData) || !is_array($postData))
			return false;
			
		//XITODO : move cleanup to controller
		unset($postData[JUtility::getToken()]);
		unset($postData['option']);
		unset($postData['task']);
		unset($postData['view']);
		unset($postData['id']);
		
		$registry	= JRegistry::getInstance('xipt');
		$registry->loadArray($postData,'xipt');
		$params	= $registry->toString( 'INI' , 'xipt' );
		
		return $this->save(array('params'=> $params), $id);
	}
	
	function loadParams($id)
	{
		if( isset($this->_params[$id]))
			return $this->_params[$id]; 		
		
		$record = $this->loadRecords();
		
		// if config not found from tabale then load default config of jom social
		if(!isset($record[$id]->params) || empty($record[$id]->params))
			$this->_params[$id] = CFactory::getConfig();
		else
			$this->_params[$id] = new JParameter( $record[$id]->params );
			
		return $this->_params[$id];
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