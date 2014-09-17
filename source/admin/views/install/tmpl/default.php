<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2013- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>

<div class="row-fluid">
	<div class="well offset2 span8 offset2 alert alert-success center">
		<h2><em><?php echo XiptText::_('COM_XIPT_INSTALLATION_SUCCESS_MSG');?></em></h2>
		<h3><?php echo XiptText::_('COM_XIPT_INSTALLATION_SUCCESS_MSG_CONTENT');?></h3>

		<button type="submit" class="btn btn-success btn-large pull-right" onclick="window.location.href='<?php echo JUri::base().'index.php?option=com_xipt&view=install&task=complete';?>';">
			<i class="icon-white icon-hand-right"></i>&nbsp;<?php echo XiptText::_('FINISH_INSTALLATION_BUTTON');?>
		</button>
		
		<div class="hide">
		<?php
			$domain  = JURI::getInstance()->toString(array('scheme', 'host', 'port'));
			$version = new JVersion();
			$suffix = 'jom=J'.$version->RELEASE.'&utm_campaign=broadcast&xiptv=XIPT'.XIPT_VERSION.'&dom='.$domain;
			
			$event 		= "product.installation";
			$event_args = array('product'=>'Xipt', 'version'=>XIPT_VERSION, 'domain'=>$domain, 'joomla_version'=>$version->RELEASE, 'email'=> '');
			$event_args = urlencode(json_encode($event_args));?>
			

		<iframe src="http://www.readybytes.net/broadcast/track.html?event=<?php echo $event;?>&event_args=<?php echo $event_args;?>" style="display :none;"></iframe>
		
	</div>
	</div>
</div>
