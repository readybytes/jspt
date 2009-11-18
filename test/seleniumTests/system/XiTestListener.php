<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__). '/joomlaFramework.php';

class XiDBCheck
{
    static private $db;
    private $testTables;
    private $excludeC;
    private $exludeR;
    private $orderBy;
    private $errorLog;
    function __construct()
    {
        if(!$this->db)
            $this->db=& JFactory::getDBO();
    }
    
    /*
     * Original Tables : 
     * Compares tables
     * */
    function compareTable($tableName)
    {
        //echo "\n --> Comparing table ".$tableName;
        
        $tmpCol = $this->db->getTableFields($tableName, false);
        $allcol = array_keys ($tmpCol[$tableName]);
        $fields = array_diff($allcol, $this->excludeC[$tableName]);
        //echo "\n ALLCOL:"; print_r($allcol);
        //echo "\n To be filtered :"; print_r($this->excludeC[$tableName]);
        
        
        $select = ' * ';
        if($fields)
        {    
            $select = '`';
            $select .=implode('`,`',$fields);
            $select .= '`';
         }
        
        //echo "\n comparing fields : "; print_r($fields); echo "\n Select is: "; print_r($select);
        
        $query    = ' SELECT '.$select.' FROM '. $tableName 
                    . $this->excludeR[$tableName]
                    . $this->orderBy[$tableName];
        $this->db->setQuery($query);
        //echo "\n Query for logTable : ".$query;
        $logTable = $this->db->loadAssocList();

        $query    = ' SELECT '.$select.' FROM '. ' au_'.$tableName 
                    . $this->excludeR[$tableName]
                    . $this->orderBy[$tableName];
        $this->db->setQuery($query);
        
        //echo "\n Query for auTable : ".$query;
        $auTable = $this->db->loadAssocList();

        //echo "\n auTable :";print_r($auTable);
        //echo "\n logTable :";print_r($logTable);
        $count=count($auTable);
        for($i=0 ; $i<$count;$i++)
        {        
            if($diff = array_diff_assoc($auTable[$i],$logTable[$i]))
            {
                $error = "\n \n \n Table " . $tableName . " mismatched"
                        ."\n for Rows " . $this->excludeR[$tableName]
                        ."\n for Cols " . $select
                        ."\n for Order " . $this->orderBy[$tableName]
                        ."\n Diff " . var_export($diff,true)
                        ."\n Gold Result " . var_export($auTable[$i],true)
                        ."\n Log " . var_export($logTable[$i],true)
                        ;
                $this->errorLog[]=$error;

                return false;
            }
            else
            {
                //echo "\n Table ".$tableName. " Record : ".$i . " Matched";
            }
            
        }
        //echo " \n ==  Table ".$tableName. " Matched == \n ";
        return true;        
    }
    
    function addTable($tableName)
    {
        //if(!in_array($testTables,$tableName))
        $this->testTables[] = $tableName;
        $this->excludeC[$tableName]='';
        $this->orderBy[$tableName]='';
    }
    
    function filterColumn($table, $column)
    {
        $this->excludeC[$table][] = $column;
    }
    
    function filterRow($table, $row)
    {
        if(array_key_exists($this->excludeR[$table])==false)
            $this->excludeR[$table] = ' WHERE '. $row;
        else
            $this->excludeR[$table] = ' AND '. $row;
    }
    
    function filterOrder($table, $order)
    {
            $this->orderBy[$table] = ' ORDER BY  '. $order;
    }
    
    
    function verify()
    {
        foreach($this->testTables as $t){
            if($this->compareTable($t)==false)
                return false;
        }
        return true;
    }
    
    function getErrorLog()
    {
       return $this->errorLog;
    }
    
    function loadSql($file)
    {
        if(!file_exists($file))
        {
            $this->errorLog[]="File does not exist : ".$file;
            return false;
        }
        $query=file_get_contents($file);
        $allQuery=explode(';',$query);
        
        foreach($allQuery as $q){
            //echo "\n Query is : ".$q . "\n";
            // we might have empty queries
            $q = trim($q);
            if(empty($q))
                continue;

            $this->db->setQuery($q);
            if(!$this->db->query())
            {
                $error = "Joomla DB Error Number : ".$this->db->getErrorNum();
                $this->errorLog[]=$error;
                    
                echo "\n Some error during Sql Loading.\n";
                echo $q."\n";
                break;
            }
        }
        
        return true;
    }
}

class XiTestListener implements PHPUnit_Framework_TestListener
{
  public function addError(PHPUnit_Framework_Test $test,Exception $e,$time){}
  public function addFailure(PHPUnit_Framework_Test $test,PHPUnit_Framework_AssertionFailedError $e,$time){}
  public function addIncompleteTest(PHPUnit_Framework_Test $test, Exception $e, $time){}
  public function addSkippedTest(PHPUnit_Framework_Test $test,Exception $e,$time){}
  public function startTestSuite(PHPUnit_Framework_TestSuite $suite){}
  public function endTestSuite(PHPUnit_Framework_TestSuite $suite){}
  
  
  public function startTest(PHPUnit_Framework_Test $test)
  {
      
    $testName      = $test->getName();    
    //echo "\n Starting Test : ".$testName;
    // this two variables must be defined by test
    if(!method_exists($test,'getSqlPath'))
        return;
        
    $sqlPath       = $test->getSqlPath(); 
    $test->_DBO    =& new XiDBCheck();
    $dbDump        =  $sqlPath.'/sql/'.$testName.'.start.sql';
    //echo "\n Loading SQL : ".$dbDump;
    $test->_DBO->loadSql($dbDump);
  }
 
  public function endTest(PHPUnit_Framework_Test $test, $time)
  {
    
    $testName = $test->getName();    
    //echo "\n Ending test : ".$testName;
    // this two variables must be defined by test
    if(!$test->_DBO)
        return;
    $errors = $test->_DBO->getErrorLog();
    if($errors){
         $sqlPath       = $test->getSqlPath();    
         $logfile       =  $sqlPath.'/'.$testName.'.log';
         file_put_contents($logfile,$errors);
    }
  } 
  
}
?>
