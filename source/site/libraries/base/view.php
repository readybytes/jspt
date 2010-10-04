<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
jimport( 'joomla.application.component.view');
jimport('joomla.html.pane');

abstract class XiptView extends JView
{	
	/*
	 * Collect prefix auto-magically
	 */
	public function getPrefix()
	{
		if(isset($this->_prefix) && empty($this->_prefix)===false)
			return $this->_prefix;

		$r = null;
		if (!preg_match('/(.*)View/i', get_class($this), $r)) {
			XiptError::raiseError (500, "XiView::getPrefix() : Can't get or parse class name.");
		}

		$this->_prefix  =  JString::strtolower($r[1]);
		return $this->_prefix;
	}
	
	
	/*
	 * We need to override joomla behaviour as they differ in
	 * Model and Controller Naming	 
	 */
	function getName()
	{
		$name = $this->_name;

		if (empty( $name ))
		{
			$r = null;
			if (!preg_match('/View(.*)/i', get_class($this), $r)) {
				XiptError::raiseError (500, "Can't get or parse class name.");
			}
			$name = strtolower( $r[1] );
		}

		return $name;
	}
}