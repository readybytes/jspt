<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementEventcategory extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'event_category';

	function fetchElement($name, $value, &$node, $control_name)
	{

		$options	= $this->getEventcategory();
		
		if(isset($node->_attributes->addall) || isset($node->_attributes['addall'])){
			$reqall 		= new stdClass();
			$reqall->id 	= 0;
			$reqall->name 	= 'All';
			array_unshift($options, $reqall);
		}
		
		return JHtml::_('select.genericlist', $options, $control_name.'['.$name.']', null, 'id', 'name', $value);
	}
	
	function getEventcategory()
	{
		$db = JFactory::getDBO();
		$query = 'SELECT id, name FROM #__community_events_category';

		$db->setQuery( $query );
		if($db->getErrorNum()) {
			JError::raiseError( 500, $db->stderr());
		}
		$result = $db->loadObjectList();
		return $result;
	}
}