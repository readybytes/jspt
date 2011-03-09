<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptText extends JText
{
		static function _($string, $jsSafe = false)
        {
        		$string='COM_XIPT_'.$string;
                return parent::_($string, $jsSafe);
        }
}

