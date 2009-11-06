<?php
/**
 * @category 	Library
 * @package		JomSocial
 * @subpackage	Core 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license http://www.azrul.com Copyrighted Commercial Software
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
include_once(JPATH_ROOT .DS.'components'.DS.'com_community'.DS.'defines.community.php');
include_once(JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'error.php');

class CFactory
{
	
	/**
	 * Function to allow caller to get a user object while
	 * it is not authenticated provided that it has a proper tokenid
	 **/	 
	function &getUserFromTokenId( $tokenId , $userId )
	{
		$db		=& JFactory::getDBO();
		
		$query	= 'SELECT COUNT(*) '
				. 'FROM ' . $db->nameQuote( '#__community_photos_tokens') . ' ' 
				. 'WHERE ' . $db->nameQuote( 'token') . '=' . $db->Quote( $tokenId ) . ' '
				. 'AND ' . $db->nameQuote( 'userid') . '=' . $db->Quote( $userId );

		$db->setQuery( $query );
		
		$count	= $db->loadResult();
		
		// We can assume that the user parsed in correct token and userid. So,
		// we return them the proper user object.

		if( $count >= 1 )
		{
			$user	=& CFactory::getUser( $userId );
			
			return $user;			
		}

		// If it doesn't bypass our tokens, we assume they are really trying
		// to hack or got in here somehow.
		$user	=& CFactory::getUser( null );
		
		return $user;
	}
	/**
	 * Return CUser Object
	 */	 	
	function &getUser($id=null)
	{
		static $instances = array();
		
		if($id === 0)
		{
			$user =& JFactory::getUser(0);
			$id = $user->id;
		}
		else
		{
			if($id == null)
			{
				$user =& JFactory::getUser();
				$id = $user->id;
			}
			
			if($id != null && !is_numeric($id)) 
			{
				//echo 'test'; exit;
				$db		=& JFactory::getDBO();
				$query ="SELECT id FROM #__users WHERE UCASE(`username`) like UCASE(".$db->Quote($id).")";
				$db->setQuery($query);
				$id = $db->loadResult();
			}
		}
			
		if( empty($instances[$id]) )
		{
			if( !is_numeric($id) && !is_null($id)) 
			{
				JError::raiseError( 500, JText::sprintf('CC CANNOT LOAD USER', $id) );
			}
			
			$instances[$id] = new CUser($id);
			$instances[$id]->init();
			$instances[$id]->getThumbAvatar();
			if($id == 0)
			{
				$instances[$id]->name = JText::_('CC ACTIVITIES GUEST');
				$instances[$id]->username = JText::_('CC ACTIVITIES GUEST');
				$instances[$id]->_avatar 	= 'components/com_community/assets/default.jpg';
				$instances[$id]->_thumb 	= 'components/com_community/assets/default_thumb.jpg';
			}
		}
		
		return $instances[$id];
	}
	
	
	/**
	 * Return JomSocial configuration object
	 * 	 
	 * @return	object		JParams object	 
	 */
	function &getConfig()
	{
		return CConfig::getInstance();
	}
	
	
	/**
	 * Return the model object, responsible for all db manipulation. Singleton
	 * 	 
	 * @param	string		model name
	 * @param	string		any class prefix
	 * @return	object		model object	 
	 */	 	
	function &getModel( $name = '', $prefix = '', $config = array() )
	{
		static $modelInstances = null;
		
		if(!isset($modelInstances)){
			$modelInstances = array();
			include_once(JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'error.php');
		}
		
		if(!isset($modelInstances[$name.$prefix]))
		{
			include_once( JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'models'.DS.'models.php');
			
			include_once( JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'models'.DS. JString::strtolower( $name ) .'.php');
			$classname = $prefix.'CommunityModel'.$name;
			$modelInstances[$name.$prefix] =& new $classname;
		}
		
		return $modelInstances[$name.$prefix];
	}

	function &getBookmarks( $uri )
	{
		static $bookmark = null;
		
		if( is_null($bookmark) )
		{
			CFactory::load( 'libraries' , 'bookmarks' );
			$bookmark	= new CBookmarks( $uri );
		}
		return $bookmark;
	}
	
	function &getToolbar()
	{
		static $toolbar = null ;
		
		if( is_null( $toolbar ) )
		{
			CFactory::load( 'libraries' , 'toolbar' );
			
			$toolbar = new CToolbar();
			
		}
		return $toolbar;
	}
	/**
	 * Return the view object, responsible for all db manipulation. Singleton
	 * 	 
	 * @param	string		model name
	 * @param	string		any class prefix
	 * @return	object		model object	 
	 */	 	
	function &getView( $name = '', $prefix = '',$viewType = '')
	{
		static $viewInstances = null;
		
		if(!isset($viewInstances)){
			$viewInstances = array();
			include_once(JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'error.php');
		}
		$viewType = JRequest::getVar('format', 'html', 'REQUEST');
 
		if(empty($viewType)){
			$viewType = JRequest::getVar('format', 'html', 'REQUEST');
		}
		
		if($viewType == 'json')
			$viewType	= 'html';
	
		if(!isset($viewInstances[$name.$prefix.$viewType])){

			include_once( JPATH_COMPONENT . DS . 'views' . DS . $name . DS . 'view.' . $viewType . '.php' );
			//include_once($cms->get_path('root') . DS.'components'.DS.'com_community'.DS.'views'.DS.$name.DS.'view.'.$viewType.'.php');
			
			if( $viewType == 'iphone' )
			{
				$classname = $prefix.'CommunityViewIphone' . JString::ucfirst($name);
			}
			else
			{
				$classname = $prefix.'CommunityView'.JString::ucfirst($name);
			}
			$viewInstances[$name.$prefix.$viewType] =& new $classname;
		}
		
		return $viewInstances[$name.$prefix.$viewType];
	}
		
	/**
	 * return the currently viewed user profile object, 
	 * for now, just return an object with username, id, email
	 * @todo: return a proper user object, with methods etc	  
	 */	 	
	function &getActiveProfile(){
		static $obj = null;
		
		if(!$obj)
		{
			$my = & JFactory::getUser();
			$uid = JRequest::getVar('userid', 0, 'REQUEST');
				
			if($uid == 0)
			{
				$uid = JRequest::getVar('activeProfile', null, 'COOKIE');
			}
			
			$obj =& CFactory::getUser($uid);
		}
		return $obj;
	}
	
	/**
	 * Set current active profile
	 * @param	integer id	Current user id
	 */	 	
	function setActiveProfile($id = '')
	{	
		if( empty($id) )
		{
			$my =& CFactory::getUser();
			$id = $my->id;
		}
		$jConfig	=& JFactory::getConfig();
		$lifetime	= $jConfig->getValue('lifetime');
			
		setcookie('activeProfile', $id, time() + ($lifetime * 60) , '/');
	}

	function unsetActiveProfile()
	{
		$jConfig	=& JFactory::getConfig();
		$lifetime	= $jConfig->getValue('lifetime');
		
		setcookie('activeProfile', false , time() + ($lifetime * 60 ), '/');
	}
		
	function setCurrentURI()
	{
		$uri 		=& JFactory::getURI();
		$current	= $uri->toString();

		setcookie( 'currentURI' , $current , time() + 60 * 60 * 24 , '/' );
	}
	
	function getLastURI()
	{
		$uri	= JRequest::getVar( 'currentURI' , null , 'COOKIE' );
		
		if( is_null( $uri ) )
		{
			$uri	= JURI::root();
		}
		return $uri;
	}
	
	/**
	 * Return the view object, responsible for all db manipulation. Singleton
	 * 	 
	 * @param	string		type	libraries/helper
	 * @param	string		name 	class prefix
	 */	 	
	function load( $type, $name )
	{
		include_once(JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'error.php');
		include_once(JPATH_ROOT.DS.'components'.DS.'com_community'.DS.$type.DS.$name.'.php');
		
		// If it is a library, we call the object and call the 'load' method
		if( $type == 'libraries' )
		{
			$classname = 'C'.$name ;
			if(	class_exists($classname) ) {
				// @todo
			}
		}
	}
		
}

