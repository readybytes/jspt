<?php
require_once 'PHPUnit/Framework.php';

class Stack2Test extends PHPUnit_Framework_TestCase
{
	var $_compareresult = array();
	function setUp()
	{
		$this->_compareresult[0] = "SELECT u.id as user_id , s2.value AS sortBy2 FROM `#__users` AS u LEFT JOIN `#
__community_fields_values` AS s2 ON ( s2.`user_id` = u.`id` AND s2.`field_id`='2') ORDER BY sortBy2 ASC" ; 
	}
	
    public function testPushAndPop()
    {
		require_once(JPATH_BASE . DS . 'components' . DS . 'com_userlist' . DS . 'libraries' . DS . 'userlist.php');
		$query = CUserListLibrary::_buildCustomQuery('','and',2,'ASC');
		
        $this->assertEquals($query, $this->_compareresult[0]);
    }
}
?>