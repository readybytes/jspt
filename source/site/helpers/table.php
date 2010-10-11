<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptHelperTable 
{
	static function isTableExist($tableName)
	{
		$db		 	=	JFactory::getDBO();

		//if table name consist #__ replace it.
		$tableName	=	$db->replacePrefix($tableName);

		//get table list
		$tables	= array();
		$tables	= $db->getTableList();

		//check if table exist
		return in_array($tableName, $tables ) ? true : false;
	}
}