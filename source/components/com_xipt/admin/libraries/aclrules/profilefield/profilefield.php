<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class profilefield extends xiptAclRules
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__, $debugMode);
	}
	
	function collectParamsFromPost($postdata)
	{
		$postdata['aclparams'] = array('Xiprofiletypes'=>serialize($postdata['aclparams']['Xiprofiletypes']));
		return parent::collectParamsFromPost($postdata);
	}
	
	function checkAclViolatingRule($data)
	{
		return true;
	}
	
 	function checkAclOnProfile($data)
    {
	  if( 'onprofileload' == $data['args']['from'])
	    return true;
	    
	  return false;
    }
	
 	function handleViolation($data)
   	{
   	
   		$fieldCount		= count($data['args']['field']);
   		$otherptype_arr = unserialize($this->aclparams->get('Xiprofiletypes',-1));
   		$userid			= $data['viewuserid'];
   		
   		$otherpid	     = XiPTLibraryProfiletypes::getUserData($userid,'PROFILETYPE');
    	$selfprofiletype = $this->coreparams->get('core_profiletype',0);
    	$arr_field 		 = & $data['args']['field'];
   		
    	for($i=0 ; $i < $fieldCount ; $i++)
   		{   		
	   		 $field = $arr_field[$i];
		    
		     if(is_object($field))
		        $fieldId   = $field->id;
		    else
		        $fieldId   = $field['id'];	
		        
   			if(array_key_exists($fieldId, $otherptype_arr) &&
   				 (in_array($otherpid, $otherptype_arr[$fieldId]) 
   				 	|| in_array(0, $otherptype_arr[$fieldId])))
			{
					
			    unset($arr_field[$i]);
			    continue;
			}
   		    
   		}
   		//xitodo : write test case for this	
   		$fields = array_values($arr_field);	
    }
}
