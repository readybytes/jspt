<?php
// Disallow direct access to this file
if(!defined('_JEXEC')) die('Restricted access');
?>
	<?php 
	
	// Jom Social Profile field comfiguration
			
	echo JHtmlSliders::panel( "1. " . JText::_('COM_XIPT_JOMSOCIAL_PROFILE_FIELD_CONFIGURATION'), 'jsprofilefield' );
	?>
	<ol>
		<?php if($this->field->published == 0){?><li><?php echo JText::_('COM_XIPT_THIS_FIELD_IS');?><span style="color:red;"><?php echo JText::_('COM_XIPT_NOT_PUBLISHED');?></span><?php echo JText::_('COM_XIPT_IN_JOMSOCIAL_CUSTOM_PROFILES_PLEASE_PUBLISH_IT');?></li><?php }?>
		<?php if($this->field->required == 0){?><li><?php echo JText::_('COM_XIPT_THIS_FIELD_IS_SET_TO');?><span style="color:red;"><?php echo JText::_('COM_XIPT_NOT_REQUIRED');?></span><?php echo JText::_('COM_XIPT_IN_JOMSOCIAL_CUSTOM_PROFILES_PLEASE_MAKE_IT_REQUIRED');?></li><?php }?>
		<?php if($this->field->visible == 0){?><li><?php echo JText::_('COM_XIPT_THIS_FIELD_IS_SET_TO');?><span style="color:red;"><?php echo JText::_('COM_XIPT_NOT_VISIBLE');?></span><?php echo JText::_('COM_XIPT_FOR_USER_IN_JOMSOCIAL_CUSTOM_PROFILES_PLEASE_MAKE_IT_REQUIRED');?></li><?php }?>
		<?php if($this->field->published == 1 
				&& $this->field->required == 1
				&& $this->field->visible == 1){
				?><li> <?php echo JText::_('');?><?php echo JText::_('COM_XIPT_ALL_THE_SETTINGS_FOR_PROFILE_FIELDS_HAVE_BEEN_CONFIGURED_CORRECTLY');?></li><?php 
				}?>
	</ol>
	<?php 
	
	echo JHtmlSliders::panel( "2. " . JText::_('COM_XIPT_ALLOW'), 'allow' );
	?>
	<ol>
		<li><?php echo JText::_('COM_XIPT_THIS_FIELD_MUST_BE_PUBLISHED_AND_VISIBLE_IN_JOMSOCIAL_CUSTOM_PROFILE');?></li>
		<li><?php echo JText::_('COM_XIPT_THIS_FIELD_WILL_ONLY_BE_ALLOWED_TO_THE_USERS_OF_SELECTED_PROFILETYPE');?></li>
		<li><?php echo JText::_('COM_XIPT_IF_YOU_ARE_CONFIGURING_THIS_FIRST_TIME_THIS_FIELD_WILL_BE_ALLOWED_TO_ALL_USER');?></li>
	</ol>
	<?php 
	
	
	echo JHtmlSliders::panel( "3. " . JText::_('COM_XIPT_REQUIRE'), 'required' );
	?>
		<ol>
		<li><?php echo JText::_('COM_XIPT_THIS_FIELD_MUST_BE_PUBLISHED_REQUIRED_AND_VISIBLE_IN_JOMSOCIAL_CUSTOM_PROFILE');?></li>
		<li><?php echo JText::_('COM_XIPT_THIS_FIELD_WILL_ONLY_BE_REQUIRED_TO_THE_USERS_OF_SELECTED_PROFILETYPE');?></li>
		<li><?php echo JText::_('COM_XIPT_IF_YOU_ARE_CONFIGURING_THIS_FIRST_TIME_THIS_FIELD_WILL_BE_REQUIRED_TO_ALL_USER');?></li>
	</ol>
	<?php 
	
	echo JHtmlSliders::panel( "4. " . JText::_('COM_XIPT_VISIBL'), 'visible' );
	?>
		<ol>
		<li><?php echo JText::_('COM_XIPT_THIS_FIELD_MUST_BE_PUBLISHED_AND_VISIBLE_IN_JOMSOCIAL_CUSTOM_PROFILE');?></li>
		<li><?php echo JText::_('COM_XIPT_THIS_FIELD_WILL_BE_VISIBLE_AT_THE_TIME_OF_EDITING_PROFILE');?></li>
		<li><?php echo JText::_('COM_XIPT_FOR_OTHER_USERS_IT_WILL_ONLY_BE_VISIBLE_AT_THE_TIME_OF_EDITING_PROFILE');?></li>
		<li><?php echo JText::_('COM_XIPT_IF_YOU_ARE_CONFIGURING_THIS_FIRST_TIME_THIS_FIELD_WILL_BE_VISIBLE_TO_ALL_USER');?></li>
	</ol>
	<?php
	
	echo JHtmlSliders::panel( "5. " . JText::_('COM_XIPT_EDITABLE_AFTER_REGISTRATION'), 'editableAfterRegistration' );
	?>
		<ol>
		<li><?php echo JText::_('COM_XIPT_THIS_FIELD_MUST_BE_PUBLISHED_AND_VISIBLE_IN_JOMSOCIAL_CUSTOM_PROFILE');?></li>
		<li><?php echo JText::_('COM_XIPT_THIS_FIELD_WILL_BE_VISIBLE_AFTER_REGISTRATION_WHEN_EDITING_PROFILE_FOR_SELECTED_PROFILETYPE');?></li>
		<li><?php echo JText::_('COM_XIPT_FOR_OTHER_USERS_IT_WILL_ONLY_BE_VISIBLE_AT_THE_TIME_OF_REGISTRATION_AND_VIEWING_SELF_PROFILE');?></li>
		<li><?php echo JText::_('COM_XIPT_IF_YOU_ARE_CONFIGURING_THIS_FIRST_TIME_THIS_FIELD_WILL_BE_EDITABLE_AFTER_REGISTRATION_TO_ALL_USER');?></li>
	</ol>
	<?php 	
	
	echo JHtmlSliders::panel( "6. " . JText::_('COM_XIPT_EDITABLE_DURING_REGISTRATION'), 'editableDurinRegistration' );
	?>
		<ol>
		<li><?php echo JText::_('COM_XIPT_THIS_FIELD_MUST_BE_PUBLISHED_AND_VISIBLE_IN_JOMSOCIAL_CUSTOM_PROFILE_AND_SET_TO_VISIBLE_IN_THIS_CONFIGURATION');?></li>
		<li><?php echo JText::_('COM_XIPT_THIS_FIELD_WILL_BE_VISIBLE_DURING_REGISTRATION_FOR_SELECTED_PROFILETYPE');?></li>
		<li><?php echo JText::_('COM_XIPT_FOR_OTHER_USERS_IT_WILL_ONLY_BE_VISIBLE_AT_THE_TIME_OF_REGISTRATION');?></li>
		<li><?php echo JText::_('COM_XIPT_IF_YOU_ARE_CONFIGURING_THIS_FIRST_TIME_THIS_FIELD_WILL_BE_EDITABLE_DURING_REGISTRATION_TO_ALL_USER');?></li>
	</ol>
	<?php 	
	
	echo JHtmlSliders::panel( "7. " . JText::_('COM_XIPT_ADVANCE_SEARCHABL'), 'advanceSearchable' );
	?>
		<ol>
		<li><?php echo JText::_('COM_XIPT_THIS_FIELD_WILL_BE_VISIBLE_DURING_ADVANCE_SEARCH');?></li>
	</ol>
	<?php 	