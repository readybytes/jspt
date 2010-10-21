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
		$positions[] = JHTML::_('select.option', 'tl', XiptText::_('Top Left'));
		$positions[] = JHTML::_('select.option', 'tr', XiptText::_('Top Right'));
		$positions[] = JHTML::_('select.option', 'bl', XiptText::_('Bottom Left'));
		$positions[] = JHTML::_('select.option', 'br', XiptText::_('Bottom Right'));
		$positions[] = JHTML::_('select.option', 'lt', XiptText::_('Left Top'));
		$positions[] = JHTML::_('select.option', 'lb', XiptText::_('Left Bottom'));
		$positions[] = JHTML::_('select.option', 'rt', XiptText::_('Right Top'));
		$positions[] = JHTML::_('select.option', 'rb', XiptText::_('Right Bottom'));
		$html =  JHTML::_('select.genericlist', $positions,$control_name.'['.$name.']' ,
                                null, 'value', 'text', $value);
		return $html;
	}
	
}