/**
 * Global Asset manager
 */
class CAssets 
{
	/**
	 * Centralized location to attach asset to any page. It avoids duplicate 
	 * attachement
	 */
	function attach( $path, $type , $assetPath = ''){
		
		$document =& JFactory::getDocument();
		if($document->getType() != 'html')
			return;
		
		if( !defined( 'C_ASSET_JQUERY' ) ){ 
			// JQuery has to be added manually since no conflict call must follow
			// immediately
			
			/* Sean: When using addCustomTag(), jquery gets appended after addScript().
			   Logically, jQuery should be loaded before other js files in the asset folder.
			   To use addScript, I appended the noConflict() line to the jquery.js file.  
			   (need this to get future versions of gallery.js working).
			   
			   TODO: Anyway, someone should come up with a better solution.
			*/
			
			$js  = JURI::root().'components/com_community/assets/jquery-1.3.2.pack.js';
			$document->addScript($js);
			define( 'C_ASSET_JQUERY', 1);
		}

		if( !empty($assetPath) )
		{
			$path = $assetPath . $path;
		}
		else
		{		
			$path = JURI::root(). 'components/com_community'.$path;
		}

		if( !defined( 'C_ASSET_' . md5($path) ) ) 
		{
			define( 'C_ASSET_' . md5($path), 1 );
			
			switch( $type )
			{
				case 'js':
					$document->addScript($path);
					break;
					
				case 'css':
					$document->addStyleSheet($path);
			}
		}
	}	 
}	

