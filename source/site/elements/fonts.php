<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementFonts extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Fonts';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$fontsHtml = $this->getFontsHTML($name,$value,$control_name);

		return $fontsHtml;
	}
	
	
	function getFontsHTML($name,$value,$control_name='params')
	{	
		$fonts = XiPTHelperProfiletypes::getFonts();
		$html =  JHTML::_('select.genericlist', $fonts,$control_name.'['.$name.']' ,
                                null, 'value', 'text', $value);
		
		return $html;
	}
}