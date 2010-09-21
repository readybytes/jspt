<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/


require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php';

class XiptAPI
{
    
	/**
	 * Collect User's Profiletype from user-id
	 * 
	 * @param $userid
	 * @param $what (default value is "id", you can ask for "name" too)
	 * @return int (id) or String (Name)
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

	/**
	 * Gives all the profiletypes attributes -
	 *  
	 *  - if "id" is not given then returns all profiletypes
	 *   
	 * @param $id
	 * @param $filter : Associative array to define conditions
	 * @return Array of Profiletype Objects
	 */
	function getProfiletypeInfo($id=0, $filter=array())
	{
		//$filter = array('published'=>$onlypublished);
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
	        {
	        	//return always an array
	        	$retVal[] = $pt;
	            return $retVal;
	        }

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
	 * returns user information
	 * @param $userid : 
	 * @param $what : can be 'PROFILETYPE' or 'TEMPLATE'
	 * @return unknown_type
	 */
	function getUserInfo($userid, $what='PROFILETYPE')
	{
		//Resetting getuserdata fn result
		XiPTLibraryProfiletypes::getUserData($userid, $what, true);
		return XiPTLibraryProfiletypes::getUserData($userid,$what);		
		
	}
	
	
	/**
	 * Returns any global configuration settings in JSPT 
	 * @param $paramName : the value of which variable you require
	 * @param $defaultValue
	 * @return unknown_type
	 */
	function getGlobalConfig($paramName='', $defaultValue=0)
	{
		if($paramName === '')
			return null;
			
		return XiPTLibraryUtils::getParams($paramName ,$defaultValue);
	}
}
