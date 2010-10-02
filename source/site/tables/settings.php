<?php

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Jom Social Table Model
 */
class XiptTableSettings extends XiptTable
{
	var $name				= null;
	var $params 			= null;
	
	function __construct()
	{
		parent::__construct('#__xipt_settings','name');
	}

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
}