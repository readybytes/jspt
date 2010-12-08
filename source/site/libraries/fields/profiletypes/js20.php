<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/


// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptFieldsProfiletypesJs20 extends XiptFieldsProfiletypesBase
{
	function getTemplateValue($field,$userid)
	{
		// during registration
        if($this->_view =='register'){
            $pID = XiptFactory::getPluginHandler()->getRegistrationPType();
		    $tName = XiptLibProfiletypes::getProfileTypeData($pID,'template');
		    return $tName;
        }
		

        if(!empty($field) && isset($field['value']))
            $tName=$field['value'];
        else
        {
	        //a valid or default value
	        $tName = XiptLibProfiletypes::getUserData($userid,'TEMPLATE');
        }
        return $tName;
	}
	
	function getFieldData( $field =array() )
	{
		$pID = 0;
		if(!empty($field) && isset($field['value']))
            $pID=$field['value'];		
		
		if(!$pID){
			//get value from profiletype field from xipt_users table
			//not required to get data from getUser() fn b'coz we call this fn in 
			//getViewableprofile only.
			$userid = JRequest::getVar('userid',0);
			XiptError::assert($userid,XiptText::_("USERID = $userid DOES NOT EXIST"), XiptError::ERROR);
			$pID = XiptLibProfiletypes::getUserData($userid,'PROFILETYPE');
		}
		
		$pName = XiptLibProfiletypes::getProfiletypeName($pID);
		return XiptText::_($pName);
	}
	
} 
