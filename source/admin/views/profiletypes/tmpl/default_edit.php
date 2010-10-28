<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');
?>

<script language="javascript" type="text/javascript">
	function submitbutton(action) {
		var form = document.adminForm;
		switch(action)
		{
		case 'save':			
			if( form.name.value == '' )
			{
				alert( "<?php echo XiptText::_( 'You must provide a Profiletype name.', true ); ?>" );
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
</script>


<div style="background-color: #F9F9F9; border: 1px solid #D5D5D5; margin-bottom: 10px; padding: 5px;font-weight: bold;">
	<?php echo XiptText::_('Create new profile types for your site.');?>
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
						<?php echo XiptText::_( 'Profiletype Settings' ); ?>
					</legend>
					<table width="100%">
						<tr>
							<td class="key">
							<label class="hasTip" title="<?php echo JText::_('TITLE'); ?>::<?php echo JText::_('PTYPE TITLE.DESC'); ?>">
							<?php echo JText::_('TITLE'); ?>
							</label>	
							<td>
								<input type="text" value="<?php echo $this->data->name;?>" name="name" />
							</td>
						</tr>
						<tr>
							<td class="key">
								<label class="hasTip" title="<?php echo JText::_('Published'); ?>::<?php echo JText::_('PTYPE PUBLISHED.DESC'); ?>">
								<?php echo XiptText::_('Published');?></td>
								</label>
							<td>
								<span><?php echo JHTML::_('select.booleanlist',  'published', '', $this->data->published);?></span>
							</td>
						</tr>						
						<tr>	
						<td class="key">
								<label class="hasTip" title="<?php echo JText::_('REQUIRE APPROVAL'); ?>::<?php echo JText::_('PTYPE REQUIRE APPROVAL.DESC'); ?>">
								<?php echo XiptText::_('REQUIRE APPROVAL');?></td>
								</label>
							<td>
								<span><?php echo JHTML::_('select.booleanlist',  'approve', '', $this->data->approve );?></span>
							</td>					
						</tr>
						<tr>
							<td class="key">
								<label class="hasTip" title="<?php echo JText::_('DEFAULT JOOMLA USER TYPE SETTINGS FOR PROFILE'); ?>::<?php echo JText::_('PTYPE DEFAULT JOOMLA USER TYPE SETTINGS FOR PROFILE.DESC'); ?>">
								<?php echo XiptText::_('DEFAULT JOOMLA USER TYPE SETTINGS FOR PROFILE');?></td>
								</label>
							<!--<td colspan="4"> -->
							<td>
								<?php echo XiptHelperProfiletypes::buildTypes($this->data->jusertype,'jusertype');?>
							</td>
						</tr>
						<tr>	
							<td class="key">
								<label class="hasTip" title="<?php echo JText::_('DEFAULT TEMPLATE SETTINGS FOR PROFILE'); ?>::<?php echo JText::_('PTYPE DEFAULT TEMPLATE SETTINGS FOR PROFILE.DESC'); ?>">
								<?php echo XiptText::_('DEFAULT TEMPLATE SETTINGS FOR PROFILE');?></td>
								</label>
							<td>
								<?php echo XiptHelperProfiletypes::buildTypes($this->data->template, 'template');?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label class="hasTip" title="<?php echo JText::_('DESCRIPTION OF PROFILE TYPE'); ?>::<?php echo JText::_('PTYPE DESCRIPTION OF PROFILE TYPE.DESC'); ?>">
								<?php echo XiptText::_('DESCRIPTION OF PROFILE TYPE');?></td>
								</label>
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
						<legend><?php echo XiptText::_( 'Parameters' ); ?>	</legend>
						<table width="100%">
							<tr><td>
							<?php echo $this->pane->startPane("parameters-pane");?>
							<?php echo $this->pane->startPanel(XiptText :: _('ASSIGNMENTS'), 'assignments-page');?>
							<table>
								<tr>
								<td class="key" >
								<label class="hasTip" title="<?php echo XiptText::_('DEFAULT AVATAR');?>::<?php echo JText::_('DEFAULT AVATAR.DESC'); ?>">
									<?php echo XiptText::_('DEFAULT AVATAR');?></td>
								</label>

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
										<a href="<?php echo $link; ?>"><?php echo XiptText::_('Remove Avatar'); ?></a>
										</span>								
									</td>
								</tr>
										
								<tr>
								<td class="key" >
								<label class="hasTip" title="<?php echo XiptText::_('VISIBLE');?>::<?php echo JText::_('VISIBLE.DESC'); ?>">
									<?php echo XiptText::_('VISIBLE');?>
								</label></td>
								<td><span><?php echo JHTML::_('select.booleanlist',  'visible', '', $this->data->visible);?></span></td>
								</tr>
									
								<tr>
								<td class="key" >
								<label class="hasTip" title="<?php echo XiptText::_('ALLOW TEMPLATE');?>::<?php echo JText::_('ALLOW TEMPLATE.DESC'); ?>">
									<?php echo XiptText::_('ALLOW TEMPLATE');?>
								</label></td>
									<td><span><?php echo JHTML::_('select.booleanlist',  'allowt', '', $this->data->allowt );?></span></td>
								</tr>
								<tr>	
								<td class="key" >
								<label class="hasTip" title="<?php echo XiptText::_('SELECT DEFAULT GROUP TO ASSIGN');?>::<?php echo JText::_('SELECT DEFAULT GROUP TO ASSIGN.DESC'); ?>">
									<?php echo XiptText::_('SELECT DEFAULT GROUP TO ASSIGN');?>
								</label>
								</td>
									<td><span><?php echo XiptHelperProfiletypes::buildTypes($this->data->group,'group',true);?></span></td>			
								</tr>
									
							</table>
							<?php 
								echo $this->pane->endPanel();								
								
								echo $this->pane->startPanel(XiptText :: _('PRIVACY SETTINGS'), 'xiprivacysettings-page');
								echo $this->privacyParams->render('privacy');
								echo $this->pane->endPanel();
								
								echo $this->pane->startPanel(XiptText :: _('REGISTRATION'), 'xiconfiguration-page');
								echo $this->configParams->render('config');
								echo $this->pane->endPanel();
							
								echo $this->pane->startPanel(XiptText :: _('WATERMARK'), 'watermark-page');
								echo $this->watermarkParams->render('watermarkparams');
								echo $this->pane->endPanel();
								
								echo $this->pane->startPanel(XiptText :: _('RESET ALL'), 'resetall-page');
								echo XiptText::_('On saving, do you want to reset properties of all existing users');	
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


