<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.table' );

class XiptTable extends JTable
{
	protected	$_name;
    protected	$_absolutePrefix	= 'xipt';

	//apply caching
    public function getName()
	{
		$name = $this->_name;

		if(empty($name))
		{
			$r = null;
			if (!preg_match('/Table(.*)/i', get_class($this), $r)) {
				JError::raiseError (500, "XiTable : Can't get or parse class name.");
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
		if(isset($this->_prefix))
			return $this->_prefix;

		$r = null;
		if (!preg_match('/(.*)Table/i', get_class($this), $r)) {
			XiError::raiseError (500, "XiModel::getName() : Can't get or parse class name.");
		}

		$this->_prefix  =  JString::strtolower($r[1]);
		return $this->_prefix;
	}

	function __construct($tblFullName=null, $tblPrimaryKey=null, $db=null)
	{
		//Create full name e.g. #__ + xiec + products
		if($tblFullName===null)
			$tblFullName	= "#__".JString::strtolower($this->getPrefix())
							. "_" . $this->getName();

//		//create primary key name e.g. products + _ + id
//		if($tblPrimaryKey===null)
//			$tblPrimaryKey	= $this->getName().'_id';

		if($db===null)
			$db	=&	JFactory::getDBO();

		//call parent to build the table object
		parent::__construct( $tblFullName, $tblPrimaryKey, $db);

		//now automatically load the table fields
		//this way we do not need to do things statically
		$this->_loadTableProps();
	}

	/**
     * Load properties of object based on table fields
     * It will be done via reading table from DB
     */
    private function _loadTableProps()
    {
   		$fields = $this->getColumns();

    	//still not found, the table
    	if(empty($fields))
    		return false;

    	foreach ($fields as $name=>$type){
    		$this->set($name,NULL);
    	}

        return true;
    }

	/**
	 * Get structure of table from db table
	 */
	//XITODO : Cache it
	public function getColumns()
	{
		$tableName 	= $this->getTableName();
		if(XiptHelperTable::isTableExist($tableName)===FALSE)
			return XiptError::raiseError("Table $this->_tbl does not exist");

		$fields 	= $this->_db->getTableFields($tableName);
		$columns 	= $fields[$tableName];

		return $columns;
	}
	
	function bind( $data )
	{
		foreach($data as $key => $value)
			$this->$key = $value;
	}
}

