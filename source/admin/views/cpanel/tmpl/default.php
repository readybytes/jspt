<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
if(!defined('_JEXEC')) die('Restricted access');
?>
<form action="<?php echo JURI::base();?>index.php?option=com_xipt" method="post" name="adminForm">
<table width="100%" border="0">
	<tr>
		<td width="45%" valign="top">
			<div id="cpanel">
				<?php echo $this->addIcon('jspt-settings.png','index.php?option=com_xipt&view=settings', XiptText::_('SETTINGS'));?>
				<?php echo $this->addIcon('jspt-config.png','index.php?option=com_xipt&view=configuration', XiptText::_('JSCONFIGURATION'));?>
				<?php echo $this->addIcon('setup.png','index.php?option=com_xipt&view=setup', XiptText::_('SETUP'));?>
				<?php echo $this->addIcon('profiletypes.gif','index.php?option=com_xipt&view=profiletypes', XiptText::_('PROFILETYPES'));?>
			</div>
			<div class='clr'></div>
			<div id='cpanel'>
				<?php echo $this->addIcon('aclrules.gif','index.php?option=com_xipt&view=aclrules', XiptText::_('ACCESS CONTROL'));?>
				<?php echo $this->addIcon('applications.gif','index.php?option=com_xipt&view=applications', XiptText::_('APPLICATIONS'));?>
				<?php echo $this->addIcon('profilefields.gif','index.php?option=com_xipt&view=profilefields', XiptText::_('PROFILE FIELDS'));?>
			</div>
		</td>
		<td width="45%" valign="top">
			<?php 
				echo $this->pane->startPane( 'stat-pane' );
				
				echo $this->pane->startPanel( 'Welcome', 'welcome' );
				echo $this->loadTemplate('welcome');
				echo $this->pane->endPanel();
				
				echo $this->pane->startPanel( 'Changelogs', 'changelogs' );
				echo $this->loadTemplate('changelog');
				echo $this->pane->endPanel();
				
				echo $this->pane->startPanel( 'JSPT Updates', 'updates' );
				echo $this->loadTemplate('updates');
				echo $this->pane->endPanel();
				
				echo $this->pane->startPanel( 'JoomlaXi News', 'aboutus' );
				echo $this->loadTemplate('news');
				echo $this->pane->endPanel();
				
				echo $this->pane->endPane();
			?>
		</td>
	</tr>
</table>

<input type="hidden" name="view" value="cpanel" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_xipt" />
<input type="hidden" name="boxchecked" value="0" />
</form>	
<?php 
