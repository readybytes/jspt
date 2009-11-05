<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

?>
<script type="text/javascript" language="javascript">
/**
 * This function needs to be here because, Joomla toolbar calls it
 **/ 
function submitbutton( action )
{
	switch( action )
	{
		case 'remove':
			if( !confirm( '<?php echo JText::_('ARE YOU SURE YOU WANT TO REMOVE THIS RULE?'); ?>' ) )
			{
				break;
			}
		case 'publish':
		case 'unpublish':
		default:
			submitform( action );
	}
}
</script>

<form action="<?php echo JURI::base();?>index.php" method="post" name="adminForm">
<table class="adminlist" cellspacing="1">
	<thead>
		<tr class="title">
			<th width="1%">
				<?php echo JText::_( 'NUM' ); ?>
			</th>
			<th width="1%">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->fields ); ?>);" />
			</th>
			<th>
				<?php echo JText::_( 'RULE NAME' ); ?>
			</th>
			<th width="5%">
				<?php echo JText::_( 'PROFILETYPE' ); ?>
			</th>
			<th width="5%">
				<?php echo JText::_( 'OTHER PROFILETYPE' ); ?>
			</th>
			<th width="10%">
				<?php echo JText::_( 'FEATURE TO CONTROL' ); ?>
			</th>
			<th width="10%">
				<?php echo JText::_( 'TASK LIMIT' ); ?>
			</th>
			<th width="20%">
				<?php echo JText::_( 'REDIRECT URL' ); ?>
			</th>
			<th width="20%">
				<?php echo JText::_( 'MESSAGE' ); ?>
			</th>
			<th width="5%">
				<?php echo JText::_( 'PUBLISHED' ); ?>
			</th>
		</tr>		
	</thead>
<?php
	$count	= 0;
	$i		= 0;

	if(!empty($this->fields))
	foreach($this->fields as $field)
	{
		$input	= JHTML::_('grid.id', $count, $field->id);
		
		// Process publish / unpublish images
		++$i;
?>
		<tr class="row<?php echo $i%2;?>" id="rowid<?php echo $field->id;?>">
			<td><?php echo $i;?></td>
			<td>
				<?php echo $input; ?>
			</td>
			<td>
				<span class="editlinktip" title="<?php echo $field->rulename; ?>" id="name<?php echo $field->id;?>">
					<?php $link = JRoute::_('index.php?option=com_xipt&view=aclrules&task=edit&editId='.$field->id, false); ?>
						<A HREF="<?php echo $link; ?>"><?php echo $field->rulename; ?></A>
				</span>
			</td>
			<td align="center" id="profiletype<?php echo $field->id;?>">
				<?php echo XiPTHelperAclRules::getProfileTypeNameforaclrules($field->pid); ?>
			</td>
			<td align="center" id="otherprofiletype<?php echo $field->id;?>">
				<?php echo XiPTHelperAclRules::getProfileTypeNameforaclrules($field->otherpid); ?>
			</td>
			<td align="center" id="feature<?php echo $field->id;?>">
				<?php echo XiPTHelperAclRules::_getDisplayNameofAclFeature($field->feature); ?>
			</td>
			<td align="center" id="taskcount<?php echo $field->id;?>">
				<?php echo $field->taskcount; ?>
			</td>

			<td align="center" id="redirecturl<?php echo $field->id;?>">
				<?php echo $field->redirecturl; ?>
			</td>
			<td align="center" id="message<?php echo $field->id;?>">
				<?php echo $field->message;	?>
			</td>
			<td align="center" id="published<?php echo $field->id;?>">
				<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i-1;?>','<?php echo $field->published ? 'unpublish' : 'publish' ?>')">
							<?php if($field->published)
							{ ?>
								<img src="images/tick.png" width="16" height="16" border="0" alt="Published" /></a>
							<?php 
							}
							else 
							{ ?>
								<img src="images/publish_x.png" width="16" height="16" border="0" alt="Unpublished" /></a>
						<?php 
							} //echo $published;
						?>
			</td>		
		</tr>
<?php
		
		$count++;
	}
?>
	<tfoot>
	<tr>
		<td colspan="15">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tr>
	</tfoot>
</table>
<input type="hidden" name="view" value="aclrules" />
<input type="hidden" name="task" value="<?php echo JRequest::getCmd( 'task' );?>" />
<input type="hidden" name="option" value="com_xipt" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>	