<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

include_once 'uploadfile.php';

class XiptFormFieldCoverImage extends XiptFormFielduploadfile
{
	public  $type = 'coverimage';
		
	protected function getInput()
	{
		$html = '';
		if ($this->value) {
			$html = '<img src="'.JURI::root().'/'.$this->value.'" style="max-width:50%;height:auto" alt="Cover Image" border=10 /><div class="clr"></div>';
		}
		return '<div  class="offset3 span12">'.$html.parent::getInput().'</div>';		
	}
}