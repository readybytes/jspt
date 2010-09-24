<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.model' );

class XiPTModelConfiguration extends JModel
{
	/**
	 * Configuration data
	 * 
	 * @var object
	 **/	 	 	 
	var $_params;

	/**
	 * Configuration for ini path
	 * 
	 * @var string
	 **/	 	 	 
// 	var $_ini	= '';

	/**
	 * Configuration for xml path
	 * 
	 * @var string
	 **/	 	 	 
	var $_xml	= '';
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		$mainframe	=& JFactory::getApplication();

		// Test if ini path is set
// 		if( empty( $this->_ini ) )
// 		{
// 			$this->_ini	= JPATH_COMPONENT . DS . 'config.ini';
// 		}

		// Test if ini path is set
		if( empty( $this->_xml ) )
		{
			$this->_xml	= JPATH_COMPONENT . DS . 'config.xml';
		}
		
		// Call the parents constructor
		parent::__construct();

		// Get the pagination request variables
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( 'com_community.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}
	
	/**
	 * Returns the configuration object
	 *
	 * @return object	JParameter object
	 **/	 
	function getParams($id)
	{
		// Test if the config is already loaded.
		if( !$this->_params )
		{
			$db			=& JFactory::getDBO();
			$query		= 'SELECT '. $db->nameQuote('params') .' FROM '
						. $db->nameQuote( '#__xipt_profiletypes' )
						. ' WHERE '.$db->nameQuote('id').'='. $db->Quote($id);
			
			$db->setQuery( $query );
			$pTypeConfig = $db->loadResult();
			$config =& CFactory::getConfig();
			if($pTypeConfig)
				$config	= new JParameter( $pTypeConfig );			
			
			// Load default configuration
			//$registry = $config->_registry;
			$this->_params	= $config;//new JParameter( $config->_raw );

			/*
			$profiletype		=& JTable::getInstance( 'profiletypes' , 'XiPTTable' );
			$profiletype->load( $id );
			
			// Bind the user saved configuration.
			$this->_params->bind( $profiletype->params );
			*/
		}
		return $this->_params;
		
	}
	
	/**
	 * Save the configuration to the config file
	 * 
	 * @return boolean	True on success false on failure.
	 **/
	function save()
	{
		jimport('joomla.filesystem.file');
		
		$id	= JRequest::getVar( 'id','0','post');
		
		//$id should be valid
		if(!$id){
			return false;
		}	
		
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row	=& JTable::getInstance( 'profiletypes' , 'XiPTTable' );
		
		$row->load( $id );
		
		$registry	=& JRegistry::getInstance( '' );
		//$registry->loadINI( $row->params , 'xipt' );

		$postData	= JRequest::get( 'post' , 2 );
		
		$token		= JUtility::getToken();
		unset($postData[$token]);

		
		foreach( $postData as $key => $value )
		{
			
			if( $key != 'task' && $key != 'option' && $key != 'view' && $key != $token && $key != id )
			{
				$registry->setValue( 'xipt.' . $key , $value );
			}
				
		}
		
		// Get the complete INI string
		$row->params	= $registry->toString( 'INI' , 'xipt' );
		
		// Save it
		if(!$row->store() )
		{
			return false;
		}
		return true;
	}
	
	function reset($id)
	{
		jimport('joomla.filesystem.file');
		
		//$id should be valid
		if(!$id){
			return false;
		}	
		
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row	=& JTable::getInstance( 'profiletypes' , 'XiPTTable' );
		
		$row->load( $id );

		// Get the complete INI string
		$row->params = '';
		
		// Save it
		if(!$row->store() )
		{
			return false;
		}
		return true;
	}
}