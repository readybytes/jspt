<?php /**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );

require_once JPATH_ROOT.'/components/com_xipt/views/registration/tmpl/default_assets.php';
?>  
	<div class="registerProfileType container-fluid joms-page__title" style="height:300px;overflow:scroll;">
	<?php
	echo XiptText::_ ( 'PROFILE_TYPE_DESCRIPTION_FOR_SELECTBOX' )."<br />";
	
	if(XiptFactory::getSettings('jspt_fb_show_radio', 0))
		include(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'views'.DS.'registration'.DS.'tmpl'.DS.'facebook_radio.php');
	else
		include(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'views'.DS.'registration'.DS.'tmpl'.DS.'facebook_select.php');
	?>
	</div>
<?php 