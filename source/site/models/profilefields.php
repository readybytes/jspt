<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
if(!defined('_JEXEC')) die('Restricted access');

class XiptModelProfilefields extends XiptModel
{
	//assuming that by default all fields are available to all profiletype
	//if any info is stored in table means that field is not available to that profiletype
	//we store info in opposite form
	function getNotSelectedFieldForProfiletype($profiletypeId,$category)
	{
		//XIPT_NONE means none , means not visible to any body
		
		$db			= JFactory::getDBO();
		$query		= 'SELECT `fid` FROM ' . $db->nameQuote( '#__xipt_profilefields' )
					. ' WHERE '.$db->nameQuote('pid').'='.$db->Quote($profiletypeId)
					. ' AND '.$db->nameQuote('category').'='.$db->Quote($category);
		$db->setQuery( $query );
		$results = $db->loadResultArray();
		
		return $results;
	}
	
    //call fn to update fields during registration
	function getFieldsForProfiletype(&$fields, $selectedProfiletypeID, $from, $notSelectedFields= null)
	{
		global $mainframe;
		if(empty($selectedProfiletypeID)){
		    XiptError::raiseError('XIPT_ERROR','XIPT SYSTEM ERROR');
			return false;
		}
		
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
				unset($fields[$i]);
						
			if(in_array($fieldId, $notSelectedFields['EDITABLE_AFTER_REG']) &&  $from==='getEditableProfile' && $mainframe->isAdmin()==false)
				unset($fields[$i]);

			if(in_array($fieldId, $notSelectedFields['EDITABLE_DURING_REG']) &&  $from!='getViewableProfile' &&  $from!='getEditableProfile')
				unset($fields[$i]);
				
			
		}
		$fields = array_values($fields);
		return true;
	}
	
	function getProfileTypes($fid, $cat)
	{			
		$query = new XiptQuery();
		return $query->select('pid')
					 ->from('#__xipt_profilefields')
					 ->where(" `fid` = $fid ", 'AND')
					 ->where(" `category` = $cat ")
					 ->dbLoadQuery("", "")
			  		 ->loadResultArray();		
	}
}
