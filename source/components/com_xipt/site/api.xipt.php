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
	function getProfiletypeInfo($id=0,$visible=false)
	{
	    $allPT = XiPTLibraryProfiletypes::getProfiletypeArray($visible);

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
	
}