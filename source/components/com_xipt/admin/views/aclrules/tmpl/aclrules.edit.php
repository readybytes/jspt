<?php 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access'); 
?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php 
JToolBarHelper::back('Home' , 'index.php?option=com_xipt&view=aclrules');
JToolBarHelper::divider();
JToolBarHelper::apply('apply', JText::_('APPLY'));
JToolBarHelper::save('save',JText::_('SAVE'));
JToolBarHelper::cancel( 'cancel', JText::_('CLOSE' ));
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
			alert( "<?php echo JText::_( 'RULE MUST HAVE A NAME', true ); ?>" );
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
				<label for="name">
					<?php echo JText::_( 'NAME' ); ?>:
				</label>
			</td>
			<td>
				<?php echo JText::_($this->aclruleInfo['aclname']); ?>
			</td>
		</tr>
		<tr>
			<td width="100" class="key">
				<label for="featurename">
					<?php echo JText::_( 'RULE NAME' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="rulename" id="rulename" size="35" value="<?php echo $this->aclruleInfo['rulename']; ?>" />
			</td>
		</tr>
		<tr>
			<td valign="top" class="key">
				<?php echo JText::_( 'PUBLISHED' ); ?>:
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
	<legend><?php echo JText::_( 'Rule Parameters' ); ?></legend>
	<?php
		jimport('joomla.html.pane');
		$pane = &JPane::getInstance('sliders', array('allowAllClose' => true));
		echo $pane->startPane('acl-pane');
		echo $this->aclParamsHtml;
	?>
	</fieldset>
</div>
<div class="col width-60" style="width:60%; float:right;">
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'General Parameters' ); ?></legend>
	<?php
		jimport('joomla.html.pane');
		$pane = &JPane::getInstance('sliders', array('allowAllClose' => true));
		echo $pane->startPane('core-pane');
		//echo $pane->startPanel(JText :: _('Core Fields Parameters'), 'coreparam-page');
		echo $this->coreParamsHtml;
		//echo $pane->endPanel();
		?>
	</fieldset>
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
