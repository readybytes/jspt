<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>

<form action="<?php echo JURI::base();?>index.php?option=com_xipt&view=registration" method="post" name="ptypeForm">
<table class="adminlist" cellspacing="1">
	<div class="xipt-profile-types">
				<h3 class="frontTitle"><?php echo JText::_( 'CC CHOOSE PROFILE TYPE');?></h3>
						<div>
							<?php echo $this->profileTypeHtml; ?>
						</div>
	</div>

</table>
<div class="clr"></div>
<input type="submit" name="save" value="save" />
<input type="hidden" name="view" value="registration" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_xipt" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>	