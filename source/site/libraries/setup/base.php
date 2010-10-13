<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');


abstract class XiptSetupBase
{
	function isRequired()
	{
		return true;
	}
	
	function doApply()
	{
		return true;
	}
	
	function isApplicable()
	{
		return true;
	}
	
	function doRevert()
	{
		return true;
	}
}