<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');


abstract class XiptAclBase
{
	public $id			= 0 ;
	public $aclname		= '';
	public $rulename	= '';
	public $published	= 1 ;
	public $coreparams	= '';
	public $aclparams	= '';
	public $triggerForEvents = array('default'=>1);

	function __construct()
	{
		$this->aclname = $className	= get_class($this);

		//Load ACL Params, if not already loaded
		if(!$this->aclparams){
			$aclxmlpath =  dirname(__FILE__).DS.strtolower($className).DS.strtolower($className).'.xml';
			if(JFile::exists($aclxmlpath)){
				$this->aclparams = XiptParameter::getInstance('aclparams',$aclxmlpath, array('control' => 'aclparams'));
			}
		}

		//Load Core Params if defined for current ACL, if not already loaded
		if(!$this->coreparams){
			$corexmlpath =  dirname(__FILE__).DS.strtolower($className).DS.'coreparams.xml';
			if(JFile::exists($corexmlpath)){
				$corexmlpath =  dirname(__FILE__).DS.strtolower($className).DS.'coreparams.xml';
			}
			else{
				$corexmlpath = dirname(__FILE__).DS.'coreparams.xml';
			}
		}
		
		XiptError::assert(JFile::exists($corexmlpath), $corexmlpath. XiptText::_("FILE_DOES_NOT_EXIST"), XiptError::ERROR);
		
		$this->coreparams = XiptParameter::getInstance('coreparams', $corexmlpath, array('control' => 'coreparams'));
	}

	function getParams($params)
	{		
		$data = null;
      	foreach ((Array)$params as $key => $val) {
        	if($val instanceof JRegistry){
        		$data = &$val;
        		break;
        	}
    	}
    	$data = $data->toArray();
    	return $data;
	}
	
	function load($id)
	{
		if(0 == $id) {
			return $this;
		}

		$filter = array();
		$filter['id'] = $id;
		$result = XiptAclFactory::getAclRulesInfo($filter);

		if(!$result)
			return $this;

		$info = array_shift($result);
		$this->id 				= $info->id;
		$this->aclname 			= $info->aclname;
		$this->published 		= $info->published;
		$this->rulename 		= $info->rulename;

		$this->coreparams->bind(json_decode($info->coreparams));
		$this->aclparams->bind(json_decode($info->aclparams));
		return $this;
	}

	function getObjectInfoArray()
	{
		return get_object_vars($this);
	}

	public function getAclParamsHtml()
	{
		$acl_model = XiptFactory::getInstance('Aclrules','model');
		return $acl_model->getParamHtml($this->aclparams);
	}

	final public function getCoreParamsHtml()
	{
		$acl_model = XiptFactory::getInstance('Aclrules','model');
		return $acl_model->getParamHtml($this->coreparams);
	}

	function collectParamsFromPost($postdata)
	{
		// it is not necessary the each rule will have acl params
		// so check it, and return empty ini string if not exists 
		if(!isset($postdata['aclparams']))
			return "\n\n";

		return json_encode($postdata['aclparams']);
	}

	function bind($data)
	{
		if(is_object($data)) {

			$this->aclparams->bind(json_decode($data->aclparams)); 
			$this->coreparams->bind(json_decode($data->coreparams));
			$this->rulename 	= $data->rulename;
			$this->published 	= $data->published;
			$this->id			= $data->id;
			return $this;
		}

		if(is_array($data)) {
			
			$this->aclparams->bind($data['aclparams']);
			$this->coreparams->bind($data['coreparams']);
			$this->rulename 	= $data['rulename'];
			$this->published 	= $data['published'];
			$this->id			= $data['id'];
			return $this;
		}

		//Any issue
		XiptError::assert(0);
	}

