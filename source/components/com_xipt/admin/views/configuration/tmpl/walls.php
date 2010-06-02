<?php 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<fieldset class="adminform">
	<legend><?php echo JText::_('Walls'); ?></legend>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Lock walls in profile' ); ?>::<?php echo JText::_('If enabled walls will be locked to friends only.'); ?>">
						<?php echo JText::_( 'Lock walls in profile to friends only' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'lockprofilewalls' , null , $this->config->get('lockprofilewalls') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Lock walls in videos' ); ?>::<?php echo JText::_('If enabled walls will be locked to friends only.'); ?>">
						<?php echo JText::_( 'Lock walls in videos to friends only' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'lockvideoswalls' , null , $this->config->get('lockvideoswalls') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Lock walls in groups' ); ?>::<?php echo JText::_('If enabled walls will be locked to group members only.'); ?>">
						<?php echo JText::_( 'Lock walls in groups to group members only' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'lockgroupwalls' , null , $this->config->get('lockgroupwalls') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
		</tbody>
	</table>
</fieldset>