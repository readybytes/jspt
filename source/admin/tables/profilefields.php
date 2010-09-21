<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

class XiPTTableProfileFields extends JTable
{

	var $id			= null;
	var $fid		= null;
	var $pid		= null;
	var $category	= null;
	
	function __construct(&$db)
	{
		parent::__construct('#__xipt_profilefields','id', $db);
	}
	
	function load( $id)
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

	function delete()
	{		
		return parent::delete();
	}
	
	/**
	 * Overrides Joomla's JTable store method so that we can define proper values
	 * upon saving a new entry
	 * 
	 * @return boolean true on success
	 **/
	function store( )
	{
		$db		=& $this->getDBO();		
		
		//Do not store duplicate records
		$query	= ' SELECT COUNT(' . $db->nameQuote('id') . ') FROM ' 
		        . $db->nameQuote('#__xipt_profilefields')
				. ' WHERE '.$db->nameQuote('fid').'='.$db->Quote($this->fid)
				. ' AND '.$db->nameQuote('pid').'='.$db->Quote($this->pid)
				. ' AND '.$db->nameQuote('category').'='.$db->Quote($this->category);
		$db->setQuery( $query );
		$count	= $db->loadResult();
		if($count)
			return false;
 		return parent::store();
	}

	/**
	 * Tests the specific field if value exists
	 * 
	 * @param	string	
	 **/
	function resetFieldId( $fid)
	{
		$db		=& $this->getDBO();
		$query	= 'SELECT COUNT(*) FROM '
				. $db->nameQuote( '#__xipt_profilefields' )
				. ' WHERE '.$db->nameQuote('fid').'=' . $db->Quote( $fid );		
		$db->setQuery( $query );

		if($db->loadResult() < 1 ) 
			return;
		
		$query	= 'SELECT '.$db->nameQuote('id')
				. ' FROM '. $db->nameQuote( '#__xipt_profilefields' )
				. ' WHERE '.$db->nameQuote('fid').'=' . $db->Quote( $fid );	
		$db->setQuery( $query );
		$results= $db->loadObjectList();
		
		foreach($results as $result)
		{
				$this->load($result->id);
				$this->delete();
		}		
		return;
	}

	/**
	 * Bind AJAX data into object's property
	 * @param	array	data	The data for this field
	 **/
	function bindValues($data)
	{
			$this->id			= $id;
			$this->fid			= $data['fid'];
			$this->pid			= $data['pid'];
			$this->category		= $data['category'];
	}
}