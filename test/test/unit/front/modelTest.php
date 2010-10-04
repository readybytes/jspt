<?php

require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'base'.DS.'model.php';

class XiptModelTest02 extends XiptModel
{}

class XiptModelPollspgf extends XiptModel{}
class XiptTablePollspgf extends XiptTable{
	function __construct(){
		parent::__construct('#__xipt_pollspgf','pollspgf_id');
	}
}

class XiptModelTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	function testGetName()
	{
		$obj	= new XiptModelPollspgf();
		$this->assertEquals($obj->getName(),"pollspgf");
	}

	function testGetPrefix()
	{
		$obj	= new XiptModelPollspgf();
		$this->assertEquals($obj->getPrefix(),"xipt");
	}

	public function testLoadRecords()
	{
		$model	 = new XiptModelPollspgf();
		$records = $model->loadRecords();
		$this->assertEquals($records[5]->title,'poll-5');
		$this->assertEquals($records[5]->alias,'joomla-is-used-for');
		$this->assertEquals($records[5]->voters,10);		
		
		$this->assertEquals($records[2]->title,'poll-2');
		$this->assertEquals($records[2]->alias,'joomla-is-used-for');
		$this->assertEquals($records[2]->voters,5);
		$this->assertEquals($records[2]->checked_out,1);
		$this->assertEquals($records[2]->published,0);
	}
	
    public function testSave()
    {
    	$model	= new XiptModelPollspgf();
    	//loaded record 3
    	$table = $model->getTable();
    	$table->load(3);
    	$this->assertEquals($table->get('title'),'poll-3');

    	// try to save new record
    	$data =	array('title' => 'newtitle' , 'alias' => 'newalias' , 'voters' => '5');
    	$model->save($data, 0);

    	// test is record-3 is OK
    	$table->load(3);
    	$this->assertEquals($table->get('title'),'poll-3');
    }
    
 	public function testDelete()
    {
    	$model	= new XiptModelPollspgf();    
    	// try to save new record
    	//$data =	array('title' => 'newtitle' , 'alias' => 'newalias' , 'voters' => '5');
    	$this->assertTrue($model->delete(3));

    	$table = $model->getTable();
    	// test is record-3 is OK
    	$table->load(3);    	
    	$this->assertEquals($table->get('title'),null);
    }
}