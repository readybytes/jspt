<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

JFormHelper::loadFieldClass('editor');
jimport('joomla.form.formfield');

class JFormFieldXipteditor extends JFormFieldEditor
{
	
	public  $type = 'xipteditor';
		
	protected function getInput()
	{
		$this->value = base64_decode($this->value);
		return parent::getInput();
	}
}