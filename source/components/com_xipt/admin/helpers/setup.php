<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class XiPTHelperSetup 
{


	//check existance of custome fields profiletype and template
	function checkExistanceOfCustomFields($what)
	{
		$db		=& JFactory::getDBO();
		
		$query	= 'SELECT * FROM ' . $db->nameQuote( '#__community_fields' ) . ' '
				. 'WHERE '.$db->nameQuote('fieldcode').'='. $db->Quote($what);
				
		$db->setQuery( $query );
		
		$result = $db->loadObject();
		if(!$result)
			return false;
			
		return true;
	}
	
	
	//create custome field
	function createCustomField($what)
	{
		// Load the JTable Object.
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_community'.DS.'tables');
		$row	=& JTable::getInstance( 'profiles' , 'CommunityTable' );
		$row->load(0);
		switch($what) {
			case PROFILETYPE_CUSTOM_FIELD_CODE:
						$data['type']			= PROFILETYPE_FIELD_TYPE_NAME;
						$data['name']			= 'Profiletype';
						$data['tips']			= 'Profiletype Of User';
						break;
			case TEMPLATE_CUSTOM_FIELD_CODE:
						$data['type']			= TEMPLATE_FIELD_TYPE_NAME;
						$data['name']			= 'Template';
						$data['tips']			= 'Template Of User';
						break;
			default :
						assert(0);
						break;
		}
		$data['fieldcode']		= $what;
		
		$row->bind( $data );
		$groupOrdering	= isset($data['group']) ? $data['group'] : '';
		
		if($row->store( $groupOrdering ))
			return true;
			
		return false;
		
	}
	
	function checkCustomfieldRequired()
	{
		if(!self::checkExistanceOfCustomFields(PROFILETYPE_CUSTOM_FIELD_CODE)
			|| !self::checkExistanceOfCustomFields(TEMPLATE_CUSTOM_FIELD_CODE))
			return true;
			
		return false;
	}
	


}
