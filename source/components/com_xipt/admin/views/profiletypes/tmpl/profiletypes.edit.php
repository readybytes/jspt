<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');
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
		<tr>
			<td class="key"><?php echo JText::_('Name');?></td>
			<td>:</td>
			<td>
				<input type="text" value="<?php echo $this->row->name;?>" name="name" />
			</td>
			
			<td class="key" rowspan='4'><?php echo JText::_('Default avatar');?></td>
			<td rowspan='4'>
			<div>
				<div>
			    	<img src="<?php echo JURI::root().XiFactory::getUrlpathFromFilePath($this->row->avatar);?>" width="64" height="64" border="0" alt="<?php echo $this->row->avatar; ?>" />
			    </div>
			    <br />
				<div>
			    	<input class="inputbox button" type="file" id="file-upload" name="FileAvatar" style="color: #666;" />
			    </div>
			</div>
			</td>
		</tr>
		<tr>
			<td class="key"><?php echo JText::_('Published');?></td>
			<td>:</td>
			<td>
				<span><?php echo JHTML::_('select.booleanlist',  'published', '', $this->row->published);?></span>
			</td>
		</tr>
		<tr>
			<td class="key"><?php echo JText::_('Visible');?></td>
			<td>:</td>
			<td>
				<span><?php echo JHTML::_('select.booleanlist',  'visible', '', $this->row->visible);?></span>
			</td>
		</tr>
		<tr>	
		<td class="key"><?php echo JText::_('Require Approval');?></td>
			<td>:</td>
			<td>
				<span><?php echo JHTML::_('select.booleanlist',  'approve', '', $this->row->approve );?></span>
			</td>					
		</tr>
		<tr>
			<td class="key"><?php echo JText::_('Allow Template');?></td>
			<td>:</td>
			<td>
				<span><?php echo JHTML::_('select.booleanlist',  'allowt', '', $this->row->allowt );?></span>
			</td>
			
			<td rowspan='6' colspan='2'><div>
			<?php 
				echo $this->config->render('watermarkparams');
			?></div>
			</td>
		</tr>
		<tr>	
			<td class="key"><?php echo JText::_('Default Privacy Settings for Profile');?></td>
			<td>:</td>
			<td>
				<?php echo XiPTHelperProfiletypes::buildTypes($this->row->privacy, 'privacy');?>
			</td >			
		</tr>
		<tr>
			<td class="key"><?php echo JText::_('Default Joomla User Type Settings for Profile');?></td>
			<td>:</td>
			<!--<td colspan="4"> -->
			<td>
				<?php echo XiPTHelperProfiletypes::buildTypes($this->row->jusertype,'jusertype');?>
			</td>
		</tr>
		<tr>	
			<td class="key"><?php echo JText::_('Default Template Settings for Profile');?></td>
			<td>:</td>
			<td>
				<?php echo XiPTHelperProfiletypes::buildTypes($this->row->template, 'template');?>
			</td>
		</tr>
		<tr>
			
			<td class="key"><?php echo JText::_('Select default group to assign');?></td>
			<td>:</td>
			<td>
				<span><?php echo XiPTHelperProfiletypes::buildTypes($this->row->group,'group');?></span>
			</td>			
		</tr>
		<tr>
			<td class="key"><?php echo JText::_('DESCRIPTION OF PROFILE TYPE');?></td>
			<td>:</td>
			<td>
			<?php 
				echo $editor->display( 'tip',  htmlspecialchars($this->row->tip, ENT_QUOTES),
				'350', '200', '60', '20', array('pagebreak', 'readmore') ) ;
			?>
			</td>		
		</tr>
		
		<tr>
		    <td class="key" colspan="4"><font color="Red">
			<?php  
				echo JText::_('BE CAREFUL');?>!!!</font> &nbsp;&nbsp; <?php echo JText::_('On saving, do you want to reset properties of all existing users');?>
			</td><td>	
				<?php 
				echo JHTML::_('select.booleanlist',  'resetAll', '', '0' );?>
			</td>
		</tr>
	</tbody>
</table>

<div class="clr"></div>
	<input type="hidden" name="option" value="com_xipt" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'profiletypes' );?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>

