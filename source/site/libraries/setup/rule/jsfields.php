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
		if(!$this->_checkExistance(PROFILETYPE_CUSTOM_FIELD_CODE)
			|| !$this->_checkExistance(TEMPLATE_CUSTOM_FIELD_CODE))
			return true;

		//check field enable required
		if(!$this->_checkExistance(PROFILETYPE_CUSTOM_FIELD_CODE,true)
			|| !$this->_checkExistance(TEMPLATE_CUSTOM_FIELD_CODE,true))
			return true;
			
		return false;
	}
	
	function doApply()
	{
		$pFieldCreated = true;
    	$tFieldCreated = true;
    	
		if(!self::_checkExistance(TEMPLATE_CUSTOM_FIELD_CODE))
				$tFieldCreated = self::createCustomField(TEMPLATE_CUSTOM_FIELD_CODE);
				
		if(!self::_checkExistance(PROFILETYPE_CUSTOM_FIELD_CODE))
				$pFieldCreated = self::createCustomField(PROFILETYPE_CUSTOM_FIELD_CODE);

		//now check field enable required then enable field
		if(!self::_checkExistance(TEMPLATE_CUSTOM_FIELD_CODE,true))
				$tFieldEnabled = self::_enableField(TEMPLATE_CUSTOM_FIELD_CODE);
				
		if(!self::_checkExistance(PROFILETYPE_CUSTOM_FIELD_CODE,true))
				$pFieldEnabled = self::_enableField(PROFILETYPE_CUSTOM_FIELD_CODE);
				
		if($pFieldCreated && $tFieldCreated
			&& $pFieldEnabled && $tFieldEnabled)
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
		if(!$db->query())
			return false;
		return true;
	}
	
	//create custome field
	function createCustomField($what)
	{
		$group = 0;
		//get first group name from community_fields_values table
		$allGroups = self::getGroups();
		if(!empty($allGroups))
			$group = $allGroups[0]->ordering;
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
						XiptHelperUtils::XAssert(0);
						break;
		}
		$data['fieldcode']		= $what;
		$data['group']			= $group;
		
		$row->bind( $data );
		$groupOrdering	= isset($data['group']) ? $data['group'] : '';
		
		if($row->store( $groupOrdering ))
			return true;
			
		return false;
		
	}
	
	//check existance of custom fields profiletype and template
	function _checkExistance($what,$checkenable=false)
	{
		$db		= JFactory::getDBO();
		
		$extraChk = '';
		if($checkenable)
			$extraChk = ' AND '.$db->nameQuote('published').'='.$db->Quote(1);
			
		$query	= 'SELECT * FROM ' . $db->nameQuote( '#__community_fields' ) . ' '
				. 'WHERE '.$db->nameQuote('fieldcode').'='. $db->Quote($what)
				. $extraChk;
				
		$db->setQuery( $query );
		
		$result = $db->loadObject();
		if(!$result)
			return false;
			
		return true;
	}
	
	//call fn don't write update query here
	function _enableField($fieldcode)
	{
		$db			= JFactory::getDBO();
			
		$query	= 'UPDATE ' . $db->nameQuote( '#__community_fields' )
				. ' SET '.$db->nameQuote('published').'='.$db->Quote('1')
	          	.' WHERE '.$db->nameQuote('fieldcode').'='.$db->Quote($fieldcode);

		$db->setQuery($query);		
		if(!$db->query())
			return false;
			
		return true;
	}
	
	function getGroups()
	{
		$db		=& JFactory::getDBO();
		
		$query	= 'SELECT * '
				. 'FROM ' . $db->nameQuote( '#__community_fields' )
				. 'WHERE ' . $db->nameQuote( 'type' ) . '=' . $db->Quote( 'group' );

		$db->setQuery( $query );		
		
		$fieldGroups	= $db->loadObjectList();
		
		return $fieldGroups;
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