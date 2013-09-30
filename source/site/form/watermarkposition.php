<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

JFormHelper::loadFieldClass('list');
jimport('joomla.form.formfield');

class XiptFormFieldwatermarkposition extends JFormFieldList
{
	
	public  $type = 'watermarkposition';
		
	public function getOptions()
	{
		$positions = array();
		
		$positions[] = JHTML::_('select.option', 'tl', XiptText::_('TOP_LEFT'));
		$positions[] = JHTML::_('select.option', 'tr', XiptText::_('TOP_RIGHT'));
		$positions[] = JHTML::_('select.option', 'bl', XiptText::_('BOTTOM_LEFT'));
		$positions[] = JHTML::_('select.option', 'br', XiptText::_('BOTTOM_RIGHT'));
		$positions[] = JHTML::_('select.option', 'lt', XiptText::_('LEFT_TOP'));
		$positions[] = JHTML::_('select.option', 'lb', XiptText::_('LEFT_BOTTOM'));
		$positions[] = JHTML::_('select.option', 'rt', XiptText::_('RIGHT_TOP'));
		$positions[] = JHTML::_('select.option', 'rb', XiptText::_('RIGHT_BOTTOM'));
		
		return $positions;
	}
}