<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementWatermarkposition extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Watermarkposition';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$positions = array();
		$positions[] = JHTML::_('select.option', 'tl', JText::_('Top Left'));
		$positions[] = JHTML::_('select.option', 'tr', JText::_('Top Right'));
		$positions[] = JHTML::_('select.option', 'bl', JText::_('Bottom Left'));
		$positions[] = JHTML::_('select.option', 'br', JText::_('Bottom Right'));
		$positions[] = JHTML::_('select.option', 'lt', JText::_('Left Top'));
		$positions[] = JHTML::_('select.option', 'lb', JText::_('Left Bottom'));
		$positions[] = JHTML::_('select.option', 'rt', JText::_('Right Top'));
		$positions[] = JHTML::_('select.option', 'rb', JText::_('Right Bottom'));
		/*$positions[] = JHTML::_('select.option', 'lta', JText::_('Left Top Angle'));
		$positions[] = JHTML::_('select.option', 'rta', JText::_('Right Top Angle'));
		$positions[] = JHTML::_('select.option', 'lba', JText::_('Left Bottom Angle'));
		$positions[] = JHTML::_('select.option', 'rba', JText::_('Right Bottom Angle'));
		*/
		$html =  JHTML::_('select.genericlist', $positions,$control_name.'['.$name.']' ,
                                null, 'value', 'text', $value);
		return $html;
	}
	
}
