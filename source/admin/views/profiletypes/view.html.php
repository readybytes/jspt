<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');


class XiptViewProfiletypes extends XiptView 
{
    function display($tpl = null)
    {
    	$profiletype	=XiptFactory::getModel( 'Profiletypes' );
		
		$fields		=& $profiletype->loadRecords();
		$pagination	=& $profiletype->getPagination();
		$profiletypes = array();
		$allTypes = XiptLibProfiletypes::getProfiletypeArray();
		if ($allTypes)
				foreach ($allTypes as $ptype){
					$profiletypes[$ptype->id]	= $ptype->name;
				}
		//We should add none also.
		$profiletypes['0']='None';
		// Load tooltips
		JHTML::_('behavior.tooltip', '.hasTip');

		$this->setToolbar();
		
		$this->assignRef( 'fields' 		, $fields );
		$this->assignRef( 'pagination'	, $pagination );
		$this->assignRef( 'profiletypes'	, $profiletypes );
		parent::display( $tpl );
    }
	
	function edit($id,$tpl = null )
	{
		$row	=& JTable::getInstance( 'profiletypes' , 'XiptTable' );
		$row->load( $id );	
		
		$wmxmlpath 	= XIPT_FRONT_PATH_ASSETS.DS.'xml'.DS.'profiletypes.watermarkparams.xml';
		$wmini		= XIPT_FRONT_PATH_ASSETS.DS.'ini'.DS.'profiletypes.watermarkparams.ini';
		$wmdata		= JFile::read($wmini);

		if(JFile::exists($wmxmlpath))
			$config = new JParameter($wmdata,$wmxmlpath);
		else
			$config = new JParameter('','');

		$config->bind($row->watermarkparams);
		
		$this->assign( 'config' , $config );
		
		$this->assign( 'row' , $row );
               
        	$paramsxmlpath         = XIPT_FRONT_PATH_ASSETS.DS.'xml'.DS.'profiletypes.config.xml';
        	$ini                   = XIPT_FRONT_PATH_ASSETS.DS.'ini'.DS.'profiletypes.config.ini';
        	$data                  = JFile::read($ini);                
               
	       if(JFile::exists($paramsxmlpath))
        		$ptypesetting  = new JParameter($data,$paramsxmlpath);
        	else
        		$ptypesetting  = new JParameter('','');
                               
	        $ptypesetting->bind($row->config);
		
		$this->assign( 'configuration' , $ptypesetting );
		
		$this->assign( 'row' , $row );
		              
	        $psettingsxmlpath      = XIPT_FRONT_PATH_ASSETS.DS.'xml'.DS.'profiletypes.privacy.xml';
        	$ini                   = XIPT_FRONT_PATH_ASSETS.DS.'ini'.DS.'profiletypes.privacy.ini';
        	$psdata                = JFile::read($ini);                
               
    	       if(JFile::exists($paramsxmlpath))
        		$privacysetting  = new JParameter($psdata,$psettingsxmlpath);
               else
        		$privacysetting  = new JParameter('','');
                               
	        $privacysetting->bind($row->privacy);
		
		$this->assign( 'privacy' , $privacysetting );
		
		$this->assign( 'row' , $row );


		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'EDIT PROFILETYPE' ), 'profiletypes' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt&view=profiletypes');
		JToolBarHelper::divider();
		JToolBarHelper::apply('apply', JText::_('APPLY'));
		JToolBarHelper::save('save',JText::_('SAVE'));
		JToolBarHelper::cancel( 'cancel', JText::_('CLOSE' ));

		$pane = &JPane::getInstance('sliders', array('allowAllClose' => true));
		$this->assignRef('pane', $pane);

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
