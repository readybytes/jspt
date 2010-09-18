<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');
?>

<form action="<?php echo JURI::base();?>index.php?option=com_xipt" method="post" name="adminForm" id="adminForm">
<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="1%">
				<?php echo JText::_( 'NUM' ); ?>
			</th>
			<th width="29%" class="title">
					<?php echo JText::_( 'FIELD NAME' ); ?>
			</th>
			<?php 
			foreach($this->categories as $catIndex => $catInfo)
			{
				$catName = $catInfo['name'];	
			?>
			<th width="15%" class="title">
					<?php echo JText::_( $catName ); ?>
			</th>
			<?php 
			}
			?>
		</tr>
	</thead>
		<?php
		$count = 0;
		$i  = 0;
		
		if(!empty($this->fields))
		foreach($this->fields as $field)
		{
			//$input	= JHTML::_('grid.id', $count, $field->id);
			
			if($field->type != "group")
			{
				++$i;
				?>
				<tr class="row<?php echo $i%2;?>" id="rowid<?php echo $field->id;?>">
				<td><?php echo $i;?></td>
				<td>
					<span class="editlinktip" title="<?php echo $field->name; ?>" id="name<?php echo $field->id;?>">
					<?php $link = XiPTRoute::_('index.php?option=com_xipt&view=profilefields&task=edit&editId='.$field->id, false); ?>
						&nbsp;&nbsp;|_ <A HREF="<?php echo $link; ?>"><?php echo $field->name; ?></A>
					</span>
				</td>
				<?php 
				foreach($this->categories as $catIndex => $catInfo)
				{		
					$controlName = $catInfo['controlName'];	
					?>
					<td align="center">
						<span id="<?php echo "$controlName"."$field->id";?>" onclick="$('typeOption').style.display = 'block';$(this).style.display = 'none';">
						<?php 
							echo XiPTHelperProfileFields::getProfileTypeNamesForFieldId( $field->id,$catIndex); 
						?>
						</span>
					</td>
					<?php 
				}
				?>
				
				</tr>
				<?php
			}
			else
			{?>
				<tr>
				<td>
				<?php echo ""; ?>
				</td>
				<td>
					<span class="editlinktip" title="<?php echo $field->name; ?>" id="name<?php echo $field->id;?>">
					<?php $link = XiPTRoute::_('index.php?option=com_xipt&view=profilefields&task=edit&editId='.$field->id, false); ?>
						Group <A HREF="<?php echo $link; ?>"><?php echo $field->name; ?></A>
					</span>
				</td>
				<?php 
				foreach($this->categories as $catIndex => $catInfo)
				{		
					$controlName = $catInfo['controlName'];	
					?>
				<td align="center">
					<span id="<?php echo "$controlName"."$field->id";?>" onclick="$('typeOption').style.display = 'block';$(this).style.display = 'none';">
					<?php 
						echo XiPTHelperProfileFields::getProfileTypeNamesForFieldId( $field->id,$catIndex); 
					?>
					</span>
				</td>
				<?php 
				}
				?>
				</tr>
			<?php
			$i = 0;
			}
		}
		?>
</table>

<div class="clr"></div>

	<input type="hidden" name="option" value="com_xipt" />
	<input type="hidden" name="view" value="profilefields" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>

