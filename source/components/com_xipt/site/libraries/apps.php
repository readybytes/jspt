<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

//TODO: we should store
class XiPTLibraryApps
{
    function filterCommunityApps(&$apps, $profiletype)
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
        $db		=& JFactory::getDBO();
		$query	= 'SELECT ' . $db->nameQuote( 'applicationid' ) . ' '
				. 'FROM ' . $db->nameQuote( '#__xipt_applications' ) . ' '
				. 'WHERE '. $db->nameQuote( 'profiletype' ).'='.$db->Quote( $profiletype );

		$db->setQuery( $query );
		$results = $db->loadResultArray();
		
		return $results;
    }
    
	function getPluginId( $element )
	{
		$db		=& JFactory::getDBO();
		$query	= 'SELECT ' . $db->nameQuote( 'id' ) . ' ' 
				. 'FROM ' . $db->nameQuote( '#__plugins' ) . ' '
				. 'WHERE ' . $db->nameQuote( 'element' ) . '=' . $db->Quote( $element );

		$db->setQuery( $query );
		$result = $db->loadResult();
		
		if($db->getErrorNum())
			JError::raiseError( 500, $db->stderr());
		
		return $result;
	}
}
