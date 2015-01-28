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
		XiptError::assert($id, XiptText::_("ID $id IS_NOT_VALID"), XiptError::ERROR);
		
		if(empty($data) || !is_array($data))
			return false;

		//We want to handle only JS Configuration from this function
		//Everything else should be handled by generic parent function
		if($what != 'params'){
			parent::saveParams($data, $id, $what);
			return;
		}
		
        $params = json_encode($data);
		return $this->save(array($what => $params), $id);
	}
	
	function loadParams($id, $what = 'params')
	{
		$reset = XiptLibJomsocial::cleanStaticCache();
		if($what != 'params')
			return parent::loadParams($id, $what);
		
		if( isset($this->_params[$id])&& $reset == false)
			return $this->_params[$id]; 		
		
		$record = $this->loadRecords(0);
		$config = CFactory::getConfig();
		// if config not found from tabale then load default config of jom social
		if(!($record[$id]->params)){
			$this->_params[$id] = $config;
		}
		else{
			$params = array();
			$params = json_decode($record[$id]->params);
			
			foreach($params as $key => $value){
				$config->set($key, $value);
			}
			$this->_params[$id] = $config;
		}
			
		return $this->_params[$id];
	}
	
	function resetUserAvatar($pid, $newavatar, $oldavatar, $newavatarthumb)
	{
		//get all users for profiletype
		$users = XiptLibProfiletypes::getAllUsers($pid);
		
		//Change all avatar and thumb path in url formate  
		$newavatar	= XiptHelperUtils::getUrlpathFromFilePath($newavatar);
		$newavatarthumb = XiptHelperUtils::getUrlpathFromFilePath($newavatarthumb);

		$cnt = count($users);
		for($i=0; $i < $cnt; $i++)
		{
			//if user is admin unset value
			if(XiptHelperUtils::isAdmin($users[$i])){ 
				unset($users[$i]);
			}
		}
		
		$users = array_values($users);
		
		$cnt = count($users);
		if($cnt>0)
		{
			// XITODO : Change IN query to sub query
			//update user avatar and thumb of all users who doesn't have custom avatar 
			$query = new XiptQuery();
			$result = $query->update('#__community_users')
							->set(" avatar = '$newavatar' ")
							->set(" thumb = '$newavatarthumb' ")
							->where(" avatar = '$oldavatar' ")
							->where(" userid  IN (" .implode(",", $users).") ")
							->dbLoadQuery()
							->query();

			if (!$result)
				return XiptError::raiseWarning( 500, XiptText::_("ERROR_IN_DATABASE_WHEN_SAVING_AVATAR_IN_COMMUNITY_USER_TABLE"));

			return true;
		}
	}
	
}
