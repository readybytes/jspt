<?php /**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
	<link rel="stylesheet" type="text/css" href="<?php echo JURI::root() . '/components/com_xipt/assets/style.css'; ?>" />    
	<div class="registerProfileType">
	<h3 id="Title"><?php
	echo XiptText::_ ( 'CHOOSE PROFILE TYPE' );
	?></h3>
	<div class='clr'></div>
	<?php
	echo XiptText::_ ( 'PROFILE TYPE DESCRIPTION FOR SELECTBOX' )."<br />";
	
	if(XiptFactory::getSettings('jspt_fb_show_radio', 0))
		include(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'views'.DS.'registration'.DS.'tmpl'.DS.'facebook_radio.php');
	else
		include(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'views'.DS.'registration'.DS.'tmpl'.DS.'facebook_select.php');
	?>
	</div>
<?php 
