<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

$jspcPath = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt';

if(!JFolder::exists($jspcPath))
	return false;
	
/*$file = dirname(__FILE__);
$Protocol = "http://";
$tp =	$Protocol.$_SERVER['HTTP_HOST'].str_replace($_SERVER['DOCUMENT_ROOT'], '', $file);*/
?>
<script type="text/javascript" src="<?php echo JURI::root();?>administrator/components/com_xipt/elements/colorbox/jscolor.js"></script>

<?php 
class JElementColorbox extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Colorbox';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$html = '<input class="color" type="text" id="'.$control_name.'['.$name.']" name="'.$control_name.'['.$name.']" value="'.$value.'" />';

		return $html;
	}
	
}