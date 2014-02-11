<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
jimport( 'joomla.application.component.table' );

abstract class XiptTable extends JTable
{
	protected	$_name;

	//apply caching
    public function getName()
	{
		if(isset($this->_name))
			return $this->_name;
			
		$r = null;
		if (!preg_match('/Table(.*)/i', get_class($this), $r)) {
			XiptError::raiseError (__CLASS__.'.'.__LINE__, "XiTable : Can't get or parse class name.");
		}
		$this->_name = strtolower( $r[1] );
		
		return $this->_name;
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
			XiError::raiseError (__CLASS__.'.'.__LINE__, "XiModel::getName() : Can't get or parse class name.");
		}

		$this->_prefix  =  JString::strtolower($r[1]);
		return $this->_prefix;
	}

	function __construct($tblFullName=null, $tblPrimaryKey=null, $db=null)
	{
		if($db===null)
			$db	=	JFactory::getDBO();

		//call parent to build the table object
		parent::__construct( $tblFullName, $tblPrimaryKey, $db);

		//now automatically load the table fields
		//this way we do not need to do things statically
		$this->_loadTableProps();
	}

	public function reset()
	{
		$k = $this->_tbl_key;
		foreach ($this->getProperties() as $name => $value)
			$this->$name	= null;
		
		return true;
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
	public function getColumns()
	{
		if(isset($this->_columns))
			return $this->_columns;
			
		$tableName 	= $this->getTableName();
		if(XiptHelperTable::isTableExist($tableName)===FALSE)
			return XiptError::raiseError(__CLASS__.'.'.__LINE__, XiptText::_("Table $this->_tbl DOES_NOT_EXIST"));
			

		$fields 		= $this->_db->getTableFields($tableName);
		$this->_columns = $fields[$tableName];

		return $this->_columns;
	}
	
	function bind($data =array(),$ignore = array())
	{
		
		$prop = $this->getProperties();
		
		foreach($data as $key => $value){
			// set those properties which exists in filed list of table
			// otherwise do not update
			if(array_key_exists($key, $prop))
				$this->$key = $value;
		}
			
		return true;
	}
	
	function delete($oid= null)
	{
		if(empty($oid)) {
			return false;
		}
			
		//if its a pk, then simple call parent
		// if its a array then its not a single primary key 
		if(is_array($oid)===false) {
			return parent::delete($oid);
		}

		$glue= 'AND';
		
		$num_args = func_num_args();

    	if ($num_args = 2) {
        	$glue = func_get_arg(1);
    	}
		
    	
		$query = new XiptQuery(); 
		$query->delete()
			  ->from($this->getTableName());
		
		foreach($oid as $key=> $value){
			$query->where(" `$key`  = '$value' ",$glue);
		}
		// XITODO : generate warning if record does not exists
		return $query->dbLoadQuery("", "")
					 ->query();		
		
	}
	
	public function store($updateNulls = false)
	{
		$k = $this->_tbl_key;
		if (!empty($this->asset_id))
		{
			$currentAssetId = $this->asset_id;
		}

		if (0 === $this->$k)
		{
			$this->$k = null;
		}

		// The asset id field is managed privately by this class.
		if ($this->_trackAssets)
		{
			unset($this->asset_id);
		}

		// If a primary key exists update the object, otherwise insert it.
		if ($this->$k)
		{
			$this->_db->updateObject($this->_tbl, $this, $this->_tbl_key, $updateNulls);
		}
		else
		{
			$this->_db->insertObject($this->_tbl, $this, $this->_tbl_key);
		}

		// If the table is not set to track assets return true.
		if (!$this->_trackAssets)
		{
			return true;
		}

		if ($this->_locked)
		{
			$this->_unlock();
		}

		/*
		 * Asset Tracking
		 */

		$parentId = $this->_getAssetParentId();
		$name = $this->_getAssetName();
		$title = $this->_getAssetTitle();

		$asset = self::getInstance('Asset', 'JTable', array('dbo' => $this->getDbo()));
		$asset->loadByName($name);

		// Re-inject the asset id.
		$this->asset_id = $asset->id;

		// Check for an error.
		$error = $asset->getError();
		if ($error)
		{
			$this->setError($error);
			return false;
		}

		// Specify how a new or moved node asset is inserted into the tree.
		if (empty($this->asset_id) || $asset->parent_id != $parentId)
		{
			$asset->setLocation($parentId, 'last-child');
		}

		// Prepare the asset to be stored.
		$asset->parent_id = $parentId;
		$asset->name = $name;
		$asset->title = $title;

		if ($this->_rules instanceof JAccessRules)
		{
			$asset->rules = (string) $this->_rules;
		}

		if (!$asset->check() || !$asset->store($updateNulls))
		{
			$this->setError($asset->getError());
			return false;
		}

		// Create an asset_id or heal one that is corrupted.
		if (empty($this->asset_id) || ($currentAssetId != $this->asset_id && !empty($this->asset_id)))
		{
			// Update the asset_id field in this table.
			$this->asset_id = (int) $asset->id;

			$query = $this->_db->getQuery(true)
				->update($this->_db->quoteName($this->_tbl))
				->set('asset_id = ' . (int) $this->asset_id)
				->where($this->_db->quoteName($k) . ' = ' . (int) $this->$k);
			$this->_db->setQuery($query);

			$this->_db->execute();
		}

		return true;
	}
}

