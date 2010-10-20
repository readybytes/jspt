<?php

class XiAclUnitTest extends XiUnitTestCase
{

	function checkApplicable($aclid, $info)
	{
		//load
		$filter['id']	= $aclid;
		$filter['published']= 1;
		$rules = XiptAclFactory::getAclRulesInfo($filter);

		//prepare
		$rule = array_pop($rules);
		$aclObject = XiptAclFactory::getAclObject($rule->aclname);
		$aclObject->bind($rule);

		//applicable
		return $aclObject->isApplicable($info);
	}

	function checkViolation($aclid, $info)
	{
		//load
		$filter['id']	= $aclid;
		$filter['published']= 1;
		$rules = XiptAclFactory::getAclRulesInfo($filter);

		//prepare
		$rule = array_pop($rules);
		$aclObject = XiptAclFactory::getAclObject($rule->aclname);
		$aclObject->bind($rule);

		//applicable
		if(false == $aclObject->isApplicable($info))
			return false;

		//test violation
		$result = $aclObject->checkViolation($info);
		return $result;
	}
}