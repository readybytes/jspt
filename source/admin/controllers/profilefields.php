<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptControllerProfileFields extends XiptController 
{	
	function edit($fieldId=0)
	{
		$fieldId = JRequest::getVar('editId', $fieldId);		
		return $this->getView()->edit($fieldId,'edit');
	}
	
	//save fields which is not accsible , means in opposite form
	// like field1 is visible to ptype 1 not to ptype 2 and 3 , then store 2 and 3
	//by default all fields are visible to all ptype
	//if all is selected then store nothing
	//remove old fields
	
	function save()
	{
		$post	= JRequest::get('post');		
					
		//remove all rows related to specific field id 
		// cleaning all data for storing new profiletype with fields		
		$this->getModel()->delete(array('fid'=> $post['id']));
		
		$allTypes		= XiptHelperProfiletypes::getProfileTypeArray();
		$categories		= XiptHelperProfilefields::getProfileFieldCategories();
		foreach($categories as $catIndex => $catInfo)
		{
			$controlName= $catInfo['controlName'];
			$count = 0;
			if(!array_key_exists($controlName."0",$post)) {
				foreach($allTypes as $type) {
					if($type) {
						if(!array_key_exists($controlName.$type,$post)) {
							  $this->getModel()->save(array('fid'=>$post['id'], 'pid'=>$type, 'category'=>$catIndex));
							  $msg = JText::_('FIELDS SAVED');
							  $count++;
						}
					}
				}
				/*if($count == 0) {
				 XiptHelperProfilefields::addFieldsProfileType($post['id'], 'XIPT_NONE','XIPT_NONE');
			}*/
			}
		}
			
		$msg 	= JText::_('FIELDS SAVED');	
		$link 	= XiptRoute::_('index.php?option=com_xipt&view=profilefields', false);
		JFactory::getApplication()->redirect($link, $msg);
		return;
	}
}
