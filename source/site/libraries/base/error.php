<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptError extends JError
{
	//XITODO : add assertError. assertWarn, assertMessage function
	function assert($condition)
	{
		if($condition)
			return;

		self::raiseError('XIPT-ASSERT', "$condition is false");
	}
}