/**
 * Provide global access to JomSocial configuration and paramaters
 */ 
class CConfig extends JParameter
{
	var $_defaultParam;
	
	/**
	 * Return reference to global config object
	 * 	 
	 * @return	object		JParams object	 
	 */
	function &getInstance()
	{
		static $instance = null;
		if(!$instance)
		{
			jimport('joomla.filesystem.file');
			
			// First we need to load the default INI file so that new configuration,
			// will not cause any errors.
			$ini	= JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_community' . DS . 'default.ini';
			$data	= JFile::read($ini);
			
			$instance = new CConfig($data);

// 			$ini	= JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_community' . DS . 'default.ini';
// 			$data	= JFile::read($ini);
			
//			$instance = new CConfig($data);
			JTable::addIncludePath( JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_community' . DS . 'tables' );
			$config	=& JTable::getInstance( 'configuration' , 'CommunityTable' );
			$config->load( 'config' );
			
			$instance->bind( $config->params );
			// Now we need to override the default INI with the current configuration
// 			$config		= JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_community' . DS . 'config.ini';
// 			$data		= JFile::read( $config );
			
			// Rebind the current configuration values
			//$instance->bind( $data );
		}
		
		return $instance;
	}
	
	/**
	 * Get a value
	 *
	 * @access	public
	 * @param	string The name of the param
	 * @param	mixed The default value if not found
	 * @return	string
	 * @since	1.5
	 */
	function get($key, $default = '', $group = '_default')
	{
		$defaultVal = array();
		if(empty($default))
			$default = @$defaultVal[$key];
		
		$value = parent::get($key, $default, $group);
		return $value;
	}
}

jimport( 'joomla.plugin.plugin' );

class CApplications extends JPlugin
{
	//@todo: Do some stuff so the childs get inheritance?
	var $params	= '';

	function CApplications(& $subject, $config = null)
	{
		// Set the params for the current object
		parent::__construct($subject, $config);
		//$this->_getUserParams(  );
	}

	/**
	 * Function is Deprecated.
	 * -	 Should only be used in profile area.
	 **/	 	
	function loadUserParams()
	{
		$model	=& CFactory::getModel( 'apps' );
		$user	=& CFactory::getActiveProfile();
		$appName = $this->_name;

		$params	= $model->getUserAppParams( $model->getUserApplicationId( $appName , $user->id ) );

		$this->userparams	= new JParameter( $params );
	}
}

class CUser extends JUser {
	
	var $_userid	= 0;
	var $_status = '';
	var $_cparams		= null;
	var $_tooltip		= null;
	var $_points		= 0;
	var $_init			= false;
	var $_thumb			= '';
	var $_avatar		= '';
	var $_isonline		= false;
	var $_view			= 0;
	var $_posted_on		= null;
	var $_invite		= 0;
	var $_friendcount	= 0;
	
	/**
	 * Constructor.
	 * Perform a shallow copy of JUser object	 
	 */	 	
	function CUser($id){
		
		if($id == null) {
			$user =& JFactory::getUser($id);
			$id = $user->id;
		}
			
		$this->id = $id;	
	}
	
