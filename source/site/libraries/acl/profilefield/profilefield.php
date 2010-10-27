<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class profilefield extends XiptAclBase
{
		public $triggerForEvents = array('onprofileload'=>1);  
		    
        function collectParamsFromPost($postdata)
        {
        	$postdata['aclparams']['Xiprofiletypes']=serialize($postdata['aclparams']['Xiprofiletypes']);
            return parent::collectParamsFromPost($postdata);
        }
        
        function checkAclViolation($data)
        {
		        if($this->aclparams->get('acl_applicable_to_friend',1) == 0)
				{
					$isFriend = XiptAclHelper::isFriend($data['userid'],$data['viewuserid']);
					if($isFriend)
					 return false;
				}
				
		        return true;
        }
        
        function checkAclOnProfile(&$data)
    	{
             if(is_array($data['args']) 
                                && array_key_exists('from',$data['args']) 
                                && 'onprofileload' == $data['args']['from'])
                	return true;
            
             return false;
   	   }
        
       function handleViolation($data)
       {
        
                $fieldCount             = count($data['args']['field']);
                $otherptype_arr 		= unserialize($this->aclparams->get('Xiprofiletypes',-1));
                $userid                 = $data['viewuserid'];
                
                $otherpid            	= XiptLibProfiletypes::getUserData($userid,'PROFILETYPE');
        		$selfprofiletype 	 	= $this->coreparams->get('core_profiletype',0);
        		$arr_field           	= & $data['args']['field'];
                
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
                $fields = array_values($arr_field);     
    }

    function checkAclApplicable(&$data)
    {
                if('com_community' === $data['option'] 
                        && 'profile' === $data['view']
                           && 'edit' !== $data['task']) 
                        return true;
                        
                return false;
    }
        
}     
        