<?php 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<fieldset class="adminform">
	<legend><?php echo JText::_( 'Messaging' ); ?></legend>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Enable Messaging' ); ?>::<?php echo JText::_('Enable or disable system messaging'); ?>">
						<?php echo JText::_( 'Enable messaging' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'enablepm' , null , $this->config->get('enablepm') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Limit number of new messages' ); ?>::<?php echo JText::_('Limit number of new messages that user can send in a day'); ?>">
						<?php echo JText::_( 'Limit number of new messages' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="pmperday" value="<?php echo $this->config->get('pmperday');?>" size="4" /> <?php echo JText::_('per day');?>
				</td>
			</tr>
		</tbody>
	</table>
</fieldset>