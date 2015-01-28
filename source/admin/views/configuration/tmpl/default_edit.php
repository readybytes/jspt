<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<script language="javascript" type="text/javascript">

	/** FOR JOOMLA1.6++ **/
	Joomla.submitbutton=function(action) {
		submitbutton(action);
	}
</script>
</script>
<link rel="stylesheet" href="<?php echo JURI::root().'administrator/components/com_community/assets/css/ace.min.css';	?>" type="text/css">
<style>
#js-cpanel #config-document td {
    float: none;
}
#js-cpanel input, 
#js-cpanel select {
    font-size: 15px;
}
</style>
<div id="js-cpanel">
<form action="index.php" id="application-form" method="post" name="adminForm" enctype="multipart/form-data">

<?php if (version_compare(JVERSION, '3.0', 'lt')) { ?>
	
	<div id="config-document">
		<div id="page-main" class="tab">
			<table class="noshow">
				<tr>
					<td>
						<?php require_once( $this->jsConfigPath . DS . 'registrations.php' ); ?>
						<?php require_once( $this->jsConfigPath . DS . 'reportings.php' ); ?>
						<?php require_once( $this->jsConfigPath . DS . 'messaging.php' ); ?>
						<?php require_once( $this->jsConfigPath . DS . 'walls.php' ); ?>
						<?php require_once( $this->jsConfigPath . DS . 'events.php' ); ?>
						<?php require_once( $this->jsConfigPath . DS . 'limits.php' ); ?>
						<?php require_once( $this->jsConfigPath . DS . 'frontpage_options.php' ); ?>
						
					</td>
					<td>
						<?php require_once( $this->jsConfigPath . DS . 'groups.php' ); ?>
						<?php require_once( $this->jsConfigPath . DS . 'videos.php' ); ?>
						<?php require_once( $this->jsConfigPath . DS . 'photos.php' ); ?>
						<?php require_once( $this->jsConfigPath . DS . 'myblog.php' ); ?>
						<?php require_once( $this->jsConfigPath . DS . 'display.php' ); ?>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="clr"></div>

	<?php } else {?>
	
	<div class="row-fluid">
		<div class="span6"><?php require_once( $this->jsConfigPath . DS . 'registrations.php' ); ?></div>
		<div class="span6"><?php require_once( $this->jsConfigPath . DS . 'walls.php' ); ?></div>
	</div>
	
	<div class="row-fluid">
		<div class="span6"><?php require_once( $this->jsConfigPath . DS . 'reportings.php' ); ?></div>
		<div class="span6"><?php require_once( $this->jsConfigPath . DS . 'messaging.php' ); ?></div>
	</div>
	
	<div class="row-fluid">
		<div class="span6"><?php require_once( $this->jsConfigPath . DS . 'groups.php' ); ?></div>
		<div class="span6"><?php require_once( $this->jsConfigPath . DS . 'events.php' ); ?></div>
	</div>
	
	<div class="row-fluid">
		<div class="span6"><?php require_once( $this->jsConfigPath . DS . 'frontpage_options.php' ); ?></div>
		<div class="span6"><?php require_once( $this->jsConfigPath . DS . 'limits.php' ); ?></div>
	</div>
	
	<div class="row-fluid">
		<?php if(!isset($this->lists['videoThumbSize'])):?>
		<?php $this->lists['videoThumbSize'] =CFactory::getConfig()->get('videosThumbSize', '');?>
		<?php endif;?>
		<div class="span6"><?php require_once( $this->jsConfigPath . DS . 'videos.php' ); ?></div>
		<div class="span6"><?php require_once( $this->jsConfigPath . DS . 'photos.php' ); ?></div>
	</div>
	
	<div class="row-fluid">
		<div class="span6"><?php require_once( $this->jsConfigPath . DS . 'myblog.php' ); ?></div>
		<div class="span6"><?php require_once( $this->jsConfigPath . DS . 'display.php' ); ?></div>
		<div class="span6"><?php require_once( $this->jsConfigPath . DS . 'status.php' ); ?></div>
	</div>
	
	
	<?php };?>
	
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="task" value="save" />
<input type="hidden" name="view" value="configuration" />
<input type="hidden" name="option" value="com_xipt" />
<input type="hidden" name="id" value=<?php echo $this->id; ?> />
</form>
</div>
<?php 
