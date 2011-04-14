<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

?>
<script type="text/javascript" src="<?php echo JURI::root().'components/com_xipt/assets/js/jquery1.4.2.js';?>" ></script>
<script type="text/javascript">jQuery.noConflict();</script>
<script language="javascript" type="text/javascript">
<?php 
If(XIPT_JOOMLA_16)
{
	?>
/** FOR JOOMLA1.6 **/
Joomla.submitbutton=function(action) {
	submitbutton(action);
}
<?php }?>

function submitbutton(action){	
	var form = document.adminForm;
		switch(action)
		{
		case 'save':case 'apply':			
			if( form.name.value == '' )
			{
				alert( "<?php echo XiptText::_( 'YOU_MUST_PROVIDE_A_PROFILETYPE_NAME', true ); ?>" );
				break;
			}
			<?php
	                $editor =& JFactory::getEditor();
	                echo $editor->save( 'tip' );
	        ?>
		case 'publish':
		case 'unpublish':
		case 'cancel':
		default:
			submitform( action );
		}
	}
	
	jQuery(document).ready(function($){
    	$('#resetAll1').click(function(){
           if(!confirm('Are you confirm to reset properties of all existing users')){
				$('#resetAll0').attr("checked", "checked"); 
           }
        });
	});
</script>


<div style="background-color: #F9F9F9; border: 1px solid #D5D5D5; margin-bottom: 10px; padding: 5px;font-weight: bold;">
	<?php echo XiptText::_('CREATE_NEW_PROFILE_TYPE_FOR_YOUR_SITE');?>
