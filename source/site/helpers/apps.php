<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

//XITODO : apps
class XiptHelperApps 
{

	function getProfileTypeNameforApplication($id)
	{
		if($id==0 || empty($id))
			return "ALL";

		$db			=& JFactory::getDBO();
		$query		= 'SELECT '.$db->nameQuote('name')
					. ' FROM ' . $db->nameQuote( '#__xipt_profiletypes' ) 
					. ' WHERE '.$db->nameQuote('id').'='.$db->Quote($id);
		$db->setQuery( $query );
		return $db->loadResult();
	}

	function getProfileTypeNamesForApplicationId($aid)
	{
	
		XiptLibUtils::XAssert($aid, "Application Id cannot be null.");

		$selected = array();
		$selected = XiptHelperApps::getProfileTypeArrayForApplicationId($aid);
		
		//if selected is empty means field is invisible, then return none
		if(empty($selected))
			return JText::_("NONE");
		
		//if 0 exist in selected ptype means , field is available to all
		if(in_array('0',$selected))
			return XiptHelperApps::getProfileTypeNameforApplication(0);
			
		$retVal = '';
		
		foreach($selected as $pid) {
		   //echo $pid;
	     		if(in_array($pid,$selected)) {
			        $retVal .= XiptHelperApps::getProfileTypeNameforApplication($pid);
			        $retVal .=','; 
			    }
		}
		       
		return $retVal;
	}   


	function getProfileTypeArrayForApplicationId($aid)
	{
	
		XiptLibUtils::XAssert($aid, "Application ID cannot be NULL.");
			
		//Load all profiletypes for the field
		$db			=& JFactory::getDBO();
		$query		= 'SELECT '.$db->nameQuote('profiletype')
					. ' FROM ' . $db->nameQuote( '#__xipt_applications' ) 
					. ' WHERE '.$db->nameQuote('applicationid').'='.$db->Quote($aid);
		$db->setQuery( $query );
		$results = $db->loadObjectList();
		
		$allTypes		= XiptHelperApps::getProfileTypeArrayforApplication();
		
		$notselected = array();
		$selected = array();
		//means there is no bound ptype , so we will retrun all ptypes
		//we store ptype that is not required for that application
		//so empty results means field is applicable to all.
		if(empty($results)) {
			$selected[] = 0;
			return $selected;
			//return $allTypes;
		}
			
		
		if($results)
			foreach ($results as $result)
				$notselected[]=$result->profiletype;
	
		foreach($allTypes as $pid) {
			   //echo $pid;
		     		if(!in_array($pid,$notselected)) 
				        $selected[] = $pid;
		}
		
		return $selected;
	}


	function getProfileTypeArrayforApplication($all = '')
	{
		$db			=& JFactory::getDBO();
		$query		= 'SELECT '.$db->nameQuote('id')
					. ' FROM ' . $db->nameQuote( '#__xipt_profiletypes' ) ;
		$db->setQuery( $query );
		$results = $db->loadObjectList();
		$retVal	= array();
		if($results)
			foreach ($results as $result)
				$retVal[]=$result->id;
				
		if($all == 'ALL')
			$retVal[] = 0;
			
		return $retVal;
	}	

	function buildProfileTypesforApplication( $aid )
	{
		$selectedTypes 	= XiptHelperApps::getProfileTypeArrayForApplicationId($aid);		
		$allTypes		= XiptHelperApps::getProfileTypeArrayforApplication('ALL');
		
		$html	= '';
		
		$html	.= '<span>';
		$count=count($allTypes);
		$html .= '<input type="hidden" name="profileTypesCount" value="'.$count.'" />';
		foreach( $allTypes as $option )
		{
		  	$selected	= in_array($option , $selectedTypes ) ? ' checked="checked"' : '';
			$html .= '<lable><input type="checkbox" name="profileTypes'.$option. '" value="' . $option . '"' . $selected .'" style="margin: 0 5px 5px 0;" />';
			$html .= XiptHelperApps::getProfileTypeNameforApplication($option).'</lable>';
		}
		$html	.= '</span>';		
		
		return $html;
	}

	//XITODO : Clean Code
	function addApplicationProfileType($aid, $pid)
	{
		$row	=& JTable::getInstance( 'Applications' , 'XiptTable' );
		if(is_array($pid))
		{
			foreach($pid as $p)
			{			
				$row->bind(array('applicationid'=>$aid,'profiletype'=>$p));
				$row->store();
			}
		}
		else
		{
			$row->bind(array('applicationid'=>$aid,'profiletype'=>$pid));
			$row->store();
		}
	}

	//XITODO : remove this wrapper also
	function remMyApplicationProfileType($aid)
	{
		if(empty($aid))
			return;
		$row	= XiptFactory::getInstance( 'Applications' , 'model' );
		$row->resetApplicationId($aid);
	}

}
