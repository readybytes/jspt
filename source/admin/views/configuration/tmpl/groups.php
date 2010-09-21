<?php /**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<fieldset class="adminform">
	<legend><?php echo JText::_( 'Groups' ); ?></legend>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td width="350" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Enable Groups System' ); ?>::<?php echo JText::_('Enable or disable groups in Jom Social'); ?>">
						<?php echo JText::_( 'Enable Groups' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php 
					$tmpGP = $this->config->get('enablegroups');
					echo JHTML::_('select.booleanlist' , 'enablegroups' , null , $this->config->get('enablegroups') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Moderate groups creation' ); ?>::<?php echo JText::_('Moderate groups creation which causes groups created to automatically be unpublished.'); ?>">
						<?php echo JText::_( 'Moderate groups creation' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'moderategroupcreation' , null , $this->config->get('moderategroupcreation') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Allow Group Creation' ); ?>::<?php echo JText::_('Allow site users to create a new group'); ?>">
						<?php echo JText::_( 'Allow Group Creation' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'creategroups' , null , $this->config->get('creategroups') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Group creation limit' ); ?>::<?php echo JText::_('Specify how many groups can a user create. Set it to 0 if you would like to disable this feature'); ?>">
						<?php echo JText::_( 'Group creation limit' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="groupcreatelimit" value="<?php echo $this->config->get('groupcreatelimit' );?>" size="10" />
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Group photo uploads limit' ); ?>::<?php echo JText::_('Specify how many photos can a group upload. Set it to 0 if you would like to disable this feature'); ?>">
						<?php echo JText::_( 'Group photo uploads limit' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="groupphotouploadlimit" value="<?php echo $this->config->get('groupphotouploadlimit' );?>" size="10" />
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Group video uploads limit' ); ?>::<?php echo JText::_('Specify how many videos can a group upload. Set it to 0 if you would like to disable this feature'); ?>">
						<?php echo JText::_( 'Group video uploads limit' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="groupvideouploadlimit" value="<?php echo $this->config->get('groupvideouploadlimit' );?>" size="10" />
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'Enable Discussion Utility' ); ?>::<?php echo JText::_('Allow group administrator to create discussions'); ?>">
						<?php echo JText::_( 'Enable Discussion Utility' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'creatediscussion' , null , $this->config->get('creatediscussion') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'Enable Group Photos' ); ?>::<?php echo JText::_('Allow group administrators to upload photos / albums'); ?>">
						<?php echo JText::_( 'Enable Group Photos' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'groupphotos' , null , $this->config->get('groupphotos') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'Enable Group Videos' ); ?>::<?php echo JText::_('Allow group administrators to add / upload videos'); ?>">
						<?php echo JText::_( 'Enable Group Videos' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'groupvideos' , null , $this->config->get('groupvideos') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'Allow notification when new discussion created' ); ?>::<?php echo JText::_('Enable notification for new discussion creation'); ?>">
						<?php echo JText::_( 'Allow notification when new discussion created' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'groupdiscussnotification' , null , $this->config->get('groupdiscussnotification') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
		</tbody>
	</table>
</fieldset>