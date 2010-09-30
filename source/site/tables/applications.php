<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

class XiptTableApplications extends XiptTable
{
	function load($id)
	{
		if( $id ){
			return parent::load( $id );
		}
		
		$this->id				= 0;
		$this->applicationid	= '';
		$this->profiletype		= '';
		return true;
	}
	
	function __construct()
	{
		parent::__construct('#__xipt_applications','id');
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
	
	function resetApplicationId( $aid )
	{
		$db		=& $this->getDBO();		
		$query	= 'DELETE '
				. ' FROM '. $db->nameQuote( '#__xipt_applications' )
				. ' WHERE '.$db->nameQuote('applicationid').'=' . $db->Quote( $aid );	
		$db->setQuery( $query );
		return  $db->query();		
	}
}
