<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptSetupRuleJsfields extends XiptSetupBase
{
	function isRequired()
	{
		$fields = $this->_checkExistance();
		if(!$fields || count($fields)!= 2)
			return true;

		$tmpField = $fields[TEMPLATE_CUSTOM_FIELD_CODE];
		$ptField  = $fields[PROFILETYPE_CUSTOM_FIELD_CODE];
		
		return (!($tmpField->published && $ptField->published));
	}
	
	function doApply()
	{
		if($this->isRequired()== false)
			return JText::_("CUSTOM FIELD ALREADY CREATED AND ENABLED SUCCESSFULLY");
			
		$fields = $this->_checkExistance();
			
		
		if(isset($fields[TEMPLATE_CUSTOM_FIELD_CODE])===false)
			$tFieldCreated = $this->createCustomField(TEMPLATE_CUSTOM_FIELD_CODE);
		
		if(isset($fields[PROFILETYPE_CUSTOM_FIELD_CODE])===false)
			$pFieldCreated  = $this->createCustomField(PROFILETYPE_CUSTOM_FIELD_CODE);
			
		$fieldEnabled = $this->_enableField();

				
		if($pFieldCreated && $tFieldCreated && $fieldEnabled)
			return JText::_("CUSTOM FIELD CREATED AND ENABLED SUCCESSFULLY");
			
		return JText::_("CUSTOM FIELDS ARE NOT CREATED OR ENABLED");
	}
	
	function doRevert()
	{
		$db			=& JFactory::getDBO();		
		$query	= 'UPDATE ' . $db->nameQuote( '#__community_fields' )
				. ' SET '.$db->nameQuote('published').'='.$db->Quote('0')
	          	.' WHERE '.$db->nameQuote('type').'='.$db->Quote('profiletypes')
	          	.' OR '.$db->nameQuote('type').'='.$db->Quote('templates');
	
		$db->setQuery($query);		
		return $db->query();
	}
	
	//check existance of custom fields profiletype and template
	function _checkExistance()
	{
		$db		= JFactory::getDBO();
			
		$query	= 'SELECT * FROM ' . $db->nameQuote( '#__community_fields' ) . ' '
				. ' WHERE '.$db->nameQuote('fieldcode').'='. $db->Quote(PROFILETYPE_CUSTOM_FIELD_CODE)
				. ' OR '.$db->nameQuote('fieldcode').'='. $db->Quote(TEMPLATE_CUSTOM_FIELD_CODE);
				
		$db->setQuery( $query );
		$results = $db->loadObjectList('fieldcode');
		
		if(!$results)
			return false;
			
		return $results;
	}
	
	//create custome field
	function createCustomField($what)
	{
		// Load the JTable Object.
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_community'.DS.'tables');
		$row	= JTable::getInstance( 'profiles' , 'CommunityTable' );
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
						XiptError::assert(0);
						break;
		}
		
		$data['published'] =  1;								
		$data['fieldcode'] = $what;
		
		return $row->bind($data) && $row->store();		
	}
	
	
	
	//enable template & profiletype fields in community_fields table
	function _enableField()
	{
		$db		= JFactory::getDBO();
			
		$query	= 'UPDATE ' . $db->nameQuote( '#__community_fields' )
				. ' SET '.$db->nameQuote('published').'='.$db->Quote('1')
	          	. ' WHERE '.$db->nameQuote('type').'='. $db->Quote('profiletypes')
				. ' OR '.$db->nameQuote('type').'='. $db->Quote('templates');

		$db->setQuery($query);		
		if(!$db->query())
			return false;
			
		return true;
	}
	
	
	function getMessage()
	{
		$requiredSetup = array();
		if($this->isRequired())
		{
			$link = XiptRoute::_("index.php?option=com_xipt&view=setup&task=doApply&name=jsfields",false);
			$requiredSetup['message']  = '<a href="'.$link.'">'.JText::_("PLEASE CLICK HERE TO CREATE AND ENABLE CUSTOM FIELDS").'</a>';
			$requiredSetup['done']  = false;
		}
		
		else
		{
			$requiredSetup['message']  = JText::_("CUSTOM FIELDS EXIST");
			$requiredSetup['done']  = true;
		}
			
			
		return $requiredSetup;
	}
}