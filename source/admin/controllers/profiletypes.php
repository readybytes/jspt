<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
 
class XiptControllerProfiletypes extends XiptController 
{
    
	function __construct($config = array())
	{
		parent::__construct($config);
		
		//registering some extra in all task list which we want to call
		$this->registerTask( 'orderup' , 'saveOrder' );
		$this->registerTask( 'orderdown' , 'saveOrder' );
	}
	
	function edit($id=0)
	{
		$id 	= JRequest::getVar('id', $id);					
		return $this->getView()->edit($id);
	}	
	
	function apply()
	{
		$info = $this->_processSave();
		$link = XiptRoute::_('index.php?option=com_xipt&view=profiletypes&task=edit&id='.$info['id'], false);
		$this->setRedirect($link, $info['msg']);
	}
		
	function save()
	{
		$info = $this->_processSave();
		$link = XiptRoute::_('index.php?option=com_xipt&view=profiletypes', false);
		$this->setRedirect($link, $info['msg']);
	}
	
	// XITODO : needs test case
	function _processSave($post=null,$id=0)
	{
		if($post === null) $post	= JRequest::get('post');
		$id	= JRequest::getVar('id', $id, 'post');
		
	
		//We only need few data as special case
		$data = $post;
		$data['tip'] 		= JRequest::getVar( 'tip', $post['tip'], 'post', 'string', JREQUEST_ALLOWRAW );
		$data['group'] 		= implode(',',$post['group']);

		// These data will be seperately stored, we dont want to update these
		unset($data['watermarkparams']);
		unset($data['config']);
		unset($data['privacy']);
			
		$model = $this->getModel();
		//for Reset we will save old Data
		// give 0 in loadRecords so that all records will be loaded
		$allData = $model->loadRecords(0);
		if(isset($allData[$id]))
			$oldData = $allData[$id];
		
		// set ordering
		if(end($allData)){
			if($allData[$id]->id == 0)
			$data['ordering'] = end($allData)->ordering + 1;
		}
		else
			$data['ordering'] =  1;
			
		// now save model
		$id	 = $model->save($data, $id);
		XiptError::assert($id, XiptText::_("$id NOT EXISTS"), XiptError::ERROR);
		
		// Now store other data
		// Handle Avatar : call uploadImage function if post(image) data is set
		$fileAvatar		= JRequest::getVar( 'FileAvatar' , '' , 'FILES' , 'array' );
		if(isset($fileAvatar['tmp_name']) && !empty($fileAvatar['tmp_name']))
			XiptHelperProfiletypes::uploadAndSetImage($fileAvatar,$id,'avatar');

		//display demo on watermark profile according ProfileType
		if($post['watermarkparams']['enableWaterMark'])
			$post['watermarkparams']['demo']= $id;
		
		// Handle Params : watermarkparams, privacy, config
		$model->saveParams($post['watermarkparams'],$id, 'watermarkparams');
		$model->saveParams($post['config'], 		$id, 'config');
		$model->saveParams($post['privacy'], 		$id, 'privacy');

		// now generate watermark, and update watermark field
		$image = $this->_saveWatermark($id);
		
		//XITODO : Ensure data is reloaded, not cached
		$newData = $model->loadRecords(0);
		$newData = $newData[$id];
		//to reset privacy of users need to load from loadParams
		$newData->privacy = $model->loadParams($id,'privacy');		
		
	    // Reset existing user's 
		if($post['resetAll']) {
			// if watermark disable then restore avatar
			if(!$post['watermarkparams']['enableWaterMark'])
					$newData->watermark='';
									
			//If not uploaded data then by default save the previous values 
			XiptHelperProfiletypes::resetAllUsers($id, $oldData, $newData);	
		}
					
		$info['id'] = $id;
		$info['msg'] = XiptText::_('PROFILETYPE SAVED');

		return $info;
	}

