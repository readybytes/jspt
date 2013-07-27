<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

?>
<script language="javascript" type="text/javascript">
<?php 
If(!XIPT_JOOMLA_15)
{
	?>
/** FOR JOOMLA1.6++ **/
Joomla.submitbutton=function(action) {
	submitbutton(action);
}
<?php }?>

function submitbutton(action){	
	var form = document.adminForm;
		switch(action)
		{
		case 'save':
		case 'apply':			
		case 'cancel':
		default:
			submitform( action );
		}
	}
	
</script>

<div id="JSPT">
<div class="xippElements">
	<form action="index.php" method="post" name="adminForm" id="adminForm">
		<div class="elementColumn">
			<fieldset class="adminform">
			<legend><?php echo XiptText::_( 'DETAILS' ); ?></legend>
			
			<div class="elementParams">
					<div class="paramTitle">
						<label class="hasTip" title="<?php echo XiptText::_('NAME'); ?>::<?php echo XiptText::_('PTYPE_TITLE_DESC'); ?>"><?php echo XiptText::_('NAME'); ?>
						</label>
					</div>
					<div class="paramValue"><label><?php echo $this->user->name;?></label></div>
			</div>
			
			<div class="elementParams">
					<div class="paramTitle">				
						<label class="hasTip" title="<?php echo XiptText::_('PROFILETYPE'); ?>::<?php echo XiptText::_('PROFILETYPE_DESC'); ?>"><?php echo XiptText::_('PROFILETYPE');?>
						</label>
					</div>
					<div class="paramValue"><?php echo XiptHelperProfiletypes::buildTypes($this->ptype, 'profiletypes');?></div>
			</div>
			
			<div class="elementParams">
					<div class="paramTitle">
						<label class="hasTip" title="<?php echo XiptText::_('TEMPLATE'); ?>::<?php echo XiptText::_('TEMPLATE_DESC'); ?>">
								<?php echo XiptText::_('TEMPLATE');?>
						</label>
					</div>	
					<div class="paramValue"><?php echo XiptHelperProfiletypes::buildTypes($this->template, 'template');?></div>
			</div>
			
			<div class="elementParams">
					<div class="paramTitle">
						<label class="hasTip" title="<?php echo XiptText::_('JOOMLA_USER_TYPE'); ?>::<?php echo XiptText::_('JOOMLA_USER_TYPE_DESC'); ?>">
								<?php echo XiptText::_('JOOMLA_USER_TYPE');?>
						</label>
					</div>	
					<div class="paramValue"><label><?php echo $this->user->title;?></label></div>
			</div>					
										
    	</fieldset>
     </div>	

<div class="clr"></div>
	<input type="hidden" name="option" value="com_xipt" />
	<input type="hidden" name="view" value="users" />
	<input type="hidden" name="id" value="<?php echo $this->user->user_id; ?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
</div>
<?php 