<?php
defined('_JEXEC') or die('Restricted access');
require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'aclrules.php' );
$aModel	= XiFactory::getModel( 'applications' );
?>

<script language="javascript" type="text/javascript">
	function submitbutton(action) {
		var form = document.adminForm;
		switch(action)
		{
		case 'save':
			if( form.rulename.value == '' )
			{
				alert( "<?php echo JText::_( 'You must provide a Rule name.', true ); ?>" );
				//jQuery( '#name-message-error' ).html( "please provide name" ).css( 'color' , 'red' );
				break;
			}
		case 'publish':
		case 'unpublish':
		case 'cancel':
		default:
			submitform( action );
		}
	}
</script>

<div style="background-color: #F9F9F9; border: 1px solid #D5D5D5; margin-bottom: 10px; padding: 5px;font-weight: bold;">
	<?php echo JText::_('Create new Rule for your site.');?>
</div>
<div id="error-notice" style="color: red; font-weight:700;"></div>
<div style="clear: both;"></div>
<form action="<?php echo JURI::base();?>index.php?" method="post" name="adminForm" id="adminForm">
<table cellspacing="0" class="admintable" border="0" width="100%">
	<tbody>
		<tr>
			<td class="key"><?php echo JText::_('Rule Name');?></td>
			<td>:</td>
			<td>
				<input type="text" size="50" value="<?php echo $this->row->rulename;?>" name="rulename" />
			</td>
			<td class="key"><?php echo JText::_('Published');?></td>
			<td>:</td>
			<td>
				<span><?php echo JHTML::_('select.booleanlist',  'published', '', $this->row->published);?></span>
			</td>
		</tr>
		<tr>
			<td class="key"><?php echo JText::_('Self Profiletype');?></td>
			<td>:</td>
			<td>
				<span><?php echo XiPTHelperAclRules::_buildTypesforaclrules($this->row->pid, 'profiletype');?></span>
			</td>
			<td class="key"><?php echo JText::_('Other Profiletype');?></td>
			<td>:</td>
			<td>
				<span><?php echo XiPTHelperAclRules::_buildTypesforaclrules($this->row->otherpid, 'otherprofiletype');?></span>
			</td>
			
		</tr>
		<tr>
			<td class="key"><?php echo JText::_('Control the feature');?></td>
			<td>:</td>
			<td>
				<?php echo XiPTHelperAclRules::_buildTypesforaclrules($this->row->feature, 'feature');?>
			</td >
			
			<td class="key"><?php echo JText::_('Feature Limit');?></td>
			<td>:</td>
			<td>
				<input type="text" value="<?php echo $this->row->taskcount;?>" name="taskcount" />
			</td>
			
		</tr>
		<tr>
			<td class="key" ><?php echo JText::_('Message to display when user violates this rule');?></td>
			<td>:</td>
			<td colspan=4>
				<input type="text" size="100" value="<?php echo $this->row->message;?>" name="message" />
			</td>
		</tr>
		<tr>
			<td class="key"><?php echo JText::_('Redirect URL when user violates this rule');?></td>
			<td>:</td>
			<td colspan="4">
			<input type="text" size="100" value="<?php echo $this->row->redirecturl;?>" name="redirecturl" />
			</td>			
		</tr>
	</tbody>
</table>

<div class="clr"></div>

	<input type="hidden" name="option" value="com_xipt" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'aclrules' );?>" />
	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
