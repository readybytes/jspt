<?php
	
class XiptAPI
{
	/* deprecated */
	function getUserProfiletype($userid)
	{
	    return XiPTLibraryProfiletypes::getUserDataFromUserID($userid,'PROFILETYPE');
	}
	
}