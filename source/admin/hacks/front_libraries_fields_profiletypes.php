<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
defined('_JEXEC') or die('Restricted access');
require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php');
 
class CFieldsProfiletypes
{
	/* Value must be numeric */
	var $_mainframe;
	var $_task;
	var $_view;
	var $_params;
	
	function __construct()
	{
		global $mainframe;
		$this->_mainframe =& $mainframe;
		$this->_task = JRequest::getVar('task','','GET');
		$this->_view = JRequest::getVar('view','','GET');
		$this->_params = XiPTLibraryUtils::getParams('', 0);
	}
	
	/* if data not available,
	 * then find user's profiletype and return
	 * else present defaultProfiletype to community
	 *
	 * So there will be always a valid value returned
	 * */
	function formatData($value=0)
	{
	    $pID = $value;
		
		if(!$pID){
			//get value from profiletype field from xipt_users table
			$userid = JRequest::getVar('userid',0,'GET');
			$pID = XiPTLibraryProfiletypes::getUserData($userid,'PROFILETYPE');
		}
		return $pID;
	}
	/*
	 * Convert stored profileType ID to profileTypeName
	 *
	 * */
	function getFieldData( $value = 0 )
	{
		$pID = $value;
		
		if(!$pID){
			//get value from profiletype field from xipt_users table
			//not required to get data from getUser() fn b'coz we call this fn in 
			//getViewableprofile only.
			$userid = JRequest::getVar('userid',0,'GET');
			XiPTLibraryUtils::XAssert($userid);
			$pID = XiPTLibraryProfiletypes::getUserData($userid,'PROFILETYPE');
		}
		
		$pName = XiPTLibraryProfiletypes::getProfiletypeName($pID);
		
		/*
		// add search link
	 	$searchLink = CRoute::_('index.php?option=com_community&view=search&task=field&'.
 				PROFILETYPE_CUSTOM_FIELD_CODE.'='.urlencode( $pID ) );
		$data = '<a href="'.$searchLink.'">'.$pName.'</a>';

		return $data; //$pName;
		*/
		return JText::_($pName);
	}
	
	/*
	 * Generate input HTML for field
	 */
	function getFieldHTML($field ,$required )
	{
		$html	    = '';
		$pID	    = $field->value;
		$class	    = ($required == 1) ? ' required' : '';
		$disabled   = '';
		
		if($this->_view ==='register') {
    
		    // get pType from registration session OR defaultPType
		    $pID = XiPTFactory::getLibraryPluginHandler()->getRegistrationPType();
				 
			$html = '<input type="hidden"
							id="field'.$field->id.'"
							name="field' . $field->id.'"
							value="'.$pID.'" />';
			
			$pName = XiPTLibraryProfiletypes::getProfiletypeName($pID);
			$html .= JText::_($pName);
			
			return $html;
		}
		    
		// it might be some other user (in case of admin is editing profile)
		$user    =& JFactory::getUser();
		$userid  = $user->id;
		
		$allowToChangePType = $this->_params->get('allow_user_to_change_ptype_after_reg',0);
		$allowToChangePType = $allowToChangePType || XiPTLibraryUtils::isAdmin($user->id);
		
		//if not allowed then show disabled view of ptype
		if($allowToChangePType == false){

			if(!(int)$pID){
			    $pID = XiPTLibraryProfiletypes::getUserData($userid,'PROFILETYPE');
				XiPTLibraryUtils::XAssert($pID);
			}
			
			$pName = XiPTLibraryProfiletypes::getProfileTypeName($pID);
			$pName =JText::_($pName);
			$html = '<input type="hidden"
							id="field'.$field->id.'"
							name="field' . $field->id.'"
							value="'.$pID.'" />';
			return $html.$pName;
		}
		
		global $mainframe;
		if($mainframe->isAdmin()==true)
			$filter	= array('published'=>1);
		else
			$filter	= array('published'=>1,'visible'=>1);
		// user can change profiletype, add information
		$pTypes = XiPTLibraryProfiletypes::getProfiletypeArray($filter);
		
		$html	= '<select id="field'.$field->id.'" name="field' . $field->id  . '" '.$disabled.' class="hasTip select'.$class.' inputbox" title="' . $field->name . '::' . htmlentities( $field->tips ). '">';
		
		$selectedElement	= 0;
		if(!empty($pTypes)){
			foreach($pTypes as $pType){
			    
				$selected	= ( $pType->id == $pID ) ? ' selected="selected"' : '';
				if( !empty( $selected ) )
					$selectedElement++;
				
				$html	.= '<option value="' . $pType->id . '"' . $selected . '>' .JText::_($pType->name)  . '</option>';
			}
		}
		
		$html	.= '</select>';
		$html   .= '<span id="errfield'.$field->id.'msg" style="display:none;">&nbsp;</span>';
		
		return $html;
	}
	
	// Just an validation
	function isValid($value,$required)
	{
	    if(!$value)
			return false;
			
		if(!XiPTLibraryProfiletypes::validateProfiletype($value))
			return false;
		    
		return true;
	}
	
}
