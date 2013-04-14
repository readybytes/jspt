<?php

class XiptResetWatermarkTest extends XiUnitTestCase 
{
	//define this function if you require DB setup
  	function getSqlPath()
  	{
    	return dirname(__FILE__).'/sql/'.__CLASS__;
  	}
  	/**
  	 * check image with gold image
  	 * @param unknown_type $imagePath
  	 * @param unknown_type $au_imagePath
  	 */
  	function checkImage($imagePath, $au_imagePath)
  	{
  		$this->assertEquals(md5_file($imagePath),md5_file($au_imagePath));
  	}
  	  	
  	function getPostValue()
  	{
  		$post['tip']	= '';
  		$post['group']	= Array(0);
  		$post['config']	= Array();
  		$post['privacy']= Array('jsPrivacyController'=>1);
  		$post['resetAll']=1;
  		return $post;
  	}
  	
  	function setPath()
  	{
  		$path['avatarPath']				= JPATH_ROOT.DS.'test/test/unit/front/setup/images/avatar_1.gif';
		$path['thumbPath']				= JPATH_ROOT.DS.'test/test/unit/front/setup/images/avatar_1_thumb.gif';
		$path['au_avatar']				= JPATH_ROOT.DS."test/test/unit/front/setup/images/watr_avatar_1.gif";
		$path['au_thumb']				= JPATH_ROOT.DS."test/test/unit/front/setup/images/watr_avatar_1_thumb.gif";
		$path['custom_avatar']			= JPATH_ROOT.DS.'test/test/unit/front/controller/images/custom_avatar.jpg';
  		$path['custom_thumb'] 			= JPATH_ROOT.DS.'test/test/unit/front/controller/images/thumb_custom_avatar.jpg'; 		
  		$path['au_custom_avatar']		= JPATH_ROOT.DS.'test/test/unit/front/controller/images/au_custom_avatar.jpg';
  		$path['au_thumb_custom_avatar']	= JPATH_ROOT.DS.'test/test/unit/front/controller/images/au_thumb_custom_avatar.jpg';
		$path['copy_custom_avatar']		= JPATH_ROOT.DS.'test/test/unit/front/controller/images/copy_custom_avatar.jpg';
  		$path['copy_thumb_custom_avatar']= JPATH_ROOT.DS.'test/test/unit/front/controller/images/copy_thumb_custom_avatar.jpg'; 
  		$path['default_avatar']			= JPATH_ROOT.DS.'test/test/unit/front/controller/images/avatar_2.jpg';
  		$path['default_thumb']			= JPATH_ROOT.DS.'test/test/unit/front/controller/images/avatar_2_thumb.jpg';
		return $path;
   	} 	
   	
  	   	
   	//Case::1(Existing User) Reset all with add water-mark 
  	function testResetAllCase1()
  	{
  		if (TEST_XIPT_JOOMLA_15)
  			$this->reloadUser(Array(62,63,64));
  		else
  			$this->reloadUser(Array(42,63,64));
  		$post = $this->getPostValue();
  		$path = $this->setPath(); 
  		$post['watermarkparams']=Array('enableWaterMark'=> 1, 'xiText'=>'P');
  		
  		$controllerObj= new XiptControllerProfiletypes();
  		$controllerObj->_processSave($post, 1);
  		if(TEST_XIPT_JOOMLA_15){ 
  		  	$path['au_avatar']= JPATH_ROOT.DS."test/test/unit/front/setup/images/watr_avatar1.5.gif";
		    $path['au_thumb']= JPATH_ROOT.DS."test/test/unit/front/setup/images/watr_avatar1.5_thumb.gif";
  		   }
  		else{
  		  	$path['au_avatar']= JPATH_ROOT.DS."test/test/unit/front/setup/images/watr_avatar1.7.gif";
		    $path['au_thumb']= JPATH_ROOT.DS."test/test/unit/front/setup/images/watr_avatar1.7_thumb.gif";
  		    }
  		  
  		//check water-mark apply on existing avatar and thumb 
  		$this->checkImage($path['avatarPath'], $path['au_avatar']);
		$this->checkImage($path['thumbPath'], $path['au_thumb']);
		
		$bk_avatar	=	USER_AVATAR_BACKUP.'/avatar_1.gif';
		$bk_thumb	=	USER_AVATAR_BACKUP.'/avatar_1_thumb.gif';
		if(TEST_XIPT_JOOMLA_15){ 
		       $au_avatar	= 	JPATH_ROOT.DS."test/test/unit/front/setup/images/copy_avatar_1_1.5.gif";
		       $au_thumb	= 	JPATH_ROOT.DS."test/test/unit/front/setup/images/copy_avatar_1_1.5_thumb.gif";
		}
		else{
			 $au_avatar	= 	JPATH_ROOT.DS."test/test/unit/front/setup/images/copy_avatar_1_1.7.gif";
		     $au_thumb	= 	JPATH_ROOT.DS."test/test/unit/front/setup/images/copy_avatar_1_1.7_thumb.gif";
		}
		//Check Backup of Avatar and thumb
		$this->checkImage($bk_avatar,$au_avatar);
		$this->checkImage($bk_thumb,$au_thumb);

		// for further testing
		JFile::copy($au_avatar, $path['avatarPath']);
		JFile::copy($au_thumb, $path['thumbPath']);
		$this->cleanStaticCache();
		if (TEST_XIPT_JOOMLA_15)
  			$this->reloadUser(Array(62,63,64));
  		else
  			$this->reloadUser(Array(42,63,64));
  	}
   //Case Reset all with image as watermark
    function testResetAllwithImgWatermrkCase1()
    {
    	if (TEST_XIPT_JOOMLA_15)
  			$this->reloadUser(Array(62,63,64));
  		else
  			$this->reloadUser(Array(42,63,64));
  		$post = $this->getPostValue();
  		//$path = $this->setPath(); 
        if(TEST_XIPT_JOOMLA_15){
  		   $path['avatarPath1']= JPATH_ROOT.DS.'test/test/unit/front/controller/images/avatar_1.gif';
  		   $path['thumbPath1']= JPATH_ROOT.DS.'test/test/unit/front/controller/images/avatar_1_thumb.gif';
  		      $avatarPath1= JPATH_ROOT.DS.'test/test/unit/front/controller/images/avatar_1.gif';
  		   $thumbPath1= JPATH_ROOT.DS.'test/test/unit/front/controller/images/avatar_1_thumb.gif';
  		   $au_avatar1	= 	JPATH_ROOT.DS."test/test/unit/front/setup/images/copy_avatar_11_1.5.gif";
		   $au_thumb1	= 	JPATH_ROOT.DS."test/test/unit/front/setup/images/copy_avatar_11_1.5_thumb.gif";
		   $path['au_avatar1']	= 	JPATH_ROOT.DS."test/test/unit/front/setup/images/copy_avatar_11_1.5.gif";
		   $path['au_thumb1']	= 	JPATH_ROOT.DS."test/test/unit/front/setup/images/copy_avatar_11_1.5_thumb.gif";       
  		}
  		else{
  		 $path['avatarPath1']= JPATH_ROOT.DS.'test/test/unit/front/controller/images/avatar_1_1.7.gif';
  		 $path['thumbPath1']= JPATH_ROOT.DS.'test/test/unit/front/controller/images/avatar_1_1.7_thumb.gif';
  		  $avatarPath1= JPATH_ROOT.DS.'test/test/unit/front/controller/images/avatar_1_1.7.gif';
  		  $thumbPath1= JPATH_ROOT.DS.'test/test/unit/front/controller/images/avatar_1_1.7_thumb.gif';
  		  $au_avatar1	= 	JPATH_ROOT.DS."test/test/unit/front/controller/images/copy_avatar_1_1.7.gif";
		  $au_thumb1	= 	JPATH_ROOT.DS."test/test/unit/front/controller/images/copy_avatar_1_1.7_thumb.gif";
  		  $path['au_avatar1']= JPATH_ROOT.DS."test/test/unit/front/controller/images/copy_avatar_1_1.7.gif";
  		  $path['au_thumb1']= JPATH_ROOT.DS."test/test/unit/front/controller/images/copy_avatar_1_1.7_thumb.gif";
  		 }
  		$post['watermarkparams']=Array('enableWaterMark'=> 1, 'typeofwatermark'=> 1);
  		$controllerObj= new XiptControllerProfiletypes();
  		$controllerObj->_processSave($post, 1);
  		
  		
  		$this->checkImage($path['avatarPath1'], $path['au_avatar1']);
		$this->checkImage($path['thumbPath1'], $path['au_thumb1']);
        // for further testing
		JFile::copy($au_avatar1, $path['avatarPath1']);
		JFile::copy($au_thumb1, $path['thumbPath1']);
		$this->cleanStaticCache();
		if (TEST_XIPT_JOOMLA_15)
  			$this->reloadUser(Array(62,63,64));
  		else
  			$this->reloadUser(Array(42,63,64));
  				// Replace avtar and thumb (wid watrmark)
		JFile::copy(JPATH_ROOT.DS.'test/test/unit/front/setup/images/copy_avatar_1.gif',$avatarPath1);
		JFile::copy(JPATH_ROOT.DS.'test/test/unit/front/setup/images/copy_avatar_1_thumb.gif',$thumbPath1);
  			
    }	
  	
    
    
