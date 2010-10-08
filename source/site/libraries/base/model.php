<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

jimport( 'joomla.application.component.model' );

abstract class XiptModel extends JModel
{
	protected 	$_pagination	 = '';
	protected	$_query		= null;
	protected 	$_total 	= array();

	public function __construct($options = array())
	{
		//name can be collected by parent class
		if(array_key_exists('name',$options)==false)
			$options['name']	= $this->getName();

		if(array_key_exists('prefix',$options)==false)
			$options['prefix']	= $this->getPrefix();

		//now construct the parent
		parent::__construct($options);
		$this->getPagination();
	}

	/*
	 * We need to override joomla behaviour as they differ in
	 * Model and Controller Naming
	 */
	function getName()
	{
		$name = $this->_name;

		if (empty( $name ))
		{
			$r = null;
			if (!preg_match('/Model(.*)/i', get_class($this), $r)) {
				JError::raiseError (500, "XiptModel::getName() : Can't get or parse class name.");
			}
			$name = strtolower( $r[1] );
		}

		return $name;
	}

	/*
	 * Collect prefix auto-magically
	 */
	public function getPrefix()
	{
		if(isset($this->_prefix) && empty($this->_prefix)===false)
			return $this->_prefix;

		$r = null;
		if (!preg_match('/(.*)Model/i', get_class($this), $r)) {
			XiptError::raiseError (500, "XiptModel::getPrefix() : Can't get or parse class name.");
		}

		$this->_prefix  =  JString::strtolower($r[1]);
		return $this->_prefix;
	}
	
	/*
	 * Count number of total records as per current query
	 */
	public function getTotal()
	{
		if($this->_total)
			return $this->_total;

		$query 			= $this->getQuery();
        $this->_total 	= $this->_getListCount((string) $query);

		return $this->_total;
	}

	
	private function __getEmptyRecord()
	{
		$vars = $this->getTable()->getProperties();
		$retObj = new stdClass();

		foreach($vars as $key => $value)
			$retObj->$key = null;

		return array($retObj);
	}
	
	/*
	 * Returns Records from Model Tables
	 * as per Model STATE
	 */
	public function loadRecords($limit=null, $limitstart=null, $emptyRecord=false)
	{
		if($limit===null)
			$limit = $this->getState('limit',null);

		if($limitstart ===null)
			$limitstart = $this->getState('limitstart',0);

		$query = $this->getQuery();

		//there might be no table and no query at all
		if($query === null )
			return null;
			
		//we want returned record indexed by columns
		$pKey = $this->getTable()->getKeyName();

		$this->_recordlist = $query->limit($limit,$limitstart)
									->dbLoadQuery("", "")
									->loadObjectList($pKey);

		if($emptyRecord){
			$this->_recordlist = $this->__getEmptyRecord();
		}

		return $this->_recordlist;
	}


	/**
	 * Get an object of model-corresponding table.
	 * @return XiptTable
	 */
	public function getTable($tableName=null)
	{
		// support for parameter
		if($tableName===null)
			$tableName = $this->getName();

		return XiptFactory::getInstance($tableName,'Table');
	}

	function save($data, $pk=null)
	{
		if(isset($data)===false || count($data)<=0)
		{			
			XiptError::raiseError(500,XiptText::_("NO DATA TO SAVE"));
			return false;
		}

		//load the table row
		$table = $this->getTable();
		if(!$table){
			XiptError::raiseError(500,XiptText::_("Table does not exist"));
			return false;
		}
	
		// If table object was loaded by some code previously
		// then it can overwrite the previous record
		// So we must ensure that either PK is set to given value
		// Else it should be set to 0
		$table->reset();
		
		//if we have itemid then we MUST load the record
		// else this is a new record
		if($pk && $table->load($pk)===false){
			XiptError::raiseError(XiptText::_("NOT ABLE TO LOAD DATA"));
			return false;
		}

		//bind, and then save, we should return the record_id updated/inserted
	    if($table->save($data))
			return $table->{$table->getKeyName()};

		//some error occured
		XiptError::raiseError(500, XiptText::_("NOT ABLE TO SAVE DATA"));
		return false;
	}

	/**
	 * Method to delete rows.
	 */
	public function delete($filters,$glue='AND')
	{
		//XITODO assert for $pk
		//load the table row
		$table = $this->getTable();

		if(!$table)
			return false;

		//try to load and delete 
	    if($table->delete($filters,$glue))
	    	return true;

		XiptError::raiseError(500,XiptText::_('NOT ABLE TO DELETE DATA'));		
		return false;
	}

	/**
	 * XITODO Method to order rows.
	 */
	public function order($pk, $change)
	{
		XiptHelperUtils::XAssert($pk);

		//load the table row
		$table = $this->getTable();

		if(!$table)
			return false;

		//try to move
	    if($table->load($pk) && $table->move($change))
			return true;

		//some error occured
		XiptError::raiseError(500,XiptText::_("NOT ABLE TO LOAD DATA"));
		return false;
	}
	
	/**
	 * Returns the Query Object if exist
	 * else It builds the object
	 * @return XiQuery
	 */
	public function getQuery()
	{
		//query already exist
		if($this->_query)
			return $this->_query;

		//create a new query
		$this->_query = new XiptQuery();
		
		$this->_query->select('*'); 
		$this->_query->from($this->getTable()->getTableName());	
		return $this->_query;
	}

	/**
	 * @return XiPagination
	 */
	function &getPagination()
	{
	 	if($this->_pagination)
	 		return $this->_pagination;

		$this->_pagination = new XiptPagination($this);
		return $this->_pagination;
	}
	// XITODO : check these fileds exist in table or not
	function publish($id)
	{		
		return $this->save( array('published'=>1), $id );		
	}
	
	function unpublish($id)
	{		
		return $this->save( array('published'=>0), $id );		
	}	
	
	function saveParams($data, $id, $what = '')
	{
		
		XiptHelperUtils::XAssert($id);
		XiptHelperUtils::XAssert($what);
		
		if(empty($data) || !is_array($data))
			return false;
			
		//$xmlPath = XIPT_FRONT_PATH_ASSETS.DS.'xml'.DS. JString::strtolower($this->getName().".$what.xml");
		$iniPath = XIPT_FRONT_PATH_ASSETS.DS.'ini'.DS. JString::strtolower($this->getName().".$what.ini");
		$iniData = JFile::read($iniPath);
		
		$registry	= new JRegistry();
		$registry->loadINI($iniData);
		$registry->loadArray($data);
		$iniData	= $registry->toString('INI');
		return $this->save(array($what => $iniData), $id);
	}
	
	function loadParams($id, $what = '')
	{		
		$record = $this->loadRecords();
		
		$xmlPath 	= XIPT_FRONT_PATH_ASSETS.DS.'xml'.DS.JString::strtolower($this->getName().".$what.xml");
		$iniPath	= XIPT_FRONT_PATH_ASSETS.DS.'ini'.DS.JString::strtolower($this->getName().".$what.ini");
		$iniData	= JFile::read($iniPath);

		XiptHelperUtils::XAssert(JFile::exists($xmlPath));
			
		$config = new JParameter($iniData,$xmlPath);
		$config->bind($record[$id]->$what);	
		
		return $config;
	}
}