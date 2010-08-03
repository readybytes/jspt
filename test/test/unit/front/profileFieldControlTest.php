<?php
class ProfileFieldControlTest extends XiUnitTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
	
  function xtestProfileFieldControl()
  {		
	require_once(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'profiletypes.php');
  	// ptofile type 1 when all categories are set to all
		$fields 	= $this->getProfileFields(82);
		$compare=array();
		$require=array();
	        $pTypeID = XiPTLibraryProfiletypes::getUserData(0,'PROFILETYPE',true);	
		XiPTLibraryProfiletypes::filterCommunityFields(82,$fields,'getEditableProfile');
		$this->compareProfileFields($fields,$compare,$require);
		
  	  // profile type 2 , set to all		
		$fields 	= $this->getProfileFields(83);

		XiPTLibraryProfiletypes::filterCommunityFields(83,$fields,'getViewableProfile');
		$this->compareProfileFields($fields,$compare,$require);
		
		// profile type 3 , set to all		
		$fields 	= $this->getProfileFields(84);
		XiPTLibraryProfiletypes::filterCommunityFields(84,$fields,'getViewableProfile');
		$this->compareProfileFields($fields,$compare,$require);
		
		
	// profile type 1 at viewable, when some conditions are applied
		$url=dirname(__FILE__).'/sql/ProfileFieldControlTest/testProfileFieldControl1.sql';
		$this->_DBO->loadSql($url);
		// the time of registration
		$compare[3]=1;
		$compare[4]=1;
		$require[5]=0;
		$fields 	= $this->getProfileFields(82);
		XiPTLibraryProfiletypes::filterCommunityFields(82,$fields,'getViewableProfile');
		$this->compareProfileFields($fields,$compare,$require);

		// profile type 1 at editable, when some conditions are applied
		$url=dirname(__FILE__).'/sql/ProfileFieldControlTest/testProfileFieldControl1.sql';
		$this->_DBO->loadSql($url);
		// the time of registration
		$compare=array();
		$require=array();
		$compare[2]=1;
		$compare[4]=1;
		$compare[5]=1;
		$require[3]=1;
		$fields 	= $this->getProfileFields(85);
		XiPTLibraryProfiletypes::filterCommunityFields(85,$fields,'getEditableProfile');
		$this->compareProfileFields($fields,$compare,$require);
	
		// profile type 1 at registration, when some conditions are applied
		$url=dirname(__FILE__).'/sql/ProfileFieldControlTest/testProfileFieldControl1.sql';
		$this->_DBO->loadSql($url);
		// the time of registration
		$compare=array();
		$require=array();
		$compare[3]=1;
		$compare[4]=1;
		$require[5]=0;
		$fields 	= $this->getProfileFields(85);
		XiPTLibraryProfiletypes::_getFieldsForProfiletype($fields,1,'registration');
		$this->compareProfileFields($fields,$compare,$require);
	
  }
  
  function getProfileFields($userId)
  {
  	   $db		= & JFactory::getDBO();
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
  
  function compareProfileFields($fields,$compareWith,$require)
  {
  	foreach($fields as $fieldIndex => $fieldInfo)
  		{
  			$this->assertFalse(array_key_exists($fieldInfo['id'],$compareWith));
  			if(array_key_exists($fieldInfo['id'],$require))
  				$this->assertEquals($fieldInfo['required'],$require[$fieldInfo['id']]) ; 			
  		}
  }
  
}
