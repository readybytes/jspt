<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');

$aModel			= XiFactory::getModel( 'applications' );
?>

	
<div style="background-color: #F9F9F9; border: 1px solid #D5D5D5; margin-bottom: 10px; padding: 5px;font-weight: bold;">
	<?php echo JText::_('ASSIGN APPLICATION AS PER PROFILE TYPES FOR YOUR SITE.');?>
</div>
<div id="error-notice" style="color: red; font-weight:700;"></div>
<div style="clear: both;"></div>
<form action="#" method="post" name="adminForm" id="adminForm">
<table cellspacing="0" class="admintable" border="0" width="100%">
	<tbody>
		<tr>
			<td class="key"><?php echo JText::_('NAME');?></td>
			<td>:</td>
			<td>
				<?php echo $aModel->getPluginNamefromId($this->applicationId);?>
			</td>
		</tr>
		<br>
		<br>
		<tr>
			<td class="key"><?php echo JText::_('FOR PROFILETYPES');?></td>
			<td>:</td>
			<td colspan="4"> <?php echo XiPTHelperApplications::buildProfileTypesforApplication($this->applicationId);?></td>			
		</tr>
	</tbody>
</table>

<div class="clr"></div>

	<input type="hidden" name="option" value="com_xipt" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'applications' );?>" />
	<input type="hidden" name="id" value="<?php echo $this->applicationId; ?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
