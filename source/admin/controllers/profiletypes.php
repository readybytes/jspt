<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');
 
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
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		jimport('joomla.filesystem.file');
		jimport('joomla.utilities.utility');

		$info = $this->_processSave();
		$link = XiptRoute::_('index.php?option=com_xipt&view=profiletypes&task=edit&editId='.$info['id'], false);
		$mainframe->redirect($link, $info['msg']);
	}
	
	
	
	function save()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		jimport('joomla.filesystem.file');
		jimport('joomla.utilities.utility');
		
		$info = $this->_processSave();
		$link = XiptRoute::_('index.php?option=com_xipt&view=profiletypes', false);
		$mainframe->redirect($link, $info['msg']);
	}
	
	
	function _processSave()
	{
		$post	= JRequest::get('post');
		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		
		$user	=& JFactory::getUser();

		if ( $user->get('guest')) {
			XiptError::raiseError( 403, JText::_('Access Forbidden') );
			return;
		}

		$info = array();
		$info['id'] = $cid[0];
		$info['msg'] = '';
		
		
		// Load the JTable Object.
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row	=& JTable::getInstance( 'profiletypes' , 'XiptTable' );
		$row->load( $cid[0] );	
		$isValid	= true;
		
		//for Reset we will save old Data
		$oldData = clone($row);
		
		$data = array();
		$data['name'] 		= $post['name'];
		$data['tip'] 		= JRequest::getVar( 'tip', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$data['published'] 	= $post['published']; 
		$data['template'] 	= $post['template'];
		$data['jusertype'] 	= $post['jusertype'];
		$data['approve'] 	= $post['approve'];
		$data['allowt'] 	= $post['allowt'];
		$data['group'] 		= implode(',',$post['group']);
		$data['visible']	= $post['visible'];
		
		$registry	=& JRegistry::getInstance( 'xipt' );
		$registry->loadArray($post['watermarkparams'],'xipt_watermarkparams');
		$data['watermarkparams'] =  $registry->toString('INI' , 'xipt_watermarkparams' );
		//$data['ordering']	= 0;
		
		$registry->loadArray($post['config'],'xipt_config');
		$data['config'] =  $registry->toString('INI' , 'xipt_config' );
		
		$registry->loadArray($post['privacy'],'xipt_params');
		$data['privacy']  =  $registry->toString('INI' , 'xipt_params' );
		
		$row->bind($data);

		if( $isValid )
		{
			$id = $row->store();	
			if($id != 0)
			{
				//call uploadImage function if post(image) data is set
				$fileAvatar		= JRequest::getVar( 'FileAvatar' , '' , 'FILES' , 'array' );
		
				if( isset( $fileAvatar['tmp_name'] ) && !empty( $fileAvatar['tmp_name'] ) )
					XiptHelperProfiletypes::uploadAndSetImage($fileAvatar,$row->id,'avatar');

				/* generate watermark image */
				$config = new JParameter('','');
				$config->bind($row->watermarkparams);
				
				$ptypesetting = new JParameter('','');
				$ptypesetting->bind($row->config);
				
				$privacysetting = new JParameter('','');
				$privacysetting->bind($row->privacy);

				
				$imageGenerator = new XiptLibImage($config);
				$storage		= PROFILETYPE_AVATAR_STORAGE_PATH;
				$imageName 		= 'watermark_'. $row->id;
				$filename		= $imageGenerator->genImage($storage,$imageName);
				
				if($filename) {
					$config->set('demo',$row->id);
					//save watermark params
					
					$image=$this->saveWatermarkparams($filename,$row,$config);
					/*generate thumnail */
				    $this->generateThumbnail($imageName,$filename,$storage,$row,$config);
				    
					}	

				if($ptypesetting)
				{
					$this->saveConfig($row, $ptypesetting,'config');
				}
				
			   if($privacysetting)
			   {
					$this->saveConfig($row, $privacysetting,'privacy');
			   }
				
				/* Reset existing user's */
				if($post['resetAll']) {
					//If not uploaded data then by default save the previous values 
					$data['avatar'] 	= XiptLibProfiletypes::getProfiletypeData($cid[0],'avatar');
					$data['watermark'] 	= $image; //XiptLibProfiletypes::getProfiletypeData($cid[0],'watermark');
					XiptHelperProfiletypes::resetAllUsers($row->id, $oldData, $data);	
				}
					
				$info['id'] = $row->id;
				$info['msg'] .= JText::_('PROFILETYPE SAVED');
			}
		}
		return $info;
	}
	
	function saveWatermarkparams($filename,$row,$config,$test=false)
	{
		$image = PROFILETYPE_AVATAR_STORAGE_REFERENCE_PATH.DS.$filename;
		
		/*assign ptype id in  demo so we can generate data in element itself */ 
		if($test==false)
			$params = $config->toString('INI');
		else
			$params = $config;
		//now update profiletype with new watermark
		$db =& JFactory::getDBO();
		$query	= 'UPDATE ' . $db->nameQuote( '#__xipt_profiletypes' ) . ' '
    			. 'SET ' . $db->nameQuote( 'watermark' ) . '=' . $db->Quote( $image ) . ' '
    			. ', '.$db->nameQuote( 'watermarkparams' ) . '=' . $db->Quote( $params ) . ' '
    			. 'WHERE ' . $db->nameQuote( 'id' ) . '=' . $db->Quote( $row->id );
    	$db->setQuery( $query );
    	$db->query( $query );

		if($db->getErrorNum())
		{
			XiptError::raiseError( 500, $db->stderr());
	    }
	    return $image;
	}

	// this function generates thumbnail of watermark
	function generateThumbnail($imageName,$filename,$storage,$row,$config)
	{
		require_once JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'helpers'.DS.'image.php';
					
		$fileExt = JFile::getExt($filename);
		$thumbnailName = 'watermark_'. $row->id.'_thumb.'.$fileExt;
		$storageThumbnail = $storage . DS .$thumbnailName;
		$watermarkPath = $storage.DS.$imageName.'.'.$fileExt;
		
		$watermarkThumbWidth  = $config->get('xiThumbWidth',80);
		$watermarkThumbHeight = $config->get('xiThumbHeight',20);
		$dstimg 			= 	ImageCreateTrueColor($watermarkThumbWidth,$watermarkThumbHeight) 
					or die('Cannot initialize GD Image');

		$watermarkType = XiptLibUtils::getImageType($watermarkPath);
		$srcimg	 = cImageOpen( $watermarkPath , $watermarkType);
		//XITODO : also support other formats
		
		
		if(imagecopyresampled($dstimg,$srcimg,0,0,0,0,$watermarkThumbWidth,$watermarkThumbHeight,$config->get(xiWidth,64),$config->get(xiHeight,64)))
		{
			//fix for permissions
			imagepng($dstimg,$storageThumbnail);
			chmod($storageThumbnail, 0744);
		}	
		else
			XiptError::raiseWarning('XIPT_THUMB_WAR','THUMBNAIL NOT SUPPORTED');
		
		/*if(!cImageCreateThumb( $watermarkPath , $storageThumbnail , XiptLibUtils::getImageType($watermarkPath),$config->get(xiWidth,64)/2,$config->get(xiHeight,64)/2));
			$info['msg'] .= sprintf(JText::_('ERROR MOVING UPLOADED FILE') , $storageThumbnail);*/
		return;
	}
	
	function saveConfig($row,$ptypesetting,$what,$test=false)
	{
		if($test===false)
			$params = $ptypesetting->toString('INI');
		else
		{
			$params = $ptypesetting;	
		}
		//now update profiletype with new watermark
		$db =& JFactory::getDBO();
		$query	= 'UPDATE ' . $db->nameQuote( '#__xipt_profiletypes' ) . ' '
    			. 'SET ' . ' '.$db->nameQuote( $what ) . '=' . $db->Quote( $params ) . ' '
    			. 'WHERE ' . $db->nameQuote( 'id' ) . '=' . $db->Quote( $row->id );
    	$db->setQuery( $query );
    	$db->query( $query );

		if($db->getErrorNum())
		{
			XiptError::raiseError( 500, $db->stderr());
	    }
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
			$pModel->save(array('published'=>1),$id);
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
			$pModel->save(array('published'=>0),$id);
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
			$pModel->save( array('visible' => 1), $id );
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
			$pModel->save( array('visible' => 0), $id );
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
}
