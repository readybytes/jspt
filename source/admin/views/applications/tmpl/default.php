<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
if(!defined('_JEXEC')) die('Restricted access');
?>

<form action="<?php echo JURI::base();?>index.php?option=com_xipt" method="post" name="adminForm">
<table class="adminlist" cellspacing="1">
	<thead>
		<tr class="title">		
			<th width="1%">
				<?php echo XiptText::_( '#' ); ?>
			</th>
			<th width="5%">
				<?php echo XiptText::_( 'APPLICATION ID' ); ?>
			</th>
			<th>
				<?php echo XiptText::_( 'JOMSOCIAL APPLICATION NAME' ); ?>
			</th>
			<th width="50%">
				<?php echo XiptText::_( 'AVAILABLE TO PROFILE TYPES' ); ?>
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
			<td align='center'>
				<span class="editlinktip" title="<?php echo $field->id; ?>" id="<?php echo $field->id;?>">
					<?php echo $field->id ; ?>
				</span>
			</td>
			<td>
				<span class="editlinktip" title="<?php echo $field->name; ?>" id="name<?php echo $field->id;?>">
					<?php $link = XiptRoute::_('index.php?option=com_xipt&view=applications&task=edit&id='.$field->id, false); ?>
						<A HREF="<?php echo $link; ?>"><?php echo $field->name; ?></A>
				</span>
			</td>
			<td align="center" id="profiletype<?php echo $field->id;?>">
				<?php echo XiptHelperApps::getProfileTypeNames($field->id); ?>
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
<?php 


