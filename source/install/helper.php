<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.folder' );
jimport( 'joomla.filesystem.file' );

class XiPTHelperInstall
{
	function get_js_version()
	{	
		$CMP_PATH_ADMIN	= JPATH_ROOT . DS. 'administrator' .DS.'components' . DS . 'com_community';
	
		$parser		=& JFactory::getXMLParser('Simple');
		$xml		= $CMP_PATH_ADMIN . DS . 'community.xml';
	
		$parser->loadFile( $xml );
	
		$doc		=& $parser->document;
		$element	=& $doc->getElementByPath( 'version' );
		$version	= $element->data();
	
		return $version;
	}

	
	function getJSPTFileList()
	{
		$CMP_PATH_FRNTEND = JPATH_ROOT .DS. 'components' . DS . 'com_community';
		$CMP_PATH_ADMIN	  = JPATH_ROOT .DS. 'administrator' .DS.'components' . DS . 'com_community';
		
		$filestoreplace = array();
	
		$filestoreplace['front_libraries_fields_customfields.xml']=$CMP_PATH_FRNTEND.DS.'libraries'.DS.'fields'.DS.'customfields.xml';
		$filestoreplace['front_models_profile.php']=$CMP_PATH_FRNTEND.DS.'models'.DS.'profile.php';
		$filestoreplace['admin_models_user.php']=$CMP_PATH_ADMIN.DS.'models'.DS.'users.php';
		
		//Codrev : disable plugins and fields too
		//AEC microintegration install, if AEC exist
		$AEC_MI_PATH = JPATH_ROOT . DS. 'components' . DS . 'com_acctexp' . DS . 'micro_integration';
		if(JFolder::exists($AEC_MI_PATH))
			$filestoreplace['mi_jomsocialjspt.php']=	$AEC_MI_PATH .DS.'mi_jomsocialjspt.php';
	
		return $filestoreplace;
	}
	
	// XITODO : chek if function is usabel
	function generateParamsString($params=array())
	{
		$config = new JParameter('','');
		$config->bind($params);
		$configString = $config->toString('INI');
		return $configString;
	}
}