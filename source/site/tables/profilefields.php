<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

class XiptTableProfileFields extends XiptTable
{		
	function load($id)
	{
		if( $id == 0 )
		{
			$this->id			= 0;
			$this->fid			= 0;
			$this->pid			= 0;
			$this->category		= 0;
			return true;
		}
		else
		{
			return parent::load( $id );
		}
	}
	
	
	function __construct()
	{
		parent::__construct('#__xipt_profilefields','id');
	}
	
	// XITODO : move to model
	function resetFieldId( $fid)
	{
		return $this->delete(array('fid'=> $fid));
	}
}