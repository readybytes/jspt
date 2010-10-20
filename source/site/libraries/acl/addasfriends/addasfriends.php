<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class addasfriends extends XiptAclBase
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}


	public function checkAclViolation($data)
	{
		$otherptype = $this->aclparams->get('other_profiletype',-1);
		$otherpid	= XiptLibProfiletypes::getUserData($data['args'][0],'PROFILETYPE');

		if(!in_array($otherptype, array(XIPT_PROFILETYPE_ALL,XIPT_PROFILETYPE_NONE,$otherpid)))
			return false;

		return true;
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
