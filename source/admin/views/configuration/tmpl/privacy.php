<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<fieldset class="adminform">
	<legend><?php echo JText::_( 'Privacy' ); ?></legend>
	<h3><?php echo JText::_( 'Default User Privacy' ); ?></h3>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'SHOW DETAILS' ); ?>::<?php echo JText::_('SHOW DETAILS TIP'); ?>">
					<?php echo JText::_( 'Default Profile Privacy' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo $this->getPrivacyHTML( 'privacyprofile' , $this->config->get('privacyprofile') ); ?>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'SHOW DETAILS' ); ?>::<?php echo JText::_('SHOW DETAILS TIP'); ?>">
					<?php echo JText::_( 'Default Friends Privacy' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo $this->getPrivacyHTML( 'privacyfriends' , $this->config->get('privacyfriends') , true ); ?>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'SHOW DETAILS' ); ?>::<?php echo JText::_('SHOW DETAILS TIP'); ?>">
					<?php echo JText::_( 'Default Photos Privacy' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo $this->getPrivacyHTML( 'privacyphotos' , $this->config->get('privacyphotos') , true ); ?>
				</td>
			</tr>
		</tbody>
	</table>

	<h3><?php echo JText::_( 'Default User Email & Notifications' ); ?></h3>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'SHOW DETAILS' ); ?>::<?php echo JText::_('SHOW DETAILS TIP'); ?>">
					<?php echo JText::_( 'Receive system e-mails' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'privacyemail' , null , $this->config->get('privacyemail') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'SHOW DETAILS' ); ?>::<?php echo JText::_('SHOW DETAILS TIP'); ?>">
					<?php echo JText::_( 'Allow Applications' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'privacyapps' , null , $this->config->get('privacyapps') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Receive wall comment notification' ); ?>::<?php echo JText::_('Enable or disable wall comment notifications via email'); ?>">
					<?php echo JText::_( 'Receive wall comment notification' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'privacywallcomment' , null , $this->config->get('privacywallcomment') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
		</tbody>
	</table>
</fieldset>