<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class addasfriends extends XiptAclBase
{
	public function checkAclViolation($data)
	{
		$otherptype = $this->aclparams->get('other_profiletype',-1);
		$otherpid	= XiptLibProfiletypes::getUserData($data['args'][0],'PROFILETYPE');
		$selfptype  = $this->coreparams->get('core_profiletype',-1);
		
		if(!in_array($otherptype, array(XIPT_PROFILETYPE_ALL,XIPT_PROFILETYPE_NONE,$otherpid)))
			return false;
			
		$count = $this->getFeatureCounts($data['userid'], $otherptype, $selfptype);

		$maxmimunCount = $this->aclparams->get('friends_limit',0);

		if(($count >= $maxmimunCount))
			return true;

		return false;

	}

	function getFeatureCounts($userid, $otherptype, $selfptype)
	{
		// XITODO : change this query into object
		$db		= JFactory::getDBO();
		$query	= 'SELECT DISTINCT(a.connect_to) AS id  FROM ' . $db->nameQuote('#__community_connection') . ' AS a '
				. 'INNER JOIN ' . $db->nameQuote( '#__users' ) . ' AS b '
				. 'ON a.connect_from=' . $db->Quote( $userid ) . ' '
				. 'AND a.connect_to=b.id '
				. ' LEFT JOIN #__xipt_users as ptfrom ON a.`connect_to`=ptfrom.`userid`'
				. ' AND ptfrom .`profiletype`=' . $db->Quote($selfptype)
				. ' LEFT JOIN #__xipt_users as ptto ON a.`connect_to`=ptto.`userid`'
				. ' AND ptto .`profiletype`=' . $db->Quote($otherptype);
		$db->setQuery( $query );
		$count		= $db->loadResultArray();
		return count($count);
	}	
	
	function checkAclApplicable(&$data)
	{
		if('com_community' != $data['option'] && 'community' != $data['option'])
			return false;
			
		if('friends' != $data['view'])
			return false;
			
		if($data['args'][0] != 0 && $data['task'] === 'ajaxconnect')
				return true;
				
		return false;
	}
}
