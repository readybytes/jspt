<?php
/*
------------------------------------------------------------------------
* copyright	Copyright (C) 2010 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* Author : Team JoomlaXi @ Ready Bytes Software Labs Pvt. Ltd.
* Email  : shyam@joomlaxi.com
* License : GNU-GPL V2
* Websites: www.joomlaxi.com
*/

// no direct access
if(!defined('_JEXEC')) die('Restricted access');

JFormHelper::loadFieldClass('file');
jimport('joomla.form.formfield');

class XiptFormFielduploadfile extends JFormFieldFile
{
	
	public  $type = 'uploadfile';
		
	protected function getInput()
	{
		$this->element['accept'] = '.png';
		$this->input = $this->value;
		return parent::getInput();
	}
}