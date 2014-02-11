<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptAclFactory
{
	public static function getAclRulesInfo($filter='',$join='AND')
	{		 
		$records 	= XiptFactory::getInstance('aclrules', 'model')->loadRecords(0);
		
		if(empty($filter))
			return $records;

		foreach($records as $record){
			foreach($filter as $name => $info){ 				
				if($record->$name != $info){
					unset($records[$record->id]);
					break;
				}									
			}
		}
		
		return $records;		
	}



	public static function getAcl()
	{
		return JFolder::folders(dirname(__FILE__));
	}


	public static function getAclObject($aclName)
	{
		$path	= dirname(__FILE__). DS . $aclName . DS . $aclName.'.php';
		if(!JFile::exists($path)){
			XiptError::raiseError(__CLASS__.'.'.__LINE__,sprintf(XiptText::_("INVALID_ACL_FILE"), $aclName ));
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


	public static function getAclObjectFromId($id,$checkPublished=false)
	{
		$filter = array();
		$filter['id']	= $id;
		if($checkPublished) {
			$filter['published']	= 1;
		}
		$array = self::getAclRulesInfo($filter);
		
		$info = array_shift($array);
		
		if($info){
			$aclObject = self::getAclObject($info->aclname);
			return $aclObject;
		}

		return false;
	}
}
