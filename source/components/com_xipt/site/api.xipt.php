<?php
/**
* @version      $Id$
* @package      JoomlaXi
* @subpackage   JomSocial Profile Types
* @copyright    Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license      GNU/GPL, see LICENSE.php
*/


require_once JPATH_SITE.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php';

class XiptAPI
{
    
	/**
	 * Collect Profiletype from user-id
	 * 
	 * @param $userid
	 * @param $what (default value is "id", you can ask for "name" too)
	 * @return unknown_type
	 */
	function getUserProfiletype($userid, $what='id')
	{
	    $pID = XiPTLibraryProfiletypes::getUserData($userid,'PROFILETYPE');
	    if($what == 'id')
	        return $pID;

	    //else
        return XiPTLibraryProfiletypes::getProfiletypeName($pID);
	}
	
	/**
	 * Gives profiletype attributes -
	 *  
	 *  - if "id" is not given then returns all profiletypes
	 *  - if "visible" is true, then send all profiletypes, invisibles too. 
	 * @param $id
	 * @param $visible
	 * @return Array of Profiletype Objects
	 */
	function getProfiletypeInfo($id=0,$onlyvisible=false,$onlypublished=1)
	{
		$filter = array('published'=>$onlypublished);
	    $allPT = XiPTLibraryProfiletypes::getProfiletypeArray($filter);

	    //no profiletype available
	    if(!$allPT)
	        return null;
	        
	    //no id, return all
	    if(!$id || $id < 0)
	        return $allPT;
	        
	    //return specfic array
	    foreach($allPT as $pt)
	        if($pt->id == $id)
	            return $pt;

	    // invalid id 
	    return null;  
	}
	
	/*
	 * Returns default profiletype 
	 */
	function getDefaultProfiletype()
	{
		return XiPTLibraryProfiletypes::getDefaultProfiletype();
	}
	

	/**
	 * Use this function to update user's profiletype
	 * @param $userId			: Which user's profiletype should be updated
	 * @param $profiletypeId	: New Profiletype ID
	 * @param $reset			: Which attributes should be reset, default is ALL
	 * 							  or you can use (profiletype, jusertype, avatar, group, privacy etc.)
	 * @return unknown_type
	 */
	function setUserProfiletype($userId, $profiletypeId, $reset = 'ALL')
	{
		return XiPTLibraryProfiletypes::updateUserProfiletypeData($userId,$profiletypeId,null, $reset);
	}
	
	
	function getUserInfo($userid, $what='PROFILETYPE')
	{
		return XiPTLibraryProfiletypes::getUserData($userid,$what);
	}
}
