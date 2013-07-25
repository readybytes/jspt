<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class deletemessages extends XiptAclBase
{
	function getResourceOwner($data)
	{
		$args		= $data['args'];
		$msgId	    = $args[0];
		
		$db 		= JFactory::getDBO();
		$query		= ' SELECT '.$db->quoteName('msg_from')
					 .' FROM '.$db->quoteName('#__community_msg_recepient')
					 .' WHERE '.$db->quoteName('msg_id').' = '.$db->Quote($msgId);
					 
		$db->setQuery( $query );
		$userid		= $db->loadResult();
		return $userid;	
	}

	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;

		if('inbox' != $data['view'])
			return false;

		$task = array('ajaxremovefullmessages', 'ajaxdeletemessages', 'ajaxremovemessage');
		if(in_array($data['task'], $task))
				return true;

		return false;
	}
}