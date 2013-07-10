<?php

class XiptSettingsTableTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

    function xtestConstruct()
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
		$table	= new XiptTableSettings();		

		$table->load();
		//exit;
		$this->assertEquals($table->name,'');		
		$this->assertEquals($table->params,'');
		
		$table->load('settings');
		$this->assertEquals($table->name,'settings');		
		$this->assertEquals($table->params,"show_ptype_during_reg=1\nallow_user_to_change_ptype_after_reg=0\ndefaultProfiletypeID=1\nguestProfiletypeID=2\njspt_show_radio=1\njspt_fb_show_radio=1\nallow_templatechange=0\nshow_watermark=1\njspt_block_dis_app=1\nuser_reg=jomsocial\nsubscription_integrate=0\nsubscription_message=b\n\n");
	}

	function xtestDelete()
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
	
	function xtestDeleteMultiple()
	{
		$table	= new XiptTablePolls();
		$table->delete(array('alias'=>'joomla-is-used-for'));
		$this->assertTrue($table->load(1));
		$this->assertFalse($table->load(2));
		$this->assertFalse($table->load(3));
		$this->assertFalse($table->load(4));
		$this->assertFalse($table->load(5));		
	} 

	function xtestStore()
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
	
	function xtestBind()
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