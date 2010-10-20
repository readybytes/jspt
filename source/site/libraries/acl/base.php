<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');


abstract class XiptAclBase
{
	public $id			= 0 ;
	public $aclname		= '';
	public $rulename	= '';
	public $published	= 1 ;
	public $coreparams	= '';
	public $aclparams	= '';

	function __construct()
	{
		$className	= get_class($this);

		//Load ACL Params, if not already loaded
		if(!$this->aclparams){
			$aclxmlpath =  dirname(__FILE__).DS.strtolower($className).DS.strtolower($className).'.xml';
			if(JFile::exists($aclxmlpath))
				$this->aclparams = new JParameter('',$aclxmlpath);
			else
				$this->aclparams = new JParameter('','');
		}

		//load core params
		//XITODO : CREATE INI FILE
		$corexmlpath = dirname(__FILE__).DS.'coreparams.xml';
		XiptError::assert(JFile::exists($corexmlpath));
		$this->coreparams = new JParameter('',$corexmlpath);
	}


	function load($id)
	{
		if(0 == $id) {
			return $this;
		}

		$filter = array();
		$filter['id'] = $id;
		$result = XiptAclFactory::getAclRulesInfo($filter);

		if(!$result)
			return $this;

		$info = array_shift($result);
		$this->id 				= $info->id;
		$this->aclname 			= $info->aclname;
		$this->published 		= $info->published;
		$this->rulename 		= $info->rulename;

		$this->coreparams->bind($info->coreparams);
		$this->aclparams->bind($info->aclparams);
		return $this;
	}

	function getObjectInfoArray()
	{
		return get_object_vars($this);
	}

	public function getAclParamsHtml()
	{
		return $this->aclparams->render('aclparams');
	}

	final public function getCoreParamsHtml()
	{
		return $this->coreparams->render('coreparams');
	}

	function collectParamsFromPost($postdata)
	{
		XiptError::assert($postdata['aclparams']);

		$registry	= new JRegistry();
		$registry->loadArray($postdata['aclparams']);
		return  $registry->toString('INI');
	}

	function bind($data)
	{
		if(is_object($data)) {
			$this->aclparams->bind($data->aclparams);
			$this->coreparams->bind($data->coreparams);
			$this->rulename 	= $data->rulename;
			$this->published 	= $data->published;
			$this->id			= $data->id;
			return $this;
		}

		if(is_array($data)) {
			$this->aclparams->bind($data['aclparams']);
			$this->coreparams->bind($data['coreparams']);
			$this->rulename 	= $data['rulename'];
			$this->published 	= $data['published'];
			$this->id			= $data['id'];
			return $this;
		}

		//Any issue
		XiptError::assert(0);
	}

	/**
	 * IMP : Use Refrence as we may need to 
	 * change viewuserid in case of writemessages
	 */
	function isApplicable(&$data)
	{
//	    $isAclApplicableOnProfile  =     $this->checkAclOnProfile($data);
		$isApplicableAccToAcl      =     $this->checkAclApplicable($data);
		$isApplicableAccToCore     =     $this->checkCoreApplicable($data);

		//These condition need to be AND as we ensure rule only apply if
		// it is applicable as per conditions.
		if($isApplicableAccToAcl && $isApplicableAccToCore)
			return true;

		return false;
	}

//	public function checkAclOnProfile($data)
//    {
//	  if(is_array($data['args']) && array_key_exists('from',$data['args']) && 'onprofileload' == $data['args']['from'])
//	    return false;
//
//	  return true;
//    }

	public function checkCoreApplicable($data)
	{
		$ptype = $this->getCoreParams('core_profiletype',XIPT_PROFILETYPE_ALL);

		//All means applicable
		if(XIPT_PROFILETYPE_ALL == $ptype)
			return true;

		//profiletype matching
		if(XiptLibProfiletypes::getUserData($data['userid']) == $ptype)
			return true;

		return false;
	}


	public function checkAclApplicable($data)
	{
		return $this->published;
	}


	function checkViolation($data)
	{
		return ($this->checkAclViolation($data) || $this->checkCoreViolation($data));
	}


	public function checkAclViolation($data)
	{
		return false;
	}


	public function checkCoreViolation($data)
	{
		return false;
	}

	public function getCoreParams($what,$default=0)
	{
		return $this->coreparams->get($what,$default);
	}


	public function handleViolation($info)
	{
		$msg 			= $this->getDisplayMessage();
		if($info['ajax']) {
			$this->aclAjaxBlock($msg);
			return $this;
		}

		$redirectUrl 	= $this->getRedirectUrl();
		JFactory::getApplication()->redirect(XiptRoute::_($redirectUrl,false),$msg);
	}


	function aclAjaxBlock($html, $objResponse=null)
	{
		if($objResponse === null)
			$objResponse   	= new JAXResponse();

		$objResponse->addAssign('cwin_logo', 'innerHTML', JText::_('YOU ARE NOT ALLOWED TO PERFORM THIS ACTION'));
		$objResponse->addAssign('cWindowContent', 'innerHTML', $html);
		$objResponse->addScriptCall('cWindowResize', 80);
		$objResponse->sendResponse();
	}


	public function getMe()
	{
		return get_class($this);
	}

	public function getDisplayMessage()
	{
		$message = $this->getCoreParams('core_display_message','YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE');
		return JText::_($message);
	}

	public function getRedirectUrl()
	{
		return $this->getCoreParams('core_redirect_url','index.php?option=com_community');
	}
}
