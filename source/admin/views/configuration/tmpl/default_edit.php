<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
if(!defined('_JEXEC')) die('Restricted access');
?>
<form action="index.php" id="application-form" method="post" name="adminForm" enctype="multipart/form-data">
<div id="config-document">
	<div id="page-main">
		<table class="admintable" cellspacing="1">
			<tr>
				<td width="44%">
					<?php require_once( $this->jsConfigPath . DS . 'registrations.php' ); ?>
					<?php require_once( $this->jsConfigPath . DS . 'reportings.php' ); ?>
					<?php require_once( $this->jsConfigPath . DS . 'messaging.php' ); ?>
					<?php require_once( $this->jsConfigPath . DS . 'walls.php' ); ?>
					<?php require_once( $this->jsConfigPath . DS . 'events.php' ); ?>
							
				</td>
				<td>
					<?php require_once( $this->jsConfigPath . DS . 'groups.php' ); ?>
					<?php require_once( $this->jsConfigPath . DS . 'videos.php' ); ?>
					<?php require_once( $this->jsConfigPath . DS . 'photos.php' ); ?>
					<?php require_once( $this->jsConfigPath . DS . 'myblog.php' ); ?>
				
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="clr"></div>
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="task" value="save" />
<input type="hidden" name="view" value="configuration" />
<input type="hidden" name="option" value="com_xipt" />
<input type="hidden" name="id" value=<?php echo $this->id; ?> />
</form>
<?php 
