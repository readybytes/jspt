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
				alert( "<?php echo JText::_( 'You must provide a Profiletype name.', true ); ?>" );
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
	<?php echo JText::_('Create new profile types for your site.');?>
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
						<?php echo JText::_( 'Profiletype Settings' ); ?>
					</legend>
					<table width="100%">
						<tr>
							<td class="key"><?php echo JText::_('Name');?></td>
							<td>:</td>
							<td>
								<input type="text" value="<?php echo $this->data->name;?>" name="name" />
							</td>
						</tr>
						<tr>
							<td class="key"><?php echo JText::_('Published');?></td>
							<td>:</td>
							<td>
								<span><?php echo JHTML::_('select.booleanlist',  'published', '', $this->data->published);?></span>
							</td>
						</tr>
						<tr>
							<td class="key"><?php echo JText::_('Visible');?></td>
							<td>:</td>
							<td>
								<span><?php echo JHTML::_('select.booleanlist',  'visible', '', $this->data->visible);?></span>
							</td>
						</tr>
						<tr>	
						<td class="key"><?php echo JText::_('Require Approval');?></td>
							<td>:</td>
							<td>
								<span><?php echo JHTML::_('select.booleanlist',  'approve', '', $this->data->approve );?></span>
							</td>					
						</tr>
						<tr>
							<td class="key"><?php echo JText::_('Allow Template');?></td>
							<td>:</td>
							<td>
								<span><?php echo JHTML::_('select.booleanlist',  'allowt', '', $this->data->allowt );?></span>
							</td>
						</tr>
						<tr>
							<td class="key"><?php echo JText::_('Default Joomla User Type Settings for Profile');?></td>
							<td>:</td>
							<!--<td colspan="4"> -->
							<td>
								<?php echo XiptHelperProfiletypes::buildTypes($this->data->jusertype,'jusertype');?>
							</td>
						</tr>
						<tr>	
							<td class="key"><?php echo JText::_('Default Template Settings for Profile');?></td>
							<td>:</td>
							<td>
								<?php echo XiptHelperProfiletypes::buildTypes($this->data->template, 'template');?>
							</td>
						</tr>
						<tr>
							
							<td class="key"><?php echo JText::_('Select default group to assign');?></td>
							<td>:</td>
							<td>
								<span><?php echo XiptHelperProfiletypes::buildTypes($this->data->group,'group',true);?></span>
							</td>			
						</tr>
						<tr>
							<td class="key"><?php echo JText::_('DESCRIPTION OF PROFILE TYPE');?></td>
							<td>:</td>
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
					<legend>
						<?php echo JText::_( 'Default avatar' ); ?>
					</legend>
					<table width="100%">
						<tr>
							<td class="key" rowspan='4'><?php echo JText::_('Default avatar');?></td>
								<td rowspan='4'>
								<div>
									<div>
									<?php 
									?>
								    	<img src="<?php echo JURI::root().XiptFactory::getUrlpathFromFilePath($this->data->avatar);?>" width="64" height="64" border="0" alt="<?php echo $this->data->avatar; ?>" />
								    </div>
								    <br />
									<div>
								    	<input class="inputbox button" type="file" id="file-upload" name="FileAvatar" style="color: #666;" />
								    </div>
								</div>
								</td>
							</tr>
							<tr>
							<td>
								<span class="editlinktip">
									<?php $link = JRoute::_('index.php?option=com_xipt&view=profiletypes&task=removeAvatar&editId='.$this->data->id.'&oldAvatar='.$this->data->avatar, false); ?>
										<a href="<?php echo $link; ?>"><?php echo JText::_('Remove Avatar'); ?></a>
								</span>								
							</td>
							</tr>
						</table>
					</fieldset>
					<fieldset>
					<legend>
						<?php echo JText::_( 'Parameters' ); ?>
					</legend>
						<table width="100%"><tr><td>
							<?php 
								echo $this->pane->startPane("parameters-pane");
								echo $this->pane->startPanel(JText :: _('Watermark'), 'watermark-page');
								echo $this->watermarkParams->render('watermarkparams');
								echo $this->pane->endPanel();
								
								echo $this->pane->startPanel(JText :: _('XiConfiguration'), 'xiconfiguration-page');
								echo $this->configParams->render('config');
								echo $this->pane->endPanel();
								
								echo $this->pane->startPanel(JText :: _('Privacy-Settings'), 'xiprivacysettings-page');
								echo $this->privacyParams->render('privacy');
								echo $this->pane->endPanel();
								
								echo $this->pane->startPanel(JText :: _('ResetAll'), 'resetall-page');
								echo JText::_('On saving, do you want to reset properties of all existing users');	
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
	<input type="hidden" name="cid[]" value="<?php echo $this->data->id; ?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
<?php 