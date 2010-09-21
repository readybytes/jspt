<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<form action="<?php echo JURI::base();?>index.php?option=com_xipt" method="post" name="adminForm">
<table width="100%" border="0">
	<tr>
		<td width="100%" valign="top">
			<div id="cpanel">
				<?php echo $this->addIcon('jspt-settings.png','index.php?option=com_xipt&view=settings', JText::_('SETTINGS'));?>
				<?php echo $this->addIcon('jspt-config.png','index.php?option=com_xipt&view=configuration', JText::_('JSCONFIGURATION'));?>
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
		</td>
	</tr>
</table>

<input type="hidden" name="view" value="cpanel" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_xipt" />
<input type="hidden" name="boxchecked" value="0" />
</form>	
