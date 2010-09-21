<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

class XiPTTableApplications extends JTable
{

	var $id			= null;
	var $applicationid		= null;
	var $profiletype		= null;
	
	
	function __construct(&$db)
	{
		parent::__construct('#__xipt_applications','id', $db);
	}
	
	/**
	 * Overrides Joomla's load method so that we can define proper values
	 * upon loading a new entry
	 * 
	 * @param	int	id	The id of the field
	 * @param	boolean isGroup	Whether the field is a group
	 * 	 
	 * @return boolean true on success
	 **/
	function load( $id)
	{
		if( $id ){
			return parent::load( $id );
		}
		
		$this->id				= 0;
		$this->applicationid	= '';
		$this->profiletype		= '';
		return true;
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
		// TODOTEST for $id=0
				
		// Set the ordering
 		$query	= 'SELECT COUNT('.$db->nameQuote('id').') FROM ' 
 				. $db->nameQuote('#__xipt_applications')
				. ' WHERE '.$db->nameQuote('applicationid').'='.$db->Quote($this->applicationid)
				. ' AND '.$db->nameQuote('profiletype').'='.$db->Quote($this->profiletype);	
			
		$db->setQuery( $query );
		$count	= $db->loadResult();
		if($count)
			return false;
 		  
       	return 	parent::store();
	}

	/**
	 * Tests the specific field if value exists
	 * 
	 * @param	string	
	 **/
	function _exists( $field , $value )
	{
		$db		=& $this->getDBO();
		$query	= 'SELECT COUNT(*) FROM '
				. $db->nameQuote( '#__xipt_applications' )
				. ' WHERE ' . $db->nameQuote( $field ) . '=' . $db->Quote( $value );
		
		$db->setQuery( $query );

		$result	= ( $db->loadResult() > 0 ) ? true : false ;
		
		return $result;
	}

	/**
	 * Bind AJAX data into object's property
	 * 
	 * @param	array	data	The data for this field
	 **/
	function bindAjaxPost( $data )
	{
			$this->applicationid			= $data['applicationid'];
			$this->profiletype		= $data['profiletype'];
	}
	
	function bindValues($applicationid, $profiletypeid, $id='')
	{
			$this->id			= $id;
			$this->applicationid			= $applicationid;
			$this->profiletype			= $profiletypeid;
	}
	
	function resetApplicationId( $aid )
	{
		$db		=& $this->getDBO();
		$query	= 'SELECT COUNT(*) FROM '
				. $db->nameQuote( '#__xipt_applications' )
				. ' WHERE '.$db->nameQuote('applicationid').'=' . $db->Quote( $aid );		
		$db->setQuery( $query );

		if($db->loadResult() < 1 ) 
			return;
		
		$query	= 'SELECT '.$db->nameQuote('id')
				. ' FROM '. $db->nameQuote( '#__xipt_applications' )
				. ' WHERE '.$db->nameQuote('applicationid').'=' . $db->Quote( $aid );	
		$db->setQuery( $query );
		$results= $db->loadObjectList();
		
		foreach($results as $result)
		{
				$this->load($result->id);
				$this->delete();
		}		
		return;
	}
}
