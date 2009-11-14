<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class XiPTLibraryAEC
{
	
	function getHiddenParameterForProfiletype()
	{
		if(!XiPTLibraryProfiletypes::check_aec_existance())
			return;
		
		$config = CFactory::getConfig();
		$param = array();
		$param['hidden'] = false;
		$param['profiletype'] = $config->get('profiletypes');
		$param['plan'] = '';
		$param['planid'] = 0;
		$mySess 	=& JFactory::getSession();
		if(isset($_REQUEST))
		{
			if(JRequest::getVar( 'usage', '0', 'REQUEST') || $mySess->has('JSPT_REG_PLANID','JSPT'))
			{
				$planid = JRequest::getVar( 'usage', '0', 'REQUEST') ? JRequest::getVar( 'usage', '0', 'REQUEST') : $mySess->get('JSPT_REG_PLANID','','JSPT');
				$param['planid'] = $planid;
				$param['plan'] = XiPTLibraryProfiletypes::getPlanNameFromPlanId($planid);
				$param['profiletype'] = XiPTLibraryProfiletypes::getAecPlanParameterFromId($planid);
				$param['hidden'] = true;
			}
			else
				$param['hidden'] = false;
		}
			
		return $param;
	}
	
	function getPlanNameFromPlanId($planid)
	{
		assert($planid);
		//check Existance of plan table
		if(!XiPTLibraryProfiletypes::checkExistanceofTable('acctexp_plans'))
			return '';
		
		//check existance of plan
		if(!XiPTLibraryProfiletypes::checkExistanceOfPlan($planid))
			return '';
			
		$db = &JFactory::getDBO();
		$query = 'SELECT '.$db->nameQuote('name')
			. ' FROM '.$db->nameQuote('#__acctexp_plans')
			. ' WHERE '.$db->nameQuote('id').'=' .$db->Quote($planid);
		
		$db->setQuery( $query );
		$result = $db->loadResult();

		return $result;
	}
	
	function getAecPlanParameterFromId($planid)
	{
		return XiPTLibraryProfiletypes::getProfiletypebyPlanId($planid);
	}
	
	function getProfiletypebyPlanId( $planid ) {
		
		$config = CFactory::getConfig();
		$defaultptype =  $config->get('profiletypes');
		if(empty($defaultptype))
			$defaultptype = 0;
		
		//get MI from planid;
		
		$micro_integrations = XiPTLibraryProfiletypes::getMIfromPlanid($planid);
			
		if(!XiPTLibraryProfiletypes::checkExistanceofTable('community_jspt_aec'))
			return $defaultptype;
		
		//check existance of plan
		if(!XiPTLibraryProfiletypes::checkExistanceOfPlan($planid))
			return $defaultptype;
		
		
		if(!$micro_integrations)
			return $defaultptype;
		
		// if ANY jspt mi IS  attached to this plan, then return the
		// proper profiletype.
		$db = &JFactory::getDBO();
		foreach($micro_integrations as $mi)
		{
			if(!XiPTLibraryProfiletypes::checkExistanceOfMI($mi))
				continue;
				
			$query = 'SELECT '.$db->nameQuote('profiletype')
				. ' FROM '.$db->nameQuote('#__xipt_jspt_aec')
				. ' WHERE '.$db->nameQuote('planid').'=' .$db->Quote($mi);
		
			$db->setQuery( $query );
			$result = $db->loadResult();

			if($result)
				return $result;
		}
				
		return $defaultptype;
	}
	
	
	function getMIfromPlanid($planid)
	{
		if(!XiPTLibraryProfiletypes::checkExistanceofTable('acctexp_plans'))
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
	
	
	function checkExistanceOfPlan( $planid )
	 {
	 	if(!XiPTLibraryProfiletypes::checkExistanceofTable('acctexp_plans'))
	 		return false;

		$db = &JFactory::getDBO();

		$query = 'SELECT '.$db->nameQuote('id')
			. ' FROM '.$db->nameQuote('#__acctexp_plans')
			. ' WHERE '.$db->nameQuote('id').'=' .$db->Quote($planid);
		
		$db->setQuery( $query );
		$result = $db->loadResult();
		
		if(empty($result))
			return 0;
		else
			return 1;
	}
	
	function checkExistanceOfMI( $mi )
	 {
	 	if(!XiPTLibraryProfiletypes::checkExistanceofTable('acctexp_microintegrations'))
	 		return false;
		$db = &JFactory::getDBO();

		$query = 'SELECT '.$db->nameQuote('id')
			. ' FROM '.$db->nameQuote('#__acctexp_microintegrations')
			. ' WHERE '.$db->nameQuote('id').'=' .$db->Quote($mi);
		
		$db->setQuery( $query );
		$result = $db->loadResult();
		if(empty($result))
			return 0;
		else
			return 1;
	}
	
	function checkExistanceofTable($tname)
	{
		$database = &JFactory::getDBO();

		global $mainframe;

		$tables	= array();
		$tables	= $database->getTableList();

		return in_array( $mainframe->getCfg( 'dbprefix' ) . $tname, $tables );
	}
	
	function check_aec_existance()
	{
		$aec_front = JPATH_ROOT . DS . 'components' . DS . 'com_acctexp';
		return JFolder::exists($aec_front);
	}
	
	//Function to display plan selection message manner in configuration
	function getAecMessageFieldHTML($selectedVal)
	{
		$manner = array();
		$manner['b'] = 'Both , Plan and Profiletype';
		$manner['pl'] = 'Only Plan';
		$manner['pt'] = 'Only Profiletype';
		 
		$html				= '';
		$html	.= '<select id="aecmessage" name="aecmessage" class="hasTip select" title="' . "Select AEC Message Display Manner" . '::' . "Please select display manner" . '">';
		foreach( $manner as $key => $value )
		{
		    $selected	= ( JString::trim($key) == $selectedVal ) ? ' selected="true"' : '';
			$html	.= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
		}
		$html	.= '</select>';
		return $html;
	}
		
}