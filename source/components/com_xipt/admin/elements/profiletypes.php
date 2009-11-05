<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementProfiletypes extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Profiletypes';

	function fetchElement($name, $value, &$node, $control_name)
	{
		require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php';
		$params = JComponentHelper::getParams('com_xipt');
		$ptypeHtml = XiPTHelperProfiletypes::getProfiletypeFieldHTML($params->get('defaultProfiletypeID'));

		return $ptypeHtml;
	}
}