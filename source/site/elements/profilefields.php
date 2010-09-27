<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementProfilefields extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Profilefields';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$value      = unserialize($value);		
		$feildsHtml = $this->getFieldsHtml($name, $value, $control_name);

		return $feildsHtml;
	}
	
	function getJomsocialProfileFields($filter = '',$join='AND')
	{
		//$ptype=jspcAddons::getCoreParams('jspc_profiletype',0);
		$allField=null;
		
		if($allField == null){
			$db	=& JFactory::getDBO();
			
			//setting up the search condition is there is any
		$wheres = array();
		if(! empty($filter)){
			foreach($filter as $column => $value)
			{
				$wheres[] = "`$column` = " . $db->Quote($value); 	
			}
		}
			
		$sql = "SELECT * FROM " . $db->nameQuote('#__community_fields');
		if(! empty($wheres)){
		   $sql .= " WHERE ".implode(' AND ', $wheres);
		}
		$sql .= " ORDER BY `ordering`";
			
		$db->setQuery($sql);
		$fields = $db->loadObjectList();
	    	
	   // $xipt_exists = JspcHelper::checkXiptExists();
	    
	    	//$result  = XiptLibProfiletypes::_getFieldsForProfiletype($fields,$ptype,null);
	    
		return $fields;
		
		}
	}
	
	function getFieldsHtml($name, $value, $control_name)
	{
		$fields = self::getJomsocialProfileFields();
		$html = '';
		if(empty($fields)) {
			$html = "<div style=\"text-align: center; padding: 5px; \">".JText::_('There are no parameters for this item')."</div>";
			return $html;
		}

		$html .= "<table width='100%' class='paramlist admintable' cellspacing='1'>";
		$html .= "<tr class='title'>";
		$html .= "<th width='30%'>".JText::_( 'FIELD NAME' )."</th>";
		
		$i = 0;
		foreach($fields as $f) {
			if($f->published) {
				++$i;
				if($f->type != 'group') {
					$html .= "<td class='paramlist_value'>".$f->name."</td>";
						$profiletypeFieldHtml=$this->buildProfileTypes($name, $value, $control_name,$f->id);
					$html .= "<td class='paramlist_value'>".$profiletypeFieldHtml."</td>";
					//$html .= "<td class='paramlist_value'>".$fieldsPercentage[$f->id]."</td>";
					//$html .= "<td class='paramlist_value'>".$fieldsPercentageInTotal[$f->id]." % </td>";
				}
				
				//$html .= "<input type='text' id='params[".$f->id."]' name='params[".$f->id."]' value='' />";
				$html .= "</tr>";
			}
		}
		
		$html .= "</table>";
		return $html;
	}
	
	function buildProfileTypes($name, $value, $control_name, $fid)
	{
		//$selectedTypes 	= XiptHelperProfilefields::getProfileTypeArrayForFieldId($fid,$for);		
		$allTypes		= XiptHelperProfiletypes::getProfileTypeArray('ALL');
		$html			= '';
		$html .= '<select id="'.$control_name.'['.$name.']['.$fid.'][]" name="'.$control_name.'['.$name.']['.$fid.'][]" value="" style="margin: 0 5px 5px 0;"  size="3" multiple/>';	
		foreach( $allTypes as $option )
		{
			$ptypeName       = XiptHelperProfiletypes::getProfileTypeName($option);
			$selected       ='';
		 	if (is_array($value) && array_key_exists($fid, $value) && in_array($option, $value[$fid]))
		  		$selected        ='SELECTED';
		  			
		 	$html .= '<option name="'.$name.'_'.$option.'" "'.$selected.'" value="'.$option.'">' ;  
			$html .= XiptHelperProfiletypes::getProfileTypeName($option).'</option>';
		}
		$html	.= '</select>';		
		
		return $html;
	}
}