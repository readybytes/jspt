<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class aclFactory
{
	
	public function getAclRulesInfo($filter='',$join='AND')
	{
		$db			=& JFactory::getDBO();
		
		$filterSql = ''; 
		if(!empty($filter)){
			$filterSql = ' WHERE ';
			$counter = 0;
			foreach($filter as $name => $info) {
				$filterSql .= $counter ? ' '.$join.' ' : '';
				$filterSql .= $db->nameQuote($name).'='.$db->Quote($info);
				$counter++;
			}
		}

		$query = 'SELECT * FROM '.$db->nameQuote('#__xipt_aclrules')
				.$filterSql;
				
		$db->setQuery($query);
		$aclRuleinfo = $db->loadObjectList();
		
		return $aclRuleinfo;
	}
	
	
	
	public function getAcl()
	{
		$path	= dirname(__FILE__);
	
		jimport( 'joomla.filesystem.folder' );
		$acl = array();
		$acl = JFolder::folders($path);
		return $acl;
	}
	
	
	public function getAclObject($aclName)
	{
		$path	= dirname(__FILE__). DS . $aclName . DS . $aclName.'.php';
		jimport( 'joomla.filesystem.file' );
		if(!JFile::exists($path))
		{
			JError::raiseError(400,JText::_("INVALID ACL FILE"));
			return false;
		}

		require_once $path;
			
		//$instance will comtain all addon object according to rule
		//Every rule will have different object
		static $instance = array();
		if(isset($instance[$aclName]))
			return $instance[$aclName];
			
		//XITODO send debugmode
		$instance[$aclName] = new $aclName(0);	
		return $instance[$aclName];
	}
	
	
	public function getAclObjectFromId($id,$checkPublished=false)
	{
		$filter = array();
		$filter['id']	= $id;
		if($checkPublished)
			$filter['published']	= 1;
		$info = self::getAclRulesInfo($filter);
		if($info){
			$aclObject = self::getAclObject($info[0]->aclname);
			return $aclObject;
		}
		
		return false;
	}
	
	
}





abstract class xiptAclRules
{
	protected $id;
	protected $aclname;
	protected $rulename;
	protected $published;
	protected $coreparams;
	protected $aclparams;
	protected $debugMode;
	
	function __construct($className,$debugMode)
	{
		jimport( 'joomla.filesystem.files' );
		$this->debugMode = $debugMode;
		$this->aclname = $className;
		$aclxmlpath =  dirname(__FILE__) . DS . strtolower($className) . DS . strtolower($className).'.xml';
		if(!$this->aclparams && JFile::exists($aclxmlpath))
			$this->aclparams = new JParameter('',$aclxmlpath);
		else if(!$this->aclparams && !JFile::exists($aclxmlpath))
			$this->aclparams = new JParameter('','');

		$corexmlpath = dirname(__FILE__) . DS . 'coreparams.xml';
		if(JFile::exists($corexmlpath))
			$this->coreparams = new JParameter('',$corexmlpath);
			
		$this->id = 0;
		$this->rulename = '';
		$this->published = 1;
	}
	
	
	function load($id)
	{
		if(0 == $id) {
			$this->id = 0;
			$this->rulename = '';
			$this->published = 1;
		}
		else {
			$filter = array();
			$filter['id'] = $id;
			$info = aclFactory::getAclRulesInfo($filter);
			if($info) {
				$this->id 				= $info[0]->id;
				$this->aclname 			= $info[0]->aclname;
				$this->published 		= $info[0]->published;
				$this->rulename 		= $info[0]->rulename;
				$this->coreparams->bind($info[0]->coreparams);
				$this->aclparams->bind($info[0]->aclparams);
			}
		}
	}
	
	/* function will return array of all value */
	function getObjectInfoArray()
	{
		$data = array();
		$data['id']				= $this->id;
		$data['aclname']		= $this->aclname;
		$data['rulename']		= $this->rulename;
		$data['published']		= $this->published;
		$data['coreparams']		= $this->coreparams;
		$data['aclparams']		= $this->aclparams;
		return $data;
	}
	
	
	public function getHtml(&$coreParamsHtml,&$aclParamsHtml)
	{
		//Imp : Function will always call core field html
		$coreParamsHtml = $this->getCoreParamsHtml();
		$aclParamsHtml = $this->getAclParamsHtml();
	}
	
	
	public function getAclParamsHtml()
	{
		$aclParamsHtml = $this->aclparams->render('aclparams');
		
		if($aclParamsHtml)
			return $aclParamsHtml;
		
		$aclParamsHtml = "<div style=\"text-align: center; padding: 5px; \">".JText::_('There are no parameters for this item')."</div>";
		
		return $aclParamsHtml;
	}
	
	
	final public function getCoreParamsHtml()
	{
		$coreParamsHtml = $this->coreparams->render('coreparams');
		
		if($coreParamsHtml)
			return $coreParamsHtml;
		
		$coreParamsHtml = "<div style=\"text-align: center; padding: 5px; \">".JText::_('There are no parameters for this item')."</div>";
		
		return $coreParamsHtml;
	}
	
	
	function collectParamsFromPost($postdata)
	{
		assert($postdata['aclparams']);
		$registry	=& JRegistry::getInstance( 'xipt' );
		$registry->loadArray($postdata['aclparams'],'xipt_aclparams');
		$aclparams =  $registry->toString('INI' , 'xipt_aclparams' );
		return $aclparams;
	}
	
	
	
