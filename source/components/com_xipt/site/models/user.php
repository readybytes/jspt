<?php

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class XiPTModelUser extends JModel
{

	
	function updateIndividualData( $userid,$what,$value )
	{
		
		$db		=& JFactory::getDBO();
	
		assert($what);
		assert($value);
		$query		= ' UPDATE '. $db->nameQuote('#__xipt_users')
               		 	. ' SET '.$db->nameQuote($what).'='. $db->Quote($value)
				. ' WHERE '.$db->nameQuote('userid').'='.$db->Quote($userid);
		
		$db->setQuery( $query );
		$db->query();

		if($db->getErrorNum())
		{
			JError::raiseError( 500, $db->stderr());
		}
	}
	
	
	function setUserData( $data )
	{
		global $mainframe;
		$validated = true;
		$emptyFields ='';
		if( empty( $data->userid ) ){
				$validated = false;
				$emptyFields .= JText::_('USERID');
		}
		
		if( empty( $data->profiletype ) ){
				$validated = false;
				$emptyFields .= JText::_('PROFILETYPE');
		}
		
		if( empty( $data->template ) ){
				$validated = false;
				$emptyFields .= JText::_('TEMPLATE');
		}
				
			
		if($validated == false)
		{
			$mainframe->enqueueMessage(sprintf(JText::_('FIELDS CAN NOT BE EMPTY'),$emptyFields), 'error');
			return false;
		}
	   
		$db		=& JFactory::getDBO();

		$query		= 'SELECT * FROM '. $db->nameQuote('#__xipt_users')
				. ' WHERE '.$db->nameQuote('userid').'='.$db->Quote($data->userid);

		$db->setQuery( $query );
		$result	= $db->loadObject();
		
		
		if(!$result)
		{
			// New record, insert it.
			$db->insertObject( '#__xipt_users' , $data,'userid' );

			if($db->getErrorNum())
				JError::raiseError( 500, $db->stderr());
		}
		else
		{
			// Old record, update it.
			$db->updateObject( '#__xipt_users' , $data , 'userid');
		}
  }
	



}

class XiPTTableUser extends JTable
{
	var $userid 		= null;
	var $profiletype	= null;
	var $template		= null;

	/**
	 * Constructor
	 */
	function __construct( &$db )
	{
		//userid is ker of xipt_users table
		parent::__construct( '#__xipt_users', 'userid', $db );
	}

}
