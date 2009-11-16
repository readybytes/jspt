<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>

<form action="<?php echo JURI::base();?>index.php?option=com_xipt&view=setup" method="post" name="adminForm">
<table class="adminlist" cellspacing="1">
<tr>
	<?php 
		//@TODO : check whether custom field exitst or not
		//Default ptype exist or not
		//profiletypes exist or not
		//patch file 
		if($this->requiredSetup) {
			$counter = 1; 
			?>
			<table>
			<?php 
			$complete = '<img src="images/tick.png" alt="done" />';
			$notcomplete = '<img src="images/cancel_f2.png" alt="not complete" />';
			foreach($this->requiredSetup as $util) {
				?>
				<tr>
				 <td><?php  echo $counter;?></td>
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
		}
	?>
</table>
<div class="clr"></div>
<input type="hidden" name="view" value="setup" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_xipt" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>	