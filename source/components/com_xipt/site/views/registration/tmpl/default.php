<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'profiletypes.php');
?>

<form action="<?php echo JURI::base();?>index.php?option=com_xipt&view=registration" method="post" name="ptypeForm">
<table class="adminlist" cellspacing="1">
	<div class="xipt-profile-types">
				<h3 class="frontTitle"><?php echo JText::_( 'CC CHOOSE PROFILE TYPE');?></h3>
						<?php 
						if(!empty($this->profileTypes))
							foreach($this->profileTypes as $key => $value) {
								
							if($value)
								$selected = 'checked="true"';
							else
								$selected = '';
						?>
							<div>
								<label class="label" style="
							font-size: 14px; color: #000000;
							line-height: 16px;height: 16px;
							font-weight: bold;padding-top:10px;">
							
							<input type="radio" id="profiletypes" name="profiletypes"
							 value="<?php echo $key ;?>" <?php echo $selected ; ?> style="margin: 0 5px 0 0;" />
							 <?php echo XiPTLibraryProfiletypes::getProfileTypeNameFromID($key) ;?>
							 </label>
							</div>
						<?php 
							}
						?>
	</div>

</table>
<div class="clr"></div>
<input type="submit" name="save" value="save" />
<input type="hidden" name="view" value="registration" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_xipt" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>	