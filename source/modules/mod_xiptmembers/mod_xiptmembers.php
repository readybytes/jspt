<?php
	
	/**
	 * @category	Model
	 * @package		JomSocial
	 * @subpackage	Groups 
	 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
	 * @license Copyrighted Commercial Software
	 */
	defined('_JEXEC') or die('Restricted access');
	
	include_once( JPATH_ROOT . DS . 'components' . DS . 'com_community' . DS . 'defines.community.php' );
	require_once( JPATH_ROOT . DS . 'components' . DS . 'com_community' . DS . 'libraries' . DS . 'core.php' );
	require_once( JPATH_ROOT . DS . 'components' . DS . 'com_community' . DS . 'libraries' . DS . 'tooltip.php' );
	require_once( JPATH_ROOT . DS . 'components' . DS . 'com_community' . DS . 'helpers' . DS . 'string.php' );
	require_once (dirname(__FILE__).DS.'helper.php');
	
	CFactory::load( 'libraries','error');
	JPlugin::loadLanguage("mod_xiptmembers");
	JPlugin::loadLanguage( 'com_community', JPATH_ROOT );
	
	$document				=& JFactory::getDocument();
	$usermodel 				=& CFactory::getModel('user');
	$display_limit 			= $params->get('count',10);
	$updated_avatar_only	= $params->get('updated_avatar_only', 0);
	$tooltips 				= $params->get('tooltips', 1);
	$mootools 				= $params->get('loadmootools', 1);
	$profile_type			= $params->get('profile_type');
	
	if($profile_type)
	{
		$row = getLatestMember($display_limit, $updated_avatar_only, $profile_type);
	
		// preload users
		$CFactoryMethod = get_class_methods('CFactory');					
		if(in_array('loadUsers', $CFactoryMethod))
		{
			$uids = array();
			foreach($row as $m)
			{
				$uids[] = $m->id;
			}
			CFactory::loadUsers($uids);
		}
	}
	else
		$row = array();
	
	if(!empty($mootools))
	{	
		JHTML::script('mootools.js', 'media/system/js/', false);
	}
	
$tooltipScript =<<<SHOWJS
window.addEvent('domready', function(){ var JTooltips = new Tips($$('.hasTipLatestMembers'), { maxTitleChars: 50, fixed: false}); });
SHOWJS;

	$type = strtolower('text/javascript'); 
	if(false == isset($document->_script[$type]) || false == JString::stristr($document->_script[$type],$tooltipScript))
	{
		$document->addScriptDeclaration($tooltipScript);	
	}
	
	
	
	require(JModuleHelper::getLayoutPath('mod_xiptmembers'));
