<?php
/**
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license http://www.azrul.com Copyrighted Commercial Software
 */

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Jom Social Table Model
 */
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
	function load( $id , $isGroup = false )
	{
		if( $id == 0 )
		{
			$this->id			= 0;
			$this->applicationid			= '';
			$this->profiletype			= '';
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
		
		//For new records need to update the ordering.
 		/*
     if( $this->id == 0 )
 		{
 		*/
 			// Set the ordering
 			$query	= 'SELECT COUNT(' . $db->nameQuote('id') . ') FROM ' . $db->nameQuote('#__xipt_applications')
					. ' WHERE '.$db->nameQuote('applicationid').'='.$db->Quote($this->applicationid)
					. ' AND '.$db->nameQuote('profiletype').'='.$db->Quote($this->profiletype);	
			
 			$db->setQuery( $query );
		  $count	= $db->loadResult();
		  if($count)
			     return;
 		  
       return parent::store();
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
