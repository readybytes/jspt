<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );

require_once JPATH_ROOT.'/components/com_xipt/views/registration/tmpl/default_assets.php';

?>
<div class="container-fluid jomsocial">
	<form action="<?php echo XiptRoute::_( 'index.php?option=com_xipt&view=registration&reset=true',false ); ?>" method="post" name="ptypeForm">
		<div class="registerProfileType joms-page__title">
			<div class="row-fluid">
				<h3><?php
				echo XiptText::_ ( 'CHOOSE_PROFILE_TYPE' );
				?></h3><hr>
				<?php
				if(XiptFactory::getSettings('jspt_show_radio'))
					echo $this->loadTemplate('click');
				else
					echo $this->loadTemplate('select');
				?>
			</div>
		</div>
<div class="clr" title="Next"></div>
<input type="hidden" name="view" value="registration" /> 
<input type="hidden" name="task" value="" /> 
<input type="hidden" name="option" value="com_xipt" /> 
<input type="hidden" name="boxchecked" value="0" />
<?php  echo JHTML::_ ( 'form.token' ); ?>
</form>
</div>
<?php