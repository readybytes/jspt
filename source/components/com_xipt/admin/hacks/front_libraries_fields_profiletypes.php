<?php
/**
 */
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
		$this->_task = JRequest::getVar('task',0,'GET');
		$this->_view = JRequest::getVar('view',0,'GET');
		$this->_params = JComponentHelper::getParams('com_xipt');
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
			assert($userid);
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
		return $pName;
	}
	
	/*
	 * Generate input HTML for field
	 */
	function getFieldHTML($field ,$required )
	{
		$html	    = '';
		$pID	    = $field->value;
		$class	    = ($field->required == 1) ? ' required' : '';
		$disabled   = '';
		
		if($this->_view =='register') {
    
		    // get pType from registration session OR defaultPType
		    $pID = XiPTFactory::getLibraryPluginHandler()->getRegistrationPType();
				 
			$html = '<input type="hidden"
							id="field'.$field->id.'"
							name="field' . $field->id.'"
							value="'.$pID.'" />';
			
			$pName = XiPTLibraryProfiletypes::getProfiletypeName($pID);
			$html .= $pName;
			
			return $html;
		}
		    
		// it might be some other user (in case of admin is editing profile)
		$user    =& JFactory::getUser();
		
		$allowToChangePType = $this->_params->get('allow_user_to_change_ptype_after_reg',0);
		$allowToChangePType = $allowToChangePType || XiPTLibraryUtils::isAdmin($user->id);
		
		//if not allowed then show disabled view of ptype
		if($allowToChangePType == false){

			if(!(int)$pID){
			    $pID = XiPTLibraryProfiletypes::getUserData($userid,'PROFILETYPE');
				assert($pID);
			}
			
			$pName = XiPTLibraryProfiletypes::getProfileTypeName($pID);
			$html = '<input type="hidden"
							id="field'.$field->id.'"
							name="field' . $field->id.'"
							value="'.$pID.'" />';
			return $html.$pName;
		}
		
		// user can change profiletype, add information
		$pTypes = XiPTLibraryProfiletypes::getProfiletypeArray();
		
		$html	= '<select id="field'.$field->id.'" name="field' . $field->id  . '" '.$disabled.' class="hasTip select'.$class.' inputbox" title="' . $field->name . '::' . htmlentities( $field->tips ). '">';
		
		$selectedElement	= 0;
		if(!empty($pTypes)){
			foreach($pTypes as $pType){
			    
				$selected	= ( $pType->id == $pID ) ? ' selected="selected"' : '';
				if( !empty( $selected ) )
					$selectedElement++;
				
				$html	.= '<option value="' . $pType->id . '"' . $selected . '>' .$pType->name  . '</option>';
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
