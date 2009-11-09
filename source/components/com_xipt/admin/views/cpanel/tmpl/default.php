<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<table width="100%" border="0">
	<tr>
		<td width="55%" valign="top">
			<div id="cpanel">
				<?php echo $this->addIcon('profiletypes.gif','index.php?option=com_xipt&view=profiletypes', JText::_('PROFILETYPES'));?>
				<?php echo $this->addIcon('acl.gif','index.php?option=com_xipt&view=aclrules', JText::_('ACCESS CONTROL'));?>
				<?php echo $this->addIcon('applications.gif','index.php?option=com_xipt&view=applications', JText::_('APPLICATIONS'));?>
				<?php echo $this->addIcon('profilefields.gif','index.php?option=com_xipt&view=profilefields', JText::_('PROFILE FIELDS'));?>
			</div>
		</td>
		<td width="45%" valign="top">
			<?php
				echo $this->pane->startPane( 'stat-pane' );
				echo $this->pane->startPanel( JText::_('WELCOME TO XIPT') , 'welcome' );
			?>
			<table class="adminlist">
				<tr>
					<td>
						<div style="font-weight:700;">
							<?php echo JText::_('ANOTHER GREAT COMPONENT BROUGHT TO YOU BY JOOMLAXI.COM');?>
						</div>
						<p>
							If you require professional support just head on to the forums at 
							<a href="http://www.joomlaxi.com/support/forum.html" target="_blank">
							http://www.joomlaxi.com/support/forum.html
							</a>
						</p>
						<p>
							If you found any bugs, just drop us an email at bugs@joomlaxi.com
						</p>
					</td>
				</tr>
			</table>
			<?php
				echo $this->pane->endPanel();
				echo $this->pane->startPanel( JText::_('XIPT STATISTICS') , 'xipt' );

				echo $this->pane->endPanel();
				echo $this->pane->endPane();
			?>
		</td>
	</tr>
</table>
