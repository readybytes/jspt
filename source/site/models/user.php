<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');

class XiptModelUser extends XiptModel
{
	function updateIndividualData( $userid,$what,$value )
	{
		
		$db		=& JFactory::getDBO();
	
		XiptLibUtils::XAssert($what);
		XiptLibUtils::XAssert($value);
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
		$db		=& JFactory::getDBO();
		$query	= 'SELECT * FROM '. $db->nameQuote('#__xipt_users')
				. ' WHERE '.$db->nameQuote('userid').'='.$db->Quote($data->userid);

		$db->setQuery( $query );
		$result	= $db->loadObject();
		
		
		if($result)
		    $db->updateObject( '#__xipt_users', $data, 'userid');
		else
		    $db->insertObject( '#__xipt_users', $data, 'userid' );
		
		if(!$db->getErrorNum())
		    return true;
		
		JError::raiseError( 500, $db->stderr());
		return false;
	}
}

class XiptTableUser extends XiptTable
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
