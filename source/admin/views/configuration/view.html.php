<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptViewConfiguration extends XiptView 
{
    
	function display($tpl = null){
    	$pModel	= $this->getModel();		
		
    	$fields		= $pModel->loadRecords();
		$pagination	= $pModel->getPagination();		

		$this->setToolBar();		
		
		$this->assign('reset',XiptHelperConfiguration::getResetLinkArray());
		$this->assignRef( 'fields' 		, $fields );
		$this->assignRef( 'pagination'	, $pagination );
		return parent::display( $tpl );
    }
	
	function edit($id, $tpl = 'edit' )
	{				
		$params	= $this->getModel()->loadParams($id);

		$lists = array();
		for ($i=1; $i<=31; $i++)
			$qscale[]	= JHTML::_('select.option', $i, $i);
		
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
		);

		$lists['videosSize'] = JHTML::_('select.genericlist',  $videosSize, 'videosSize', 'class="inputbox" size="1"', 'value', 'text', $params->get('videosSize'));
				
		$uploadLimit = ini_get('upload_max_filesize');
		$uploadLimit = JString::str_ireplace('M', ' MB', $uploadLimit);
		
		$this->assign( 'lists', $lists );
		$this->assign( 'uploadLimit' , $uploadLimit );
		$this->assign( 'config'	, $params );
		$this->assign( 'id'	, $id );
		$this->assign( 'jsConfigPath'	, JPATH_ADMINISTRATOR .DS.'components'. DS. 'com_community'.DS.'views'.DS.'configuration'.DS.'tmpl' );
		
		$this->setToolBar();
		// Set the titlebar text		
		return parent::display($tpl);
	}
	
	// set the toolbar according to task	 	 
	function setToolBar($task='display')
	{	
		$task = JRequest::getVar('task',$task,'GET');
		if($task === 'display'){		
			JToolBarHelper::title( JText::_( 'Jom Social Configuration' ), 'configuration' );		
			JToolBarHelper::back('Home' , 'index.php?option=com_xipt');
			return true;
		}
		
		if($task === 'edit'){
			// XITODO : show name of profiltype for which configuration is being edited
			$name 	= JRequest :: getVar('name');	
			JToolBarHelper::title( sprintf(JText::_( 'EDIT CONFIGURATION'),$name), 'configuration' );
			JToolBarHelper::back('Home' , 'index.php?option=com_xipt&view=configuration');
			JToolBarHelper::divider();
			JToolBarHelper::save('save',JText::_('SAVE'));
			JToolBarHelper::cancel( 'cancel', JText::_('CLOSE' ));
			return true;
		}		
	}
	
//	function getGroup( $id )
//	{	
//		if($id==0)
//			return "NONE";
//			
//		$query = new XiptQuery();
//		return $query->select('name')
//					 ->from('#__community_groups')
//					 ->where(" `id` = $id ")
//					 ->dbLoadQuery("", "")
//					 ->loadResult();					
//	}
	
//	function getPrivacyHTML( $name , $selected , $showSelf = false )
//	{
//		$public		= ( $selected == 0 ) ? 'checked="true" ' : '';
//		$members	= ( $selected == 20 ) ? 'checked="true" ' : '';
//		$friends	= ( $selected == 30 ) ? 'checked="true" ' : '';
//		$self		= ( $selected == 40 ) ? 'checked="true" ' : '';
//		
//		$html	= '<input type="radio" value="0" name="' . $name . '" ' . $public . '/> ' . JText::_('Public');
//		$html	.= '<input type="radio" value="20" name="' . $name . '" ' . $members . '/> ' . JText::_('Members');
//		$html	.= '<input type="radio" value="30" name="' . $name . '" ' . $friends . '/> ' . JText::_('Friends');
//		
//		if( $showSelf )
//		{
//			$html	.= '<input type="radio" value="40" name="' . $name . '" ' . $self . '/> ' . JText::_('Self');
//		}
//		return $html;
//	}
	
//	function getFolderPermissionsPhoto( $name , $selected )
//	{		
//		$all		= ( $selected == '0777' ) ? 'checked="true" ' : '';
//		$default	= ( $selected == '0755' ) ? 'checked="true" ' : '';
//
//		$html	 = '<input type="radio" value="0777" name="' . $name . '" ' . $all . '/> ' . JText::_('Enable All (CHMOD 0777)');
//		$html	.= '<input type="radio" value="0755" name="' . $name . '" ' . $default . '/> ' . JText::_('System Default');
//
//		return $html;
//	}
	
//	function getFolderPermissionsVideo( $name , $selected )
//	{		
//		$all		= ( $selected == '0777' ) ? 'checked="true" ' : '';
//		$default	= ( $selected == '0755' ) ? 'checked="true" ' : '';
//
//		$html	 = '<input type="radio" value="0777" name="' . $name . '" ' . $all . '/> ' . JText::_('Enable All (CHMOD 0777)');
//		$html	.= '<input type="radio" value="0755" name="' . $name . '" ' . $default . '/> ' . JText::_('System Default');
//
//		return $html;
//	}
}
