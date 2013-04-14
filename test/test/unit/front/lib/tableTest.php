<?php

//require_once(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'base'.DS.'table.php');

class XiptTableTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	/**
     * @dataProvider columnProvider
     */
	function testColumnInTableConstruction($cols, $className, $tableName)
	{
		//create table
		$sql	= "DROP TABLE IF EXISTS `#__xipt_{$tableName}`;;";
		$this->_DBO->execSql($sql);

		$sql	= "CREATE TABLE IF NOT EXISTS `#__xipt_{$tableName}` (
				`id1` int(10) NOT NULL auto_increment";

		for($i=2; $i<= $cols ; $i++)
			$sql	.=	", `id$i` int(10)";

		$sql	.=",PRIMARY KEY  (`id1`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8;;";


		$this->_DBO->execSql($sql);

		//test it
		$db		= JFactory::getDBO();
		$table	= new $className();

		// No error should come across
		$error	= $table->getError(null,true);
		if($error)
			echo $error;
		$this->assertTrue(empty($error)==TRUE);

		$vars = get_object_vars($table);

		//count number of vars
		for($i=1; $i<= $cols ; $i++)
		{
			$var	= 'id'.$i;
			$this->assertTrue(in_array($var,array_keys($vars)));
		}

		//do cleanup : delete
		$sql	= "DROP TABLE IF EXISTS `#__xipt_{$tableName}`;;";
		$this->_DBO->execSql($sql);
	}

	public function columnProvider()
    {
        return array(
          array(1,'XiptTableTest01','test01'),
          array(3,'XiptTableTest02','test02'),
          array(5,'XiptTableTest03','test03'),
          array(9,'XiptTableTest04','test04')
        );
    }
	
    function testConstruct()
    {
    	$table	= new XiptTablePolls();
    	$compare = array('polls_id' => 'int unsigned',
    					 'title' => 'varchar',
    					 'alias' => 'varchar',
    					 'voters' => 'int',
    					 'checked_out' => 'int',
    					 'checked_out_time' => 'datetime',
    					 'published' => 'tinyint');
    	
    	$this->assertEquals($table->_columns,$compare);
    	$this->assertEquals($table->polls_id,null);
    	$this->assertEquals($table->title,null);
    	$this->assertEquals($table->alias,null);
    	$this->assertEquals($table->voters,null);
    	$this->assertEquals($table->checked_out,null);
    	$this->assertEquals($table->checked_out_time,null);
    	$this->assertEquals($table->published,null);    	
    } 
    
	function testLoad()
	{
		//test it
		$table	= new XiptTablePolls();		

		$table->load(2);
		//exit;
		$this->assertEquals($table->polls_id,2);		
		$this->assertEquals($table->voters,5);
		$this->assertEquals($table->checked_out,1);	
		$this->assertEquals($table->published,1);
		
		$table->load(4);
		$this->assertEquals($table->polls_id,4);		
		$this->assertEquals($table->voters,18);
		$this->assertEquals($table->checked_out,0);
		$this->assertEquals($table->published,0);		
	}

	function testDelete()
	{
		//test it
		$table	= new XiptTablePolls();

		$table->delete(2);
		$this->assertFalse($table->load(2));

		$table->delete(5);
		$this->assertFalse($table->load(5));

		$this->assertTrue($table->load(3));
		$table->delete(3);
		$this->assertFalse($table->load(3));

		$table->delete(4);
		$this->assertFalse($table->load(4));

		$this->assertTrue($table->load(1));
		$table->delete(1);
		$this->assertFalse($table->load(1));
	}
	
	function testDeleteMultiple()
	{
		$table	= new XiptTablePolls();
		$table->delete(array('alias'=>'joomla-is-used-for'));
		$this->assertTrue($table->load(1));
		$this->assertFalse($table->load(2));
		$this->assertFalse($table->load(3));
		$this->assertFalse($table->load(4));
		$this->assertFalse($table->load(5));		
	} 

	function testStore()
	{
		//test it
		$table	= new XiptTablePolls();
		
		$this->assertTrue(empty($table)==false);

		$table->load(2);

		$this->assertEquals($table->voters,5);
		$table->voters=6;
		$this->assertEquals($table->voters,6);
		//store
		$table->store();

		//now again load and test
		$table2	= new XiptTablePolls();
		$table2->load(2);
		$this->assertEquals($table2->voters,6);
	}
	
	function testBind()
	{
		$table	= new XiptTablePolls();		
		$table->load(2);
		
		$data = array('title'=>"Polls For Joomla",
					  'alias'=>"polls for joomla",
					  'voters'=>40,
					  'dummy'=>'joomlaxi'
					 );
		$table->bind($data);
		$this->assertEquals($table->title,"Polls For Joomla");
		$this->assertEquals($table->alias,"polls for joomla");
		$this->assertEquals($table->voters,40);		
		$this->assertTrue(!isset($table->dummy));
	}
}

//case 1 : no DB
class TestTable extends XiptTable{
	function __construct($tableName,$id){
		parent::__construct($tableName,$id);
	}
}

class XiptTableTest00 extends TestTable{
	function __construct(){
		parent::__construct('#__xipt_test00','id0');
	}	
};
class XiptTableTest01 extends TestTable{
	function __construct(){
		parent::__construct('#__xipt_test01','id1');
	}
};
class XiptTableTest02 extends TestTable{
	function __construct(){
		parent::__construct('#__xipt_test02','id2');
	}
};
class XiptTableTest03 extends TestTable{
	function __construct(){
		parent::__construct('#__xipt_test03','id3');
	}
};
class XiptTableTest04 extends TestTable{
	function __construct(){
		parent::__construct('#__xipt_test04','id4');
	}
};
class XiptTableTest05 extends TestTable{
	function __construct(){
		parent::__construct('#__xipt_test05','id5');
	}
};
class XiptTableTest06 extends TestTable{
	function __construct(){
		parent::__construct('#__xipt_test06','id6');
	}
};

class XiptTablePolls extends XiptTable{
	function __construct(){
		parent::__construct('#__xipt_polls','polls_id');
	}
};

