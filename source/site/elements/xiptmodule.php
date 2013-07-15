<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementXiptmodule extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'xiptModule';

	function fetchElement($name, $value, &$node, $control_name)
	{	
		$options = $this->getAllModules(1);

		return JHtml::_('select.genericlist', $options, $control_name.'['.$name.']', null, 'id', 'title', $value);
	}
	
	function getAllModules($published = '')
	{
		$query = new XiptQuery();
		$query->select('*');
		$query->from('#__modules');
		$query->where("`published` = $published");
		
		$query->order('ordering');	
		$modules =$query->dbLoadQuery("","")->loadObjectList();			 	    	
		
		return $modules;	
	}
}