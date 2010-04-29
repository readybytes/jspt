<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementImage extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Image';

	function fetchElement($name, $value, &$node, $control_name)
	{
		/*value contain profiletype id so get watermark from function */
		$watermark = XiPTHelperProfiletypes::getProfileTypeData($value,'watermark'); 
		$generatedImage = '';
		/*generate image from watermark */
		$imagePath = JPATH_ROOT.DS.DEFAULT_AVATAR;
		$watermarkPath = JPATH_ROOT.DS.$watermark;
		
		$watermarkParams = XiPTLibraryProfiletypes::getParams($value,'watermarkparams');
		
		if(JFile::exists($imagePath) && JFile::exists($watermarkPath))
			$generatedImage = XiPTLibraryUtils::showWatermarkOverImage($imagePath,$watermarkPath,'ptype_'.$value,$watermarkParams->get('xiWatermarkPosition'));
		if(DS== '\\') 
			$generatedImage = str_replace('\\','/',$generatedImage);
		$html = '';
		//$html = '<img src="'.JURI::root().DS.$watermark.'" width="64" alt="watermark" />';
		$html .= '<img src="'.JURI::root().'/'.$generatedImage.'" width="64" height="64" alt="generatedimage" border=10 />';
		

		return $html;
	}
	
}
