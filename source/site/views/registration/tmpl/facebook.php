<?php /**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
	<?php echo JHTML::stylesheet('style.css','components/com_xipt/assets'); ?>
	<div class="registerProfileType">
	<h3 id="Title"><?php
	echo XiptText::_ ( 'CHOOSE PROFILE TYPE' );
	?></h3>
	<div class='clr'></div>
	<?php
	echo XiptText::_ ( 'PROFILE TYPE DESCRIPTION FOR SELECTBOX' )."<br />";
	
	if(XiptFactory::getSettings('jspt_fb_show_radio', 0))
		echo $this->loadTemplate('radio');
	else
		echo $this->loadTemplate('select');
	?>
	</div>
<?php 
