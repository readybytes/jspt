<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
if(!defined('_JEXEC')) die('Restricted access');

?>

<script type="text/javascript" language="javascript">
/**
 * This function needs to be here because, Joomla toolbar calls it
 **/ 
/** FOR JOOMLA1.6 ++**/
Joomla.submitbutton=function(action) {
	submitbutton(action);
}
	  
function submitbutton( action )
{
	switch( action )
	{
		default:
			submitform( action );
	}
}
</script>

<div id="JSPT">
<form action="<?php echo JURI::base();?>index.php?option=com_xipt" method="post" name="adminForm" id="adminForm">
<?php if (!empty( $this->sidebar)) : ?>
		<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
		</div>
		<div id="j-main-container" class="span10">
	<?php else : ?>
		<div id="j-main-container">
	<?php endif;?>
<div style="margin-bottom: 10px;">
<table class="adminform" cellpadding="3">
	<tr>
		<td width="95%">
			<?php echo XiptText::_('SEARCH_USERS');?>
			<input type="text" onchange="document.adminForm.submit();" class="text_area" value="<?php echo ($this->search) ? $this->escape( $this->search ) : ''; ?>" id="search" name="search"/>
			<button onclick="this.form.submit();"><?php echo XiptText::_('SEARCH');?></button>
		</td>
		<td nowrap="nowrap" align="right">
			<span style="font-weight: bold;"><?php echo XiptText::_('FILTER_USERS_BY'); ?>
			
			<select name="profiletype" onchange="document.adminForm.submit();">
				<option value="all"<?php echo $this->selectedPtype == 'all' ? ' selected="selected"' : '';?>><?php echo XiptText::_('ALL');?></option>
				<?php
				if( $this->allPtypes )
				{
					foreach( $this->allPtypes as $ptype )
					{
				?>
					<option value="<?php echo $ptype->id;?>"<?php echo $this->selectedPtype == $ptype->id ? ' selected="selected"' : '';?>><?php echo $ptype->name;?></option>
				<?php
					}
				}
				?>
			</select>
			</span>
		</td>
	</tr>
</table>

</div>
<table class="adminlist" cellspacing="1">
	<thead>
		<tr class="title">
			<th width="1%">
				<?php echo XiptText::_( 'NUM' ); ?>
			</th>
			<th width="1%">
				<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
			</th>
			<th>
				<?php echo JHTML::_('grid.sort',   XiptText::_( 'NAME' ) , 'name', $this->order_Dir, $this->order ); ?>
			</th>
			<th>
				<?php echo JHTML::_('grid.sort',   XiptText::_( 'USERNAME' ) , 'username', $this->order_Dir, $this->order ); ?>
			</th>
			<th>
				<?php echo XiptText::_( 'PROFILETYPE' ); ?>
			</th>
			<th>
				<?php echo XiptText::_( 'TEMPLATE' ); ?>
			</th>
			<th>
				<?php echo XiptText::_( 'JOOMLA_USER_TYPE' ); ?>
			</th>
			<th>
				<?php echo JHTML::_('grid.sort',   XiptText::_( 'USER_ID' ) , 'user_id', $this->order_Dir, $this->order ); ?>
			</th>
			<th>
				<?php echo XiptText::_( 'REGISTER_DATE' ); ?>
			</th>
		</tr>		
	</thead>
<?php
	$count	= 0;
	$i		= 0;

	if(!empty($this->users))
	foreach($this->users as $user)
	{
?>
		<tr class="row<?php echo $i%2;?>" id="rowid<?php echo $user->user_id;?>">
			<td><?php echo $i+1;?></td>
			<td>
				<?php echo JHTML::_('grid.id', $i++, $user->user_id); ?>
			</td>
			<td>
				<span class="editlinktip" title="<?php echo $user->name; ?>" id="name<?php echo $user->user_id;?>">
					<?php $link = XiptRoute::_('index.php?option=com_xipt&view=users&task=edit&id='.$user->user_id, false); ?>
						<A HREF="<?php echo $link; ?>"><?php echo $user->name; ?></A>
				</span>
			</td>
			<td>
				<span class="editlinktip" title="<?php echo $user->username; ?>" id="name<?php echo $user->user_id;?>">
					<?php $link = XiptRoute::_('index.php?option=com_community&view=users&layout=edit&id='.$user->user_id, false); ?>
						<A HREF="<?php echo $link; ?>"><?php echo $user->username; ?></A>
				</span>
			</td>
			<td>
				<?php echo $this->getUserInfo($user->user_id, 'PROFILETYPE'); ?>
			</td>
			<td>
				<?php echo $this->getUserInfo($user->user_id, 'TEMPLATE'); ?>
			</td>
			<td>
				<?php echo $user->title; ?>
			</td>
			<td>
				<?php echo $user->user_id; ?>
			</td>
			<td>
				<?php echo $user->registerDate; ?>
			</td>
		</tr>
<?php
		
		$count++;
	}
	else
		{
	?>
	<tr>
		<td colspan="10" align="center"><?php echo XiptText::_('NO_RESULT');?></td>
	</tr>
	<?php
		}
	 ?>
	<tfoot>
	<tr>
		<td colspan="15" align="center">
			<!--     Replace getLimitBox function with getListFooter-->
<!--			<?php echo $this->pagination->getLimitBox(); ?>-->
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tr>
	</tfoot>
</table>



<input type="hidden" name="view" value="users" />
<input type="hidden" name="option" value="com_xipt" />
<input type="hidden" name="task" value="users" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->order; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->order_Dir; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</div>
</form>	
</div>
<?php 
