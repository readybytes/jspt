<?php


class XiptSettingsControllerTest extends XiUnitTestCase 
{

	//define this function if you require DB setup
  	function getSqlPath()
  	{
    	return dirname(__FILE__).'/sql/'.__CLASS__;
  	}
  	
  	function testSave()
  	{
  		$data['settings'] = array('show_ptype_during_reg'=>1,'allow_user_to_change_ptype_after_reg'=>1,
  								'defaultProfiletypeID'=>2,'guestProfiletypeID'=>2,'jspt_show_radio'=>1,
  								'jspt_fb_show_radio'=>1,'allow_templatechange'=>0,'show_watermark'=>1,
  								'jspt_block_dis_app'=>2,'user_reg'=>'jomsocial','aec_integrate'=>1,
  								'aec_message'=>'b'
  					 			);

  		$controller = new XiptControllerSettings();
  		$this->assertTrue($controller->save($data));
  		
  		$this->_DBO->addTable('#__xipt_settings');
  	}
}