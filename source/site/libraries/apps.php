<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

//TODO: we should store
class XiPTLibraryApps
{
    function filterCommunityApps(&$apps, $profiletype, $blockProfileApps=true)
    {
        // $apps is array of objects
        $notAllowedApps =XiPTLibraryApps::getNotAllowedCommunityAppsArray($profiletype);
        for($i=0 ; $i < count($apps) ; $i++ )
        {
            $app   =& $apps[$i];
            
            //legacy plugins come as array, we dont work on them
            if(is_object($app)==false)
                continue;
            
            // we want to restrict only community apps
            if($app->_type != 'community')
                continue;
            
            // do not restrict our component, user may do mistakes :-)
            if($app->_name == 'xipt_community')
                continue;
                
			if(method_exists($app,'onProfileDisplay') != $blockProfileApps)
				continue;
			
            $appId    = XiPTLibraryApps::getPluginId($app->_name);
           // is it not allowed
           if(in_array($appId,$notAllowedApps))
               unset($apps[$i]);
        }
        
        $apps =& array_values($apps);
        return true;
    }
    
    function getNotAllowedCommunityAppsArray($profiletype)
    {
        // cache the results in static $instance
        $db		=& JFactory::getDBO();
		$query	= 'SELECT ' . $db->nameQuote( 'applicationid' ) . ' '
				. 'FROM ' . $db->nameQuote( '#__xipt_applications' ) . ' '
				. 'WHERE '. $db->nameQuote( 'profiletype' ).'='.$db->Quote( $profiletype );

		$db->setQuery( $query );
		$results = $db->loadResultArray();
		
		return $results;
    }
    
	function getPluginId( $element, $folder = 'community' )
	{
		static $result = null;
		if($result === null || isset($result[$folder])===false)
		{
			$db		=& JFactory::getDBO();
			$query	= 'SELECT ' . $db->nameQuote( 'id' ) . ' , ' . $db->nameQuote( 'element' ) . ' '
					. 'FROM ' . $db->nameQuote( '#__plugins' ) . ' '
					. 'WHERE ' .$db->nameQuote( 'folder' ) . '=' . $db->Quote( $folder );
	
			$db->setQuery( $query );
			$result[$folder] = $db->loadAssocList('element');
			
			if($db->getErrorNum())
				JError::raiseError( 500, $db->stderr());
		}
			
		return $result[$folder][$element]['id'];
	}
	
	
	function filterAjaxAddApps(&$appName,&$profiletype, &$objResponse)
	{
	    $appId = XiPTLibraryApps::getPluginId($appName);
	    $notAllowedApps =XiPTLibraryApps::getNotAllowedCommunityAppsArray($profiletype);
	    
	    // do not restrict if allowed
	    if(!in_array($appId,$notAllowedApps))
	        return true;
	    
	    //restrict the user.
	    $objResponse->addAssign('cwin_logo', 'innerHTML', JText::_('CC ADD APPLICATION TITLE'));

		$action		= '<form name="cancelRequest" action="" method="POST">';
		$action		.= '<input type="button" class="button" onclick="cWindowHide();return false;" name="cancel" value="'.JText::_('CC BUTTON CLOSE').'" />';
		$action		.= '</form>';
		
		$objResponse->addAssign('cWindowContent', 'innerHTML', '<div class="ajax-notice-apps-added">'.JText::_( 'APPLICATION ACCESS DENIED' ).'</div>');
		
		$objResponse->addScriptCall('cWindowActions', $action);
		return false;
		
	} 
}
