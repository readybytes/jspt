<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
?>
<div class="row-fluid">
	<select id="profiletypes" name="profiletypes" class="select required pt-font-color" >
                             
		<?php				
		foreach ( $this->allProfileTypes as $pType ):
		
			$selected = '';
			// check if selected
			if ($this->selectedPT == $pType->id)
				$selected = 'checked="true"';
		
			// show as selectbox	
		    $option		= $pType->name;
			$id			= $pType->id;
		    
		    $selected	= ( JString::trim($id) == $this->selectedPT ) ? ' selected="true"' : '';
			echo '<option value="' . $id . '"' 
						. $selected . ' '
						.  '>' 
						. $option . '</option>';
		endforeach;			
		?>
	</select>
</div>
<div class="row-fluid">
	<input class="joms-button joms-button--primary joms-button--small" type="submit" id="ptypesavebtn" name="save" value="<?php echo XiptText::_('NEXT');?>"/>
</div>
<?php
