<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

//TODO: we should store
class XiptLibApps
{
    function filterCommunityApps(&$apps, $profiletype, $blockProfileApps=true)
    {
        $notAllowedApps = XiptLibApps::getNotAllowedCommunityAppsArray($profiletype);
        
        // $apps is array of objects
        for($i=0 ; $i < count($apps) ; $i++ )
        {
            $app   =& $apps[$i];
            
            //legacy plugins come as array, we dont work on them
            if(is_object($app) == false)
                continue;
            
            // we want to restrict only community apps and do not restrict our component
            if($app->_type != 'community' && $app->_name == 'xipt_community')
                continue;
                
			if(method_exists($app,'onProfileDisplay') != $blockProfileApps)
				continue;
			
            $appId    = XiptLibApps::getPluginId($app->_name);
           // is it not allowed
           if(in_array($appId,$notAllowedApps))
               unset($apps[$i]);
        }
        
        $apps =& array_values($apps);
        return true;
    }
    
    function getNotAllowedCommunityAppsArray($profiletype)
    {
    	$tempResult = XiptFactory::getInstance('applications', 'model')
    								->loadRecords(0);		
				
		foreach($tempResult as $temp)
			$result[$temp->profiletype][] = $temp->applicationid;
		
		if(isset($result[$profiletype]))
			return $result[$profiletype];
		else
			return array();		
    }
    
	function getPluginId( $element, $folder = 'community' )
	{
		$reset = XiptLibJomsocial::cleanStaticCache();
		
		static $plugin = null;
		if($plugin == null || !isset($plugin[$folder]) || $reset)
		{			
			$query = new XiptQuery();
			$plugin[$folder] = $query->select('*')
							->from('#__extensions')
							->where(" `folder` = '$folder' ")
							->dbLoadQuery("","")
							->loadObjectList('element');
		}
		
		if(isset($plugin[$folder][$element]))
			return $plugin[$folder][$element]->id;
		else
			return false;
	}
	
	
	function filterAjaxAddApps(&$appName,&$profiletype, &$objResponse)
	{
	    $appId = XiptLibApps::getPluginId($appName);
	    $notAllowedApps =XiptLibApps::getNotAllowedCommunityAppsArray($profiletype);
	    
	    // do not restrict if allowed
	    if(!in_array($appId,$notAllowedApps))
	        return true;
	    
	    //restrict the user.
	    $objResponse->addAssign('cwin_logo', 'innerHTML', XiptText::_('CC ADD APPLICATION TITLE'));

		$action		= '<form name="cancelRequest" action="" method="POST">';
		$action		.= '<input type="button" class="button" onclick="cWindowHide();return false;" name="cancel" value="'.XiptText::_('CC BUTTON CLOSE').'" />';
		$action		.= '</form>';
		
		$objResponse->addAssign('cWindowContent', 'innerHTML', '<div class="ajax-notice-apps-added">'.XiptText::_( 'APPLICATION ACCESS DENIED' ).'</div>');
		
		$objResponse->addScriptCall('cWindowActions', $action);
		return false;
		
	} 
}
