<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * profilestatus Helper
 *
 * @package Joomla
 * @subpackage profilestatus
 * @since 1.5
 */
class XiPTHelperApplications {

function getProfileTypeNameforApplication($id)
{
		if($id==0 || empty($id))
			return "ALL";

		$db			=& JFactory::getDBO();
		$query		= 'SELECT '.$db->nameQuote('name')
					. ' FROM ' . $db->nameQuote( '#__XiPT_profiletypes' ) 
					. ' WHERE '.$db->nameQuote('id').'='.$db->Quote($id);
		$db->setQuery( $query );
		return $db->loadResult();
}

function getProfileTypeNamesForApplicationId($aid)
{
	if(empty($aid))
		return "ALL";
		
	//Load all profiletypes for the field
	$db			=& JFactory::getDBO();
	$query		= 'SELECT '.$db->nameQuote('profiletype')
				. ' FROM ' . $db->nameQuote( '#__XiPT_Applications' ) 
				. ' WHERE '.$db->nameQuote('applicationid').'='.$db->Quote($aid);
	$db->setQuery( $query );
	$results = $db->loadObjectList();
	
	//print_r("result = ".$results);
	
	if(!$results)
		return "ALL";
	
  $notselected = array();
	//create array of result profile type
	foreach($results as $result)
	{
      $notselected[] = $result->profiletype;
  }
	
	$retVal = '';
	$i=0;
	$allTypes		= XiPTHelperApplications::getProfileTypeArrayforApplication();
	// Add ALL also
	$allTypes[] = 0;
	$profileTypeCount = count($allTypes)-1;
	foreach($allTypes as $pid)
	{
	   //echo $pid;
     		if(!in_array($pid,$notselected) && $pid != 0)
		    {
		        $retVal .= XiPTHelperApplications::getProfileTypeNameforApplication($pid);
		        $retVal .=','; 
		        $i++;
		    }
	}
	
	if($retVal == '')
	       $retVal .= XiPTHelperApplications::getProfileTypeNameforApplication(0);
	       
	return $retVal;
}   


function getProfileTypeArrayForApplicationId($aid)
{
	$retVal	= array();
	if(empty($aid))
	{
		$retVal[] = -1;
		return $retVal;
	}
		
	//Load all profiletypes for the field
	$db			=& JFactory::getDBO();
	$query		= 'SELECT '.$db->nameQuote('profiletype')
				. ' FROM ' . $db->nameQuote( '#__XiPT_Applications' ) 
				. ' WHERE '.$db->nameQuote('applicationid').'='.$db->Quote($aid);
	$db->setQuery( $query );
	$results = $db->loadObjectList();
	/*
	$allProfiletypeId = getProfileTypeArrayforApplication();
	if(empty($allProfiletypeId))
	{
      $retVal[] = 0;
      return $retVal;
  }
  */
	if($results)
	{
		foreach ($results as $result)
		{
			//print_r($result);
			$retVal[]=$result->profiletype;
		}
	}
	
	return $retVal;
}


function getProfileTypeArrayforApplication()
{
	$db			=& JFactory::getDBO();
	$query		= 'SELECT '.$db->nameQuote('id')
				. ' FROM ' . $db->nameQuote( '#__XiPT_profiletypes' ) ;
	$db->setQuery( $query );
	$results = $db->loadObjectList();
	$retVal	= array();
	if($results)
		foreach ($results as $result)
			$retVal[]=$result->id;
		
	return $retVal;
}	

function buildProfileTypesforApplication( $aid )
	{
		$notselectedTypes 	= XiPTHelperApplications::getProfileTypeArrayForApplicationId($aid);		
		$allTypes		= XiPTHelperApplications::getProfileTypeArrayforApplication();
		// Add ALL also
		$allTypes[] = 0;
		
		$selectedTypes = array();
		
		$html	= '';
		
		if(empty($notselectedTypes))
		    $selectedTypes[] = 0;
		else
		{
		    foreach($allTypes as $pid)
		    {
		      if(!in_array($pid,$notselectedTypes))
		      {
		          //print_r("pid = ".$pid);
		          if($pid != 0)
		              $selectedTypes[] = $pid;
		      }
		    }
		}
		
		$html	.= '<span>';
		$count = count($allTypes)-1;
		$html .= '<input type="hidden" name="profileTypesCount" value="'.$count.'" />';
		foreach( $allTypes as $option )
		{
		  $selected	= in_array($option , $selectedTypes ) ? ' checked="checked"' : '';
			$html .= '<lable><input type="checkbox" name="profileTypes'.$option. '" value="' . $option . '"' . $selected .'" style="margin: 0 5px 5px 0;" />';
			$html .= XiPTHelperApplications::getProfileTypeNameforApplication($option).'</lable>';
			$count--;
		}
		$html	.= '</span>';		
		
		return $html;
	}


function addApplicationProfileType($aid, $pid)
{
	$row	=& JTable::getInstance( 'Applications' , 'XiPTTable' );
	if(is_array($pid))
	{
		foreach($pid as $p)
		{			
			$row->bindValues($aid,$p);
			$row->store();
		}
	}
	else
	{
		$row->bindValues($aid,$pid);
		$row->store();
	}
}

function remMyApplicationProfileType($aid)
{
	if(empty($aid))
		return;
	$row	=& JTable::getInstance( 'Applications' , 'XiPTTable' );
	$row->resetApplicationId($aid);
}

}
?>