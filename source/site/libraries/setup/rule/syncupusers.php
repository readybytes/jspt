<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
jimport( 'joomla.error.profiler' );

class XiptSetupRuleSyncupusers extends XiptSetupBase
{
	public static function isRequired()
	{
		$params = XiptFactory::getSettings('', 0);
		$defaultProfiletypeID = $params->getValue('defaultProfiletypeID');
		
		if(!$defaultProfiletypeID){
			JFactory::getApplication()->enqueueMessage(XiptText::_("FIRST_SELECT_THE_DEFAULT_PROFILE_TYPE"));
			return false;
		}

		$PTFieldId = XiptHelperJomsocial::getFieldId(PROFILETYPE_CUSTOM_FIELD_CODE);
		$TMFieldId = XiptHelperJomsocial::getFieldId(TEMPLATE_CUSTOM_FIELD_CODE);
		
		// we need first these fields to be exist
		if(!($PTFieldId && $TMFieldId))
			return true;
			
		$result = self::getUsertoSyncUp();
		
		if(empty($result))
		{
			return false;
		}
		
		return true;
	}
	
	function doApply()
	{
		$mysess = JFactory::getSession();
		$start  = JRequest::getVar('end',0);
	    if($start == 0 && $mysess->has('limits') && $mysess->has('isSET')){
	    	self::clearSession($mysess);
		}
				
		//set sync up limit as per memory limit
		if($start==0)
		  $limit = SYNCUP_USER_LIMIT;
		else
		  $limit=$mysess->get('limits');

        $reply = $this->syncUpUserPT($start,$limit);
		if($reply === -1)
			return -1;
		else if($reply)
        	return XiptText::_('USERS_PROFILETYPE_AND_TEMPLATES_SYNCRONIZED_SUCCESSFULLY');
        else 
        	return XiptText::_('USERS_PROFILETYPE_AND_TEMPLATES_SYNCRONIZATION_FAILED');
	}
	
	function syncUpUserPT($start, $limit, $test = false)
	{   

		$total_result = JRequest::getVar('total_result',0);
        $mysess    = JFactory::getSession();
		$count     = $mysess->get('countUser',0);
		$startTime = JProfiler::getmicrotime();
		$PTFieldId = XiptHelperJomsocial::getFieldId(PROFILETYPE_CUSTOM_FIELD_CODE);
		$TMFieldId = XiptHelperJomsocial::getFieldId(TEMPLATE_CUSTOM_FIELD_CODE);
		
		// we need first these fields to be exist
		if(!($PTFieldId && $TMFieldId))
			return false;
	    // get userids for syn-cp	
		$result 	 = $this->getUsertoSyncUp(0,$limit);
		$profiletype = XiPTLibProfiletypes::getDefaultProfiletype();
		$template	 = XiPTLibProfiletypes::getProfileTypeData($profiletype,'template');			
		
		//$total = $this->totalUsers;
		$db 	= JFactory::getDBO();	
		// XITODO : PUT into query Object
		$xiptquery = ' SELECT `userid` FROM `#__xipt_users` ';
		$query 	= ' SELECT count(*) FROM `#__users` '
					.' WHERE `id` NOT IN ('.$xiptquery.') ';
		$db->setquery($query);	
		$total = $db->loadResult();	
		
		if($total_result == 0){
		    $mysess->set('totalUser',$total);
		}
		$total = $mysess->get('totalUser');
		if($count < $total){
			$this->_SynCpUser($result,$profiletype,$template);
			$count=$count+count($result);
			//If total is less than limit,no need to load html.
			if($total > $limit){
			  if(!$mysess->has('isSET')){
			      //Find the No. of users to be syncronised in next iteration.
	              $limit = self::setNextLimit($startTime);
	              $mysess->set('limits',$limit);
	              $mysess->set('isSET',true);
			  }
			  //load Html
			  $mysess->set('countUser',$count);
			  echo $this->getHTML($count,$total);
			  return -1;
			}
	     }

			if($test)
			 return true;
			self::clearSession($mysess);
			$msg = 'Total '. $total . ' users '.XiptText::_('SYNCHORNIZED');
		    JFactory::getApplication()->enqueueMessage($msg);
		    return true;
	}
	
