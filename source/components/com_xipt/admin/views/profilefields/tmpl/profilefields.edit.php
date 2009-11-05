<?php
defined('_JEXEC') or die('Restricted access');
?>

<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		submitform( pressbutton );
	}
</script>

<form action=<?php echo JURI::base();?> method="post" name="adminForm" id="adminForm">
<table class="adminlist" cellspacing="1">
		<tr>
			<td width="30%">
				<?php echo JText::_( 'FIELD NAME' ); ?> :
			</td>
			<td width="50%">
					<?php echo XiPTHelperProfileFields::get_fieldname_from_fieldid($this->fieldid); ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_('FOR PROFILETYPES');?> :
			</td>
			<td colspan="4"> 
				<?php echo XiPTHelperProfileFields::buildProfileTypes($this->fieldid);?>
			</td>			
		</tr>
		</tr>
</table>

<div class="clr"></div>

	<input type="hidden" name="option" value="com_xipt" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'profilefields' );?>" />
	<input type="hidden" name="id" value="<?php echo $this->fieldid; ?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
