<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.form.formfield');

class JFormFieldXiptplans extends JFormField
{
	public $type = 'Xiptplans';
		
	function getInput(){

		if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_payplans'))
  			return XiptText::_("PAYPLANS_DOES_NOT_EXISTS");
  		
  		require_once JPATH_ROOT.DS.'components'.DS.'com_payplans'.DS.'includes'.DS.'api.php';
  		
		$options	 = PayplansApi::getPlans();
		
		if(isset($this->element['addall'])){
			$reqall 			= new stdClass();
			$reqall->plan_id 	= 0;
			$reqall->title 		= 'All';
			array_unshift($options, $reqall);
		}
		
		if(isset($this->element['addnone'])){
			$reqnone 			= new stdClass();
			$reqnone->plan_id 	= -1;
			$reqnone->title 	= 'None';
			$options[]			= $reqnone;
		}
		
		$attr = '';
		if($this->multiple){
			$attr .= ' multiple="multiple"';
		}
		
		if($size = $this->element['size']){
			$attr .= ' size="'.$size.'"';
		}
		
		return JHTML::_('select.genericlist', $options, $this->name, $attr, 'plan_id', 'title', $this->value);
	}
}