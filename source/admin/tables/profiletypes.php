<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Jom Social Table Model
 */
class XiPTTableProfiletypes extends JTable
{

	var $id					= null;
	var $name				= null;
	var $tip				= null;
	var $ordering			= null;
	var $published  		= null;
	var $privacy			= null;
	var $template			= null;
	var $jusertype			= null;
	var $avatar				= null;
	var $watermark			= null;
	var $approve			= null;
	var $allowt				= null;
	var $group 				= null;
	var $params 			= null;
	var $watermarkparams 	= null;
	var $visible			= null;
	
	function __construct(&$db)
	{
		parent::__construct('#__xipt_profiletypes','id', $db);
	}
	
	/**
	 * Overrides Joomla's load method so that we can define proper values
	 * upon loading a new entry
	 * 
	 * @param	int	id	The id of the field
	 * 	 
	 * @return boolean true on success
	 **/
	function load( $id)
	{
		if( $id == 0 )
		{
			$this->id			= 0;
			$this->name			= '';
			$this->tip			= '';
			$this->ordering		= true;
			$this->published	= true;
			$this->ordering		= 0;
			$this->privacy 		= "friends";
			$this->template		= "default";
			$this->jusertype	= "Registered";
			$this->allowt		= false;
			$this->avatar		= DEFAULT_AVATAR;
			$this->watermark	= "";
			$this->approve		= false;
			$this->group 		= 0;
			$this->params 		= '';
			$this->watermarkparams 		= '';
			$this->visible		= 1;
			return true;
		}
		else
		{
			return parent::load( $id );
		}
	}

	function delete()
	{
	
		$db		=& $this->getDBO();
		
		if(empty($this->ordering))
			$this->ordering='0';
			
		$query	= "UPDATE " . $db->nameQuote( '#__xipt_profiletypes' ) . ' '
				. 'SET ordering = (ordering -1 ) '
				. 'WHERE ' . $db->nameQuote( 'ordering' ) . '>' . $this->ordering;
				
		$db->setQuery( $query );
		//print_r($query);
		$db->query();
		
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
 		if( $this->id == 0 )
 		{
 			$query	= 'SELECT COUNT(' . $db->nameQuote('ordering') . ') FROM ' . $db->nameQuote('#__xipt_profiletypes');
				
 			$db->setQuery( $query );
 			$this->ordering	= $db->loadResult() + 1;
			//print_r("ordering is ".$this->ordering);
 		}
		else
		{
			//print_r("updating record ". $this->id);		
		}
		
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
				. $db->nameQuote( '#__xipt_profiletypes' )
				. 'WHERE ' . $db->nameQuote( $field ) . '=' . $db->Quote( $value );
		
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
			$this->name			= $data['name'];
			$this->tip			= $data['tip'];
			$this->published	= $data['published'];
			$this->template		= $data['template'];
			$this->jusertype	= $data['jusertype'];
			$this->privacy		= $data['privacy'];
			//$this->avatar		= $data['avatar'];
			//$this->watermark	= $data['watermark'];
			$this->approve		= $data['approve'];
			$this->allowt		= $data['allowt'];
			$this->group 		= $data['group'];
			$this->watermarkparams 		= $data['watermarkparams'];
			$this->visible		= $data['visible'];
			//$this->ordering		= $data['ordering'];
	}
}
