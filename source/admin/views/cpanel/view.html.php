<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// Disallow direct access to this file
if(!defined('_JEXEC')) die('Restricted access');
		
class XiptViewCpanel extends XiptView
{	
	function display($tpl = null)
	{
		$this->setToolbar();

		parent::display( $tpl );
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
		JToolBarHelper::title( XiptText::_( 'CONTROL_PANEL' ), 'xipt' );
	}
	
	function addIcon( $image , $url , $text , $newWindow = false )
	{	
		$newWindow	= ( $newWindow ) ? ' target="_blank"' : '';
		
		$this->assign('image',$image);
		$this->assign('url',$url);
		$this->assign('text',$text);
		$this->assign('newWindow',$newWindow);

		return $this->loadTemplate('addicon');
	}
	
	function aboutus($tpl = 'aboutus')
	{
		return $this->display( $tpl);
	}
}
?>