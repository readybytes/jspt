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
	
	function getFieldData( $value = null)
	{
		$pID = 0;
		if(!$value)
           		 $pID=$value;		
		
		if(!$pID){
			//get value from profiletype field from xipt_users table
			//not required to get data from getUser() fn b'coz we call this fn in 
			//getViewableprofile only.
			$my 	= CFactory::getUser();
			$userid = JRequest::getVar('userid', $my->id);
			XiptError::assert($userid,XiptText::_("USERID $userid DOES_NOT_EXIST"), XiptError::ERROR);
			$pID = XiptLibProfiletypes::getUserData($userid,'PROFILETYPE');
		}
		
		$pName = XiptLibProfiletypes::getProfiletypeName($pID);
		return $pName;
	}
	
} 