	/**
	 * Method to set the property when the properties are already
	 * assigned
	 * 
	 * @param property	The property value that needs to be changed
	 * @param value		The value that needs to be set
	 * 	 	 	 	 	 
	 **/	 	 	
	function set( $property , $value )
	{
		CError::assert( $property , '' , '!empty' , __FILE__ , __LINE__ );
		$this->$property	= $value;
	}
	
	function delete()
	{
		$db		=& JFactory::getDBO();
		
		$query	= 'DELETE FROM ' . $db->nameQuote( '#__community_users' ) . ' '
				. 'WHERE ' . $db->nameQuote( 'userid' ) . '=' . $db->Quote( $this->id );
		$db->setQuery( $query );
		$db->query();
		
		return parent::delete();
	}

	function getAppParams( $appName )
	{
		$model	=& CFactory::getModel( 'apps' );
		$params	= $model->getUserAppParams( $model->getUserApplicationId( $appName , $this->id ) );
		$params	= new JParameter( $params );
		
		return $params;
	}
	
	/**
	 * Inititalize the user JUser object
	 */	 	
	function init() {
		if(!$this->_init) {
			$db		=& JFactory::getDBO();
			$query  = "SELECT  "
					. "	a.`userid` as _userid , "
					. "	a.`status` as _status , "
					. "	a.`points`	as _points, "
					. "	a.`posted_on` as _posted_on, " 	
					. "	a.`avatar`	as _avatar , "
					. "	a.`thumb`	as _thumb , "
					. "	a.`invite`	as _invite, "
					. "	a.`params`	as _cparams,  "
					. "	a.`view`	as _view, "
					. " a.`friendcount` as _friendcount, "
					. "s.`userid` as _isonline, u.* "
					. " FROM #__community_users as a "
					. " LEFT JOIN #__users u "
		 			. " ON u.`id`=a.`userid` "
					. " LEFT OUTER JOIN #__session s "
		 			. " ON s.`userid`=a.`userid` "
					. "WHERE a.`userid`='{$this->id}'";
					
			$db->setQuery($query);
			$obj = $db->loadObject();

			// Initialise new user
			// @todo: trigger event onProfileInit
			if(empty($obj))
			{
				if( !$obj && ($this->id != 0) )
				{
					// @rule: ensure that the id given is correct and exists in #__users
					$existQuery	= 'SELECT COUNT(1) FROM ' . $db->nameQuote( '#__users' ) . ' '
								. 'WHERE ' . $db->nameQuote( 'id' ) . '=' . $db->Quote( $this->id );
							
					$db->setQuery( $existQuery );

					$isValid	= $db->loadResult() > 0 ? true : false;
					
					if( $isValid )
					{
						// We need to create a new record for this specific user first.
						$config	=& CFactory::getConfig();
						
						$obj = new stdClass();
						
						// @todo: get all the values from $default values;
						$obj->userid	= $this->id;
						$obj->points	= $this->_points;
						$obj->thumb		= $this->_getMediumAvatar();
						$obj->avatar	= $this->_getLargeAvatar();
						
						// Load default params				
						$obj->params = "notifyEmailSystem=" . $config->get('privacyemail') . "\n"
									 . "privacyProfileView=" . $config->get('privacyprofile') . "\n"
									 . "privacyPhotoView=" . $config->get('privacyphotos') . "\n"
									 . "privacyFriendsView=" . $config->get('privacyfriends') . "\n"
									 . "privacyVideoView=1\n"
									 . "notifyEmailMessage=" . $config->get('privacyemailpm') . "\n"
									 . "notifyEmailApps=" . $config->get('privacyapps') . "\n"
									 . "notifyWallComment=" . $config->get('privacywallcomment') . "\n";
						
						$db->insertObject( '#__community_users' , $obj );
		
						if($db->getErrorNum())
						{
							JError::raiseError( 500, $db->stderr());
					    }
					    
					    // Reload the object
						$db->setQuery($query);
						$obj = $db->loadObject();
					}
					
				}
			}

			$thisVars = get_object_vars($this);
			$objVars = get_object_vars($obj);
			
			if($objVars) {
				
				// load cparams
				$this->_cparams = new JParameter($objVars['_cparams']);
				unset($objVars['_cparams']);
				
				// load user params
				$this->_params = new JParameter($objVars['params']);
				unset($objVars['params']);
				
				//print_r($this->_cparams); exit;
				foreach( $thisVars as $key=>$val ) {
					// @todo: if null, we should load default values
					
					if( isset($objVars[$key]) ) {
						$this->$key = $objVars[$key] ;
					} 				
				}
				
				// Looks like we have to do this manually
			}
				
			$this->_init = true;
			
		}

	}
	
