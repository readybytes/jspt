<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

class XiptModelAclrules extends XiptModel
{	 
	/**
	 * Returns the Fields
	 * @return object	JParameter object
	 **/
	function getRules()
	{		
		return $this->loadRecords();
	}
	
	function updatePublish($id,$value)
	{		
		return $this->save( array('published'=>$value), $id );		
	}
}