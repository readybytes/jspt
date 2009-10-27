<?php
function com_uninstall()
{
	//drop_database();
}

function drop_database()
{
	$db	=& JFactory::getDBO();
	$query ='DROP TABLE `#__xipt_profiletypes`';
	$db->setQuery( $query );
	$db->query();
	
	$query ='DROP TABLE `#__xipt_profilefields`';
	$db->setQuery( $query );
	$db->query();
	
	return true;
}
?>