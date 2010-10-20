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
		$id 	= JRequest::getVar('editId', $id , 'GET');					
		return $this->getView()->edit($id);
	}	
	
	function apply()
	{
		$info = $this->_processSave();
		$link = XiptRoute::_('index.php?option=com_xipt&view=profiletypes&task=edit&editId='.$info['id'], false);
		$this->setRedirect($link, $info['msg']);
	}
		
	function save()
	{
		$info = $this->_processSave();
		$link = XiptRoute::_('index.php?option=com_xipt&view=profiletypes', false);
		$this->setRedirect($link, $info['msg']);
	}
	
	// XITODO : needs test case
	function _processSave($post=null,$cid=array(0))
	{
		if($post === null) $post	= JRequest::get('post');
		$cid	= JRequest::getVar('cid', $cid, 'post', 'array');
		
	
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
		$allData = $model->loadRecords();
		if(isset($allData[$cid[0]]))
			$oldData = $allData[$cid[0]];
		
		// now save model
		$id	= $model->save($data, $cid[0]);
		XiptError::assert($id);
		
		// Now store other data
		// Handle Avatar : call uploadImage function if post(image) data is set
		$fileAvatar		= JRequest::getVar( 'FileAvatar' , '' , 'FILES' , 'array' );
		if(isset($fileAvatar['tmp_name']) && !empty($fileAvatar['tmp_name']))
			XiptHelperProfiletypes::uploadAndSetImage($fileAvatar,$id,'avatar');

		// Handle Params : watermarkparams, privacy, config
		$model->saveParams($post['watermarkparams'],$id, 'watermarkparams');
		$model->saveParams($post['config'], 		$id, 'config');
		$model->saveParams($post['privacy'], 		$id, 'privacy');

		// now generate watermark, and update watermark field
		$image = $this->_saveWatermark($id);
		
		//XITODO : Ensure data is reloaded, not cached
		$newData = $model->loadRecords();
		$newData = $newData[$id];

	    // Reset existing user's 
		if($post['resetAll']) {
			//If not uploaded data then by default save the previous values 
			XiptHelperProfiletypes::resetAllUsers($id, $oldData, $newData);	
		}
					
		$info['id'] = $id;
		$info['msg'] .= JText::_('PROFILETYPE SAVED');

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
				$message= JText::_('CAN NOT DELETE DEFAULT PROFILE TYPE');
				JFactory::getApplication()->enqueueMessage($message);
				continue;
			}
			
			if(!$this->getModel()->delete($id))
			{
				// If there are any error when deleting, we just stop and redirect user with error.
				$message	= JText::_('ERROR IN REMOVING PROFILETYPE');
				$this->setRedirect($link, $message);
				return false;
			}
			$i++;
		}	
		
		$message	= ($i - 1).' '.JText::_('PROFILETYPE REMOVED');		
		$this->setRedirect($link, $message);
	}
	
	function visible($ids=array(0))
	{
		$ids		= JRequest::getVar('cid', $ids, 'post', 'array');
		$count		= count( $ids );

		if(!$this->getModel()->visible($ids)){
			XiptError::raiseWarning(500,JText::_('ERROR IN MAKING PROFILETYPE VISIBLE'));
			return false;
		}
		
		$msg = sprintf(JText::_('ITEMS VISIBLE'),$count);
		$link = XiptRoute::_('index.php?option=com_xipt&view=profiletypes', false);
		$this->setRedirect($link, $msg);	
		return true;
	}
	
	function invisible($ids=array(0))
	{
		$ids		= JRequest::getVar('cid', $ids, 'post', 'array');
		$count		= count( $ids );

		if(!$this->getModel()->invisible($ids)){
			XiptError::raiseWarning(500,JText::_('ERROR IN MAKING PROFILETYPE INVISIBLE'));
			return false;
		}
		
		$msg = sprintf(JText::_('ITEMS INVISIBLE'),$count);
		$link = XiptRoute::_('index.php?option=com_xipt&view=profiletypes', false);
		$this->setRedirect($link, $msg);
		return true;
	}
	
	function removeAvatar($id=0, $oldAvatar=null)
	{
		//get id and old avatar.
		$id        = JRequest::getVar('editId', $id, 'GET');
		$oldAvatar = JRequest::getVar('oldAvatar', $oldAvatar, 'GET');
		
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
		$newData = $model->loadRecords();
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
		$data 	= array('watermark' => $image);
		$this->generateThumbnail($imageName,$filename,$storage,$newData,$config);
		
		// now save model
		$model->save($data, $id);
		return $image;
	}
}