	/**
	 * Return current user status
	 * @return	string	user status	 
	 */	 	
	function getStatus($user = null){
		return $this->_status;
	}
	
	function getViewCount(){
		return $this->_view;
	}
	
	/**
	 * Return the html formatted tooltip
	 */	 	
	function getTooltip()
	{
		if(!$this->_tooltip)
		{
			require_once( JPATH_ROOT . DS . 'components' . DS . 'com_community' . DS . 'libraries' . DS . 'tooltip.php' );
			$this->_tooltip =  cAvatarTooltip($this);
		}
		return $this->_tooltip;
	}
	
	/**
	 *
	 */	 	
	function getKarmaPoint() {
		return $this->_points;
	} 
	
	/**
	 * Return the the name for display, either username of name based on backend config
	 */	 	
	function getDisplayName() {
		$config =& CFactory::getConfig();
		$nameField = $config->get('displayname'); 
		return $this->$nameField;
	}

	/**
	 * Return the count of the friends
	 **/	 	
	function getFriendCount()
	{
		return $this->_friendcount;
	}
	
	/**
	 * @todo: wrap the get functions for both the image types since they are quite identical
	 **/
	function _getImage()
	{
	}
		 	
	/**
	 * Return path to avatar image
	 **/
	function getAvatar()
	{
		return JURI::root() . $this->_avatar;	
	}
	
	/**
	 * Return the custom profile data based on the given field code
	 *
	 * @param	string	$fieldCode	The field code that is given for the specific field.
	 */	 	
	function getInfo( $fieldCode )
	{
		// Run Query to return 1 value
		$db =& JFactory::getDBO();

		$query	= 'SELECT b.value FROM ' . $db->nameQuote( '#__community_fields' ) . ' AS a '
				. 'INNER JOIN ' . $db->nameQuote( '#__community_fields_values' ) . ' AS b '
				. 'ON b.field_id=a.id '
				. 'AND b.user_id=' . $db->Quote( $this->id ) . ' '
				. 'WHERE a.fieldcode=' . $db->Quote( $fieldCode );
		
		$db->setQuery( $query );
		
		$value	= $db->loadResult();

		if($db->getErrorNum())
		{
			JError::raiseError( 500, $db->stderr());
		}
		return $value;
	}
	
		/**
	 * Return path to avatar image
	 **/
	function _getLargeAvatar()
	{
		//@compatibility: For older releases
		// can be removed at a later time.
		if( empty( $this->_avatar ) && ($this->id != 0) )
		{
			//@todo: when this code is removed, we should test if $this->_avatar is empty, then use
			// default guest image.
			
			// Copy old data.
			$model	=& CFactory::getModel( 'avatar' );

			// Save new data.
			$this->_avatar	= $model->getLargeImg( $this->id );

			// We only want the relative path , specific fix for http://dev.jomsocial.com
			$this->_avatar	= JString::str_ireplace( JURI::base() , '' , $this->_avatar );
			
			// Test if this is default image as we dont want to save default image
			if( JString::stristr( $this->_avatar , 'default.jpg' ) === FALSE )
			{
				$userModel	=& CFactory::getModel( 'user' );

				// Fix the .jpg_thumb for older release
				$userModel->setImage( $this->id , $this->_avatar , 'avatar' );
			}
			else
			{
				return $this->_avatar;
			}
		}
		
		return $this->_avatar;		
	}
		 
		 
	/**
	 * Return path to thumb image
	 */
	function getThumbAvatar()
	{
		return JURI::root() . $this->_thumb;
	}
	
	
	function _getMediumAvatar()
	{
		//@compatibility: For older releases
		// can be removed at a later time.
		if( empty( $this->_thumb ) && ($this->id != 0) )
		{
			//@todo: when this code is removed, we should test if $this->_avatar is empty, then use
			// default guest image.
			
			// Copy old data.
			$model	=& CFactory::getModel( 'avatar' );

			// Save new data.
			$this->_thumb	= $model->getSmallImg( $this->id );

			// We only want the relative path , specific fix for http://dev.jomsocial.com
			$this->_thumb	= JString::str_ireplace( JURI::base() , '' , $this->_thumb );

			// Test if this is default image as we dont want to save default image
			if( JString::stristr( $this->_thumb , 'default_thumb.jpg' ) === FALSE )
			{
				$userModel	=& CFactory::getModel( 'user' );

				// Fix the .jpg_thumb for older release
				$userModel->setImage( $this->id , $this->_thumb , 'thumb' );
			}

		}
		
		return $this->_thumb;
	}
	/**
	 * Return the combined params of JUser and CUser
	 * @return	JParameter	 
	 */	 	
	function &getParams()
	{
		return $this->_cparams;
	}
	
