<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Check to ensure this file is within the rest of the framework
if(!defined('_JEXEC')) die('Restricted access');

function com_uninstall()
{
	// disable plugins
	disable_plugin('xipt_system');
	disable_plugin('xipt_community');
}

function disable_plugin($pluginname)
{
	$db			=& JFactory::getDBO();		
	$query	= 'UPDATE ' . $db->nameQuote( '#__plugins' )
			. ' SET '.$db->nameQuote('published').'='.$db->Quote('0')
          	.' WHERE '.$db->nameQuote('element').'='.$db->Quote($pluginname);

	$db->setQuery($query);		
	if(!$db->query())
		return false;
	return true;
}