  	//Case::2 (On existing User) Reset all then test watr-mark remove
  	function testResetAllCase2()
  	{
  		if (TEST_XIPT_JOOMLA_15)
  			$this->reloadUser(Array(62,87,85,86,84,83,82,81,80,79));
  		else
  			$this->reloadUser(Array(42,87,85,86,84,83,82,81,80,79));
  		$this->cleanStaticCache();
  		$post = $this->getPostValue();
  		$path = $this->setPath();
		$post['watermarkparams']=Array('enableWaterMark'=> 0, 'xiText'=>'P');	
  		$post['resetAll']=1;
  		  		
		$custom_avatar	=	JPATH_ROOT.DS.'test/test/unit/front/controller/images/case2_avatar.jpg';
		$custom_thumb	=	JPATH_ROOT.DS.'test/test/unit/front/controller/images/case2_thumb.jpg';
		$copyAvatar		=	JPATH_ROOT.DS.'test/test/unit/front/controller/images/copy_case2_avatar.jpg';
		$copyThumb		=	JPATH_ROOT.DS.'test/test/unit/front/controller/images/copy_case2_thumb.jpg';
  		
		//copy images in back-up folder then image restore
		JFile::copy($path['custom_avatar'], USER_AVATAR_BACKUP.'/case2_avatar.jpg');
		JFile::copy($path['custom_thumb'], USER_AVATAR_BACKUP.'/case2_thumb.jpg');

  		JRequest::setVar('resetAll',1,'POST');
  		$controllerObj= new XiptControllerProfiletypes();
  		$controllerObj->_processSave($post, 2);
  		$this->checkImage($path['custom_avatar'], $custom_avatar);
  		$this->checkImage($path['custom_thumb'], $custom_thumb);
  		// restore image for further use 
  		JFile::copy($copyAvatar, $custom_avatar);
		JFile::copy($copyThumb, $custom_thumb);
		// delete from backup folder for further testing
		JFile::delete(USER_AVATAR_BACKUP.'/case2_avatar.jpg');
		JFile::delete(USER_AVATAR_BACKUP.'/case2_thumb.jpg');
		$this->cleanStaticCache();
		if (TEST_XIPT_JOOMLA_15)
			$this->reloadUser(Array(62,87,85,86,84,83,82,81,80,79));
		else
			$this->reloadUser(Array(42,87,85,86,84,83,82,81,80,79));
  	}
  