	/**
	 * IMP : Use Refrence as we may need to 
	 * change viewuserid in case of writemessages
	 */
	function isApplicable(&$data)
	{
		// if acl rule are invoked with any triggerForEvent then 
		// only those acl rule will be applied which has set that trigger in 
		// their variable triggerForEvents
		// by default only that acl rules will be applied whci has 
		// default value in it
		//XITODO : clean code : use default from where acl rules are being invoked
		if(isset($data['args']['triggerForEvents'])){
			$key = $data['args']['triggerForEvents'];
			if($key && isset($this->triggerForEvents[$key])==false)
				return false;			
		}
		else	
		 	if(!isset($this->triggerForEvents['default']))
				return false;
			
		$isApplicableAccToAcl      =     $this->checkAclApplicable($data);
		$isApplicableAccToCore     =     $this->checkCoreApplicable($data);

		//These condition need to be AND as we ensure rule only apply if
		// it is applicable as per conditions.
	
		if($isApplicableAccToAcl && $isApplicableAccToCore)
			return true;

		return false;
	}

	public function checkCoreApplicable($data)
	{
		$restrictBy = $this->getCoreParams('restrict_by',0);
		
		if($restrictBy){
			return $this->checkCoreApplicableByPlan($data);
		}
		else{
			$ptype = $this->getCoreParams('core_profiletype',XIPT_PROFILETYPE_ALL);
	
			//check if its applicable on more than 1 ptype
			$ptype = is_array($ptype)?$ptype:array($ptype);
			
			//All means applicable
			if(in_array(XIPT_PROFILETYPE_ALL, $ptype))
				return true;
			
			//profiletype matching
			if(in_array(XiptLibProfiletypes::getUserData($data['userid']), $ptype))
				return true;
		}
		return false;
	}


	abstract public function checkAclApplicable(&$data);


	function checkViolation($data)
	{
		$restrictBy = $this->getCoreParams('restrict_by',0);
		
		if($restrictBy)
			return ($this->checkAclViolationByPlan($data) || $this->checkCoreViolation($data));
		else
			return ($this->checkAclViolation($data) || $this->checkCoreViolation($data));
	}


	function isApplicableOnSelfProfiletype($resourceAccesser)
	{
		$aclSelfPtype = $this->getACLAccesserProfileType();
		$selfPid	= XiptLibProfiletypes::getUserData($resourceAccesser,'PROFILETYPE');
		
		//check if its applicable on more than 1 ptype
		$aclSelfPtype = is_array($aclSelfPtype)?$aclSelfPtype:array($aclSelfPtype);
		
		//if its applicable to all
		if(in_array(XIPT_PROFILETYPE_ALL, $aclSelfPtype))
			return true;
		
		//if user's ptype exists in ACL ptype array
		if(in_array($selfPid, $aclSelfPtype))
			return true;

		return false;
	}
	
	function isApplicableOnOtherProfiletype($resourceOwner)
	{
		$otherptype = $this->getACLOwnerProfileType();
		$otherpid	= XiptLibProfiletypes::getUserData($resourceOwner,'PROFILETYPE');

		//check if its applicable on more than 1 ptype
		$otherptype = is_array($otherptype)?$otherptype:array($otherptype);
		
		//if its applicable to all
		if(in_array(XIPT_PROFILETYPE_ALL, $otherptype))
			return true;
		
		//if user's ptype exists in ACL ptype array
		if(in_array($otherpid, $otherptype))
			return true;

		return false;
	}
	
	function getACLAccesserProfileType()
	{
		return $this->coreparams->getValue('core_profiletype',null,XIPT_PROFILETYPE_NONE);		
	}
	
	function getACLOwnerProfileType()
	{
		return $this->aclparams->getValue('other_profiletype',null,XIPT_PROFILETYPE_ALL);
	}
	
