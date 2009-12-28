<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

class XiPTTableAclRules extends JTable
{

	var $id					= null;
	var $rulename			= null;
	var $pid				= null;
	var $otherpid			= null;
	var $feature			= null;
	var $taskcount 			= null;
	/*TODO : Will include this feature in next releases.
  	var $objectid			= null;
	var $userid				= null;
		*/	
	var $redirecturl		= null;
	var $message			= null;
	var $published			= null;
	
	function __construct(&$db)
	{
		parent::__construct('#__xipt_aclrules','id', $db);
	}
	
	/**
	 * Overrides Joomla's load method so that we can define proper values
	 * upon loading a new entry
	 * 
	 * @param	int	id	The id of the field
	 * @param	boolean isGroup	Whether the field is a group
	 * 	 
	 * @return boolean true on success
	 **/
	function load( $id )
	{
		// ID exist 
		if($id){
			return parent::load( $id );
		}
		
		// load the default value for new object 
		$this->id			= 0;
		$this->rulename		= '';
		$this->pid			= '';
		$this->otherpid		= '0';
		$this->feature		= '';
		$this->taskcount	= '0';
		$this->redirecturl	= 'index.php?option=com_community';
		$this->message		= JText::_('YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE');
		$this->published	= true;
		return true;
	}

	/**
	 * Overrides Joomla's JTable store method so that we can define proper values
	 * upon saving a new entry
	 * 
	 * @return boolean true on success
	 **/
	function store( )
	{
 		return 	parent::store();
	}

	/**
	 * Bind AJAX data into object's property
	 * @param	array	data	The data for this field
	 **/
	function bindAjaxPost( $data )
	{
			$this->rulename			= $data['rulename'];
			$this->pid				= $data['profiletype'];
			$this->otherpid			= $data['otherprofiletype'];
			$this->feature			= $data['feature'];
			$this->taskcount		= $data['taskcount'];
			$this->redirecturl		= $data['redirecturl'];
			$this->message			= $data['message'];
			$this->published		= $data['published'];
	}
}