<?php
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.folder' );
jimport( 'joomla.filesystem.file' );

function get_js_version()
{	
	$CMP_PATH_ADMIN	= dirname( JPATH_BASE ) . DS. 'administrator' .DS.'components' . DS . 'com_community';

	$parser		=& JFactory::getXMLParser('Simple');
	$xml		= $CMP_PATH_ADMIN . DS . 'community.xml';

	$parser->loadFile( $xml );

	$doc		=& $parser->document;
	$element	=& $doc->getElementByPath( 'version' );
	$version	= $element->data();

	return $version;
}

function get_jspt_version()
{	
	// this version will be added from phing script.
	return "@XIPT_VERSION@";
}

	
function getJSPTFileList()
{
	$MY_PATH_FRNTEND  = dirname( JPATH_BASE ) .DS. 'components' . DS . 'com_xipt';
	$MY_PATH_ADMIN	  = dirname( JPATH_BASE ) .DS. 'administrator' .DS.'components' . DS . 'com_xipt';

	$CMP_PATH_FRNTEND = dirname( JPATH_BASE ) .DS. 'components' . DS . 'com_community';
	$CMP_PATH_ADMIN	  = dirname( JPATH_BASE ) .DS. 'administrator' .DS.'components' . DS . 'com_community';

	
	$filestoreplace = array();

	$filestoreplace['front_libraries_fields_customfields.xml']=$CMP_PATH_FRNTEND.DS.'libraries'.DS.'fields'.DS.'customfields.xml';
	$filestoreplace['front_libraries_fields_profiletypes.php']=$CMP_PATH_FRNTEND.DS.'libraries'.DS.'fields'.DS.'profiletypes.php';
	$filestoreplace['front_libraries_fields_templates.php']=$CMP_PATH_FRNTEND.DS.'libraries'.DS.'fields'.DS.'templates.php';

	$filestoreplace['front_models_profile.php']=$CMP_PATH_FRNTEND.DS.'models'.DS.'profile.php';
	
	//AEC microintegration install, if AEC exist
	$AEC_MI_PATH = dirname( JPATH_BASE ) . DS. 'components' . DS . 'com_acctexp' . DS . 'micro_integration';
	if(JFolder::exists($AEC_MI_PATH))
		$filestoreplace['mi_jomsocialjspt.php']=	$AEC_MI_PATH .DS.'mi_jomsocialjspt.php';

	return $filestoreplace;
}
