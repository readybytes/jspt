<?php
if(!defined('_JEXEC')) die('Restricted access');
?>
<script language="javascript" type="text/javascript">
	function submitbutton(action) {
		var form = document.adminForm;
		switch(action)
		{
		case 'save':			
		case 'publish':
		case 'unpublish':
		case 'cancel':
		default:
			submitform( action );
		}
	}
</script>

<script type="text/javascript" src="<?php echo JURI::root().'components/com_xipt/assets/js/jquery1.4.2.js';?>" ></script>
<script type="text/javascript">
	jQuery(document).ready(function($){
			$("div#xiptAdvanceSettings").css("display","none");
			$("input#advanceSettings").click(function(){
			$("div#xiptAdvanceSettings").slideToggle('fast');
		});	
	});
	
</script>
<script type="text/javascript">jQuery.noConflict();</script>


<form action="<?php echo JURI::base();?>index.php?" method="post" name="adminForm">

<div class="col width-45" style="float:left;">
<fieldset class="adminform">
<legend><?php echo XiptText::_( 'BASIC_SETTINGS' ); ?></legend>
	<div>
		<fieldset class="adminform" id="basicPtypeSettings">
		<legend><?php echo XiptText::_( 'PROFILE_TYPE_SETTINGS' ); ?></legend>
		<?php echo $this->settingsParams->render('settings','basicPtypeSettings');?>
		</fieldset>
	</div>
	
	<div>
		<fieldset class="adminform" id="basicIntegrationSettings">
		<legend><?php echo XiptText::_( 'INTEGRATION_SETTINGS' ); ?></legend>
		<?php echo $this->settingsParams->render('settings','basicIntegrationSettings');?>
		</fieldset>
	</div>
		
</fieldset>
</div>


<div class="col width-45" style="float:right;">
<fieldset class="adminform">
<legend><input type="checkbox" id="advanceSettings"><?php echo XiptText::_( 'ADVANCE_SETTINGS' ); ?></legend>
	<div id="xiptAdvanceSettings">
	
		<div>
			<fieldset class="adminform" id="advPtypeSettings">
			<legend><?php echo XiptText::_( 'PROFILE_TYPE_SETTINGS' ); ?></legend>
			<?php echo $this->settingsParams->render('settings','advPtypeSettings');?>
			</fieldset>
		</div>
		
		<div>
			<fieldset class="adminform" id="advRegistrationSettings">
			<legend><?php echo XiptText::_( 'REGISTRATION_SETTINGS' ); ?></legend>
			<?php echo $this->settingsParams->render('settings','advRegistrationSettings');?>
			</fieldset>
		</div>	
		
		<div>
			<fieldset class="adminform" id="advAppsSettings">
			<legend><?php echo XiptText::_( 'APPLICATION_SETTINGS' ); ?></legend>
			<?php echo $this->settingsParams->render('settings','advAppsSettings');?>
			</fieldset>
		</div>		
				
		<div>
			<fieldset class="adminform" id="advAecSettings">
			<legend><?php echo XiptText::_( 'AEC_SETTINGS' ); ?></legend>
			<?php echo $this->settingsParams->render('settings','advAecSettings');?>
			</fieldset>
		</div>
		
		<div>
			<fieldset class="adminform" id="others">
			<legend><?php echo XiptText::_( 'OTHERS'); ?></legend>
			<?php echo $this->settingsParams->render('settings','others');?>
			</fieldset>
		</div>
		
	</div>
</fieldset>	
</div>


<div class="clr"></div>
	<input type="hidden" name="option" value="com_xipt" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'settings' );?>" />
	<input type="hidden" name="name" value="settings" />
	<input type="hidden" name="task" value="" />
	
<?php echo JHTML::_( 'form.token' ); ?>
</form>	
<?php 