</div>
<div id="error-notice" style="color: red; font-weight:700;"></div>
<div style="clear: both;"></div>
<form enctype="multipart/form-data" action="<?php echo JURI::base();?>index.php?" method="post" name="adminForm" id="adminForm">
<table cellspacing="0" class="admintable" border="0" width="100%">
	<tbody>
		<tr valign="top">
			<td width="60%">
				<fieldset>
					<legend>
						<?php echo XiptText::_( 'PROFILETYPE_SETTINGS' ); ?>
					</legend>
					<table width="100%">
						<tr>
							<td class="key">
							<label class="hasTip" title="<?php echo XiptText::_('TITLE'); ?>::<?php echo XiptText::_('PTYPE_TITLE_DESC'); ?>">
							<?php echo XiptText::_('TITLE'); ?></label>
							</td>	
							<td>
								<input type="text" value="<?php echo $this->data->name;?>" name="name" />
							</td>
						</tr>
						<tr>
							<td class="key">
								<label class="hasTip" title="<?php echo XiptText::_('PUBLISHED'); ?>::<?php echo XiptText::_('PTYPE_PUBLISHED_DESC'); ?>">
								<?php echo XiptText::_('PUBLISHED');?></label>
								</td>
							<td>
								<span><?php echo JHTML::_('select.booleanlist',  'published', '', $this->data->published);?></span>
							</td>
						</tr>						
						<tr>	
						<td class="key">
								<label class="hasTip" title="<?php echo XiptText::_('REQUIRE_APPROVAL'); ?>::<?php echo XiptText::_('PTYPE_REQUIRE_APPROVAL_DESC'); ?>">
								<?php echo XiptText::_('REQUIRE_APPROVAL');?>
								</label>
						</td>		
							<td>
								<span><?php echo JHTML::_('select.booleanlist',  'approve', '', $this->data->approve );?></span>
							</td>					
						</tr>
						<tr>
							<td class="key">
								<label class="hasTip" title="<?php echo XiptText::_('DEFAULT_JOOMLA_USER_TYPE_SETTINGS_FOR_PROFILE'); ?>::<?php echo XiptText::_('PTYPE_DEFAULT_JOOMLA_USER_TYPE_SETTINGS_FOR_PROFILE_DESC'); ?>">
								<?php echo XiptText::_('DEFAULT_JOOMLA_USER_TYPE_SETTINGS_FOR_PROFILE');?></label>
								</td>
							<!--<td colspan="4"> -->
							<td>
								<?php echo XiptHelperProfiletypes::buildTypes($this->data->jusertype,'jusertype');?>
							</td>
						</tr>
						<tr>	
							<td class="key">
								<label class="hasTip" title="<?php echo XiptText::_('DEFAULT_TEMPLATE_SETTINGS_FOR_PROFILE'); ?>::<?php echo XiptText::_('PTYPE_DEFAULT_TEMPLATE_SETTINGS_FOR_PROFILE_DESC'); ?>">
								<?php echo XiptText::_('DEFAULT_TEMPLATE_SETTINGS_FOR_PROFILE');?></label>
							</td>
							<td>
								<?php echo XiptHelperProfiletypes::buildTypes($this->data->template, 'template');?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label class="hasTip" title="<?php echo XiptText::_('DESCRIPTION_OF_PROFILE_TYPE'); ?>::<?php echo XiptText::_('PTYPE_DESCRIPTION_OF_PROFILE_TYPE_DESC'); ?>">
								<?php echo XiptText::_('DESCRIPTION_OF_PROFILE_TYPE');?></label>
							</td>	
							<td>
							<?php 
								echo $editor->display( 'tip',  htmlspecialchars($this->data->tip, ENT_QUOTES),
								'350', '200', '60', '20', array('pagebreak', 'readmore') ) ;
							?>
							</td>		
						</tr>
					</table>
				</fieldset>
				</td>
				
				<td width="60%">
					<fieldset>
						<legend><?php echo XiptText::_( 'PARAMETERS' ); ?>	</legend>
						<table width="100%">
							<tr><td>
							<?php echo $this->pane->startPane("parameters-pane");?>
							<?php echo $this->pane->startPanel(XiptText :: _('ASSIGNMENTS'), 'assignments-page');?>
							<table>
								<tr>
								<td class="key" >
								<label class="hasTip" title="<?php echo XiptText::_('DEFAULT_AVATAR');?>::<?php echo XiptText::_('DEFAULT_AVATAR_DESC'); ?>">
									<?php echo XiptText::_('DEFAULT_AVATAR');?></label>
									</td>

									<td><div>							
										<div>
											<img src="<?php echo JURI::root().XiptHelperUtils::getUrlpathFromFilePath($this->data->avatar);?>" width="64" height="64" border="0" alt="<?php echo $this->data->avatar; ?>" />
										</div>
										<div class='clr'></div>
										<div>
											<input class="inputbox button" type="file" id="file-upload" name="FileAvatar" style="color: #666;" />
										</div>
										</div>
									</td>
								</tr>
								
								<tr><td></td>						
									<td><span class="editlinktip">
										<?php $link = XiptRoute::_('index.php?option=com_xipt&view=profiletypes&task=removeAvatar&id='.$this->data->id.'&oldAvatar='.$this->data->avatar, false); ?>
										<a href="<?php echo $link; ?>"><?php echo XiptText::_('REMOVE_AVTAR'); ?></a>
										</span>								
									</td>
								</tr>
										
								<tr>
								<td class="key" >
								<label class="hasTip" title="<?php echo XiptText::_('VISIBLE');?>::<?php echo XiptText::_('VISIBLE_DESC'); ?>">
									<?php echo XiptText::_('VISIBLE');?>
								</label></td>
								<td><?php echo JHTML::_('select.booleanlist',  'visible', '', $this->data->visible);?></td>
								</tr>
									
								<tr>
								<td class="key" >
								<label class="hasTip" title="<?php echo XiptText::_('ALLOW_TEMPLATE');?>::<?php echo XiptText::_('ALLOW_TEMPLATE_DESC'); ?>">
									<?php echo XiptText::_('ALLOW_TEMPLATE');?>
								</label></td>
									<td><?php echo JHTML::_('select.booleanlist',  'allowt', '', $this->data->allowt );?></td>
								</tr>
								<tr>	
								<td class="key" >
								<label class="hasTip" title="<?php echo XiptText::_('SELECT_DEFAULT_GROUP_TO_ASSIGN');?>::<?php echo XiptText::_('SELECT_DEFAULT_GROUP_TO_ASSIGN_DESC'); ?>">
									<?php echo XiptText::_('SELECT_DEFAULT_GROUP_TO_ASSIGN');?>
								</label>
								</td>
									<td><?php echo XiptHelperProfiletypes::buildTypes($this->data->group,'group',true);?></td>			
								</tr>
									
							</table>
							<?php 
								echo $this->pane->endPanel();								
								
								echo $this->pane->startPanel(XiptText :: _('PRIVACY_SETTINGS'), 'xiprivacysettings-page');
								echo $this->privacyParams->render('privacy');
								echo $this->pane->endPanel();
								
								echo $this->pane->startPanel(XiptText::_('REGISTRATION'), 'xiconfiguration-page');
								echo $this->configParams->render('config');
								echo $this->pane->endPanel();
							
								echo $this->pane->startPanel(XiptText :: _('WATERMARK'), 'watermark-page');
								echo $this->watermarkParams->render('watermarkparams');
								echo $this->pane->endPanel();
								
								echo $this->pane->startPanel(XiptText::_('RESET_ALL'), 'resetall-page');
								echo XiptText::_('ON_SAVING_DO_YOU_WANT_TO_RESET_PROPERTIES_OF_ALL_EXISTING_USERS');	
								echo JHTML::_('select.booleanlist',  'resetAll', '', '0' );
								echo $this->pane->endPanel();
								
								echo $this->pane->endPane();
							?>
							</td></tr>
						</table>
					</fieldset>
				</td>
			</tr>
	</tbody>
</table>

<div class="clr"></div>
	<input type="hidden" name="option" value="com_xipt" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'profiletypes' );?>" />
	<input type="hidden" name="id" value="<?php echo $this->data->id; ?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
<?php 

