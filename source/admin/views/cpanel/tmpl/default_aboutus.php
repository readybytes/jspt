<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
if(!defined('_JEXEC')) die('Restricted access');
?>
<div style="background-color: #F9F9F9; border: 1px solid #D5D5D5;"><?php 
				//echo $this->pane->startPane( 'stat-pane1' );
				echo $this->loadTemplate('welcome');
				//echo $this->pane->endPanel();
				?>
</div>
<table>
		<tr>
				<td width="50%" valign="top">
				<div style="background-color: #F9F9F9; border: 1px solid #D5D5D5;"><?php 
				//echo $this->pane->startPane( 'stat-pane1' );
				echo $this->loadTemplate('news');
				//echo $this->pane->endPanel();
				?>
				</div>
				</td>
				<td width="50%" valign="top">
				<div style="background-color: #F9F9F9; border: 1px solid #D5D5D5;" ><?php
				//echo $this->pane->startPane( 'stat-pane2' );
				echo $this->loadTemplate('updates');
				//echo $this->pane->endPanel();
				?>
				</div>
			</td>
			</tr>
		</table>
<?php 
