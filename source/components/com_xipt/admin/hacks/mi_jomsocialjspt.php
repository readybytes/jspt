<?php
/**
 * @version $Id: mi_jomsocialjspt.php 16 2007-07-01 12:07:07Z mic $
 * @subpackage Micro Integrations - Jomsocial-JSPT
 * @copyright 2009 Shyam Verma
 * @author Meenal Devpura <admin@joomlaxi.com> & Team Joomlaxi - http://www.joomlaxi.com
 *
 */

// Dont allow direct linking
( defined('_JEXEC') || defined( '_VALID_MOS' ) ) or die( 'Direct Access to this location is not allowed.' );

define( '_AEC_MI_NAME_JOMSOCIALJSPT',		'JomSocial-JSPT' );
define( '_AEC_MI_DESC_JOMSOCIALJSPT',		'Choose the default profile type for a user.' );
define( '_MI_MI_JOMSOCIALJSPT_SET_PROFILETYPE_NAME',				'Set JSPT Profiletype' );
define( '_MI_MI_JOMSOCIALJSPT_SET_PROFILETYPE_DESC',				'Choose Yes if you want this MI to set the profiletype when it is called.' );
define( '_MI_MI_JOMSOCIALJSPT_PROFILETYPE_NAME',					'Select Profile Type Name' );
define( '_MI_MI_JOMSOCIALJSPT_PROFILETYPE_DESC',					'The Profile type name that you want the user to be in.' );
define( '_MI_MI_JOMSOCIALJSPT_SET_PROFILETYPE_AFTER_EXP_NAME',			'Set Expiration profiletype.' );
define( '_MI_MI_JOMSOCIALJSPT_PROFILETYPE_AFTER_EXP_NAME',			'Expiration profiletype' );
define( '_MI_MI_JOMSOCIALJSPT_SET_PROFILETYPE_AFTER_EXP_DESC',			'Choose Yes if you want this MI to set the profile type when the calling payment plan expires.' );
define( '_MI_MI_JOMSOCIALJSPT_PROFILETYPE_AFTER_EXP_DESC',			'The Profile type name that you want the user to be in when plan expires.' );

class mi_jomsocialjspt
{
	function Info()
	{
		$info = array();
		$info['name'] = _AEC_MI_NAME_JOMSOCIALJSPT;
		$info['desc'] = _AEC_MI_DESC_JOMSOCIALJSPT;

		return $info;
	}

	function detect_application()
	{
		global $mosConfig_absolute_path;
		if(is_dir( $mosConfig_absolute_path . '/components/com_community' ) 
			&& is_dir( $mosConfig_absolute_path . '/components/com_jsprofiletype' ))
				return 1;
		else
				return 0;
	}

	function Settings()
	{
		global $database;
		$database	=& JFactory::getDBO();
        $settings = array();
		//$settings['set_profiletype']			= array( 'list_yesno' );
		$settings['profiletype']				= array( 'list' );
		//$settings['set_profiletype_after_exp']	= array( 'list_yesno' );
		$settings['profiletype_after_exp'] 		= array( 'list' );
		
		$query = ' SELECT `id`, `name` '
			 	. ' FROM #__community_profiletypes';
	 	$database->setQuery( $query );
	 	$profiletypes = $database->loadObjectList();
		
		$spt = array();
		$spte = array();

		$ptype = array();
		foreach( $profiletypes as $profiletype ) {
			$ptype[] = mosHTML::makeOption( $profiletype->id, $profiletype->name );
			if ( !empty( $this->settings['profiletype'] ) ) {
				if ( in_array( $profiletype->id, $this->settings['profiletype'] ) ) {
					$spt[] = mosHTML::makeOption( $profiletype->id, $profiletype->name );
				}
			}
			
			if ( !empty( $this->settings['profiletype_after_exp'] ) ) {
				if ( in_array( $profiletype->id, $this->settings['profiletype_after_exp'] ) ) {
					$spte[] = mosHTML::makeOption( $profiletype->id, $profiletype->name );
				}
			}
		}
		
		$settings['lists']['profiletype']			= mosHTML::selectList( $ptype, 'profiletype[]', 'size="4"' , 'value', 'text', $spt );
		$settings['lists']['profiletype_after_exp'] 	= mosHTML::selectList( $ptype, 'profiletype_after_exp[]', 'size="4"', 'value', 'text', $spte );
		
		return $settings;
	}
	
	function action( $request )
	{
		if ( !empty( $this->settings['profiletype'] ) ) {
				$this->setUserProfiletype( $request->metaUser->userid, $this->settings['profiletype'][0] );
		}

		return true;
	}
	
	function expiration_action( $request )
	{
		if ( !empty( $this->settings['profiletype_after_exp'] ) ) {
				$this->setUserProfiletype( $request->metaUser->userid, $this->settings['profiletype_after_exp'][0] );
		}

		return true;
	}
	
	
	function setUserProfiletype($userId,$pId)
	{
		global $database;
		static $instances = array();
		$database	=&	JFactory::getDBO();
		$query 		= 'SELECT * FROM #__community_users'.' '
						. 'WHERE `id`='.$userId;
		
		$database->setQuery( $query );
		$result = $database->loadObjectlist();
		if(!empty($result))
		{
			require_once ( JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'profiletypes.php');
			CProfiletypeLibrary::setProfileDataForUserID($userId,$pId, 'ALL');
		}
		else
		{
			require_once ( JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');
			$instances[$id] = new CUser($userId);
			$instances[$id]->init();
			$instances[$id]->getThumbAvatar();
			require_once ( JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'profiletypes.php');
			CProfiletypeLibrary::setProfileDataForUserID($userId,$pId, 'ALL');
		}
	}
	
	function saveparams( $request )
	{
		//save all data in community_jspt_aec table
		$database = &JFactory::getDBO();
		$planid = $this->id;
		$mi_jspthandler = new jomsocialjspt_restriction( $database );
		$id = $mi_jspthandler->getIDbyPlanId( $planid );
		$mi_id = $id ? $id : 0;
		$mi_jspthandler->load( $mi_id );

		$mi_jspthandler->planid = $planid;
		$mi_jspthandler->profiletype = $request['profiletype'][0];
		
		$mi_jspthandler->check();
		$mi_jspthandler->store();

		return $request;
	}
	
}


class jomsocialjspt_restriction extends JTable {
	/** @var int Primary key */
	var $id						= null;
	/** @var int */
	var $planid		 			= null;
	/** @var int contain micro-integration id  */
	var $profiletype 			= null;
	/** @var int */

	function jomsocialjspt_restriction( &$db ) {
		parent::__construct( '#__community_jspt_aec', 'id', $db );
	}
	
	function getIDbyPlanId( $planid ) {
		$db = &JFactory::getDBO();

		$query = 'SELECT '.$db->nameQuote('id')
			. ' FROM '.$db->nameQuote('#__community_jspt_aec')
			. ' WHERE '.$db->nameQuote('planid').'=' .$db->Quote($planid);
		
		$db->setQuery( $query );
		return $db->loadResult();
	}
}

?>