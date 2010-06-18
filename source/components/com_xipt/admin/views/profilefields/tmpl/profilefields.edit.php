<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');
?>

<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		submitform( pressbutton );
	}
</script>

<form action=<?php echo JURI::base();?> method="post" name="adminForm" id="adminForm">
<table class="adminlist" cellspacing="1" style="width:50%; float:left;" >
		<thead>
		<tr>
			<td style="width:40%;" >
				<?php echo JText::_( 'FIELD NAME' ); ?> :
			</td>
			<td style="width:60%;">
					<?php echo XiPTHelperProfileFields::get_fieldname_from_fieldid($this->fieldid); ?>
			</td>
		</tr>
		</thead>
		<?php 
		foreach($this->categories as $catIndex => $catInfo)
			{
				$catName = $catInfo['name'];
				?>	
				<tr  class="row<?php echo $catIndex%2;?>">
					<td>
						<?php echo JText::_($catName);?> :
					</td>
					<td colspan="4"> 
						<?php echo XiPTHelperProfileFields::buildProfileTypes($this->fieldid,$catIndex);?>
					</td>			
				</tr>
				<?php 
			}
			?>
		</table>

<div style="width:45%; float:right;">
<?php 
echo $this->pane->startPane( 'stat-pane' );
require("helppanel.php");
echo $this->pane->endPane();
?>
</div>


	<input type="hidden" name="option" value="com_xipt" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'profilefields' );?>" />
	<input type="hidden" name="id" value="<?php echo $this->fieldid; ?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
