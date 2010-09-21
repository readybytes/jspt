<?php

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Jom Social Table Model
 */
class XiPTTableSettings extends JTable
{

	var $name				= null;
	var $params 			= null;
	
	function __construct(&$db)
	{
		parent::__construct('#__xipt_settings','name', $db);
	}
	
	/**
	 * Overrides Joomla's load method so that we can define proper values
	 * upon loading a new entry
	 * 
	 * @param	int	id	The id of the field
	 * 	 
	 * @return boolean true on success
	 **/
	function load( $name)
	{
		if( $name != 'settings'  )
		{
			$this->name			= '';
			$this->params 		= '';
			return true;
		}
		else
		{
			return parent::load( $name );
		}
	}

	function store( )
	{
 		parent::store();
 		
	}
		/**
	 * Bind data into object's property
	 * 
	 * @param	array	data	The data for this field
	 **/
	function bind( $data )
	{
			$this->name			= $data['name'];
			$this->params 		= $data['params'];
	}
	
}
