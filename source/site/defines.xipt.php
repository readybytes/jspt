<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

define('XIPT_VERSION','@global.version@.@svn.lastrevision@');
define('XIPT_NOT_DEFINED','XIPT_NOT_DEFINED');
define('XIPT_NONE','XIPT_NONE');


define('PROFILETYPE_FIELD_TYPE_NAME','profiletypes');
define('TEMPLATE_FIELD_TYPE_NAME','templates');


define('PROFILETYPE_FIELD_IN_USER_TABLE','profiletype');
define('TEMPLATE_FIELD_IN_USER_TABLE','template');

// we will refer our custom fields this way. this will be unique
define('TEMPLATE_CUSTOM_FIELD_CODE','XIPT_TEMPLATE');
define('PROFILETYPE_CUSTOM_FIELD_CODE','XIPT_PROFILETYPE');

//define watermark and thumb size
define('WATERMARK_HEIGHT',40);
define('WATERMARK_WIDTH',40);
define('WATERMARK_HEIGHT_THUMB',16);
define('WATERMARK_WIDTH_THUMB',16);

//define avatar sizes
define('AVATAR_HEIGHT',160);
define('AVATAR_WIDTH',160);
define('AVATAR_HEIGHT_THUMB',64);
define('AVATAR_WIDTH_THUMB',64);

define('REG_PROFILETYPE_AVATAR_HEIGHT',120);
define('REG_PROFILETYPE_AVATAR_WIDTH',120);

define('PTYPE_POPUP_WINDOW_WIDTH_RADIO',240);
define('PTYPE_POPUP_WINDOW_HEIGHT_RADIO',350);
define('PTYPE_POPUP_WINDOW_WIDTH_SELECT',160);
define('PTYPE_POPUP_WINDOW_HEIGHT_SELECT',140);

define('SYNCUP_USER_LIMIT',1000);
define('DEFAULT_AVATAR','components/com_community/assets/default.jpg');
define('DEFAULT_AVATAR_THUMB','components/com_community/assets/default_thumb.jpg');

define('DEFAULT_DEMOAVATAR','components/com_xipt/assets/images/default_avatar.png');
define('DEFAULT_DEMOAVATAR_THUMB','components/com_xipt/assets/images/default_thumb.png');

//where to store profiletype avatars
define('PROFILETYPE_AVATAR_STORAGE_REFERENCE_PATH', 'images' . DS . 'profiletype');
define('PROFILETYPE_AVATAR_STORAGE_PATH', JPATH_ROOT .DS. PROFILETYPE_AVATAR_STORAGE_REFERENCE_PATH);
define('USER_AVATAR_BACKUP', JPATH_ROOT .DS. PROFILETYPE_AVATAR_STORAGE_REFERENCE_PATH.DS.'useravatar');

/*
 * Create directories over here. if they dont exist
 * and chmod($dir, 0755);
 */
// define constants for category of Profile Fields
define('PROFILE_FIELD_CATEGORY_ALLOWED',0);
define('PROFILE_FIELD_CATEGORY_REQUIRED',1);
define('PROFILE_FIELD_CATEGORY_VISIBLE',2);
define('PROFILE_FIELD_CATEGORY_EDITABLE_AFTER_REG',3);
define('PROFILE_FIELD_CATEGORY_EDITABLE_DURING_REG',4);


//define constants for blocking display application according to owner,visitor and both
define('BLOCK_DISPLAY_APP_OF_OWNER',0);
define('BLOCK_DISPLAY_APP_OF_VISITOR',1);
define('BLOCK_DISPLAY_APP_OF_BOTH',2);

//define some constant
define('ALL',-1); //required in admin in ACL rules only ,
// it's not -1 at all places , we have used this as 0
define('XIPT_PROFILETYPE_ALL',0);
define('XIPT_PROFILETYPE_NONE',-1);

define('XIPT_FRONT_PATH_LIBRARY',JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries');
define('XIPT_FRONT_PATH_HELPER', JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'helpers');
define('XIPT_FRONT_PATH_ASSETS',JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'assets');

// define constant   for privacy value
define('XI_PRIVACY_PUBLIC',10);
define('XI_PRIVACY_MEMBERS',20);
define('XI_PRIVACY_FRIENDS',30);
