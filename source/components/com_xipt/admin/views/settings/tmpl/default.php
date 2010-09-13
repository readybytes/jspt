<?php
defined('_JEXEC') or die('Restricted access');
?>
<script language="javascript" type="text/javascript">
	function submitbutton(action) {
		var form = document.adminForm;
		switch(action)
		{
		case 'save':			
		case 'publish':
		case 'unpublish':
		case 'cancel':
		default:
			submitform( action );
		}
	}
</script>

<form action="<?php echo JURI::base();?>index.php?" method="post" name="adminForm">
<div>
<?php 
	echo $this->settingsParamsHtml;?>
</div>
<div class="clr"></div>
	<input type="hidden" name="option" value="com_xipt" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'settings' );?>" />
	<input type="hidden" name="name" value="settings" />
	<input type="hidden" name="task" value="" />
	
<?php echo JHTML::_( 'form.token' ); ?>
</form>	