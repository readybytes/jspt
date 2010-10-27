<?php
class ProfileFieldPrivacyTest extends XiUnitTestCase 
{

  //define this function if you require DB setup
   function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

 function testProfileFieldPrivacy()
  {	

  		$url =  dirname(__FILE__).'/sql/ProfileFieldPrivacyTest/testProfileFieldPrivacy.1.8.sql';
    	$this->_DBO->loadSql($url);
		
	    $fields 	= $this->getProfileFields(82); 
		$filter['id'] = '1';
		$filter['published'] = 1;
		
		$rules=XiptAclFactory::getAclRulesInfo($filter);
		$rule = array_shift($rules);
		$aclObject = XiptAclFactory::getAclObject($rule->aclname);
		$aclObject->bind($rule);
		$data['args']['field'] = & $fields;
		$data['viewuserid']    =  82     ;
		$aclObject->handleViolation($data);
		$unsetfield=array(8,16);
		$this->compareProfileFields($fields,$unsetfield);
		
		//pt1 visits 2
		
		$fields 	= $this->getProfileFields(83); 
		$filter['id'] = '2';
		$filter['published'] = 1;
		
		$rules=XiptAclFactory::getAclRulesInfo($filter);
		$rule = array_shift($rules);
		$aclObject = XiptAclFactory::getAclObject($rule->aclname);
		$aclObject->bind($rule);
		$data['args']['field'] = & $fields;
		$data['viewuserid']    =  83     ;
		$aclObject->handleViolation($data);
		$unsetfield=array(8,16);
		$this->compareProfileFields($fields,$unsetfield);
		
		//pt2 visits pt3
		
		$fields 	= $this->getProfileFields(84); 
		$filter['id'] = '3';
		$filter['published'] = 1;
		
		$rules=XiptAclFactory::getAclRulesInfo($filter);
		$rule = array_shift($rules);
		$aclObject = XiptAclFactory::getAclObject($rule->aclname);
		$aclObject->bind($rule);
		$data['args']['field'] = & $fields;
		$data['viewuserid']    =  84     ;
		$aclObject->handleViolation($data);
		$unsetfield=array(9,17);
		$this->compareProfileFields($fields,$unsetfield);
		
		//pt1 can't view any field of all profiletypes..
		
		
		$fields 	= $this->getProfileFields(82); 
		$filter['id'] = '4';
		$filter['published'] = 1;
		
		$rules=XiptAclFactory::getAclRulesInfo($filter);
		$rule = array_shift($rules);
		$aclObject = XiptAclFactory::getAclObject($rule->aclname);
		$aclObject->bind($rule);
		$data['args']['field'] = & $fields;
		$data['viewuserid']    =  82     ;
		$aclObject->handleViolation($data);
		$unsetfield=array(5,8,9,16,17);
		$this->compareProfileFields($fields,$unsetfield);
		
		//pt1 visits 2
		
		$fields 	= $this->getProfileFields(83); 
		$filter['id'] = '4';
		$filter['published'] = 1;
		
		$rules=XiptAclFactory::getAclRulesInfo($filter);
		$rule = array_shift($rules);
		$aclObject = XiptAclFactory::getAclObject($rule->aclname);
		$aclObject->bind($rule);
		$data['args']['field'] = & $fields;
		$data['viewuserid']    =  83     ;
		$aclObject->handleViolation($data);
		$unsetfield=array(6,8,9,16,17);
		$this->compareProfileFields($fields,$unsetfield);
		
		//pt1 visits 3
		$fields 	= $this->getProfileFields(84); 
		$filter['id'] = '4';
		$filter['published'] = 1;
		
		$rules=XiptAclFactory::getAclRulesInfo($filter);
		$rule = array_shift($rules);
		$aclObject = XiptAclFactory::getAclObject($rule->aclname);
		$aclObject->bind($rule);
		$data['args']['field'] = & $fields;
		$data['viewuserid']    =  84    ;
		$aclObject->handleViolation($data);
		$unsetfield=array(5,9,16,17);
		$this->compareProfileFields($fields,$unsetfield);
		
		
		//pt2 can't access others various field..
		// can't visit 5, 8 ,9 field of pt1
		
		$fields 	= $this->getProfileFields(82); 
		$filter['id'] = '5';
		$filter['published'] = 1;
		
		$rules=XiptAclFactory::getAclRulesInfo($filter);
		$rule = array_shift($rules);
		$aclObject = XiptAclFactory::getAclObject($rule->aclname);
		$aclObject->bind($rule);
		$data['args']['field'] = & $fields;
		$data['viewuserid']    =  82     ;
		$aclObject->handleViolation($data);
		$unsetfield=array(5,8,9);
		$this->compareProfileFields($fields,$unsetfield);
		
		// can't visit 8,9 field of pt2
		
		$fields 	= $this->getProfileFields(83); 
		$filter['id'] = '5';
		$filter['published'] = 1;
		
		$rules=XiptAclFactory::getAclRulesInfo($filter);
		$rule = array_shift($rules);
		$aclObject = XiptAclFactory::getAclObject($rule->aclname);
		$aclObject->bind($rule);
		$data['args']['field'] = & $fields;
		$data['viewuserid']    =  83     ;
		$aclObject->handleViolation($data);
		$unsetfield=array(8,9);
		$this->compareProfileFields($fields,$unsetfield);
		
		//can't visit field 9 of pt3
		
		$fields 	= $this->getProfileFields(84); 
		$filter['id'] = '5';
		$filter['published'] = 1;
		
		$rules=XiptAclFactory::getAclRulesInfo($filter);
		$rule = array_shift($rules);
		$aclObject = XiptAclFactory::getAclObject($rule->aclname);
		$aclObject->bind($rule);
		$data['args']['field'] = & $fields;
		$data['viewuserid']    =  84     ;
		$aclObject->handleViolation($data);
		$unsetfield=array(9);
		$this->compareProfileFields($fields,$unsetfield);
		
		
  }
  
