<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.model' );

class XiPTModelSettings extends JModel
{
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		// Call the parents constructor
		parent::__construct();
	}	

	
	function getParams()
	{
		$name='settings';
			$db			=& JFactory::getDBO();
			$query		= 'SELECT '. $db->nameQuote('params') .' FROM '
						. $db->nameQuote( '#__xipt_settings' )
						. ' WHERE '.$db->nameQuote('name').'='. $db->Quote($name);
			
			$db->setQuery( $query );
			return $db->loadResult();	
		
	}
}