	function isOnline() {
		return ($this->_isonline != null);
	} 

	/**
	 * Check if the user is blocked
	 *
	 * @param	null
	 * return	boolean True user is blocked
	 */	 
	function isBlocked()
	{
		return ( $this->block == '1' );
	}	
	/**
	 * Increment view count
	 */	 	
	function viewHit(){
		$db		=& JFactory::getDBO();
		$query = 'UPDATE `#__community_users`'
		. ' SET `view` = ( `view` + 1 )'
		. ' WHERE `userid`=' . $this->id;
		$db->setQuery( $query );
		$db->query();
		$this->_view++;
	}
	
	/**
	 * Store the user data.
	 * @params	string group	If specified, jus save the params for the given
	 * 							group								 	 
	 */	 	
	function save( $group ='' ){
// 		if( empty($group) ){
			parent::save();
			
			// Store our own data
			$obj = new stdClass();
			
			$obj->userid    = $this->id;
			$obj->status    = $this->_status;
			$obj->points    = $this->_points;
			$obj->posted_on = $this->_posted_on;
			$obj->avatar    = $this->_avatar;
			$obj->thumb     = $this->_thumb;
			$obj->invite    = $this->_invite;
			$obj->params	= $this->_cparams->toString();
			
			$model =& CFactory::getModel('user');
			$model->updateUser($obj);
			
// 		} else {
// 			switch($group){
// 				case 'params':
// 					// Just save the params
// 					$model =& CFactory::getModel('user');
// 					$model->setParams($this->_cparams, $this->id);
// 					break;
// 			}
// 		}
	}

	
	/**
	 * Sets the status for the current user
	 **/
	function setStatus( $status = '' )
	{
		if( $this->id != 0 )
		{
			$this->set( '_status' , $status );
			$this->save();
		}
	}
}

class CRoute 
{
	var $menuname = 'mainmenu';

	/**
	 * Method to wrap around getting the correct links within the email
	 * DEPRECATED since 1.5
	 */
	function emailLink( $url , $xhtml = false )
	{
		return CRoute::getExternalURL( $url , $xhtml );
	}

	/**
	 * Method to wrap around getting the correct links within the email
	 * 
	 * @return string $url
	 * @param string $url
	 * @param boolean $xhtml
	 */	
	function getExternalURL( $url , $xhtml = false )
	{
		$uri	=& JURI::getInstance();
		$base	= $uri->toString( array('scheme', 'host', 'port'));
		
		return $base . CRoute::_( $url , $xhtml );
	}
	
	function getURI()
	{
		$url		= '';
		
		// In the worst case scenario, QUERY_STRING is not defined at all.
		$url		.= 'index.php?';
		$segments	=& $_GET;
			
		$i			= 0;
		$total		= count( $segments );
		foreach( $segments as $key => $value )
		{
			++$i;
			$url	.= $key . '=' . $value;
			
			if( $i != $total )
			{
				$url	.= '&';
			}					
		}

		// @rule: clean url
		$url	= urldecode( $url );
		$url 	= str_replace('"', '&quot;',$url);
		$url 	= str_replace('<', '&lt;',$url);
		$url	= str_replace('>', '&gt;',$url);
		$url	= preg_replace('/eval\((.*)\)/', '', $url);
		$url 	= preg_replace('/[\\\"\\\'][\\s]*javascript:(.*)[\\\"\\\']/', '""', $url);
 		
		return CRoute::_( $url );
	}
	
