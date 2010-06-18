<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');
require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php';

class XiPTViewConfiguration extends JView 
{
    
	function display($tpl = null){
    	$profiletype	=XiFactory::getModel( 'Profiletypes' );		
		
    	$fields		=& $profiletype->getFields();
		$pagination	=& $profiletype->getPagination();
		
		// Load tooltips
		JHTML::_('behavior.tooltip', '.hasTip');

		$this->setToolbar();		
		
		$this->assign('reset',self::getResetLinkArray());
		$this->assignRef( 'fields' 		, $fields );
		$this->assignRef( 'pagination'	, $pagination );
		parent::display( $tpl );
    }
	
	function edit($id,$tpl = null )
	{		
		$name = JRequest :: getVar('name');
		
		$cModel = XiFactory :: getModel('configuration');
		$params  = $cModel->getParams($id);
		$lists = array();
		for ($i=1; $i<=31; $i++) {
			$qscale[]	= JHTML::_('select.option', $i, $i);
		}
		
		$lists['qscale'] = JHTML::_('select.genericlist',  $qscale, 'qscale', 'class="inputbox" size="1"', 'value', 'text', $params->get('qscale', '11'));

		$videosSize = array
		(
			JHTML::_('select.option', '320x240', '320x240 (QVGA 4:3)'),
			JHTML::_('select.option', '400x240', '400x240 (WQVGA 5:3)'),
			JHTML::_('select.option', '400x300', '400x300 (Quarter SVGA 4:3)'),
			JHTML::_('select.option', '480x272', '480x272 (Sony PSP 30:17)'),
			JHTML::_('select.option', '480x320', '480x320 (iPhone 3:2)'),
			JHTML::_('select.option', '512x384', '512x384 (4:3)'),
			JHTML::_('select.option', '600x480', '600x480 (5:4)'),
			JHTML::_('select.option', '640x360', '640x360 (16:9)'),
			JHTML::_('select.option', '640x480', '640x480 (VCA 4:3)'),
			JHTML::_('select.option', '800x600', '800x600 (SVGA 4:3)'),
//			JHTML::_('select.option', '856x480', '856x480 (WVGA 16:9)'),
//			JHTML::_('select.option', '1024x576', '1024x576 (WSVGA 16:9)'),
//			JHTML::_('select.option', '1024x768', '1024x768 (XGA 4:3)')
		);

		$lists['videosSize'] = JHTML::_('select.genericlist',  $videosSize, 'videosSize', 'class="inputbox" size="1"', 'value', 'text', $params->get('videosSize'));
		
		
		/*$dstOffset	= array();
		$counter = -12;
		for($i=0; $i <= 24; $i++ ){
			$dstOffset[] = 	JHTML::_('select.option', $counter, $counter);
			$counter++;
		}
		
		$lists['dstOffset'] = JHTML::_('select.genericlist',  $dstOffset, 'daylightsavingoffset', 'class="inputbox" size="1"', 'value', 'text', $params->get('daylightsavingoffset'));
		*/
		$uploadLimit = ini_get('upload_max_filesize');
		$uploadLimit = JString::str_ireplace('M', ' MB', $uploadLimit);
		
		$this->assign( 'lists', $lists );
		$this->assign( 'uploadLimit' , $uploadLimit );
		$this->assign( 'config'	, $params );
		$this->assign( 'id'	, $id );
		$lang =& JFactory::getLanguage();
		if($lang)
			$lang->load( 'com_community' );
	
		$this->assign( 'jsConfigPath'	, JPATH_ADMINISTRATOR .DS.'components'. DS. 'com_community'.DS.'views'.DS.'configuration'.DS.'tmpl' );
		
		// Set the titlebar text
		JToolBarHelper::title( sprintf(JText::_( 'EDIT CONFIGURATION'), $name), 'configuration' );
		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt&view=configuration');
		JToolBarHelper::divider();
		JToolBarHelper::save('save',JText::_('SAVE'));
		JToolBarHelper::cancel( 'cancel', JText::_('CLOSE' ));
		parent::display($tpl);
	}
	
	function getResetLinkArray()
	{
		$resetArray = array();
		$allPTypes = XiPTLibraryProfiletypes::getProfiletypeArray();
		if(!empty($allPTypes)) {
			foreach($allPTypes as $ptype) {
				if($ptype->params)
					$resetArray[$ptype->id] = true;
				else
					 $resetArray[$ptype->id] = false;
			}
		}
		
		return $resetArray;
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
		JToolBarHelper::title( JText::_( 'Jom Social Configuration' ), 'configuration' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt');
		//JToolBarHelper::divider();
		//JToolBarHelper::publishList('publish', JText::_( 'PUBLISH' ));
		//JToolBarHelper::unpublishList('unpublish', JText::_( 'UNPUBLISH' ));
		//JToolBarHelper::divider();
		//JToolBarHelper::trash('remove', JText::_( 'DELETE' ));
		//JToolBarHelper::addNew('edit', JText::_( 'ADD PROFILETYPES' ));
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
	
	function getPrivacyHTML( $name , $selected , $showSelf = false )
	{
		$public		= ( $selected == 0 ) ? 'checked="true" ' : '';
		$members	= ( $selected == 20 ) ? 'checked="true" ' : '';
		$friends	= ( $selected == 30 ) ? 'checked="true" ' : '';
		$self		= ( $selected == 40 ) ? 'checked="true" ' : '';
		
		$html	= '<input type="radio" value="0" name="' . $name . '" ' . $public . '/> ' . JText::_('Public');
		$html	.= '<input type="radio" value="20" name="' . $name . '" ' . $members . '/> ' . JText::_('Members');
		$html	.= '<input type="radio" value="30" name="' . $name . '" ' . $friends . '/> ' . JText::_('Friends');
		
		if( $showSelf )
		{
			$html	.= '<input type="radio" value="40" name="' . $name . '" ' . $self . '/> ' . JText::_('Self');
		}
		return $html;
	}
	
	function getFolderPermissionsPhoto( $name , $selected )
	{		
		$all		= ( $selected == '0777' ) ? 'checked="true" ' : '';
		$default	= ( $selected == '0755' ) ? 'checked="true" ' : '';

		$html	 = '<input type="radio" value="0777" name="' . $name . '" ' . $all . '/> ' . JText::_('Enable All (CHMOD 0777)');
		$html	.= '<input type="radio" value="0755" name="' . $name . '" ' . $default . '/> ' . JText::_('System Default');

		return $html;
	}
	
	function getFolderPermissionsVideo( $name , $selected )
	{		
		$all		= ( $selected == '0777' ) ? 'checked="true" ' : '';
		$default	= ( $selected == '0755' ) ? 'checked="true" ' : '';

		$html	 = '<input type="radio" value="0777" name="' . $name . '" ' . $all . '/> ' . JText::_('Enable All (CHMOD 0777)');
		$html	.= '<input type="radio" value="0755" name="' . $name . '" ' . $default . '/> ' . JText::_('System Default');

		return $html;
	}
}
