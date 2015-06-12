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
<style>
<!--
	div.xipt-container div.profile-type-container div.xipt-description{
		padding-left:10px;
	}
-->
</style>
<?php 
foreach ( $this->allProfileTypes as $pType ) :

	?>	
	<div class="container-fluid profile-type-container">
			<div class="row-fluid profile-type">
				<div class="span2" id="Avatar">
					<div class="row-fluid">
						<input 	class="pt-avatarImage"type	="image" title = "<?php echo XiptText::_('CLICK_ON_ME');?>" 
						name	="<?php echo $pType->name; ?>" 
						src		="<?php echo XiptHelperUtils::getAvatarPath($pType->avatar); ?>" 
						style="height:<?php echo REG_PROFILETYPE_AVATAR_HEIGHT; ?>px;width:<?php echo REG_PROFILETYPE_AVATAR_WIDTH; ?>px;"
						onclick="javascript:submitURL(<?php echo $pType->id; ?>);" 
					/>
					</div>					
				</div>
				
				<div class="span10 xipt-description">
					<div class="row-fluid">
						<h3 id="Name" class="pt-name">
						<?php echo $pType->name; ?>
						</h3>
						<div class="pt-description">
						<p id="Description"> <?php echo $pType->tip;?> </p>
						</div>
						<hr>					
					</div>
					<div class="row-fluid pt-select-button">
						<input 	class="pull-right joms-button joms-button--primary joms-button--small" type="button" name="save" value="<?php echo XiptText::_('NEXT');?>" 
					 	onclick="javascript:submitURL(<?php echo $pType->id; ?>);" />
					</div>
				</div>
			</div>
	</div>
		
	
	<?php
endforeach;

?>
<input type="hidden" name="profiletypes" id="profiletypeAvatar" value="<?php echo $pType->id; ?>" /> 
<input type="hidden" name="save" value="<?php echo XiptText::_('NEXT');?>" /> 
<?php 
