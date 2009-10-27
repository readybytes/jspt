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
			if( !confirm( '<?php echo JText::_('Are you sure you want to delete this profile type?'); ?>' ) )
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

<form action="<?php echo JURI::base();?>index.php?option=com_xipt" method="post" name="adminForm">
<table class="adminlist" cellspacing="1">
	<thead>
		<tr class="title">
			<th width="1%">
				<?php echo JText::_( 'Num' ); ?>
			</th>
			<th width="1%">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->fields ); ?>);" />
			</th>
			<th>
				<?php echo JText::_( 'Name' ); ?>
			</th>
			<th width="10%">
				<?php echo JText::_( 'Group' ); ?>
			</th>
			<th width="10%">
				<?php echo JText::_( 'Privacy' ); ?>
			</th>
			<th width="10%">
				<?php echo JText::_( 'Template' ); ?>
			</th>
			<th width="10%">
				<?php echo JText::_( 'Joomla User Type' ); ?>
			</th>
			<th width="20%">
				<?php echo JText::_( 'Avatar' ); ?>
			</th>
			<th width="5%">
				<?php echo JText::_( 'Require Approval' ); ?>
			</th>
			<th width="5%">
				<?php echo JText::_( 'Allow Template' ); ?>
			</th>
			<th width="5%">
				<?php echo JText::_( 'Published' ); ?>
			</th>
			<th width="5%" align="center">
				<?php echo JText::_( 'Ordering' ); ?>
			</th>
		</tr>		
	</thead>
<?php
	$count	= 0;
	$i		= 0;
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
				<span class="editlinktip" title="<?php echo $field->name; ?>" id="name<?php echo $field->id;?>">
					<?php $link = JRoute::_('index.php?option=com_xipt&view=profiletypes&task=edit&editId='.$field->id, false); ?>
						<A HREF="<?php echo $link; ?>"><?php echo $field->name; ?></A>
				</span>
			</td>
			<td align="center" id="group<?php echo $field->id;?>">
				<?php echo $this->getGroup($field->group); ?>
			</td>
			<td align="center" id="privacy<?php echo $field->id;?>">
				<?php echo $field->privacy; ?>
			</td>
			<td align="center" id="template<?php echo $field->id;?>">
				<?php echo $field->template; ?>
			</td>
			<td align="center" id="jusertype<?php echo $field->id;?>">
				<?php echo $field->jusertype; ?>
			</td>
			<td align="center" id="avatar<?php echo $field->id;?>">
				<?php echo $field->avatar; ?>
			</td>
			<td align="center" id="approve<?php echo $field->id;?>">
				<?php 
					$yntext	= $field->approve ? 'Yes' :'No';
					echo $yntext;
				?>
			</td>
			<td align="center" id="allowt<?php echo $field->id;?>">
				<?php 
					$yntext	= $field->allowt ? 'Yes' :'No';
					echo $yntext;
				?>
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
			<td align="right">
				<span><?php echo $this->pagination->orderUpIcon( $count , true, 'orderup', 'Move Up'); ?></span>
				<span><?php echo $this->pagination->orderDownIcon( $count , count($this->fields), true , 'orderdown', 'Move Down', true ); ?></span>
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
<div class="clr"></div>
<input type="hidden" name="view" value="profiletypes" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_xipt" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>	