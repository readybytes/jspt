<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
	<?php 
	echo $this->pane->startPanel( '1. Profiletype validation', 'setupmean' );
	?>
	<ol>
		  <li> JSPT system require at least one profile type to be added </li>
		  <li> The validation checks existence of profiletype in your system </li>
		  <li> Required for proper functioning of JSPT </li>
	</ol>
	<?php
		echo $this->pane->endPanel();
		
		echo $this->pane->startPanel( '(2). Default Profiletype', 'setupmean' );
	?>
		<ol>
			<li>You should set a default profiletype</li>
			<li>To set default profiletype click that link and make a selection</li>
			<li>Required for proper functioning of JSPT</li>
		</ol>
	<?php
		echo $this->pane->endPanel();
		
		echo $this->pane->startPanel( '(3). Custom Profile Fields for JSPT', 'setupmean' );
	?>
	<ol>
		<li>JSPT stores user's profiletype and template in custom field</li>
		<li>To create fields click the link.</li>
		<li>Required for proper functioning of JSPT.</li>
	</ol>
	<?php
		echo $this->pane->endPanel();
		
		echo $this->pane->startPanel( '(4). JomSocial Files Patching', 'setupmean' );
	?>
		<ol>
			<li>JSPT need to patch two files.
			<li>JSPT before patching will backup file as *.jxibak</li> 
			<li> To patch files click the link</li>
			<li>Required for proper functioning of JSPT</li>
		</ol>
	<?php
		echo $this->pane->endPanel();
		
		echo $this->pane->startPanel( '(5). JSPT Community and System plugins installed', 'setupmean' );
	?>
		<ol>
		<li>JSPT need two plugins to work properly</li>
		<li>These comes with JSPT package. Please install them manually</li>
		<li>Required for proper functioning of JSPT</li>
		</ol>	
	<?php
		echo $this->pane->endPanel();
		
		echo $this->pane->startPanel( '	(6). JSPT Community and System Plugins are enabled', 'setupmean' );
	?>
		<ol>
			<li> Community and System plugin of JSPT must be enabled</li>
			<li> To enable plugins click the link</li>
			<li> Required for proper functioning of JSPT</li> 
		</ol>
	<?php
		echo $this->pane->endPanel();
		
		echo $this->pane->startPanel( '(7). User\'s Profiletype and Profile fields sync up', 'setupmean' );
	?>
		<ol>
		  <li> Sometimes system state might be inconsistent </li>
		  <li> JSPT checks it and let you know </li>
		  <li> You can fix it, whenever you think some odd problem is there </li>
		  <li> Required for proper functioning of JSPT </li>
		</ol>
	<?php
		echo $this->pane->endPanel();
		
		echo $this->pane->startPanel( '(8). AEC Micro Integration Setup', 'setupmean' );
	?>
		<ol>
		  <li> If you have AEC, and want to integrate the use this option</li>
		  <li> To install micro integration, click the link</li>
		  <li> Required for proper functioning of JSPT </li>
		</ol>
	<?php
		echo $this->pane->endPanel();