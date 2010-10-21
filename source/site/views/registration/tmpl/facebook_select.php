<?php /**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

?>	
	<select id="profiletypes" name="profiletypes" class="select required" >
<?php
	
foreach ( $this->allProfileTypes as $pType ) :	

		$selected = '';
		// check if selected
		if ($this->selectedPT == $pType->id)
			$selected = 'checked="true"';

		// show as selectbox	
	    $option		= XiptText::_($pType->name);
		$id			= $pType->id;
	    
	    $selected	= ( JString::trim($id) == $this->selectedPT ) ? ' selected="true"' : '';
		?>		
	 	<option value="<?php echo $id; ?>" 
			     <?php echo $selected; ?>
				> <?php echo $option; ?>
		</option>
		<?php
 endforeach; ?>
  
	</select>

<?php 
