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
		$reqall  = false;
			
		if(isset($node->_attributes->addall) || isset($node->_attributes['addall']))
			$reqall = true;
			
		$ptypeHtml = $this->getGroupcategoryHTML($name,$value,$control_name,$reqall);

		return $ptypeHtml;
	}
	
	// XITODO : remove extra code for addnone and addall
	function getGroupcategoryHTML($name,$value,$control_name='params',$reqall=false)
	{	
		$required			='1';
		$html				= '';
		$class				= ($required == 1) ? ' required' : '';
		$options			= $this->getGroupcategory();
		
		$html	.= '<select id="'.$control_name.'['.$name.']" name="'.$control_name.'['.$name.']" title="' . "Select Group Category" . '">';
		
		if($reqall) {
			$selected	= ( JString::trim(0) == $value ) ? ' selected="true"' : '';
			$html	.= '<option value="' . 0 . '"' . $selected . '>' . XiptText::_("ALL") . '</option>';
		}
		
		foreach($options as $op)
		{
		    $option		= $op->name;
			$id			= $op->id;
		    
		    $selected	= ( JString::trim($id) == $value ) ? ' selected="true"' : '';
			$html	.= '<option value="' . $id . '"' . $selected . '>' . $option . '</option>';
		}
		
		$html	.= '</select>';	
		$html   .= '<span id="errprofiletypemsg" style="display: none;">&nbsp;</span>';
		
		return $html;
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