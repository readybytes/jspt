<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.form.formfield');

class JFormFieldVideocategory extends JFormField
{
	public $type = 'video_category';
		
	function getInput(){

		//get all event category
		$options	= $this->getVideocategory();
		
		if(isset($this->element['addall'])){
			$reqall 		= new stdClass();
			$reqall->id 	= 0;
			$reqall->name 	= 'All';
			array_unshift($options, $reqall);
		}
		
		//add multiselect option
		$attr = ' ';
		$attr = $this->multiple ? ' multiple="multiple"' : '';
		
		return JHTML::_('select.genericlist', $options, $this->name, $attr, 'id', 'name', $this->value);
	}
	
	function getVideocategory()
	{
		$db =& JFactory::getDBO();
		$query = 'SELECT id, name FROM #__community_videos_category';

		$db->setQuery( $query );
		if($db->getErrorNum()) {
			JError::raiseError( 500, $db->stderr());
		}
		$result = $db->loadObjectList();
		return $result;
	}
}