	/**
	 * Wrapper to JRoute to handle itemid
	 * We need to try and capture the correct itemid for different view	 
	 */	 	
	function _($url, $xhtml = true, $ssl = null) 
	{
		
		static $itemid = array();

		parse_str($url);
		if(empty($view))
			$view = 'frontpage';
		
		if(empty($itemid[$view])) {
			global $Itemid;
			$isValid = false;
			
			// If the current Itemid match the expected Itemid based on view
			// we'll just use it 
			$db		=& JFactory::getDBO();
			$viewId =CRoute::_getViewItemid($view);
			if($viewId === $Itemid && !is_null($viewId)) {
				$itemid[$view] = $Itemid;
				$isValid = true;
			} else if($viewId !== 0 && !is_null($viewId)){
				$itemid[$view] = $viewId;
				$isValid = true;
			}
			
// 			if(!$isValid){
// 				// See if current itemid is for com_community component, if yes, use it
// 				$query  = "SELECT count(*) FROM #__menu WHERE `link` LIKE '%option=com_community%' AND `id`={$db->quote($Itemid)}";					
// 				$db->setQuery($query);
// 				$isValid = $db->loadResult();
// 			}
// 			
// 			if($isValid) {
// 				$itemid[$view] = $Itemid;
// 			} 
			
			if(!$isValid){
				$id = CRoute::_getDefaultItemid();
				if($id !== 0 && !is_null($id)) {
					$itemid[$view] =$id;
				}
				$isValid = true;
			}
			
			// Search the mainmenu for the 1st itemid of jomsocial we can find
			if(!$isValid){
				$query  = "SELECT `id` FROM #__menu WHERE "
					." `link` LIKE '%option=com_community%' "
					." AND `published`='1' "
					." AND `menutype`='{CRoute::menuname}' ";					
				$db->setQuery($query);
				$isValid = $db->loadResult();
				if(!empty($isValid))
					$itemid[$view] = $isValid;
			}
			
			
			
			
			// If not in mainmenu, seach in any menu
			if(!$isValid){
				$query  = "SELECT `id` FROM #__menu WHERE "
					." `link` LIKE '%option=com_community%' "
					." AND `published`='1' ";					
				$db->setQuery($query);
				$isValid = $db->loadResult();	
				if(!empty($isValid))
					$itemid[$view] = $isValid;
			}
			
			
		}
		
		$pos = JString::strpos($url, '#');
		if ($pos === false)
		{
			if( isset( $itemid[$view] ) )
				$url .= '&Itemid='.$itemid[$view];
		}
		else 
		{
			if( isset( $itemid[$view] ) )
				$url = JString::str_ireplace('#', '&Itemid='.$itemid[$view].'#', $url);
		}		
		
		return JRoute::_($url, $xhtml, $ssl); 
	}
	
	/**
	 * Return the Itemid specific for the given view. 
	 */	 	
	function _getViewItemid($view) {
		$db		=& JFactory::getDBO();
		
		$url = $db->quote('%option=com_community&view=' . $view . '%');
		
		$query  = 'SELECT id FROM #__menu WHERE `link` LIKE ' . $url . ' AND `published`=1';					
		$db->setQuery($query);
		$val = $db->loadResult();
		return $val;
	}
	
	/**
	 * Retrieve the Itemid of JomSocial's menu. If you are creating a link to JomSocial, you
	 * will need to retrieve the Itemid.
	 **/	 	
	function getItemId()
	{
		return CRoute::_getDefaultItemid();
	}
	
	/**
	 * Return the Itemid for default view, frontpage
	 */	 	
	function _getDefaultItemid()
	{
		$db		=& JFactory::getDBO();
		
		$url = $db->quote("index.php?option=com_community&view=frontpage");
		
		$query  = "SELECT id FROM #__menu WHERE `link` = {$url} AND `published`=1";					
		$db->setQuery($query);
		$val = $db->loadResult();
		
		if(!$val)
		{
			$url = $db->quote("%option=com_community%");
			
			$query  = "SELECT id FROM #__menu WHERE `link` LIKE {$url} AND `published`=1";					
			$db->setQuery($query);
			$val = $db->loadResult();
		}
		return $val;
	}
}
