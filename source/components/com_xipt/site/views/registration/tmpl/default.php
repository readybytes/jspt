<?php
// Disallow direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
?>
<form action="<?php echo JRoute::_( 'index.php?option=com_xipt&view=registration',false ); ?>" method="post" name="ptypeForm">
 
	<div class="registerProfileType">
	<h3 id="Title"><?php
	echo JText::_ ( 'CHOOSE PROFILE TYPE' );
	?></h3>
	<?php 

	//start select tag
	if(!$this->showAsRadio){
	?>	
		<select id="profiletypes" name="profiletypes" 
				class="select required" >
	<?php
	}
	
	if (!empty ( $this->allProfileTypes )) {
		
		foreach ( $this->allProfileTypes as $pType ) {

			$selected = '';
			// check if selected
			if ($this->selectedProfileTypeID == $pType->id)
				$selected = 'checked="true"';

			if($this->showAsRadio)
			{
			?>		
				<div class="singlePT">
		
					<div id="Name">
							<input type="radio" id="profiletypes<?php echo $pType->id?>" name="profiletypes" 
									value="<?php echo $pType->id;?>" <?php echo $selected; ?> />
							<?php echo JText::_($pType->name); ?>
					</div>
		
					<div id="Details">
						<div id="Avatar">
							<img src="<?php echo $pType->avatar; ?>" height="60px" width="60px"/>
						</div>
						<p id="Description"> <?php echo JText::_($pType->tip); ?> </p>
						
					</div>
				</div>
				
				
			<?php
			}
			else
			{
				// show as selectbox	
			    $option		= JText::_($pType->name);
				$id			= $pType->id;
			    
			    $selected	= ( JString::trim($id) == $this->selectedProfileTypeID ) ? ' selected="true"' : '';
				echo '<option value="' . $id . '"' 
							. $selected . ' '
							.  '>' 
							. $option . '</option>';
			}
		}
		
		//start select tag
		if(!$this->showAsRadio){
		?>	
			</select>
		<?php
		}
	
	}
	?>
	</div>
<div class="clr" title="Next"></div>
<input type="submit" id="ptypesavebtn" name="save" value="Next"/> 
<input type="hidden" name="view" value="registration" /> 
<input type="hidden" name="task" value="" /> 
<input type="hidden" name="option" value="com_xipt" /> 
<input type="hidden" name="boxchecked" value="0" />
<?php  echo JHTML::_ ( 'form.token' ); ?>
</form><?php 
