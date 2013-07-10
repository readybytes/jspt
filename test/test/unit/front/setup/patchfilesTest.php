<?php
class PatchfilesTest extends XiUnitTestCase 
{
	function testPatchFile()
	{	
		$obj = new XiptSetupRulePatchfiles();
		if($obj->isRequired())
			$obj->doApply();

		$src = JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'hacks'.DS.'front_libraries_fields_profiletypes.php';
		$desc  = JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'fields'.DS.'profiletypes.php';
		if(JFile::exists($desc))
			$this->assertTrue(JFile::delete($desc));
		
		
		// copy dummy file 
		$dummy = JPATH_ROOT.DS.'test'.DS.'test'.DS.'unit'.DS.'front'.DS.'setup'.DS.'dummy.php';
		
		$this->assertTrue(JFile::copy($dummy,$desc));
		// asser true check obj->isRequired
		
		$md5File1 = md5(JFile::read($src));
		$md5File2 = md5(JFile::read($desc));
		$this->assertNotEquals($md5File1,$md5File2);
		$this->assertTrue($obj->isRequired());
		
		$obj->doApply();
		// doApply   
		$md5File1 = md5(JFile::read($src));
		$md5File2 = md5(JFile::read($desc));
		$this->assertEquals($md5File1,$md5File2);
	}
}