	function isApplicableOnMaxFeature($resourceAccesser,$resourceOwner, $data=null)
	{	
		$aclSelfPtype = $this->getACLAccesserProfileType();
		$otherptype = $this->getACLOwnerProfileType();
		
		$count = $this->getFeatureCounts($resourceAccesser,$resourceOwner,$otherptype,$aclSelfPtype);
		$paramName = get_class($this).'_limit';
		$maxmimunCount = $this->aclparams->getValue($paramName,null,0);
		if($count >= $maxmimunCount)
			return true;
			
		return false;
	}
	
	public function checkAclViolation($data)
	{	
		$resourceOwner 		= $this->getResourceOwner($data);
		$resourceAccesser 	= $this->getResourceAccesser($data);		
		
		if($this->isApplicableOnSelf($resourceAccesser,$resourceOwner) === false)
			return false;
		
		if($this->isApplicableOnSelfProfiletype($resourceAccesser) === false)
			return false;
		
		if($this->isApplicableOnOtherProfiletype($resourceOwner) === false)
			return false;
		
		//XITODO if allwoed to self
		
		
		// if resource owner is friend of resource accesser 
		if($this->isApplicableOnFriend($resourceAccesser,$resourceOwner) === false)
			return false; 
		
		// if feature count is greater then limit
		if($this->isApplicableOnMaxFeature($resourceAccesser,$resourceOwner, $data) === false)
			return false;
				
		return true;
	}

	function getFeatureCounts($resourceAccesser,$resourceOwner,$otherptype=null,$aclSelfPtype=null)
	{
		return 0;
	}
	
	abstract function getResourceOwner($data);
	
	function getResourceAccesser($data)
	{
		return $data['userid'];
	} 
	
	function isApplicableOnSelf($accesserid,$ownerid)
	{
		if($this->aclparams->getValue('acl_applicable_to_self',null,1) == true)
			return true;
			
		if($accesserid == $ownerid)
			return false;
			
		return true;
	}
	
	function isApplicableonFriend($accesserid,$ownerid)
	{   
		//check rule applicable on friend if yes than return true
		if($this->aclparams->getValue('acl_applicable_to_friend',null,1) == true)
			return true;
		
		//check accesser is friend of resource owner, 
		//if they are friend then do not apply rule
		$isFriend = XiptAclHelper::isFriend($accesserid,$ownerid);
		if($isFriend) 
			return false;
		
		return true;
	}
	
	
	
	
	public function checkCoreViolation($data)
	{
		return false;
	}

	public function getCoreParams($what,$default=0)
	{
		return $this->coreparams->getValue($what, null, $default);
	}


	public function handleViolation($info)
	{
		$msg 			= $this->getDisplayMessage();
		if($info['ajax']) {
			$this->aclAjaxBlock($msg);
			return $this;
		}

		$redirectUrl 	= $this->getRedirectUrl();
		JFactory::getApplication()->redirect(XiptRoute::_($redirectUrl,false),$msg);
	}


	function aclAjaxBlock($html, $objResponse=null)
	{
		if($objResponse === null)
			$objResponse   	= new JAXResponse();

		$objResponse->addScriptCall('cWindowShow', '', XiptText::_('YOU_ARE_NOT_ALLOWED_TO_PERFORM_THIS_ACTION'), 450, 80);
		$objResponse->addAssign('cWindowContent', 'innerHTML', $html);
		
//XITODO: cleanup
		$forcetoredirect =$this->getCoreParams('force_to_redirect','0');    	
		if($forcetoredirect)
		   {
			 $redirectUrl 	= JURI::base().'/'.$this->getRedirectUrl();
			 $script = "function sleep_message(){"
			                                     ."window.location.href = " .$redirectUrl .";"
			                                     ."cWindowHide();"
			                                     ."return true;"
			                                     ."};";

		     $buttons	= '<input type="button" value="' . XiptText::_('CC_BUTTON_CLOSE') . '" class="button" onclick="cWindowHide(); window.location.href = &quot;' . $redirectUrl . '&quot;;" />';
		     $objResponse->addScriptCall('cWindowActions', $buttons);
		   }
		$objResponse->sendResponse();
	}


