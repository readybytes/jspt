<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// Disallow direct access to this file
if(!defined('_JEXEC')) die('Restricted access');
		
class XiptViewInstall extends XiptView
{	
	function display($tpl = null)
	{
		$this->setToolBar();
		parent::display( $tpl );
	}
	
	function setToolBar()
	{
		// Set the titlebar text
		JToolBarHelper::title( XiptText::_( 'INSTALLATION_SUCCESSFUL' ), 'xipt' );
	}
}
?>
