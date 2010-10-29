<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/


// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptFieldsTemplatesJs18 extends XiptFieldsTemplatesBase
{
	function getTemplateValue($value,$userid)
	{
		// during registration
        if($this->_view =='register'){
            $pID = XiptFactory::getPluginHandler()->getRegistrationPType();
		    $tName = XiptLibProfiletypes::getProfileTypeData($pID,'template');
		    return $tName;
        }
		
        if($value)
            $tName=$value;
        else
        {
	        //a valid or default value
	        $tName = XiptLibProfiletypes::getUserData($userid,'TEMPLATE');
        }
        return $tName;
	}
	
	function getFieldData( $value = null)
	{
		$tName = $value; 
	
		if($tName == null){
			$userid = JRequest::getVar('userid',0);
			$tName = XiptText::_($this->getTemplateValue($value,$userid));
		}
		
		return $tName;
	}
} 
