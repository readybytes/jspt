<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class XiPTControllerProfileFields extends JController 
{
    
	function __construct($config = array())
	{
		parent::__construct($config);
	}
	
	function display() 
	{
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
	
	//save fields which is not accsible , means in opposite form
	// like field1 is visible to ptype 1 not to ptype 2 and 3 , then store 2 and 3
	//by default all fields are visible to all ptype
	//if all is selected then store nothing
	//remove old fields
	
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
		
			
		//remove all rows related to specific field id 
		// cleaning all data for storing new profiletype with fields
		XiPTHelperProfileFields::remFieldsProfileType($post['id']);
		
		$allTypes		= XiPTHelperProfiletypes::getProfileTypeArray();

		$count = 0;
		if(!array_key_exists('profileTypes0',$post)) {
			foreach($allTypes as $type) {
				if($type) {
					if(!array_key_exists('profileTypes'.$type,$post)) {
						  XiPTHelperProfileFields::addFieldsProfileType($post['id'], $type);
						  $msg = JText::_('FIELDS SAVED');
						  $count++;
					}
				}
			}
			if($count == 0) {
				 XiPTHelperProfileFields::addFieldsProfileType($post['id'], 'XIPT_NONE');
				 $msg = JText::_('FIELDS SAVED');
			}
		}	
		$msg = JText::_('FIELDS SAVED');	
		$link = JRoute::_('index.php?option=com_xipt&view=profilefields', false);
		$mainframe->redirect($link, $msg);
	}
}
