<?php
/**
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');
class XiPTViewSetup extends JView 
{
    function display($tpl = null)
	{
		//@TODO : check whether custom field exitst or not
		//Default ptype exist or not
		//profiletypes exist or not
		//patch file 
			
		$requiredSetup = array();
		//check profiletype existance
		$ptypes = XiPTHelperProfiletypes::getProfileTypeArray();
		$link = JRoute::_("index.php?option=com_xipt&view=setup&task=createprofiletypes",false);
		if(!$ptypes) {
			$requiredSetup['profiletypes']['message'] = '<a href="'.$link.'">'.JText::_("PLEASE CLICK HETE TO CREATE PRFOILETYPES").'</a>';
			$requiredSetup['profiletypes']['done']  = false;
		}
		else {
			$requiredSetup['profiletypes']['message'] = JText::_("PROFILETYPE VALIDATION SUSCCESSFULL");
			$requiredSetup['profiletypes']['done']  = true;
		}
			
		//check default profiletype
		$params = JComponentHelper::getParams('com_xipt');
		$defaultProfiletypeID = $params->get('defaultProfiletypeID',0);
		$link = JRoute::_("index.php?option=com_config&controller=component&component=com_xipt&path=",false);
		if(!$defaultProfiletypeID) {
			$requiredSetup['defaultprofiletype']['message'] = '<a href="'.$link.'">'.JText::_("PLEASE CLICK HETE TO SET DEFAULT PRFOILETYPE").'</a>';
			$requiredSetup['defaultprofiletype']['done']  = false;
		}
		else {
			$requiredSetup['defaultprofiletype']['message'] = JText::_("DEFAULT PROFILETYPE EXIST");
			$requiredSetup['defaultprofiletype']['done']  = true;
		}
			
	
		$link = JRoute::_("index.php?option=com_xipt&view=setup&task=createfields",false);
		if(XiPTHelperSetup::checkCustomfieldRequired()) {
			$requiredSetup['customfields']['message'] = '<a href="'.$link.'">'.JText::_("PLEASE CLICK HETE TO CREATE CUSTOM FILEDS").'</a>';
			$requiredSetup['customfields']['done'] = false;
		}
		else {
			$requiredSetup['customfields']['message'] = JText::_("FIELDS EXISTS");
			$requiredSetup['customfields']['done'] = true;
		}
		$this->assign('requiredSetup',$requiredSetup);
		
		parent::display( $tpl );
    }
	
	function edit($id,$tpl = null )
	{
		$row	=& JTable::getInstance( 'profiletypes' , 'XiPTTable' );
		$row->load( $id );	
		
		$this->assign( 'row' , $row );
		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'EDIT PROFILETYPE' ), 'profiletypes' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt&view=profiletypes');
		JToolBarHelper::divider();
		JToolBarHelper::save('save',JText::_('SAVE'));
		JToolBarHelper::cancel( 'cancel', JText::_('CLOSE' ));
		parent::display($tpl);
	}
	
	/**
	 * Private method to set the toolbar for this view
	 * 
	 * @access private
	 * 
	 * @return null
	 **/	 	 
	function setToolBar()
	{

		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'PROFILETYPES' ), 'profiletypes' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt');
		JToolBarHelper::divider();
		JToolBarHelper::publishList('publish', JText::_( 'PUBLISH' ));
		JToolBarHelper::unpublishList('unpublish', JText::_( 'UNPUBLISH' ));
		JToolBarHelper::divider();
		JToolBarHelper::trash('remove', JText::_( 'DELETE' ));
		JToolBarHelper::addNew('edit', JText::_( 'ADD PROFILETYPES' ));
	}
	
	function getGroup( $id )
	{	
		if($id==0)
			return "NONE";
		$db			=& JFactory::getDBO();
		$query		= 'SELECT '.$db->nameQuote('name')
					. ' FROM ' . $db->nameQuote( '#__community_groups' ) 
					. ' WHERE '.$db->nameQuote('id').'='.$db->Quote($id) ;
		$db->setQuery( $query );
		$val = $db->loadResult();
		return $val;
	}
}
