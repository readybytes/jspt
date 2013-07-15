<?php
class PerformanceTest extends XiUnitTestCase
{
    function getSqlPath()
    {
        return dirname(__FILE__).'/sql/'.__CLASS__;
    }
   
    function insertUser($userLimit)
    {       
        $db    = JFactory::getDBO();
        $query = 'SELECT MAX(id) FROM `#__users`';
        $db->setQuery( $query );
        $userid = $db->loadResult();
        $userid = (int)$userid + 1;

        $config       = JFactory::getConfig();
        $authorize    = JFactory::getACL();
        $usersConfig  = JComponentHelper::getParams( 'com_users' );
        $newUsertype  = 'Registered';
        $date 		  = JFactory::getDate();
        $registerDate = $date->toMySQL();
       
       
        for($i=1 ; ($userid+$i)<$userLimit ; $i++)
        {
            $user         = new JUser();

            $user->set('id', 0);
            $user->set('usertype', $newUsertype);
            $user->set('gid', $authorize->get_group_id( '', $newUsertype, 'ARO' ));
            $user->set('registerDate', $registerDate);
           
            $this->bind($user, $userid+$i);
            $user->save();
            $this->communityUsers($user->id);
            $this->communityUserFields($user->id);
        }
    }
   
    function bind($user, $userid)
    {
        $user->name         = "name$userid";
        $user->username     = "username$userid";
        $user->email        = "username$userid@email.com";
        $user->password     = "password";   
    }
   
    function communityUsers($userid)
    {
        static $status        = "";
        static $points        = 0;
        static $posted_on     = '';
        static $avatar        = 'components/com_community/assets/default.jpg';
        static $thumb         = 'components/com_community/assets/default_thumb.jpg';
        static $invite        = 0;
        static $params        = "notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=20\nprivacyFriendsView=20\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\n\n";
        static $view          = 0;
        static $friendcount   = 0;
       
        $db 	= JFactory::getDBO();
        $query  = 'INSERT INTO `#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`)'
                . ' VALUES ('.$db->Quote($userid).','.$db->Quote($status).','.$db->Quote($points).','.$db->Quote($posted_on).','.$db->Quote($avatar).','.$db->Quote($thumb).','.$db->Quote($invite).','.$db->Quote($params).','.$db->Quote($view).','.$db->Quote($friendcount).')';
        $db->setQuery( $query );
        $db->query();               
    }   
   
    function communityUserFields($userid)
    {
        $data        = $this->getData();
        $day         = rand(1,28);
        $month       = rand(1,12);
        $year        = rand(1990,2000);
        $dob         = $year.'-'.$month.'-'.$day.' 23:59:59';

        $country_no  = rand(0,11);
        $country     = $data['country'][$country_no];
       
        $mobile      = rand(0000000000,9999999999);
        $land        = rand(1111111111,9999999999);
       
        $gen_no      = rand(0,1);
        $gender      = $data['gender'][$gen_no];
       
        $state_no    = rand(0,11);
        $state       = $data['state'][$state_no];
       
        $city_no     = rand(0,26);
        $city        = $data['city'][$city_no];
       
        $fieldValues = array(2=>$gender, 3=>$dob, 4=>$city, 7=>$mobile, 8=>$land, 9=>$city, 10=>$state, 11=>$city, 12=>$country);
                       
        $db 	= JFactory::getDBO();

        $query  = 'INSERT INTO `#__community_fields_values` (`user_id`, `field_id`, `value`) VALUES ';
        $qData  = array();
        
        foreach($fieldValues as $fieldId => $value)
        {
           $qData [] = ' ('.$db->Quote($userid).','.$db->Quote($fieldId).','.$db->Quote($value).')';
        }       
        
        $db->setQuery( $query.' '.implode(",", $qData) );
        $db->query();       
            
    }
   
    function getData()
    {
        static $data = null;
       
        if($data)
            return $data;
           
        $data['country'] 	=  array('Afghanistan','Albania','Algeria','American Samoa','Andorra','Angola','Anguilla','Antarctica','Antigua and Barbuda','Argentina','Armenia','Aruba');
        $data['gender']     =  array('Male','Female');
        $data['state']      =  array('Rajasthan','Orissa','Bihar','Delhi','Maharashtra','Uttar Pradesh','Andhra Pradesh','Assam','Goa','Gujrat','Haryana','Karnataka');
        $data['city']       =  array('Bhilwara','Jaipur','Udaipur','Jodhapur','Mumbai','Delhi','Banglore','chennai','Indore','Bhopal','Kanpur','Noida','Kolkata','Hyderabad','Ahmedabad','Pune','Surat',
                        		'Nagpur','Chandigarh','Jalandhar','Shimla','Ludhiana','Alwar','Ajmer','Bikaner','Vadodara','Coimbatore');
       
        return $data;
    }
   
    function testPerformance()
    {
        $this->insertUser(1063);
        // test for 1 user
        $this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testPerformance.start.sql');
        $time   = $this->xiptPerformance(100, false);
//        $this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testPerformance.start.sql');
//        $time   = $this->xiptPerformance(10, true);
        
//        //test for 100 users
//        $this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testPerformance.start.sql');
//        $time   = $this->xiptPerformance(100, false);
//        
//        $this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testPerformance.start.sql');
//        $time   = $this->xiptPerformance(100, true);
//
//        $this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testPerformance.start.sql');
//        $time   = $this->xiptPerformance(100, true);
        echo "\n \n Total time to sync up = $time";

    }
   
	function xiptPerformance($limit, $cache)
    {    
    	XiptLibJomsocial::cleanStaticCache($cache);
    	
    	$db             = JFactory::getDBO();
        $startTicker    = $db->getTicker();
        
    	$profiler       = new JProfiler;   
        $startTime      = $profiler->getmicrotime();
        
        $syncupObj 		= new XiptSetupRuleSyncupusers();
        $result 		= $syncupObj->isRequired();
        
        if($result)
        {
        	$this->assertTrue($syncupObj->syncUpUserPT(0, $limit, true));
        }
           
        $endTime         = $profiler->getmicrotime();
        $endTicker       = $db->getTicker();

        $queryNo = $endTicker-$startTicker;
        
        echo "Total no of queries are $queryNo \n \n";
        //print_r(var_export($db->getLog()));
        $time = $endTime - $startTime;
        
        XiptLibJomsocial::cleanStaticCache(true);
        return $time;     
    }
    
}