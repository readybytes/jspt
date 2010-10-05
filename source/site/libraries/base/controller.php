<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
jimport( 'joomla.application.component.controller' );

class XiptController extends JController
{
	public function getPrefix()
	{
		if(isset($this->_prefix) && empty($this->_prefix)===false)
			return $this->_prefix;

		$r = null;
		if (!preg_match('/(.*)Controller/i', get_class($this), $r)) {
			XiError::raiseError (500, "XiptController::getName() : Can't get or parse class name.");
		}

		$this->_prefix  =  JString::strtolower($r[1]);
		return $this->_prefix;
	}

	function getName()
	{
		$name = $this->_name;

		if (empty( $name ))
		{
			$r = null;
			if (!preg_match('/Controller(.*)/i', get_class($this), $r)) {
				XiptError::raiseError (500, "XiusController : Can't get or parse class name.");
			}
			$name = strtolower( $r[1] );
		}

		return $name;
	}
	
	public function getView()
	{
		if(isset($this->_view))
			return $this->_view;


		//get Instance from Factory
		$this->_view	= 	XiptFactory::getInstance($this->getName(),'View', $this->getPrefix());

		if(!$this->_view)
			XiptError::raiseError (500, XiusText::_("NOT ABLE TO GET INSTANCE OF VIEW : {$this->getName()}"));

		$layout	= JRequest::getCmd( 'layout' , 'default' );
		$this->_view->setLayout( $layout );		
		
		return $this->_view;
	}
}

