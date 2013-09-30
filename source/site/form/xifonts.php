<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

JFormHelper::loadFieldClass('list');
jimport('joomla.form.formfield');

class XiptFormFieldxifonts extends JFormFieldList
{
	
	public  $type = 'xifonts';
	
	public function getOptions()
	{
		$fonts = XiptHelperUtils::getFonts();
		
		$options = array();
		foreach ($fonts as $font){
			$options[] = JHtml::_('select.option', $font->text, $font->value);
		}
		
		return $options;
	}
}