<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">
<div id="config-document">
	<div id="page-main">
		<table class="noshow">
			<tr>
				<td>
					<?php require_once( dirname(__FILE__) . DS . 'groups.php' ); ?>
					<?php require_once( dirname(__FILE__) . DS . 'reportings.php' ); ?>
					<?php require_once( dirname(__FILE__) . DS . 'videos.php' ); ?>
				</td>
				<td>
					<?php require_once( dirname(__FILE__) . DS . 'photos.php' ); ?>
					<?php require_once( dirname(__FILE__) . DS . 'privacy.php' ); ?>
					<?php require_once( dirname(__FILE__) . DS . 'messaging.php' ); ?>
					<?php require_once( dirname(__FILE__) . DS . 'walls.php' ); ?>
					
				</td>
			</tr>
		</table>
	</div>
<div class="clr"></div>
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="task" value="save" />
<input type="hidden" name="view" value="configuration" />
<input type="hidden" name="option" value="com_xipt" />
<input type="hidden" name="id" value=<?php echo $this->id; ?> />
</form>