 function getProfileFields($userId)
  {
  	   $db		= JFactory::getDBO();
  	   $strSQL	= 'SELECT field.*, value.value '
				. 'FROM ' . $db->nameQuote('#__community_fields') . ' AS field '
				. 'LEFT JOIN ' . $db->nameQuote('#__community_fields_values') . ' AS value '
 				. 'ON field.id=value.field_id AND value.user_id=' . $db->Quote($userId) . ' '
				. 'WHERE field.published=' . $db->Quote('1') . ' AND '
 				. 'field.visible=' . $db->Quote('1') . ' '
 				. 'ORDER BY field.ordering';

		$db->setQuery( $strSQL );
		$result	= $db->loadAssocList();
		return $result;
  }
  
  function compareProfileFields($fields,$unsetfield)
  {
  		foreach($fields as $f)
  		{
  		  	$this->assertFalse(in_array($f['id'],$unsetfield)) ;
  				
  		}
  	
  }
  
  
  function testFrinedSupport()
  {
  		//	pt1 visits 2		
		$fields 	= $this->getProfileFields(83); 
		$filter['id'] = '2';
		$filter['published'] = 1;
		
		$rules=XiptAclFactory::getAclRulesInfo($filter);
		$rule = array_shift($rules);
		$aclObject = XiptAclFactory::getAclObject($rule->aclname);
		$aclObject->bind($rule);
		$data['args']['field'] = & $fields;
		$data['viewuserid']    =  83;
		$data['userid']    	   =  82;
		$this->assertTrue($aclObject->checkAclViolation($data));
		$aclObject->handleViolation($data);
		$unsetfield=array(8,16);
		$this->compareProfileFields($fields,$unsetfield);
		
		//pt1 visits 2		
		$fields 	= $this->getProfileFields(83); 
		$filter['id'] = '2';
		$filter['published'] = 1;
		
		$rules=XiptAclFactory::getAclRulesInfo($filter);
		$rule = array_shift($rules);
		$aclObject = XiptAclFactory::getAclObject($rule->aclname);
		$aclObject->bind($rule);
		$data['args']['field'] = & $fields;
		$data['viewuserid']    =  83     ;
		$data['userid']    	   =  79;
		$data['args']['triggerForEvents'] = 'onprofileload';
		$this->assertFalse($aclObject->checkAclViolation($data));		
				
		unset($data['args']['triggerForEvents']);
		$this->assertFalse($aclObject->isApplicable($data));
  }
}  