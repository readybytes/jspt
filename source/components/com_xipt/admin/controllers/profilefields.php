<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

//require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'profilefields.php' );

class XiPTControllerProfileFields extends JController {
    /**
     * Constructor
     * @access private
     * @subpackage profilestatus
     */
	function __construct($config = array())
	{
		parent::__construct($config);
	}
	
	function display() {
		parent::display();
    }
	
	function edit()
	{
		$fieldId = JRequest::getVar('editId', 0 , 'GET');
		$viewName	= JRequest::getCmd( 'view' , 'profilefields' );
		
		// Get the document object
		$document	=& JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();
		
		// Get the view
		$view		=& $this->getView( $viewName , $viewType );
		$layout		= JRequest::getCmd( 'layout' , 'profilefields.edit' );
		$view->setLayout( $layout );
		echo $view->edit($fieldId);
		
	}
	
	function save()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$post	= JRequest::get('post');
		
		$user	=& JFactory::getUser();

		if ( $user->get('guest')) {
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return;
		}
		
		$isValid = true;
		
		if( $isValid )
		{
			$allTypes		= XiPTHelperProfiletypes::getProfileTypeArray();
			
			if(!empty($allTypes))
				XiPTHelperProfile::remFieldsProfileType($post['id']);
				
			$allTypes[] = 0;
			$profileTypesCount = $post['profileTypesCount'];
	
			foreach($allTypes as $type)
			{
				if(array_key_exists('profileTypes'.$type,$post))
					XiPTHelperProfile::addFieldsProfileType($post['id'], $post['profileTypes'.$type]);
			}
			$msg = "Fields Saved";
		}
		$link = JRoute::_('index.php?option=com_xipt&view=profilefields', false);
		$mainframe->redirect($link, $msg);
	}

}