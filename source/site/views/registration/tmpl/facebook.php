<?php /**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
	<link rel="stylesheet" href="<?php echo JURI::root().'/components/com_xipt/assets/style.css'; ?>" type="text/css"  />
	<div class="registerProfileType">
	<h3 id="Title"><?php
	echo JText::_ ( 'CHOOSE PROFILE TYPE' );
	?></h3>
	<div class='clr'></div>
	<?php
	echo JText::_ ( 'PROFILE TYPE DESCRIPTION FOR SELECTBOX' )."<br />";
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
							<img src="<?php echo JURI::root().XiFactory::getUrlpathFromFilePath($pType->avatar); ?>" height="60px" width="60px"/>
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
			    
			    $selected	= ( JString::trim($id) == $selectedProfileTypeID ) ? ' selected="true"' : '';
				?>
				<div class='clr'></div>
				<?php 
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
