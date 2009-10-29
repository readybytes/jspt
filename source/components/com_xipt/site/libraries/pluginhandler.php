<?php
/**
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license Copyrighted Commercial Software
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class XiPTLibraryPluginHandler
{

	function event_com_community_register()
	{
		global $mainframe;
		//1. check ptype value in session
		// if exist then enqueuemessage to chane ptype
		$mySess 	=& JFactory::getSession();
		
		if($mySess->has('XI_PROFILETYPES', 'XIPT'))
		{
			$profiletype = $mySess->get('XI_PROFILETYPES','', 'XIPT');
			if(!empty($profiletype))
			{
				$url = JRoute::_('index.php?option=com_xipt&view=registration',false);
				$link = '<a href='.$url.'>click here</a>';
				
				$mainframe->enqueueMessage("To change profiletype ".$profiletype.' '.$link);
				return;
			}
				
		}
		
		//2. if not exist redirect to ptype selection display page.
		// check ptype selection is visible during registration or not
		//if not then set default ptype in session
		
		
		$params = JComponentHelper::getParams('com_xipt');
		$jspt_during_reg = $params->get('jspt_during_reg');

		if($jspt_during_reg)
			$mainframe->redirect("index.php?option=com_xipt&view=registration");
		else
		{
			//get default value from params
			$defaultPType = $params->get('profiletypes');
			if(empty($defaultPType))
				$mySess->set('XI_PROFILETYPES',0, 'XIPT');
			else
				$mySess->set('XI_PROFILETYPES',$defaultPType, 'XIPT');
		}
			
	}
}