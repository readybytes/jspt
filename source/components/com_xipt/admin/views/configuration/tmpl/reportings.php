<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<fieldset class="adminform">
	<legend><?php echo JText::_( 'Reportings' ); ?></legend>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Enable reporting' ); ?>::<?php echo JText::_('Enable or disable user reporting feature'); ?>">
						<?php echo JText::_( 'Enable reporting' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'enablereporting' , null , $this->config->get('enablereporting') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'When maximum report specified is reached, default task will be executed for the reported items' ); ?>::<?php echo JText::_('Allow or disallow guests to use report feature.'); ?>">
						<?php echo JText::_( 'Execute default task when reach' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="maxReport" style="text-align: center;" value="<?php echo $this->config->get('maxReport'); ?>" size="5" />
					<?php echo JText::_('reports');?>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Send notification emails to' ); ?>::<?php echo JText::_('When maximum report specified is reached, default task will be executed and result will be mailed to the following email'); ?>">
						<?php echo JText::_( 'Send notification emails to' ); ?>
					</span>
				</td>
				<td valign="top">
					<div><input type="text" name="notifyMaxReport" value="<?php echo $this->config->get('notifyMaxReport'); ?>" size="45" /></div>
					<?php echo JText::_('( Comma separated for different emails )');?>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Allow guests to report' ); ?>::<?php echo JText::_('Allow or disallow guests to use report feature.'); ?>">
						<?php echo JText::_( 'Allow guests to report' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'enableguestreporting' , null , $this->config->get('enableguestreporting') , JText::_('Allow') , JText::_('Disallow') ); ?>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Predefined text' ); ?>::<?php echo JText::_('Set predefined text for reports separated by a new line.'); ?>">
					<?php echo JText::_( 'Predefined text (separated by a new line)' ); ?>
					</span>
				</td>
				<td valign="top">
					<textarea name="predefinedreports" cols="30" rows="5"><?php echo $this->config->get('predefinedreports');?></textarea>
				</td>
			</tr>
		</tbody>
	</table>
</fieldset>