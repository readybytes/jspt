<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.model' );

class XiptModel extends JModel
{
	protected	$_absolutePrefix = 'xipt';
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

		$table	= XiptFactory::getInstance($tableName,'Table',JString::ucfirst($this->_absolutePrefix));
		if(!$table)
			XiptError::raiseError(500,XiptText::_("NOT ABLE TO GET INSTANCE OF TABLE : {$this->getName()}"));

		return $table;
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

		//if we have itemid then we MUST load the record
		// else this is a new record
		if($pk && $table->load($pk)===false){
			XiptError::raiseError(XiptText::_("NOT ABLE TO LOAD DATA"));
			return false;
		}

		//bind, and then save
	    if($table->bind($data) && $table->store())
			return true;

		//some error occured
		XiptError::raiseError(500, XiptText::_("NOT ABLE TO SAVE DATA"));
		return false;
	}

	/**
	 * Method to delete rows.
	 */
	public function delete($pk)
	{
		//XITODO assert for $pk
		//load the table row
		$table = $this->getTable();

		if(!$table)
			return false;

		//try to load and delete 
	    if($table->load($pk) && $table->delete($pk))
	    	return true;

		XiptError::raiseError(500,XiptText::_('NOT ABLE TO DELETE DATA'));		
		return false;
	}

	/**
	 * XITODO Method to order rows.
	 */
	public function order($pk, $change)
	{
		//XITODO assert for $pk

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
	
//XITODO : move to child model
	function visible($id)
	{		
		return $this->save( array('visible'=>1), $id );		
	}
	
	function invisible($id)
	{		
		return $this->save( array('visible'=>0), $id );		
	}
}