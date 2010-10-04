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
			XiptError::raiseError(500,XiptText::_("NO DATA TO SAVE"));
			return false;
		}

		//load the table row
		$table = $this->getTable();
		if(!$table){
			XiptError::raiseError(500,XiptText::_("Table does not exist"));
			return false;
		}

		$table->load($pk);	
		
		//bind, and then save
	    if($table->bind($data) && $table->store())
			return true;

		//some error occured
		XiptError::raiseError(500, XiptText::_("NOT ABLE TO SAVE DATA"));
		return false;
	}
}
