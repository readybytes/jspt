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
	
    function display() 
	{
		parent::display();
    }
	
	function edit()
	{
		$id = JRequest::getVar('editId', 0 , 'GET');
		
		$viewName	= JRequest::getCmd( 'view' , 'profiletypes' );
		
		// Get the document object
		$document	=& JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();
		
		$view		=& $this->getView( $viewName , $viewType );
		$layout		= JRequest::getCmd( 'layout' , 'profiletypes.edit' );
		$view->setLayout( $layout );
		echo $view->edit($id);
	}
	
	
	function apply()
	{
		global $mainframe;

		$info = $this->_processSave();
		$link = XiptRoute::_('index.php?option=com_xipt&view=profiletypes&task=edit&editId='.$info['id'], false);
		$mainframe->redirect($link, $info['msg']);
	}
	
	
	
	function save()
	{
		global $mainframe;

		
		$info = $this->_processSave();
		$link = XiptRoute::_('index.php?option=com_xipt&view=profiletypes', false);
		$mainframe->redirect($link, $info['msg']);
	}
	
	
	function _processSave()
	{
		$post	= JRequest::get('post');
		$cid	= JRequest::getVar('cid', array(0), 'post', 'array');
		
		$info = array();
		$info['id'] = $cid[0];
		$info['msg'] = '';
		
		//We only need few data as special case
		$data = $post;
		$data['tip'] 		= JRequest::getVar( 'tip', '', 'post', 'string', JREQUEST_ALLOWRAW );
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
		
		if(!$id)
			XiptError::raiseError(500, "SAVE ERROR");
		
		// Now store other data
		// Handle Avatar : call uploadImage function if post(image) data is set
		$fileAvatar		= JRequest::getVar( 'FileAvatar' , '' , 'FILES' , 'array' );
		if(isset($fileAvatar['tmp_name']) && !empty($fileAvatar['tmp_name']))
			XiptHelperProfiletypes::uploadAndSetImage($fileAvatar,$id,'avatar');

		// Handle Params : watermarkparams, privacy, config
		$model->saveParams($post['watermarkparams'],$id, $what='watermarkparams');
		$model->saveParams($post['config'], 		$id, $what='config');
		$model->saveParams($post['privacy'], 		$id, $what='privacy');

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
	
	function remove()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$ids	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
	
		//$post['id'] = (int) $cid[0];
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row	=& JTable::getInstance( 'profiletypes' , 'XiptTable' );
		$i = 1;

		if(!empty($ids))
		{
			foreach( $ids as $id )
			{
				$row->load( $id );
				if($id == XiptLibProfiletypes::getDefaultProfiletype())
				{
					$message= JText::_('CAN NOT DELETE DEFAULT PROFILE TYPE');
					$mainframe->enqueueMessage($message);
					continue;
				}
				if(!$row->delete( $id ))
				{
					// If there are any error when deleting, we just stop and redirect user with error.
					$message	= JText::_('ERROR IN REMOVING PROFILETYPE');
					$mainframe->redirect( 'index.php?option=com_xipt&view=profiletypes' , $message);
					exit;
				}
				$i++;
			}
		}

		$count = $i - 1;
		
		$cache = & JFactory::getCache('com_content');
		$cache->clean();
		$message	= $count.' '.JText::_('PROFILETYPE REMOVED');		
		$link = XiptRoute::_('index.php?option=com_xipt&view=profiletypes', false);
		$mainframe->redirect($link, $message);
	}
	
	
	function publish()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		// Initialize variables
		$ids		= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$count			= count( $ids );

		if (empty( $ids )) {
			return XiptError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
		
		$pModel	= XiptFactory::getModel( 'profiletypes' );
		foreach($ids as $id)
		{
			$pModel->publish($id);
		}
		$msg = sprintf(JText::_('ITEMS PUBLISHED'),$count);
		$link = XiptRoute::_('index.php?option=com_xipt&view=profiletypes', false);
		$mainframe->redirect($link, $msg);	
		return true;
	}
	
	function unpublish()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		// Initialize variables
		$ids		= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$count			= count( $ids );

		if (empty( $ids )) {
			return XiptError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
		
		$pModel	= XiptFactory::getModel( 'profiletypes' );
		foreach($ids as $id)
		{
			$pModel->unpublish($id);
		}
		$msg = sprintf(JText::_('ITEMS UNPUBLISHED'),$count);
		$link = XiptRoute::_('index.php?option=com_xipt&view=profiletypes', false);
		$mainframe->redirect($link, $msg);
		return true;
	}
	
	function visible()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		// Initialize variables
		$ids		= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$count			= count( $ids );

		if (empty( $ids )) {
			return XiptError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
		
		$pModel	= XiptFactory::getModel( 'profiletypes' );
		foreach($ids as $id)
		{
			$pModel->visible($id);
		}
		$msg = sprintf(JText::_('ITEMS VISIBLE'),$count);
		$link = XiptRoute::_('index.php?option=com_xipt&view=profiletypes', false);
		$mainframe->redirect($link, $msg);	
		return true;
	}
	
	function invisible()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		// Initialize variables
		$ids		= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$count			= count( $ids );

		if (empty( $ids )) {
			return XiptError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
		
		$pModel	= XiptFactory::getModel( 'profiletypes' );
		foreach($ids as $id)
		{
			$pModel->invisible($id);
		}
		$msg = sprintf(JText::_('ITEMS INVISIBLE'),$count);
		$link = XiptRoute::_('index.php?option=com_xipt&view=profiletypes', false);
		$mainframe->redirect($link, $msg);
		return true;
	}
	
/**	
	 * Save the ordering of the entire records.
	 *	 	
	 * @access public
	 *
	 **/	 
	function saveOrder()
	{
		global $mainframe;
	
		// Determine whether to order it up or down
		$direction	= ( JRequest::getWord( 'task' , '' ) == 'orderup' ) ? -1 : 1;

		// Get the ID in the correct location
 		$id			= JRequest::getVar( 'cid', array(), 'post', 'array' );

		if( isset( $id[0] ) )
		{
			$id		= (int) $id[0];
			
			// Load the JTable Object.
			$table	=& JTable::getInstance( 'profiletypes' , 'XiptTable' );
		
			$table->load( $id );
			$table->move( $direction );
			
			
			$mainframe->redirect( 'index.php?option=com_xipt&view=profiletypes' );
		}
	}
	
	function removeAvatar()
	{
		global $mainframe;
		
		//get id and old avatar.
		$id        = JRequest::getVar('editId', 0 , 'GET');
		$oldAvatar = JRequest::getVar('oldAvatar', 0 , 'GET');
		
		$newavatar 		= DEFAULT_AVATAR ;
		$newavatarthumb	= DEFAULT_AVATAR_THUMB;
		$profiletype	=XiptFactory::getModel( 'Profiletypes' );
		
		$profiletype->save( array('avatar' => $newavatar), $id );;
		
		$profiletype->resetUserAvatar($id, $newavatar, $oldAvatar, $newavatarthumb);
		$mainframe->redirect( 'index.php?option=com_xipt&view=profiletypes');
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
