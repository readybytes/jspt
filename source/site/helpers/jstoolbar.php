<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptHelperJSToolbar 
{
	public static function getProfileTypeNames($menuid)
	{	
		XiptError::assert($menuid, XiptText::_("MENU_ID_CANNOT_BE_NULL"), XiptError::ERROR);

		$selected = self::getProfileTypeArray($menuid);
		
		//if selected is empty means field is invisible, then return none
		if(empty($selected))
			return XiptText::_("NONE");
		
		//if 0 exist in selected ptype means , field is available to all
		if(in_array(XIPT_PROFILETYPE_ALL, $selected))
			return XiptText::_("ALL");
			
		$retVal = array();		
		foreach($selected as $pid)	     		
			$retVal[] = XiptHelperProfiletypes::getProfileTypeName($pid);
		       
		return implode(',',$retVal);
	}   


	public static function getProfileTypeArray($menuid)
	{	
		XiptError::assert($menuid, XiptText::_("MENU_ID_CANNOT_BE_NULL"), XiptError::ERROR);
		
		$results = XiptFactory::getInstance('jstoolbar','model')
								->getProfileTypes($menuid);

		if(empty($results)) return array(XIPT_PROFILETYPE_ALL);
		
		$allTypes	= XiptHelperProfiletypes::getProfileTypeArray();
		// array_values is user to arrange the array from index 0, 
		//array_diff uses index starting from 1
		return array_values(array_diff($allTypes, $results));
	}

	public static function buildProfileTypesforJSToolbar( $menuid )
	{
		$selectedTypes 	= self::getProfileTypeArray($menuid);		
		$allTypes		= XiptHelperProfiletypes::getProfileTypeArray();
		
		$html	= '';
		
		$html	.= '<span>';
		foreach( $allTypes as $option )
		{
			// XITODO : improve following condition
		  	$selected	= in_array($option , $selectedTypes) || in_array(XIPT_PROFILETYPE_ALL, $selectedTypes)  ? ' checked="checked"' : '';
			$html .= '<lable><input type="checkbox" id="profileTypes'.$option. '" name="profileTypes[]" value="' . $option . '"' . $selected .'" style="margin: 0 5px 5px 0;" />';
			$html .= XiptHelperProfiletypes::getProfileTypeName($option).'</lable>';
			$html .= '<div class="clr"></div>';
		}
		$html	.= '</span>';		
		
		return $html;
	}	
	
	public static function getMenusToHide($userid)
	{		
		$jsmodel = XiptFactory::getInstance('jstoolbar','model');
		$pID 	 = XiptLibProfiletypes::getUserData($userid,'PROFILETYPE');
		
		$query 	 = new XiptQuery();
		$menuids = $query->select('menuid')
		 				->from('#__xipt_jstoolbar')
		 				->where(" `profiletype` = $pID ")
		 				->dbLoadQuery("", "")
  		 				->loadColumn();
  		 				
		if(empty($menuids))
			return false;
		
		foreach($menuids as $menuid)
		{
			$result   = $jsmodel->getMenu($menuid);
			if(!$result)
				continue;
				
			$hideMenu = XiptRoute::_("$result->link");
			
			ob_start();
	        ?>
	        window.joms_queue || (window.joms_queue = []);
    		window.joms_queue.push(function( $ ) {	
				var menuUrl = "<?php echo $hideMenu; ?>".replace(/\&amp\;/gi, "&");
				$("a[href^='" + menuUrl + "']").parent('li').hide();
			});	
	        <?php 
	        $content = ob_get_contents();
	        ob_clean();
			JFactory::getDocument()->addScriptDeclaration($content); 
		}
	}
}