	function bind($data)
	{
		if(is_object($data)) {
			$this->aclparams->bind($data->aclparams);
			$this->coreparams->bind($data->coreparams);
			$this->rulename 	= $data->rulename;
			$this->published 	= $data->published;
			$this->id			= $data->id;
		}
		else if(is_array($data)) {
			$this->aclparams->bind($data['aclparams']);
			$this->coreparams->bind($data['coreparams']);
			$this->rulename 	= $data['rulename'];
			$this->published 	= $data['published'];
			$this->id			= $data['id'];
		}
	}
	
		
	
	/* we need refrence b'coz we may need to change viewuserid
	 * in case of writemessages
	 */
	function isApplicable(&$data)
	{    
	    $isAclApplicableOnProfile  =     $this->checkAclOnProfile($data);
		$isApplicableAccToAcl      =     $this->checkAclAccesibility($data);
		$isApplicableAccToCore     =     $this->checkCoreAccesibility($data);
		//XITODO : Conditions should be OR ED
		if($isApplicableAccToAcl && $isApplicableAccToCore && $isAclApplicableOnProfile)
			return true;
			
		return false;
	}
	
  public function checkAclOnProfile($data)
    {
	  if(is_array($data['args']) && array_key_exists('from',$data['args']) && 'onprofileload' == $data['args']['from'])
	    return false;
	    
	  return true;
    }
	
	public function checkCoreAccesibility($data)
	{
		$ptype = $this->getCoreParams('core_profiletype',0);
		
		/* ptype 0 means rule is defined for all */
		if(0 == $ptype)
			return true;
			
		//else check user profiletype
		$userPtype = XiPTLibraryProfiletypes::getUserData($data['userid']);
		
		if($userPtype == $ptype)
			return true;
			
		return false;
	}
	
	
	public function checkAclAccesibility($data)
	{
		return true;
	}
	
	
	function isViolatingRule($data)
	{
		$isViolateAccToAcl = $this->checkAclViolatingRule($data);

		$isViolateAccToCore =  $this->checkCoreViolatingRule($data);
		
		if($isViolateAccToCore || $isViolateAccToAcl)
			return true;
			
		return false;
	}
	
	
	public function checkAclViolatingRule($data)
	{
		return false;
	}
	
	
	public function checkCoreViolatingRule($data)
	{
		return false;	
	}

	
	
	public function getDisplayMessage()
	{
		$message = $this->getCoreParams('core_display_message','YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE');
		$message = JText::_($message,false);
		return $message;
	}
	
	
	public function getRedirectUrl()
	{
		$redirectUrl  = $this->getCoreParams('core_redirect_url','index.php?option=com_community');
		return $redirectUrl;
	}
	
	
	public function getCoreParams($what,$default=0)
	{
		$value = $this->coreparams->get($what,$default);
		return $value;
	}
	
	
	public function handleViolation($info)
	{
		/* handle ajax case also */
		global $mainframe;
		$msg 			= $this->getDisplayMessage();
		if($info['ajax']) {
			$this->aclAjaxBlock($msg);
			return;
		}
		
		// one special case
		if($info['task'] == 'jsonupload') {
			$nextUpload	= JRequest::getVar('nextupload' , '' , 'GET');
			echo 	"{\n";
			echo "error: 'true',\n";
			echo "msg: '" . $message . "'\n,";
			echo "nextupload: '" . $nextUpload . "'\n";
			echo "}";
			exit;
		}
		
		$redirectUrl 	= $this->getRedirectUrl();
		$mainframe->redirect(JRoute::_($redirectUrl,false),$msg);
	}
	
	
	function aclAjaxBlock($msg, $objResponse=null)
	{
		if($objResponse === null)
			$objResponse   	= new JAXResponse();

		$html 	= $msg;

		$objResponse->addAssign('cwin_logo', 'innerHTML', JText::_('YOU ARE NOT ALLOWED TO PERFORM THIS ACTION'));
		$objResponse->addAssign('cWindowContent', 'innerHTML', $html);
		$objResponse->addScriptCall('cWindowResize', 80);
		$objResponse->sendResponse();
	}
	
	
	public function getMe()
	{
		$name =  get_class($this);
		return $name;
	}

}
