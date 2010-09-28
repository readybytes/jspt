<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class XiptAclFactory
{
	public function getAclRulesInfo($filter='',$join='AND')
	{
		$db			=& JFactory::getDBO();
		
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
		$path	= dirname(__FILE__);
	
		jimport( 'joomla.filesystem.folder' );
		$acl = array();
		$acl = JFolder::folders($path);
		return $acl;
	}
	
	
	public function getAclObject($aclName)
	{
		$path	= dirname(__FILE__). DS . $aclName . DS . $aclName.'.php';
		jimport( 'joomla.filesystem.file' );
		if(!JFile::exists($path))
		{
			XiptError::raiseError(400,JText::_("INVALID ACL FILE"));
			return false;
		}

		require_once $path;
			
		//$instance will comtain all addon object according to rule
		//Every rule will have different object
		static $instance = array();
		if(isset($instance[$aclName]))
			return $instance[$aclName];
			
		//XITODO send debugmode
		$instance[$aclName] = new $aclName(0);	
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