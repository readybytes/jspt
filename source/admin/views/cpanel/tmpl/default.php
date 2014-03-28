<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
if(!defined('_JEXEC')) die('Restricted access');
if(XIPT_JOOMLA_25){
	require_once JPATH_ROOT . '/libraries/joomla/html/html/sliders.php';
}


if (version_compare(JVERSION, '3.0', 'lt')) {
	
	$css = "
	.span8 {
			float:left;
			width : 60%
			}

	.span4 {
			float:left;
			width : 40%
			}
			
	.clearfix:after {
	     visibility: hidden;
	     display: block;
	     font-size: 0;
	     content: '';
	     clear: both;
	     height: 0;
	     }
	     
	  .pane-sliders{
	  	margin:0;
		}
	" ;
	//JFactory::getDocument()->addStyleSheet('//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.1/css/bootstrap.min.css');
	JFactory::getDocument()->addStyleDeclaration($css);
}

?>

<form action="<?php echo JURI::base();?>index.php?option=com_xipt" method="post" name="adminForm">
<div class="row clearfix" >
 <div id="cpanel" class="span8">
				<?php echo $this->addIcon('setup.png','index.php?option=com_xipt&view=setup', XiptText::_('SETUP'));?>
				<?php echo $this->addIcon('jspt-settings.png','index.php?option=com_xipt&view=settings', XiptText::_('SETTINGS'));?>
				<?php echo $this->addIcon('profiletypes.png','index.php?option=com_xipt&view=profiletypes', XiptText::_('PROFILETYPES'));?>
				<?php echo $this->addIcon('jspt-config.png','index.php?option=com_xipt&view=configuration', XiptText::_('JSCONFIGURATION'));?>
				
				<?php echo $this->addIcon('jstoolbar.png','index.php?option=com_xipt&view=jstoolbar', XiptText::_('JS_TOOLBAR'));?>
				<?php echo $this->addIcon('aclrules.gif','index.php?option=com_xipt&view=aclrules', XiptText::_('ACCESS_CONTROL'));?>
				<?php echo $this->addIcon('profilefields.gif','index.php?option=com_xipt&view=profilefields', XiptText::_('PROFILE_FIELDS'));?>
				<?php echo $this->addIcon('applications.gif','index.php?option=com_xipt&view=applications', XiptText::_('APPLICATIONS'));?>
				
				<?php echo $this->addIcon('users.png','index.php?option=com_xipt&view=users', XiptText::_('USERS'));?>
</div>
		
<div class="span4">
			<?php 
				echo JHtmlSliders::start('slider');
				
//				echo JHtmlSliders::panel( 'Welcome', 'welcome' );
//				echo $this->loadTemplate('welcome');
				
//				echo JHtmlSliders::panel( 'JSPT Updates', 'updates' );
//				echo $this->loadTemplate('updates');
				
				echo JHtmlSliders::panel( 'JoomlaXi News', 'aboutus' );
				echo $this->loadTemplate('news');
				
				echo JHtmlSliders::end();
			?>
</div>
</div>
<input type="hidden" name="view" value="cpanel" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_xipt" />
<input type="hidden" name="boxchecked" value="0" />
</form>	
<?php 