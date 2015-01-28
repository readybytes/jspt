<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class uploadavatar extends XiptAclBase
{
	function getResourceOwner($data)
	{
		return $data['userid'];	
	}
	
	function checkCoreApplicable($data)
	{
		$restrictBy = $this->getCoreParams('restrict_by',0);
		
		if($restrictBy){
			return $this->checkCoreApplicableByPlan($data);
		}
		else{
			$ptype = $this->getCoreParams('core_profiletype',XIPT_PROFILETYPE_ALL);
	
			//check if its applicable on more than 1 ptype
			$ptype = is_array($ptype)?$ptype:array($ptype);
			
			//All means applicable
			if(in_array(XIPT_PROFILETYPE_ALL, $ptype))
				return true;
			
			//profiletype matching
			$userpt = JFactory::getSession()->get('sessionpt', false, 'XIPT');
			
			if(in_array(XiptLibProfiletypes::getUserData($data['userid']), $ptype) || in_array($userpt, $ptype))
				return true;
	
			return false;
		}
	}
	
	function isApplicableOnSelfProfiletype($resourceAccesser)
	{
		$aclSelfPtype = $this->getACLAccesserProfileType();
		
		$sessionPid   = JFactory::getSession()->get('sessionpt', false, 'XIPT');
		if($sessionPid)
			$selfPid = $sessionPid;
		else
			$selfPid	  = XiptLibProfiletypes::getUserData($resourceAccesser,'PROFILETYPE');
			
		//if its applicable to all
		if(XIPT_PROFILETYPE_ALL == $aclSelfPtype)
			return true;
			
		//check if its applicable on more than 1 ptype
		$aclSelfPtype = is_array($aclSelfPtype)?$aclSelfPtype:array($aclSelfPtype);
		
		//if user's ptype exists in ACL ptype array
		if(in_array($selfPid, $aclSelfPtype) || in_array(XIPT_PROFILETYPE_ALL, $aclSelfPtype))
			return true;

		return false;
	}
	
	function checkAclApplicable(&$data)
	{

		// Acl not applicable when Avtar imported from Facebook.
		//XiTODO:: If its default avtar of facebook then Acl need to be applicable.
		if(stristr($data['task'], 'ajaximportdata')!==FALSE){
			return false;
		}
		
		$session	= JFactory::getSession();
		$permission = $this->aclparams->getValue('upload_avatar_at_registration',null,false);
		$post		= JRequest::get('post');
		
		//check whether user has actually uploaded a avatar 
		//or he is just clicking on upload without selecting avatar
		$uploadedData   = JRequest::get('files');
		
		if($uploadedData){
			$avatar			= $uploadedData['Filedata'];
			$avatarSize		= $avatar['size'];
		}
		
		$userId = JFactory::getUser()->id;
		
		//get user's profiletype & its related avatar
		$userPid = XiptLibProfiletypes::getUserData($userId,'PROFILETYPE');
		$ptypeavatar = 	XiptLibProfiletypes::getProfiletypeData($userPid, 'avatar');
		
		// When user login then force to upload avatar
		if(!empty($userId) && ($data['task'] === 'logout' || $data['task'] === 'user.logout')){
			$session->clear('uploadAvatar','XIPT');
			return false;
		}
		
		if(!empty($userId) && stristr($data['task'], 'uploadavatar') !== FALSE){
			//get login user avatar
			$userAvatar = CFactory::getUser($userId)->_avatar;
			//if avatar is deafaul then force to upload avatar
			if(JString::stristr( $userAvatar , 'components/com_community/assets/default.jpg') 
				|| JString::stristr( $userAvatar , 'components/com_community/assets/user-Female.png')
				|| JString::stristr( $userAvatar , 'components/com_community/assets/user-Male.png')
				|| empty($userAvatar)
					|| JString::stristr($userAvatar,$ptypeavatar)) {
				$session->set('uploadAvatar',true,'XIPT');
				return true;
			}
			else 
				return false;
		}
				
		if($permission && $session->get('uploadAvatar',false,'XIPT') 
			&& isset($post['action']) && $post['action'] === 'doUpload' && $avatarSize){
			$session->clear('uploadAvatar','XIPT');
			$session->clear('sessionpt','XIPT');
		}
		//if user login and have a avatar then not apply
		if($userId && $permission){
		 	return false; 
		}
		
		//On Registeration Time:: if user come to uoload avatr then all link are disable untill user not upload avatar
		if($permission && $session->get('uploadAvatar',false,'XIPT') && stristr($data['task'],'registeravatar')!==FALSE){
			return true;
		}
		
		// When not registered than dont follow this rule until reach at upload avatar page through ragistration
		if('com_community' != $data['option'] && 'community' != $data['option']){
			return false;
		}

		// Set session variable at registration time
		if('register'== $data['view'] && $data['task'] === 'registeravatar'){
			if(!isset($post['action']) || (isset($post['action']) && $post['action'] != 'doUpload')){
				$session->set('uploadAvatar',true,'XIPT');
			}	
			//XiTODO::add javascript for Click on upload button with image path.(without image-path does nt submit form)
		}
		
		// if you click on "SKIP" url then apply rule and not redirect to success  
		if($permission && 'register' == $data['view'] 
		&& $data['task'] == 'registersucess' && $session->get('uploadAvatar',false,'XIPT')){
				return true;
		}
		return false;
	}

	public function getDisplayMessage()
	{
		$session	= JFactory::getSession();
		if($session->get('uploadAvatar',false,'XIPT')){
			//return XiptText::_('PLEASE_UPLOAD_AVATR_FOR_COMPLEATE_RAGISTRATION');
			return parent::getDisplayMessage();
		}	
	}

	
	public function getRedirectUrl()
	{
		$session = JFactory::getSession();
		$userId  = JFactory::getUser()->id;
		// if user is login and not uploaded avatar then redierct to upload avatar page
		if($session->get('uploadAvatar',false,'XIPT') && !empty($userId)){
			return "index.php?option=com_community&view=profile&task=uploadAvatar";
		}
		// if new-user is registering then all url link redirect to upload avatar after fill-up all info
		if($session->get('uploadAvatar',false,'XIPT')){	
			return "index.php?option=com_community&view=register&task=registerAvatar";
		}
		
		return "index.php?option=com_community&view=register&task=registerSucess";
	}
}
