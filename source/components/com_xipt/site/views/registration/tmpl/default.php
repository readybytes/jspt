<?php
// Disallow direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
?>

<form
	action="<?php echo JRoute::_( 'index.php?option=com_xipt&view=registration',false ); ?>" method="post" name="ptypeForm">

	<div class="registerProfileType">
	<h3 id="Title"><?php
	echo JText::_ ( 'CC CHOOSE PROFILE TYPE' );
	?></h3>
	
	<?php
	if (! empty ( $this->allProfileTypes )) {
		
		foreach ( $this->allProfileTypes as $pType ) {

			// check if selected
			if ($this->selectedProfileTypeID == $pType->id)
				$selected = 'checked="true"';
			else
				$selected = '';
			?>
		
		<div class="singlePT">

			<div id="Name">
					<input type="radio" id="profiletypes<?php echo $pType->id?>" name="profiletypes" 
							value="<?php echo $pType->id;?>" <?php echo $selected; ?> />
					<?php echo $pType->name; ?>
			</div>

			<div id="Details">
				<div id="Avatar">
					<img src="<?php echo $pType->avatar; ?>" height="60px" width="60px"/>
				</div>
				
				<p id="Description"> <?php echo $pType->tip; ?> </p>
			</div>
		</div>
		
		<div class="clr">&nbsp;</div>
	<?php
		}
	}
	?>
	</div>
<div class="clr" title="Next"></div>
<input type="submit" name="save" value="Next"/> 
<input type="hidden" name="view" value="registration" /> 
<input type="hidden" name="task" value="" /> 
<input type="hidden" name="option" value="com_xipt" /> 
<input type="hidden" name="boxchecked" value="0" />
<?php  echo JHTML::_ ( 'form.token' ); ?>
</form><?php 