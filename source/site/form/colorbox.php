<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die();

JFormHelper::loadFieldClass('color');
jimport('joomla.form.formfield');

class XiptFormFieldcolorbox extends JFormFieldColor
{
	
	public  $type = 'colorbox';
		
	protected function getInput()
	{
		$this->input = $this->value;
		return parent::getInput();
	}
}