<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');
?>

<?php 
JToolBarHelper::back('Home' , 'index.php?option=com_xipt&view=aclrules');
JToolBarHelper::cancel( 'cancel', JText::_('CLOSE' ));
?>

<script language="javascript" type="text/javascript">

	function checkForm()
	{
		var form = document.adminForm;		
		if( form.acl.value == 0 )
		{
			return false;
		}
		return true;
	}
	
	function submitbutton(action) {
		var form = document.adminForm;
		switch(action)
		{
			case 'renderacl' :
				if( form.acl.value == 0 )
				{
					alert( "<?php echo JText::_( 'PLEASE SELECT A ACL FROM LIST'); ?>" );
					break;
				} 
			case 'cancel':
			default:
				submitform( action );
		}
	}
</script>
	
<div style="background-color: #F9F9F9; border: 1px solid #D5D5D5; margin-bottom: 10px; padding: 5px;font-weight: bold;">
	<?php echo JText::_('SELECT ACL TO USE');?>
</div>
<div id="error-notice" style="color: red; font-weight:700;"></div>
<div style="clear: both;"></div>
<form action="<?php echo JURI::base();?>index.php?option=com_xipt" method="post" name="adminForm" id="adminForm" onSubmit="return checkForm();" >
<table cellspacing="0" class="admintable" border="0" width="100%">
	<tbody>
		<tr>
			<td class="key"><?php echo JText::_('ACL');?></td>
			<td>:</td>
			<td>
				<select id="acl" name="acl" >
				<option value="0">SELECT ACL</option>
				<?php
					if(!empty($this->acl)) 
					foreach($this->acl as $acl) { ?>
					    <option value="<?php echo $acl;?>" ><?php echo JText::_($acl);?></option>
					<?php 
					}
				?>
				</select>
			</td>
		</tr>
	</tbody>
</table>

<div class="clr"></div>

<div style="float:left; margin-left: 320px">
	<input type="submit" name="aclnext" value="<?php echo JText::_('NEXT');?>" onclick="submitbutton('renderacl');"/>
</div>	
	<input type="hidden" name="option" value="com_xipt" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'aclrules' );?>" />
	<input type="hidden" name="id" value="" />
	<input type="hidden" name="task" value="renderacl" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
