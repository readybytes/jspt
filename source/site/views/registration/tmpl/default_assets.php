<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );

$css  		= JURI::root() . 'components/com_xipt/assets/style.css';
$document   = JFactory::getDocument();
$document->addStyleSheet($css);

// Ask Joomla to load Bootstrap if Load Bootstrap is set to YES in configuration settings.
$loadBootstrap	= XiptFactory::getSettings('load_bootstrap',0);
if($loadBootstrap)
    JHtmlBootstrap::loadCss();
?>