	// this function generates thumbnail of watermark
	function generateThumbnail($imageName,$filename,$storage,$newData,$config)
	{
		require_once JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'helpers'.DS.'image.php';
					
		$fileExt = JFile::getExt($filename);
		$thumbnailName = 'watermark_'. $newData->id.'_thumb.'.$fileExt;
		$storageThumbnail = $storage . DS .$thumbnailName;
		$watermarkPath = $storage.DS.$imageName.'.'.$fileExt;
		
		$watermarkThumbWidth  = $config->get('xiThumbWidth',80);
		$watermarkThumbHeight = $config->get('xiThumbHeight',20);
		$dstimg 			= 	ImageCreateTrueColor($watermarkThumbWidth,$watermarkThumbHeight) 
					or die('Cannot initialize GD Image');

		$watermarkType = XiptHelperImage::getImageType($watermarkPath);
		$srcimg	 = cImageOpen( $watermarkPath , $watermarkType);
		//XITODO : also support other formats
		
		
		if(imagecopyresampled($dstimg,$srcimg,0,0,0,0,$watermarkThumbWidth,$watermarkThumbHeight,$config->get('xiWidth',64),$config->get('xiHeight',64)))
		{
			//fix for permissions
			imagepng($dstimg,$storageThumbnail);
			chmod($storageThumbnail, 0744);
		}	
		else
			XiptError::raiseWarning('XIPT_THUMB_WAR','THUMBNAIL NOT SUPPORTED');
		
		/*if(!cImageCreateThumb( $watermarkPath , $storageThumbnail , XiptHelperImage::getImageType($watermarkPath),$config->get(xiWidth,64)/2,$config->get(xiHeight,64)/2));
			$info['msg'] .= sprintf(JText::_('ERROR MOVING UPLOADED FILE') , $storageThumbnail);*/
		return;
	}
	
	function remove($ids=array())
	{
		$ids	= JRequest::getVar( 'cid', $ids, 'post', 'array' );
		$link = XiptRoute::_('index.php?option=com_xipt&view=profiletypes', false);
	
		$i = 1;
		//XITODO : Clean and commonize it
		$defaultPtype = XiptLibProfiletypes::getDefaultProfiletype();
		foreach( $ids as $id )
		{
			// can not delete default profiletype
			if($id == $defaultPtype)
			{
				$message= XiptText::_('CAN NOT DELETE DEFAULT PROFILE TYPE');
				JFactory::getApplication()->enqueueMessage($message);
				continue;
			}
			
			if(!$this->getModel()->delete($id))
			{
				// If there are any error when deleting, we just stop and redirect user with error.
				$message	= XiptText::_('ERROR IN REMOVING PROFILETYPE');
				$this->setRedirect($link, $message);
				return false;
			}
			$i++;
		}	
		
		$message	= ($i - 1).' '.XiptText::_('PROFILETYPE REMOVED');		
		$this->setRedirect($link, $message);
	}
	
	function removeAvatar($id=0, $oldAvatar=null)
	{
		//get id and old avatar.
		$id        = JRequest::getVar('id', $id);
		$oldAvatar = JRequest::getVar('oldAvatar', $oldAvatar);
		
		$newavatar 		= DEFAULT_AVATAR ;
		$newavatarthumb	= DEFAULT_AVATAR_THUMB;
		$profiletype	= $this->getModel();
		
		$profiletype->save( array('avatar' => $newavatar), $id );;
		
		$profiletype->resetUserAvatar($id, $newavatar, $oldAvatar, $newavatarthumb);
		$this->setRedirect('index.php?option=com_xipt&view=profiletypes');
		return true;
	}
	
	function _saveWatermark($id)
	{
		$model = $this->getModel();

		//Collect Newly saved data
		$newData = $model->loadRecords(0);
		$newData = $newData[$id];
		
		$config = new JParameter('','');
		$config->bind($newData->watermarkparams);

		// generate watermark image		
		//XITODO : improve nomenclature
		$imageGenerator = new XiptLibImage($config);
		$storage		= PROFILETYPE_AVATAR_STORAGE_PATH;
		$imageName 		= 'watermark_'. $id;
		$filename		= $imageGenerator->genImage($storage,$imageName);
				
		//XITODO : assert on filename
		$image = PROFILETYPE_AVATAR_STORAGE_REFERENCE_PATH.DS.$filename;
		$data 	= array('watermark' => XiptHelperUtils::getUrlpathFromFilePath($image));
		$this->generateThumbnail($imageName,$filename,$storage,$newData,$config);
		
		// now save model
		$model->save($data, $id);
		return $image;
	}
	
	function copy($ids = array())
	{
		//get selected profile type ids
		$cid	= JRequest::getVar( 'cid', $ids, 'post', 'array' );
		if (count($cid) == 0)
 			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		
		//get profile type data by id
		$model = $this->getModel();
		$data  = $model->loadRecords(0);
		
		// get last profile type from array ( will be last in ordering )
 		$lastOrder = end($data)->ordering + 1;

		foreach($cid as $id){		
			$data[$id]->id        = 0;
			$data[$id]->name      = XiptText::_('Copy of ').$data[$id]->name;
			$data[$id]->published = 0;
			$data[$id]->ordering  = $lastOrder++;
			$model->save($data[$id],0);
		}

		$this->setRedirect('index.php?option=com_xipt&view=profiletypes');
		return false;
	}

}