	//Case3: wtr-mark already disable den Reset all. Test watr-mark not apply 
  	function testResetAllCase3()
  	{	
		$filter['debug']=0;
		$this->updateJoomlaConfig($filter);

  		$this->cleanStaticCache();
  		$post = $this->getPostValue();
  		$path = $this->setPath();
		$post['watermarkparams']=Array('enableWaterMark'=> 0, 'xiText'=>'P');	
  		$post['resetAll']=1;
  		JRequest::setVar('resetAll',1,'POST');
  		$controllerObj= new XiptControllerProfiletypes();
  		$controllerObj->_processSave($post, 1);
  		$this->checkImage($path['custom_avatar'], $path['copy_custom_avatar']);
  		$this->checkImage($path['custom_thumb'], $path['copy_thumb_custom_avatar']);
  		$this->cleanStaticCache();
  		if (TEST_XIPT_JOOMLA_15)
  			$this->reloadUser(Array(62,79,80,81,82,83,84,85,86,87));
  		else
  			$this->reloadUser(Array(42,79,80,81,82,83,84,85,86,87));
		$filter['debug']=1;
		$this->updateJoomlaConfig($filter);
  	}
   	
  	// case:4 Test, Watr-mark not apply on default avatar
  	function testResetAllCase4()
  	{
  		$post = $this->getPostValue();
  		$path = $this->setPath();
		$au_default_avatar	=	md5_file($path['default_avatar']);
  		$au_default_thumb	=	md5_file($path['default_thumb']);
  		$post['watermarkparams']=Array('enableWaterMark'=> 1, 'xiText'=>'M');	
  		$post['resetAll']=1;
  		JRequest::setVar('resetAll',1,'POST');
  		//required for default avatar compair
	  	JFile::copy($path['default_avatar'], JPATH_ROOT.DS.'images/profiletype/avatar_2.jpg');
		JFile::copy($path['default_thumb'], JPATH_ROOT.DS.'images/profiletype/avatar_2_thumb.jpg');
  		$controllerObj= new XiptControllerProfiletypes();
  		$controllerObj->_processSave($post, 2);
  		$this->assertEquals(md5_file($path['default_avatar']), $au_default_avatar);
  		$this->assertEquals(md5_file($path['default_thumb']), $au_default_thumb);
  		$this->cleanStaticCache();
  		if (TEST_XIPT_JOOMLA_15)
  			$this->reloadUser(Array(62,87,85,86,84,83,82,81,80,79));
  		else
  			$this->reloadUser(Array(42,87,85,86,84,83,82,81,80,79));
  	}

