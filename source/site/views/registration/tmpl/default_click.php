<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
?>
<script type="text/javascript">
	function submitURL(id)
	 {
		document.getElementById("profiletypeAvatar").value=id;
		document.ptypeForm.method = 'post';
		document.ptypeForm.submit();
 	 }
</script>	
<?php 
foreach ( $this->allProfileTypes as $pType ) :

	?>		
	<div class="singlePT">

		<div id="Name">
				<?php echo $pType->name; ?>
		</div>
		
		<div id="Details">
			<div id="Avatar">
				<input type="image" title = "click on me" name="<?php echo $pType->name; ?>" src="<?php echo JURI::root().XiptHelperUtils::getUrlpathFromFilePath($pType->avatar); ?>" height="<?php echo REG_PROFILETYPE_AVATAR_HEIGHT; ?>" width="<?php echo REG_PROFILETYPE_AVATAR_WIDTH; ?>"
				onclick="javascript:submitURL(<?php echo $pType->id; ?>);" />
			<div>	
			<input type="button" name="save" value="<?php echo XiptText::_('NEXT');?>" onclick="javascript:submitURL(<?php echo $pType->id; ?>);" />
			</div>
			</div>
			<p id="Description"> <?php echo $pType->tip;?> </p>
			
		</div>
			
	</div>
	<?php
endforeach;

?>
<input type="hidden" name="profiletypes" id="profiletypeAvatar" value="<?php echo $pType->id; ?>" /> 
<input type="hidden" name="save" value="<?php echo XiptText::_('NEXT');?>" /> 
<?php 