	public function getMe()
	{
		return get_class($this);
	}

	public function getDisplayMessage()
	{
		$message = $this->getCoreParams('core_display_message','');		
		$message = base64_decode($message);
		return $message;
	}

	public function getRedirectUrl()
	{
		return $this->getCoreParams('core_redirect_url','index.php?option=com_community');
	}
	
	public function checkCoreApplicableByPlan($data)
	{
		if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_payplans'))
  			return false;
  		
		$plan = $this->getCoreParams('core_plan',0);

		//check if its applicable on more than 1 plan
		$plan = is_array($plan) ? $plan : array($plan);
		
		//All means applicable
		if(in_array(XIPT_PLAN_ALL, $plan))
			return true;

		$user = PayplansApi::getUser($data['userid']);
			
		//plan matching
 		if(array_intersect($user->getPlans(), $plan))
 			return true;
		
		return false;
	}
	
	function isApplicableOnSelfPlan($resourceAccesser)
	{
		$user = PayplansApi::getUser($resourceAccesser);
		
		$aclSelfPlan = $this->getACLAccesserPlan();
		$selfPlanId	 = $user->getPlans();
		
		//check if its applicable on more than 1 plan
		$aclSelfPlan = is_array($aclSelfPlan) ? $aclSelfPlan : array($aclSelfPlan);
		
		//if its applicable to all
		if(in_array(XIPT_PLAN_ALL, $aclSelfPlan))
			return true;

		//if user's plan exists in ACL plan array
		if(array_intersect($selfPlanId, $aclSelfPlan))
			return true;

		return false;
	}
	
	function isApplicableOnOtherPlan($resourceOwner)
	{
		$user = PayplansApi::getUser($resourceOwner);
		
		$otherplan		= $this->getACLOwnerPlan();
		$otherPlanId	= $user->getPlans();
		
		//check if its applicable on more than 1 pplan
		$otherplan = is_array($otherplan) ? $otherplan : array($otherplan);

		//if its applicable to all
		if(in_array(XIPT_PLAN_ALL, $otherplan))
			return true;
		
		//if user's plan exists in ACL plan array
		if(array_intersect($otherPlanId, $otherplan))
			return true;

		return false;
	}
	
	function getACLAccesserPlan()
	{
		return $this->coreparams->getValue('core_plan',null,XIPT_PLAN_NONE);		
	}
	
	function getACLOwnerPlan()
	{
		return $this->aclparams->getValue('other_plan',null,XIPT_PLAN_ALL);
	}
	
	function isApplicableOnMaxFeatureByPlan($resourceAccesser,$resourceOwner)
	{	
		$aclSelfPlan = $this->getACLAccesserPlan();
		$otherPlan   = $this->getACLOwnerPlan();
		
		$count = $this->getFeatureCounts($resourceAccesser,$resourceOwner,$otherPlan,$aclSelfPlan);
		$paramName = get_class($this).'_limit';
		$maxmimunCount = $this->aclparams->getValue($paramName,null,0);
		if($count >= $maxmimunCount)
			return true;
			
		return false;
	}
	
	public function checkAclViolationByPlan($data)
	{	
		$resourceOwner 		= $this->getResourceOwner($data);
		$resourceAccesser 	= $this->getResourceAccesser($data);		
		
		if($this->isApplicableOnSelf($resourceAccesser,$resourceOwner) === false)
			return false;
		
		if($this->isApplicableOnSelfPlan($resourceAccesser) === false)
			return false;
		
		if($this->isApplicableOnOtherPlan($resourceOwner) === false)
			return false;
		
		// if resource owner is friend of resource accesser 
		if($this->isApplicableOnFriend($resourceAccesser,$resourceOwner) === false)
			return false; 
		
		// if feature count is greater then limit
		if($this->isApplicableOnMaxFeatureByPlan($resourceAccesser,$resourceOwner) === false)
			return false;
				
		return true;
	}
}
