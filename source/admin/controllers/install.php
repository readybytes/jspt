<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2013- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

if(!defined('_JEXEC')) die('Restricted access');

class XiptControllerInstall extends XiptController 
{
	public function getModel($modelName = '', $prefix = '', $config = array())
    {
		return false;
    }
    
	public function complete()
	{
		$app = JFactory::getApplication();
		$app->redirect("index.php?option=com_xipt");
	}
}
