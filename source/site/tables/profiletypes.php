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
class XiptTableProfiletypes extends XiptTable
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
	var $config             = null;
	
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
			$this->privacy 		= '';
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
			$this->config 		= '';
			return true;
		}
		else
		{
			return parent::load( $id );
		}
	}
	
	function __construct(&$db)
	{
		parent::__construct('#__xipt_profiletypes','id');
	}

}