  	//case:5 Test,  water-mark not on existing user and watr-mark not apply by reset all
  	function testResetAllCase5() 
  	 {
  	 	$this->cleanStaticCache();
  		$post = $this->getPostValue();
  		$path = $this->setPath();
  		$post['watermarkparams']=Array('enableWaterMark'=> 0, 'xiText'=>'M');	
  		$post['resetAll']=1;
  		JRequest::setVar('resetAll',1,'POST');
  		$controllerObj= new XiptControllerProfiletypes();
  		$controllerObj->_processSave($post, 2);
  		$this->checkImage($path['custom_avatar'],$path['copy_custom_avatar']);
  		$this->checkImage($path['custom_thumb'], $path['copy_thumb_custom_avatar']);
  		$this->cleanStaticCache();
  		if (TEST_XIPT_JOOMLA_15)
  			$this->reloadUser(Array(62,87,85,86,84,83,82,81,80,79));
  		else
  			$this->reloadUser(Array(42,87,85,86,84,83,82,81,80,79));
  	}
  	
  	//case:6, Test water-mark change according  watr-mark param 
  	function testResetAllCase6() 
  	 {
  	 	if (TEST_XIPT_JOOMLA_15)
  			$this->reloadUser(Array(62,87,85,86,84,83,82,81,80,79));
  		else
  			$this->reloadUser(Array(42,87,85,86,84,83,82,81,80,79));
  		$post = $this->getPostValue();
  		$path = $this->setPath();
  		 		$this->cleanStaticCache();
		
  		// nw change watrmark params then reset
  		$post['watermarkparams'] =Array('enableWaterMark'=> 1,'xiWatermarkPosition'=> 'bl', 
  										'xiText'=>'Mani','xiThumbWidth'=>30,'xiThumbHeight'=>30,
  										'xiFontName'=>'monofont','xiFontSize'=>	20);	
   		$post['resetAll']=1;
	  	JRequest::setVar('resetAll',1,'POST');
	  	
		//copy images in back-up folder 
		JFile::copy($path['custom_avatar'], USER_AVATAR_BACKUP.'/case2_avatar.jpg');
		JFile::copy($path['custom_thumb'], USER_AVATAR_BACKUP.'/case2_thumb.jpg');
		
		$controllerObj= new XiptControllerProfiletypes();
		$controllerObj->_processSave($post, 2);
		
		$custom_avatar	=	JPATH_ROOT.DS.'test/test/unit/front/controller/images/case2_avatar.jpg';
		$custom_thumb	=	JPATH_ROOT.DS.'test/test/unit/front/controller/images/case2_thumb.jpg';
		$copyAvatar		=	JPATH_ROOT.DS.'test/test/unit/front/controller/images/copy_case2_avatar.jpg';
		$copyThumb		=	JPATH_ROOT.DS.'test/test/unit/front/controller/images/copy_case2_thumb.jpg';
  		$this->checkImage($custom_avatar,$path['au_custom_avatar']);
  		$this->checkImage($custom_thumb, $path['au_thumb_custom_avatar']);
  		// Replace actual avatar after watr-mark. (for Re-useable)
  		JFile::copy($copyAvatar, $custom_avatar);
		JFile::copy($copyThumb, $custom_thumb);
	    // delete from backup folder for further testing
		JFile::delete(USER_AVATAR_BACKUP.'/case2_avatar.jpg');
		JFile::delete(USER_AVATAR_BACKUP.'/case2_thumb.jpg');
		$this->cleanStaticCache();
		if (TEST_XIPT_JOOMLA_15)
  			$this->reloadUser(Array(62,87,85,86,84,83,82,81,80,79));
  		else
  			$this->reloadUser(Array(42,87,85,86,84,83,82,81,80,79));
		
		$this->cleanImage();
  	}

  	/**
  	 * remove all images and other data that dosn't effect to other test case
  	 */
  	function cleanImage() {
  		$images=Array('avatar_2.jpg','avatar_2_thumb.jpg', 'watermark_1.png','watermark_1_thumb.png','watermark_2.png','watermark_2_thumb.png');
  		foreach($images as $image)
  		JFile::delete(JPATH_ROOT .DS. PROFILETYPE_AVATAR_STORAGE_REFERENCE_PATH.DS.$image);
  		//reset set to 0 in post data
  		JRequest::setVar('resetAll',0,'POST');
  	}

}