    function setNextLimit($startTime)
    {  
		 $memory_size = ini_get('memory_limit');
		 $memory_size = substr($memory_size, 0, -1);
		 $memory_size = (int)($memory_size*1048567);
		 $space = (JProfiler::getMemory()); //consumed space 
		 $memoryPerUser = ($space/SYNCUP_USER_LIMIT);
		 $limit = (int)((($memory_size-$space)*0.80)/$memoryPerUser); // consider 80% of remaining
		 return $limit;
	}
	
	function clearSession($mysess)
	{
		$mysess->clear('limits');
		$mysess->clear('isSET');
		$mysess->clear('countUser');
		$mysess->clear('totalUser');
	}
	
	function getMessage()
	{
		$requiredSetup = array();
		
		if($this->isRequired())
		{
			$link = XiptRoute::_("index.php?option=com_xipt&view=setup&task=doApply&name=syncupusers",false);
			$requiredSetup['message']  = '<a href="'.$link.'">'.XiptText::_("PLEASE_CLICK_HERE_TO_SYNC_UP_USERS_PROFILETYPES").'</a>';
			$requiredSetup['done']  = false;
		}
		
		else
		{
			$requiredSetup['message']  = XiptText::_("USERS_PROFILETYPES_ALREADY_IN_SYNC");
			$requiredSetup['done']  = true;
		}
		return $requiredSetup;
	}
	
	public static function getUsertoSyncUp($start = 0, $limit = SYNCUP_USER_LIMIT)
	{
		//XITODO : apply caching
//		static $users = null;
//		$reset = XiptLibJomsocial::cleanStaticCache();
//		if($users!== null && $reset == false)
//			return $users;
		$db 	= JFactory::getDBO();

			
		if(0 == JFactory::getSession()->get('countUser',0)){
			$query= 'DELETE FROM `#__xipt_users` WHERE `profiletype` NOT IN ( SELECT `id` FROM `#__xipt_profiletypes` )';
			$db->setQuery($query);
			$db->query();
		}
		// XITODO : PUT into query Object , 
		//added limit option here
		$xiptquery = ' SELECT `userid` FROM `#__xipt_users` ';
		$query 	= ' SELECT `id` FROM `#__users` '
					.' WHERE `id` NOT IN ('.$xiptquery.') '
					." limit $start, $limit ";
        			
		$db->setQuery($query);
		$users = $db->loadColumn();

//		$query = ' SELECT `userid` FROM `#__xipt_users` WHERE `profiletype` NOT IN ( SELECT `id` FROM `#__xipt_profiletypes` )';
//		$db->setQuery($query);
//		$userid = $db->loadResultArray();
		
//		$users = array_merge($result, $userid);
		
//		sort($users);
//		$this->totalUsers = count($users);
//		echo "=======get user to sync=======";
//		$reslt=array_slice($users, $start, $limit);
//		echo "result is :::";
//		print_r($reslt);
//      return array_slice($users, $start, $limit);
		return $users;
	}
	
	function getHTML($count,$total)
	{
		ob_start();
		?>
		<div>
			<h3 style="width:100%; background:#7ac047;text-align:center;color:RED;padding:5px;font-weight:bold;">
			<?php 
			//show user reseted
			//can show 'reseting next 500 user'
			echo "Reset Page : DO NOT CLOSE THIS WINDOW WHILE SYNCRONIZATION ";
			?>
			</h3>
			<?php
					//Number of user syn-cp when limit is greater then remaining user 
					//if($limit > $total){
						//$remain=$end = $total;
					//}
					// display Total users
					echo "<br /> Total ".$total." users for Syn-cp";	
					//display syn-cp users
					echo "<br />Syned-Up Users = ".$count;
					$remain = $total-$count;
					if($remain > 0) 
					  echo "<br />Remaining " .$remain . " Users";
			?>
			<script>
			window.onload = function() {
				  setTimeout("xiredirect()", 3000);
			}
			
			function xiredirect(){
				window.location = "<?php echo XiptRoute::_("index.php?option=com_xipt&view=setup&task=doApply&name=syncupusers&end=$count&total_result=1");?>"					
			}
			
			</script>
			</div>
		<?php 
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	/**
	 * 
	 * @param unknown_type $result number of user to syncp
	 * @param unknown_type $profiletype : default profile-typr
	 * @param unknown_type $template: default-template
	 */
	function _SynCpUser($result,$profiletype,$template){
		foreach ($result as $userid){
			XiPTLibProfiletypes::updateUserProfiletypeData($userid, $profiletype, $template, 'ALL');
		}
	}
}