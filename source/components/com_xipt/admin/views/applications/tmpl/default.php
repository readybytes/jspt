<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>

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
				<?php echo JText::_( 'JOMSOCIAL APPLICATION NAME' ); ?>
			</th>
			<th width="20%">
				<?php echo JText::_( 'AVAILABLE TO PROFILE TYPES' ); ?>
			</th>
			<th width="10%">
				<?php echo JText::_( 'APPLICATION ID' ); ?>
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
					<?php $link = XiPTRoute::_('index.php?option=com_xipt&view=applications&task=edit&editId='.$field->id, false); ?>
						<A HREF="<?php echo $link; ?>"><?php echo $field->name; ?></A>
				</span>
			</td>
			<td align="center" id="profiletype<?php echo $field->id;?>">
				<?php echo XiPTHelperApplications::getProfileTypeNamesForApplicationId($field->id); ?>
			</td>
			<td>
				<span class="editlinktip" title="<?php echo $field->id; ?>" id="<?php echo $field->id;?>">
					<?php echo $field->id ; ?>
				</span>
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
<input type="hidden" name="view" value="applications" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_xipt" />
<input type="hidden" name="boxchecked" value="0" />
</form>	
