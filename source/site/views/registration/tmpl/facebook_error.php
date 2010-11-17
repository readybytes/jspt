<?php /**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<h4><u><?php echo XiptText::_("INVALID USERNAME OR PASSWORD AS FACEBOOK CONNECT");?></u></h4><br/>
<?php 
if(!$isValidUsername)
	echo XiptText::_("INVALID USER NAME AS FACEBOOK CONNECT")."\n \n";

if(!$isValidEmail)
	echo XiptText::_("INVALID EMAIL AS FACEBOOK CONNECT");
	
?>
<?php 
