<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
 
class XiptControllerCPanel extends XiptController 
{    
	public function getModel($modelName ='', $prefix = '', $config = array())
    {
    	return false;
    }
       
	function aboutus()
	{
		return $this->getView()->aboutus();
	}	
}
