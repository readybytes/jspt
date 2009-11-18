<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>

<form action="<?php echo JURI::base();?>index.php?option=com_xipt&view=setup" method="post" name="adminForm">
<div>
	<div style="float:left;"> 
	<?php 
		if($this->requiredSetup) {
			$counter = 1; 
			?>
			<table>
			<?php 
			$complete = '<img src="images/tick.png" alt="done" />';
			$notcomplete = '<img src="images/publish_x.png" alt="not complete" />';
			foreach($this->requiredSetup as $util) {
				?>
				<tr>
				 <td><?php  echo $counter.". ";?></td>
				 <td><?php  echo $util['message'];?></td>
				 <td><?php  if($util['done'])
				 				echo $complete;
				 			else 
				 				echo $notcomplete;
				 				?>
				 </td>
				 </tr>
				 <?php 
				 $counter++;
			}
			?></table><?php 
		}
	?>
	</div>
	<div style="float:inherit; margin-left:50%;">
			<?php
				echo $this->pane->startPane( 'stat-pane' );
				echo $this->pane->startPanel( JText::_('WHAT MEANS SETUP') , 'setupmean' );
			?>
			<div style="font-weight:700;">
							<?php echo "1. ".JText::_('WHAT IS PROFILETYPE VALIDATION');?>
			</div>
			<p>
				It check is their any profiletype exist in your system ,
				for properly working of JSPT profiletype should exist in system. 
			</p>
			
			<div style="font-weight:700;">
							<?php echo "2. ".JText::_('HOW TO SET DEFAULT PROFILETYPE');?>
			</div>
			<p>
				 Link will be visible if no default profiletype is set.
				 To set default profiletype click that link and make a selection.
			</p>
			<?php
				echo $this->pane->endPanel();
				echo $this->pane->endPane();
			?>
	</div>
	</div>
<input type="hidden" name="view" value="setup" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_xipt" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>	