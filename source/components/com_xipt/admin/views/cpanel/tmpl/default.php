<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<table width="100%" border="0">
	<tr>
		<td width="60%" valign="top">
			<div>
				<div id="cpanel">
					<?php echo $this->addIcon('jspt-config.png','index.php?option=com_xipt&view=profiletypes', JText::_('CONFIGURATION'));?>
					<?php echo $this->addIcon('setup.png','index.php?option=com_xipt&view=setup', JText::_('SETUP'));?>
					<?php echo $this->addIcon('profiletypes.gif','index.php?option=com_xipt&view=profiletypes', JText::_('PROFILETYPES'));?>
					<?php echo $this->addIcon('aclrules.gif','index.php?option=com_xipt&view=aclrules', JText::_('ACCESS CONTROL'));?>
					<?php echo $this->addIcon('applications.gif','index.php?option=com_xipt&view=applications', JText::_('APPLICATIONS'));?>
					<?php echo $this->addIcon('profilefields.gif','index.php?option=com_xipt&view=profilefields', JText::_('PROFILE FIELDS'));?>
					<?php echo $this->addIcon('download.png','http://www.joomlaxi.com/downloads/jomsocial-multi-profile-types.html', JText::_('DOWNLOAD'));?>
					<?php echo $this->addIcon('documentation.png','http://www.joomlaxi.com/support/documentation/59-multiple-profile-type.html', JText::_('DOCUMENTATION'));?>
					<?php echo $this->addIcon('support.png','http://www.joomlaxi.com/support/forum.html', JText::_('SUPPORT'));?>
					<?php echo $this->addIcon('gnugpl.png','http://www.gnu.org/licenses/old-licenses/gpl-2.0.html', JText::_('LICENSE'));?>				
					<?php echo $this->addIcon('twitter.jpg','http://twitter.com/joomlaXi', JText::_('FOLLOW TWITTER'));?>
				</div>
			</div>
			<div class="clr"></div>
		</td>
		<td width="40%" valign="top">
			<?php
				echo $this->pane->startPane( 'stat-pane' );
					require_once 'news.php';
					require_once 'welcome.php';
					require_once 'updates.php';
				echo $this->pane->endPane();
			?>
		</td>
	</tr>
</table>
