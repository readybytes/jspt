<?php
 /**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<fieldset class="adminform">
	<legend><?php echo JText::_( 'BLOCK APPLICATION' ); ?></legend>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'ENABLE BLOCK APPLICATION' ); ?>::<?php echo JText::_('Enable or disable block application'); ?>">
						<?php echo JText::_( 'BLOCK' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'enableblockapplication' , null , $this->config->get('enableblockapplication') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
		</tbody>
	</table>
</fieldset>