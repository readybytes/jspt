<?php
/**
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');
class XiPTViewProfiletypes extends JView 
{
    function display($tpl = null){
    	$profiletype	=XiFactory::getModel( 'Profiletypes' );
		
		$fields		=& $profiletype->getFields();
		$pagination	=& $profiletype->getPagination();
		
		// Load tooltips
		JHTML::_('behavior.tooltip', '.hasTip');

		$this->setToolbar();
		
		$this->assignRef( 'fields' 		, $fields );
		$this->assignRef( 'pagination'	, $pagination );
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
		JToolBarHelper::preferences( 'com_xipt','400','600');
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
