<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
if(!defined('_JEXEC')) die('Restricted access');
?>
<div style="float:left;">
	<div class="icon">
		<a	href="<?php echo $this->url; ?>" <?php echo $this->newWindow; ?> >		
			<?php echo JHTML::_('image', 'components/com_xipt/assets/images/' . $this->image , NULL, NULL, $this->text ); ?>		
			<span><?php echo $this->text; ?></span>
		</a>		
	</div>
</div>
<?php 
