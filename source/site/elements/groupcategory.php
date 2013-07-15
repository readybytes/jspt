<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementGroupcategory extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'group_category';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$attr		= ' ';
		$ctrl		= $control_name.'['.$name.']';
		$options	= $this->getGroupcategory();
			
		if(isset($node->_attributes->addall) || isset($node->_attributes['addall'])){
			$reqall 		= new stdClass();
			$reqall->id 	= 0;
			$reqall->name 	= 'All';
			array_unshift($options, $reqall);
		}
			
		if(isset($node->_attributes->multiselect) || isset($node->_attributes['multiselect'])){
			$attr  .= ' multiple="multiple"';
			$ctrl  .= '[]';
		}
		
		if(is_string($value))
 			$selected = explode('|', $value);
 		else
 			$selected = $value;
 			
		return JHtml::_('select.genericlist', $options, $ctrl, $attr, 'id', 'name',	$selected, $control_name.$name);
	}
	
	function getGroupcategory()
	{
		$db = JFactory::getDBO();
		$query = 'SELECT id, name FROM #__community_groups_category';

		$db->setQuery( $query );
		if($db->getErrorNum()) {
			JError::raiseError( 500, $db->stderr());
		}
		$result = $db->loadObjectList();
		return $result;
	}
}