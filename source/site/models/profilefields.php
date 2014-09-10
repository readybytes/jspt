<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
if(!defined('_JEXEC')) die('Restricted access');

class XiptModelProfilefields extends XiptModel
{
	/**
	 * 	(Customised it for pagination)
	 *  @see components/com_xipt/libraries/base/XiptModel::getTotal()
	 */
	public function getTotal()
	{
		if($this->_total) {
			return $this->_total;
		}
		/**
		 * XiTODO :: Write this code in well manner
		 * Right now profile_fields table dont have all js fields so we dont have any alternate except it. 
		 */
		$query = new XiptQuery();
		$query->select('*'); 
		$query->from('#__community_fields');
		$query->order('ordering');
		
        $this->_total 	= $this->_getListCount((string) $query);

		return $this->_total;
	}
	
	//assuming that by default all fields are available to all profiletype
	//if any info is stored in table means that field is not available to that profiletype
	//we store info in opposite form
	function getNotSelectedFieldForProfiletype($profiletypeId,$category)
	{
		//XIPT_NONE means none , means not visible to any body
		$records = $this->loadRecords(0);
		$notselectedFieldIds = array();
		foreach($records as $record){					
			if($record->pid == $profiletypeId && $record->category == $category)
				array_push($notselectedFieldIds, $record->fid);
		}

		return $notselectedFieldIds;
	}
	
    //call fn to update fields during registration
    // XITODO : move this function to helper or library
	function getFieldsForProfiletype(&$fields, $selectedProfiletypeID, $from, $notSelectedFields= null)
	{
		XiptError::assert($selectedProfiletypeID, XiptText::_("SELECTED_PROFILETYPE_DOES_NOT_EXIST"), XiptError::ERROR);
		$task 	= JRequest::getVar('task','');
		
		if($notSelectedFields===null)
		{
			$categories=XiptHelperProfilefields::getProfileFieldCategories();
			
			foreach($categories as $catIndex => $catInfo)
			{
				$catName 			 = $catInfo['name'];
				$notSelectedFields[$catName] = $this->getNotSelectedFieldForProfiletype($selectedProfiletypeID,$catIndex);
			}
		}
		
		$count = count($fields);
		
		for($i=0 ; $i < $count ; $i++){
		    $field =& $fields[$i];
		    
		    
		    if(is_object($field))
		        $fieldId   = $field->id;
		    else
		        $fieldId   = $field['id'];

			if(in_array($fieldId, $notSelectedFields['ALLOWED']))
			{
			    unset($fields[$i]);
			    continue;
			}
			
			if(in_array($fieldId, $notSelectedFields['REQUIRED']))
			{
				if(is_object($field))
				    $field->required=0;
				else
					$field['required']=0;
			}
			
			if(in_array($fieldId, $notSelectedFields['VISIBLE']) &&  $from==='getViewableProfile')
			{
				unset($fields[$i]);
				continue;
			}
						
			if( in_array($fieldId, $notSelectedFields['EDITABLE_AFTER_REG']) &&  $from==='getEditableProfile' && JFactory::getApplication()->isAdmin()==false )
			{
				if(is_object($field)){ 
					if((!empty($field->value) && $field->required) || $field->required == 0)
					{
	                  	unset($fields[$i]);
						continue;
					}
				}
                elseif(is_array($field)){
                	if((!empty($field['value']) && $field['required']) || $field['required'] == 0)
	                {
	                		                	// Remove unset - as it requires to show fields but not allow to edit. If don't want to show fields then uncomment unset line.
	                	//unset($fields[$i]);
						// Code added for disabled elements as per profile type
	                  //	Used for elements which used any value like textbox, textarea etc. Not work for element which set state of element like On / Off eg checkbox , radio element
	                  // Don't used disabled here else dat won't get post and your value will get reset after saving the form 	                	
	                	$script[] = "$('[name=".'"field'.$field['id'].'"'."]').prop('readonly' , 'readonly')";
	                	// Use for select element to disable as per id, which are used to set value to on / off  
	                	$script[] = "$('select[name=\"field{$field['id']}\"]').prop('disabled',true)";
	                	// Use for radio list, only one value get selected so not defined as array 
	                	$script[] = "$('input[name=\"field{$field['id']}\"][type=radio]').click(function(){  return false;})";
	                	// Use for checkbox, multiple values get selected so defined as array and make it read only and on click return it 
	                	$script[] = "$('input[name=\"field{$field['id']}[]\"][type=checkbox]').click(function(){   return false;})";
	                	
	                   	// code completed for diabled
						continue;
	               	}
                }
			}

			if(in_array($fieldId, $notSelectedFields['EDITABLE_DURING_REG']) &&  $from!='getViewableProfile' &&  $from!='getEditableProfile' && $task!='advancesearch')
			{
				unset($fields[$i]);
				continue;
			}

			if(in_array($fieldId, $notSelectedFields['ADVANCE_SEARCHABLE']) &&  $from==='_loadAllFields' && $task==='advancesearch')
				unset($fields[$i]);
			
		}
		// Code added for disabled field element. Id don't want then remove this code or comment it
		if(isset($script) && !empty($script)) {
			$js = "jQuery(document).ready(function($){ ".implode("\n", $script)."});"; 
			JFactory::getDocument()->addScriptDeclaration($js);
		}
		// code completed for disabled
		
		$fields = array_values($fields);
		return true;
	}
	
	function getProfileTypes($fid, $cat)
	{		
		//XITODO : Implement WHERE in load records
		static $records = null;
		if(!$records){
			$records  = $this->loadRecords(0);
		}

		$profileTypes = array();
		
		foreach($records as $record){
			if($record->fid == $fid && $record->category == $cat){
				array_push($profileTypes, $record->pid);
			}
		}
				
		return $profileTypes;
	}
}

