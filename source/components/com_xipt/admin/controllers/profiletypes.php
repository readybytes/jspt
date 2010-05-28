<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');
 
class XiPTControllerProfiletypes extends JController 
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
		$link = JRoute::_('index.php?option=com_xipt&view=profiletypes&task=edit&editId='.$info['id'], false);
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
		$link = JRoute::_('index.php?option=com_xipt&view=profiletypes', false);
		$mainframe->redirect($link, $info['msg']);
	}
	
	
	function _processSave()
	{
		$post	= JRequest::get('post');
		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		
		$user	=& JFactory::getUser();

		if ( $user->get('guest')) {
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return;
		}

		$info = array();
		$info['id'] = $cid[0];
		$info['msg'] = '';
		
		
		// Load the JTable Object.
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row	=& JTable::getInstance( 'profiletypes' , 'XiPTTable' );
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
		$data['privacy'] 	= $post['privacy'];
		$data['approve'] 	= $post['approve'];
		$data['allowt'] 	= $post['allowt'];
		$data['group'] 		= $post['group'];
		
		$registry	=& JRegistry::getInstance( 'xipt' );
		$registry->loadArray($post['watermarkparams'],'xipt_watermarkparams');
		$data['watermarkparams'] =  $registry->toString('INI' , 'xipt_watermarkparams' );
		//$data['ordering']	= 0;
		
		$row->bindAjaxPost($data);

		if( $isValid )
		{
			$id = $row->store();	
			if($id != 0)
			{
				//call uploadImage function if post(image) data is set
				$fileAvatar		= JRequest::getVar( 'FileAvatar' , '' , 'FILES' , 'array' );
		
				if( isset( $fileAvatar['tmp_name'] ) && !empty( $fileAvatar['tmp_name'] ) )
					XiPTHelperProfiletypes::uploadAndSetImage($fileAvatar,$row->id,'avatar');

				/* generate watermark image */
				$config = new JParameter('','');
				$config->bind($row->watermarkparams);
				/*XITODO : send debug mode in second parameter */
				$imageGenerator = new XiPTImageGenerator($config,0);
				$storage			= PROFILETYPE_AVATAR_STORAGE_PATH;
				$imageName = 'watermark_'. $row->id;
				$filename	= $imageGenerator->genImage($storage,$imageName);
				
				if($filename) {
					$config->set('demo',$row->id);
					//save watermark params
					
					$image=$this->saveWatermarkparams($filename,$row,$config);
					/*generate thumnail */
				    $this->generateThumbnail($imageName,$filename,$storage,$row,$config);
				    
					}				    
				/* Reset existing user's */
				if($post['resetAll']) {
					//If not uploaded data then by default save the previous values 
					$data['avatar'] 	= XiPTLibraryProfiletypes::getProfiletypeData($cid[0],'avatar');
					$data['watermark'] 	= $image; //XiPTLibraryProfiletypes::getProfiletypeData($cid[0],'watermark');
					XiPTHelperProfiletypes::resetAllUsers($row->id, $oldData, $data);	
				}
					
				$info['id'] = $row->id;
				$info['msg'] .= JText::_('PROFILETYPE SAVED');
			}
		}
		return $info;
	}
	
	function saveWatermarkparams($filename,$row,$config)
	{
		$image = PROFILETYPE_AVATAR_STORAGE_REFERENCE_PATH.DS.$filename;
		
		/*assign ptype id in  demo so we can generate data in element itself */ 
		
		$params = $config->toString('INI');
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
			JError::raiseError( 500, $db->stderr());
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

		$watermarkType = XiPTLibraryUtils::getImageType($watermarkPath);
		$srcimg	 = cImageOpen( $watermarkPath , $watermarkType);
		//XITODO : also support other formats
		
		
		if(imagecopyresampled($dstimg,$srcimg,0,0,0,0,$watermarkThumbWidth,$watermarkThumbHeight,$config->get(xiWidth,64),$config->get(xiHeight,64)))
			imagepng($dstimg,$storageThumbnail);
		else
			JError::raiseWarning('XIPT_THUMB_WAR','THUMBNAIL NOT SUPPORTED');
		
		/*if(!cImageCreateThumb( $watermarkPath , $storageThumbnail , XiPTLibraryUtils::getImageType($watermarkPath),$config->get(xiWidth,64)/2,$config->get(xiHeight,64)/2));
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
		$row	=& JTable::getInstance( 'profiletypes' , 'XiPTTable' );
		$i = 1;

		if(!empty($ids))
		{
			foreach( $ids as $id )
			{
				$row->load( $id );
				
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
		$link = JRoute::_('index.php?option=com_xipt&view=profiletypes', false);
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
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
		
		$pModel	= XiFactory::getModel( 'profiletypes' );
		foreach($ids as $id)
		{
			$pModel->updatePublish($id,1);
		}
		$msg = sprintf(JText::_('ITEMS PUBLISHED'),$count);
		$link = JRoute::_('index.php?option=com_xipt&view=profiletypes', false);
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
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
		
		$pModel	= XiFactory::getModel( 'profiletypes' );
		foreach($ids as $id)
		{
			$pModel->updatePublish($id,0);
		}
		$msg = sprintf(JText::_('ITEMS UNPUBLISHED'),$count);
		$link = JRoute::_('index.php?option=com_xipt&view=profiletypes', false);
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
			$table	=& JTable::getInstance( 'profiletypes' , 'XiPTTable' );
		
			$table->load( $id );
			$table->move( $direction );
			
			
			$mainframe->redirect( 'index.php?option=com_xipt&view=profiletypes' );
		}
	}
	
}
