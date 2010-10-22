<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');
?>

<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		if (pressbutton == "cancel") {
			submitform(pressbutton);
			return;
		}
		// validation
		var form = document.adminForm;
		if (form.rulename.value == "") {
			alert( "<?php echo XiptText::_( 'RULE MUST HAVE A NAME', true ); ?>" );
		} else {
			submitform(pressbutton);
		}
	}
</script>

<form action="index.php" method="post" name="adminForm">
<div>
<div class="col width-40" style="width:40%; float:left;">
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'Details' ); ?></legend>
	<table class="admintable">
		<tr>
			<td width="100" class="key">
				<label for="name" class="hasTip" title="<?php echo XiptText::_('NAME'); ?>::<?php echo XiptText::_('ACL NAME.DESC'); ?>">
					<?php echo XiptText::_( 'NAME' ); ?>
				</label>
			</td>
			<td>
				<?php echo XiptText::_($this->aclruleInfo['aclname']); ?>
			</td>
		</tr>
		<tr>
			<td width="100" class="key">
				<label for="featurename" class="hasTip" title="<?php echo XiptText::_('RULE NAME'); ?>::<?php echo XiptText::_('RULE NAME.DESC'); ?>">
					<?php echo XiptText::_( 'RULE NAME' ); ?>
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="rulename" id="rulename" size="35" value="<?php echo $this->aclruleInfo['rulename']; ?>" />
			</td>
		</tr>
		<tr>
			<td valign="top" class="key">
				<label class="hasTip" title="<?php echo XiptText::_('PUBLISHED'); ?>::<?php echo XiptText::_('ACL PUBLISHED.DESC'); ?>">
				<?php echo XiptText::_( 'PUBLISHED' ); ?>
				</label>
			</td>
			<td>
				<?php echo JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $this->aclruleInfo['published'] ); ?>
			</td>
		</tr>
		</table>
	</fieldset>
	<br />
	<br />

	<fieldset class="adminform">
	<legend><?php echo XiptText::_( 'Rule Parameters' ); ?></legend>
	<?php
		if($this->aclParamsHtml)
			echo $this->aclParamsHtml;
		else
			echo "<div style=\"text-align: center; padding: 5px; \">".XiptText::_('There are no parameters for this item')."</div>" ;
	?>
	</fieldset>
</div>

<div class="col width-60" style="width:60%; float:right;">
	<fieldset class="adminform">
	<legend><?php echo XiptText::_( 'General Parameters' ); ?></legend>
	<?php
		if ($this->coreParamsHtml)
			echo $this->coreParamsHtml;
		else
			echo "<div style=\"text-align: center; padding: 5px; \">".XiptText::_('There are no parameters for this item')."</div>"
		?>
	</fieldset>
	<br />
	<?php if(isset($this->xmlRule['example']) && isset($this->xmlRule['title'])) :?>	
		<fieldset class="adminform">
		<legend><?php echo JText::_('EXAMPLE'); ?></legend>
		<div style=" background-color:#F9F9F9; padding:5px;"> 
			<h3 > <?php echo $this->xmlRule['title']; ?> </h3>
			<?php echo $this->xmlRule['example']; ?>
		</div>						
		</fieldset>
	
<?php endif;?>
</div>

</div>
<div class="clr"></div>

	<input type="hidden" name="option" value="com_xipt" />
	<input type="hidden" name="id" value="<?php echo $this->aclruleInfo['id'];?>" />
	<input type="hidden" name="aclname" value="<?php echo $this->aclruleInfo['aclname'];?>" />
	<input type="hidden" name="cid[]" value="" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'aclrules' );?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
<?php
