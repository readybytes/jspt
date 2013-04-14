<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.form.formfield');

class JFormFieldProfiletypes extends JFormField
{
	public $type = 'Profiletypes';
		
	function getInput(){

		// get array of all visible profile types (std-class)
		$pTypeArray = XiptLibProfiletypes::getProfiletypeArray();
		
		//add multiselect option
		$attr = ' ';
		$attr = $this->multiple ? ' multiple="multiple"' : '';
		
		return JHTML::_('select.genericlist',  $pTypeArray, $this->name, $attr, 'id', 'name', $this->value);
	}
}