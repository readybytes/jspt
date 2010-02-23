	<div class="registerProfileType">
	<h3 id="Title"><?php
	echo JText::_ ( 'CHOOSE PROFILE TYPE' );
	?></h3>
	<br />
	<?php 
	echo JText::_ ( 'PROFILE TYPE DESCRIPTION FOR SELECTBOX' );
	//start select tag
	if(!$showAsRadio){	
	?>	
		<select id="profiletypes" name="profiletypes" 
				class="select required" >
	<?php
	}
	
	if (!empty ( $allProfileTypes )) {
		
		foreach ( $allProfileTypes as $pType ) {

			$selected = '';
			// check if selected
			if ($selectedProfileTypeID == $pType->id)
				$selected = 'checked="true"';

			if($showAsRadio)
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
					</div>
				</div>
				
				<div class="clr"></div>
			<?php
			}
			else
			{
				// show as selectbox	
			    $option		= JText::_($pType->name);
				$id			= $pType->id;
			    
			    $selected	= ( JString::trim($id) == $selectedProfileTypeID ) ? ' selected="true"' : '';
				echo '<option value="' . $id . '"' 
							. $selected . ' '
							.  '>' 
							. $option . '</option>';
			}
		}
		
		//end select tag
		if(!$showAsRadio){
		?>	
			</select>
		<?php
		}
	
	}
	?>
	</div>
<?php 
