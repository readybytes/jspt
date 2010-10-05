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
		?>
		<style type="text/css">
		#toolbar-aboutus
		{
	 		background-image:  url(../components/com_xipt/assets/images/icon-aboutus.png);
	 		background-repeat:no-repeat;
	 		background-position: top center;
	 	}
		</style>
		<?php 
		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'CONTROL PANEL' ), 'Xipt' );
		JToolBarHelper::back('Home' , 'index.php?option=com_xipt');
		JToolBarHelper::custom('aboutus','aboutus','',JText::_('ABOUT US'),0,0);
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
