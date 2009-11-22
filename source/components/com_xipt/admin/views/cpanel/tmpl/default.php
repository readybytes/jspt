<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<table width="100%" border="0">
	<tr>
		<td width="45%" valign="top">
			<div id="cpanel">
				<?php echo $this->addIcon('setup.png','index.php?option=com_xipt&view=setup', JText::_('SETUP'));?>
				<?php echo $this->addIcon('profiletypes.gif','index.php?option=com_xipt&view=profiletypes', JText::_('PROFILETYPES'));?>
				<?php echo $this->addIcon('aclrules.gif','index.php?option=com_xipt&view=aclrules', JText::_('ACCESS CONTROL'));?>
				<?php echo $this->addIcon('applications.gif','index.php?option=com_xipt&view=applications', JText::_('APPLICATIONS'));?>
				<?php echo $this->addIcon('profilefields.gif','index.php?option=com_xipt&view=profilefields', JText::_('PROFILE FIELDS'));?>

				<?php echo $this->addIcon('download.png','http://www.joomlaxi.com', JText::_('DOWNLOAD'));?>
				<?php echo $this->addIcon('documentation.png','http://www.joomlaxi.com/support/documentation.html', JText::_('DOCUMENTATION'));?>
				<?php echo $this->addIcon('support.png','http://www.joomlaxi.com/support/forum.html', JText::_('SUPPORT'));?>
				<?php echo $this->addIcon('gnugpl.png','http://www.gnu.org/licenses/old-licenses/gpl-2.0.html', JText::_('LICENSE'));?>				
				<?php echo $this->addIcon('twitter.jpg','http://twitter.com/joomlaXi', JText::_('FOLLOW TWITTER'));?>
			</div>
		</td>
		<td width="45%" valign="top">
			<?php
				echo $this->pane->startPane( 'stat-pane' );
					require_once 'welcome.php';
					require_once 'updates.php';
					require_once 'news.php';
				echo $this->pane->endPane();
			?>
		</td>
	</tr>
</table>
