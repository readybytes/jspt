<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiptViewUsers extends XiptView
{
	function display($tpl = null)
	{
		$userModel	= $this->getModel();
		
		$pagination	= $userModel->getPagination();
		$users		= $userModel->getUsers(0, $pagination->limit, $pagination->limitstart);
		$search		= JRequest::getVar( 'search' , '' );
		
		$ptypeModel		= $this->getModel('profiletypes');
		$allPtypes		= $ptypeModel->loadRecords(0);
		$selectedPtype	= JRequest::getVar( 'profiletype' , 'all' , 'POST' );
		
		$filter_order_Dir	= JRequest::getVar( 'filter_order_Dir' , 'name' );
		$filter_order		= JRequest::getVar( 'filter_order' , '' );
		
		$this->setToolbar();
		
		$this->assignRef( 'users' 			, $users );
		$this->assignRef( 'pagination'		, $pagination );
		$this->assignRef( 'search'			, $search );
		$this->assignRef( 'selectedPtype' 	, $selectedPtype );
		$this->assignRef( 'allPtypes'		, $allPtypes );
		$this->assignRef( 'order_Dir'		, $filter_order_Dir );
		$this->assignRef( 'order'			, $filter_order );
		
		return parent::display( $tpl );
    }

	function search( $tpl = null )
	{
	    if( $this->getLayout() == 'edit' )
		{
			$this->edit( $tpl );
			return;
		}
		else
		{
			$this->display( $tpl );
			return;
		}
	}
	
	function setToolBar($task='display')
	{
		// Set the titlebar text
		JToolBarHelper::title( XiptText::_( 'USERS' ), 'users' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt');

		if($task === 'edit'){
			JToolBarHelper::apply('apply', 'COM_XIPT_APPLY');
			JToolBarHelper::save('save','COM_XIPT_SAVE');
			JToolBarHelper::cancel( 'cancel', 'COM_XIPT_CLOSE' );
			return true;
		}
	}

	function edit($id=0, $tpl='edit')
	{
		$userModel	= $this->getModel();
		$user		= $userModel->getUsers($id);
		$ptype		= XiptLibProfiletypes::getUserData($id, 'PROFILETYPE');
		$template	= $this->getUserInfo($id, 'TEMPLATE');
		$this->setToolbar($tpl);
		
		$this->assignRef( 'user' 		, $user );
		$this->assignRef( 'ptype' 		, $ptype );
		$this->assignRef( 'template' 	, $template );
		return parent::display($tpl);
	}
	
	function getUserInfo($userid = 0, $what = 'PROFILETYPE')
	{
		$result = XiptLibProfiletypes::getUserData($userid, $what);
		
		//if what = profiletype, return its name
		if($what == 'PROFILETYPE')
			$result = XiptLibProfiletypes::getProfiletypeName($result);
		
		return $result;
	}
}
?>