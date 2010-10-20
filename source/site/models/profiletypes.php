<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
if(!defined('_JEXEC')) die('Restricted access');

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

	/**
	 * Save the configuration to the config file	 * 
	 * @return boolean	True on success false on failure.
	 **/
	function saveParams($data, $id, $what = 'params')
	{
		XiptHelperUtils::XAssert($id);
		
		if(empty($data) || !is_array($data))
			return false;

		//We want to handle only JS Configuration from this function
		//Everything else should be handled by generic parent function
		if($what != 'params'){
			parent::saveParams($data, $id, $what);
			return;
		}
		
		// XITODO : move this to controller
		unset($data[JUtility::getToken()]);
        unset($data['option']);
        unset($data['task']);
        unset($data['view']);
        unset($data['id']);
               
		//XITODO : bind params 
		$registry	= new JRegistry();
		$registry->loadArray($data);
		$params	= $registry->toString('INI');
		
		return $this->save(array($what => $params), $id);
	}
	
	function loadParams($id, $what = 'params')
	{
		$reset = XiptLibJomsocial::cleanStaticCache();
		if($what != 'params')
			return parent::loadParams($id, $what);
		
		if( isset($this->_params[$id])&& $reset == false)
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
			if(XiptHelperUtils::isAdmin($users[$i]))
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