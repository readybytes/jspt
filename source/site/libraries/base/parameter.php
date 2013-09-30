<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		PayPlans
* @subpackage	Frontend
* @contact 		shyam@readybytes.in
*/
if(defined('_JEXEC')===false) die();

/*
 * We have extended JDocument class so that we can control what to do
 * on particular times
 */
jimport('joomla.html.parameter');
class XiptParameter extends JForm
{
	public static function getInstance($name, $data = null, $options = array(), $replace = true, $xpath = false)
	{
		$data = trim($data);

		if (empty($data))
		{
			throw new InvalidArgumentException(sprintf('JForm::getInstance(name, *%s*)', gettype($data)));
		}

		// Instantiate the form.
		$forms[$name] = new JForm($name, $options);

		// Load the data.
		if (substr(trim($data), 0, 1) == '<')
		{
			if ($forms[$name]->load($data, $replace, $xpath) == false)
			{
				throw new RuntimeException('JForm::getInstance could not load form');
			}
		}
		else
		{
			if ($forms[$name]->loadFile($data, $replace, $xpath) == false)
			{
				throw new RuntimeException('JForm::getInstance could not load file');
			}
		}

		return $forms[$name];
	}
}