<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

define('XIPT_VERSION','2.0');
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

//define some constant
define('ALL',-1); //required in admin in ACL rules only ,
// it's not -1 at all places , we have used this as 0