<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
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
			if( !confirm( '<?php echo JText::_('ARE YOU SURE YOU WANT TO DELETE THIS PROFILE TYPE?'); ?>' ) )
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
				<?php echo JText::_( '#' ); ?>
			</th>
			<th width="1%">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->fields ); ?>);" />
			</th>
			<th width="1%">
				<?php echo JText::_( 'PROFILETYPE-ID' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'NAME' ); ?>
			</th>
			<th width="10%">
				<?php echo JText::_( 'AVATAR' ); ?>
			</th>
			<th width="10%">
				<?php echo JText::_( 'WATERMARK' ); ?>
			</th>
			<th width="10%">
				<?php echo JText::_( 'TEMPLATE' ); ?>
			</th>
			<th width="10%">
				<?php echo JText::_( 'JOOMLA USER TYPE' ); ?>
			</th>
			<th width="5%">
				<?php echo JText::_( 'REQUIRE APPROVAL' ); ?>
			</th>
			<th width="5%">
				<?php echo JText::_( 'ALLOW TEMPLATE' ); ?>
			</th>
			<th width="5%">
				<?php echo JText::_( 'PUBLISHED' ); ?>
			</th>
			<th width="5%">
				<?php echo JText::_( 'VISIBLE' ); ?>
			</th>
			<th width="5%" align="center">
				<?php echo JText::_( 'ORDERING' ); ?>
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
			<td><?php echo $field->id;?></td>
			<td>
				<span class="editlinktip" title="<?php echo $field->name; ?>" id="name<?php echo $field->id;?>">
					<?php $link = XiPTRoute::_('index.php?option=com_xipt&view=profiletypes&task=edit&editId='.$field->id, false); ?>
						<a href="<?php echo $link; ?>"><?php echo $field->name; ?></a>
				</span>
			</td>
			<td align="center" id="avatar<?php echo $field->id;?>">
			
							
				<img src="<?php echo JURI::root().XiFactory::getUrlpathFromFilePath($field->avatar);?>" width="64" height="64" border="0" alt="<?php echo $field->avatar; ?>" />	
			</td>
			<td align="center" id="watermark<?php echo $field->id;?>">
				
				<img src="<?php echo JURI::root().XiFactory::getUrlpathFromFilePath($field->watermark);?>"  border="0" alt="<?php echo $field->watermark; ?>" />	
			</td>
			<td align="center" id="template<?php echo $field->id;?>">
				<?php echo $field->template; ?>
			</td>
			<td align="center" id="jusertype<?php echo $field->id;?>">
				<?php echo $field->jusertype; ?>
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
			<td align="center" id="visible<?php echo $field->id;?>">
				<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i-1;?>','<?php echo $field->visible ? 'invisible' : 'visible' ?>')">
							<?php if($field->visible)
							{ ?>
								<img src="images/tick.png" width="16" height="16" border="0" alt="Visible" /></a>
							<?php 
							}
							else 
							{ ?>
								<img src="images/publish_x.png" width="16" height="16" border="0" alt="Invisible" /></a>
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

