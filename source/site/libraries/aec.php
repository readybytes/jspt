<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class XiPTLibraryAEC
{
	function getProfiletypeInfoFromAEC()
	{
		if(!self::_checkAECExistance())
			return false;
		
		$defaultptype = XiPTLibraryProfiletypes::getDefaultProfiletype();
		
		$param = array();
		$param['hidden'] = false;
		$param['profiletype'] = $defaultptype ;
		$param['plan'] = '';
		$param['planid'] = 0;
		
		$mySess =& JFactory::getSession();
		$usage  =  JRequest::getVar( 'usage', '0', 'REQUEST');
		$planIdInSess = $mySess->has('AEC_REG_PLANID','XIPT');
		$planid    = $planIdInSess ? $mySess->get('AEC_REG_PLANID',0,'XIPT') : 0;
		$planid =  $usage ? $usage : $planid;
		
		if($planid){		    
			$param['planid']       = $planid;
			$param['plan']         = self::getPlanNameFromPlanId($planid);
			$param['profiletype']  = self::getAecPlanParameterFromId($planid);
			$param['planSelected'] = true;
			
			//also set things in session
			$mySess->set('AEC_REG_PLANID',$planid, 'XIPT');
		}
		else
			$param['planSelected'] = false;

		return $param;
	}
	
	function getPlanNameFromPlanId($planid)
	{
		//check Existance of plan table
		if(!self::_checkExistanceOfTable('acctexp_plans'))
			return '';
		
		//check existance of plan
		if(!self::checkExistanceOfPlan($planid))
			return '';
			
		$db = &JFactory::getDBO();
		$query = 'SELECT '.$db->nameQuote('name')
			    .' FROM ' .$db->nameQuote('#__acctexp_plans')
			    .' WHERE '.$db->nameQuote('id').'=' .$db->Quote($planid);
		
		$db->setQuery( $query );
		$result = $db->loadResult();

		return $result;
	}
	
	function getAecPlanParameterFromId($planid)
	{
		return self::getProfiletypebyPlanId($planid);
	}
	

	function getProfiletypebyPlanId( $planid )
	{
	    $defaultptype = XiPTLibraryProfiletypes::getDefaultProfiletype();

	    //get MI from planid;
		$micro_integrations = self::getMIfromPlanid($planid);

		//our table exist ???
		if(!self::_checkExistanceOfTable('xipt_aec'))
			return $defaultptype;
		
		//check existance of plan
		if(!self::checkExistanceOfPlan($planid))
			return $defaultptype;
		
		
		if(!$micro_integrations)
			return $defaultptype;
		
		// if ANY jspt mi IS  attached to this plan, then return the
		// proper profiletype.
		$db = &JFactory::getDBO();
		
		foreach($micro_integrations as $mi)
		{
			if(!self::_checkExistanceOfMI($mi))
				continue;
				
			$query = 'SELECT '.$db->nameQuote('profiletype')
				    .' FROM ' .$db->nameQuote('#__xipt_aec')
				    .' WHERE '.$db->nameQuote('planid').'=' .$db->Quote($mi);
		
			$db->setQuery( $query );
			$result = $db->loadResult();

			if($result)
				return $result;
		}

		// No Profiletype was matched
		return $defaultptype;
	}
	
	
	function getMIfromPlanid($planid)
	{
		if(!self::_checkExistanceOfTable('acctexp_plans'))
	 		return false;

		$db = &JFactory::getDBO();
		$query = 'SELECT '.$db->nameQuote('micro_integrations')
			. ' FROM '.$db->nameQuote('#__acctexp_plans')
			. ' WHERE '.$db->nameQuote('id').'=' .$db->Quote($planid);
		
		$db->setQuery( $query );
		$result = $db->loadResult();

		if(!$result)
			return false;

		$micro_integration = unserialize(base64_decode($result));
		return $micro_integration;
	}
	
	
	
	
	//Function to display plan selection message manner in configuration
	function getAecMessage()
	{
	    $data   = XiPTLibraryAEC::getProfiletypeInfoFromAEC();
	    $msgOption = XiPTLibraryUtils::getParams('aec_message','b');
	    
    	switch($msgOption)
    	{
	        case 'b' :
	            $pTypeName = XiPTLibraryProfiletypes::getProfiletypeName($data['profiletype']);
                $aecMessage = JText::sprintf('ALREADY SELECTED PLAN AS.BOTH',$data['plan'],$pTypeName);
	            break;
            case 'pl':
                $aecMessage = JText::sprintf('ALREADY SELECTED PLAN AS.ONLYPLAN',$data['plan']);
                break;
            case 'pt':
                $pTypeName = XiPTLibraryProfiletypes::getProfiletypeName($data['profiletype']);
                $aecMessage = JText::sprintf('ALREADY SELECTED PLAN AS.ONLY PTYPE',$pTypeName);
                break;
    	}

	    return $aecMessage;
	}
	
	function checkExistanceOfPlan($planid)
	 {
	 	if(!self::_checkExistanceOfTable('acctexp_plans'))
	 		return false;

		$db = &JFactory::getDBO();
		$query = 'SELECT '.$db->nameQuote('id')
			    .' FROM ' .$db->nameQuote('#__acctexp_plans')
			    .' WHERE '.$db->nameQuote('id').'=' .$db->Quote($planid);
		
		$db->setQuery( $query );
		$result = $db->loadResult();		
		return ($result ? true : false);
	}
	
	
	function _checkAECExistance()
	{
	    jimport( 'joomla.filesystem.folder' );
	    
		$aecFront = JPATH_ROOT . DS . 'components' . DS . 'com_acctexp';
		return JFolder::exists($aecFront);
	}

	
	function _checkExistanceOfMI( $mi )
	 {

	     if(!self::_checkExistanceOfTable('acctexp_microintegrations'))
	 		return false;
	 		
		$db = &JFactory::getDBO();
		$query = ' SELECT '.$db->nameQuote('id')
			    .' FROM '  .$db->nameQuote('#__acctexp_microintegrations')
			    .' WHERE ' .$db->nameQuote('id').'=' .$db->Quote($mi);
		
		$db->setQuery( $query );
		$result = $db->loadResult();

		//id can not be 0
		return ($result ? true : false);
	}
	
	/**
	 * @param $tableName, without prefix and #__
	 * @return boolean
	 */
	function _checkExistanceOfTable($tname)
	{
		global $mainframe;

		$tables	= array();
		
		$database = &JFactory::getDBO();
		$tables	= $database->getTableList();

		return in_array( $mainframe->getCfg( 'dbprefix' ) . $tname, $tables );
	}			
}