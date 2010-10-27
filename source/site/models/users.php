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
			XiptError::raiseError(__CLASS__.'.'.__LINE__,XiptText::_("NO DATA TO SAVE IN USER TABLE.KINDLY RE-LOGIN AND RETRY TO SAVE DATA"));
			return false;
		}

		//load the table row
		$table = $this->getTable();
		if(!$table){
			XiptError::raiseError(__CLASS__.'.'.__LINE__,sprintf(XiptText::_("TABLE DOES NOT EXIST"),$table));
			return false;
		}

		$table->load($pk);	
		
		//bind, and then save
	    if($table->bind($data) && $table->store())
			return true;

		//some error occured
		XiptError::raiseError(__CLASS__.'.'.__LINE__, sprintf(XiptText::_("NOT ABLE TO SAVE DATA IN TABLE.PLEASE RE-TRY"),$table));
		return false;
	}
}
