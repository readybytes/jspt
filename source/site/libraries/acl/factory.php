<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptAclFactory
{
	public function getAclRulesInfo($filter='',$join='AND')
	{
		$db			= JFactory::getDBO();

		$filterSql = '';
		if(!empty($filter)){
			$filterSql = ' WHERE ';
			$counter = 0;
			foreach($filter as $name => $info) {
				$filterSql .= $counter ? ' '.$join.' ' : '';
				$filterSql .= $db->nameQuote($name).'='.$db->Quote($info);
				$counter++;
			}
		}

		$query = 'SELECT * FROM '.$db->nameQuote('#__xipt_aclrules')
				.$filterSql;

		$db->setQuery($query);
		$aclRuleinfo = $db->loadObjectList();

		return $aclRuleinfo;
	}



	public function getAcl()
	{
		return JFolder::folders(dirname(__FILE__));
	}


	public function getAclObject($aclName)
	{
		$path	= dirname(__FILE__). DS . $aclName . DS . $aclName.'.php';
		if(!JFile::exists($path)){
			XiptError::raiseError(400, XiptText::_("INVALID ACL FILE : $aclName "));
			return false;
		}

		require_once $path;

		//$instance will comtain all addon object according to rule
		//Every rule will have different object
		static $instance = array();
		if(isset($instance[$aclName]))
			return $instance[$aclName];

		$instance[$aclName] = new $aclName();
		return $instance[$aclName];
	}


	public function getAclObjectFromId($id,$checkPublished=false)
	{
		$filter = array();
		$filter['id']	= $id;
		if($checkPublished)
			$filter['published']	= 1;
		$info = self::getAclRulesInfo($filter);
		if($info){
			$aclObject = self::getAclObject($info[0]->aclname);
			return $aclObject;
		}

		return false;
	}
}