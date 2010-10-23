<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptAclHelper
{
	function isFriend($userId, $viewUserId)
	{
		$db 		= & JFactory::getDBO();
		$query		= 'SELECT '. $db->nameQuote('connection_id').'  FROM ' . $db->nameQuote( '#__community_connection')
								.' WHERE '. $db->nameQuote('connect_from').'='.$db->Quote($userId)
								.' AND '. $db->nameQuote('connect_to').'='.$db->Quote($viewUserId)
								.' AND '. $db->nameQuote('status').'='.$db->Quote('1');
		$db->setQuery( $query );
		return $db->loadResult();
	}

    function performACLCheck($ajax=false, $callArray, $args)
	{
		//Return if admin
		$userId 		= JFactory::getUser()->id;
		if(XiptHelperUtils::isAdmin($userId))
			return false;

		$option 	=  JRequest::getVar('option');
		$feature 	=  JRequest::getCmd('view');
		$task 		=  JRequest::getCmd('task');

		// depending upon call get feature and task, might be objectID
		if($ajax){
			$option 	= 'com_community';
			$feature 	= JString::strtolower($callArray[0]);
			$task	 	= JString::strtolower($callArray[1]);
		}


		// if user is uploading avatar at the time of registration then
		// the user id will be availabale from tmpuser
		if($option=='com_community' && $feature=='register' &&
			 ($task=='registerAvatar' || $task=='registerSucess'))
		{
        	$userId  = JFactory::getSession()->get('tmpUser','')->id;
		}
		$viewuserid 	= JRequest::getVar('userid', 0);


		// assign into one array
		$info['option']			= $option;
		$info['view'] 			= $feature;
		$info['task'] 			= strtolower($task);
		$info['userid'] 		= $userId;
		$info['viewuserid'] 	= $viewuserid;
		$info['ajax'] 			= $ajax;
		$info['args'] 			= $args;


		//get all published rules
		$rules = XiptAclFactory::getAclRulesInfo(array('published'=>1));
		if(empty($rules))
			return false;


		foreach($rules as $rule) {
			$aclObject = XiptAclFactory::getAclObject($rule->aclname);
			$aclObject->bind($rule);

			if(false == $aclObject->isApplicable($info))
				continue;

			if(false == $aclObject->checkViolation($info)){
				//rule might update viewuserid, pass corerct id to next rule
				$info['viewuserid'] = $viewuserid;
				continue;
			}

			$aclObject->handleViolation($info);
			break;

		}

		return false;
	}
	
	//XITODO : Apply caching
	//         test case
	function getOrderedRules()
	{
		$parser		= JFactory::getXMLParser('Simple');
		$xml		= dirname(__FILE__) . DS . 'order.xml';
	
		$parser->loadFile( $xml );
	
		$order	= array();
		$childrens = $parser->document->children();
		$groups = array();
		foreach($childrens as $child){
			$group = $child->attributes();
			array_push($groups,$group);
			
			$childGroup = $child->children();
			foreach($childGroup as $cg)
				$rules[$group['name']][] = $cg->attributes();
				
		}
		
		return array('groups'=>$groups,'rules'=>$rules);
	}
	
	// XITODO : test case
	function getHelpMessage($aclName)
	{
		$msgFile = dirname(__FILE__).DS.$aclName.DS.'help.html';
		if(!JFile::exists($msgFile))
			return false;
			
		ob_start();
		include_once($msgFile);
		$content = ob_get_contents();
		ob_end_clean();
		
		return $content;
	}
}