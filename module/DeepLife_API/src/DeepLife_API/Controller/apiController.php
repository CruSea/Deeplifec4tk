<?php
/**
 * Created by PhpStorm.
 * User: BENGEOS-PC
 * Date: 3/25/2016
 * Time: 12:57 PM
 */

namespace DeepLife_API\Controller;

use DeepLife_API\Model\Answers;
use DeepLife_API\Model\Disciple;
use DeepLife_API\Model\Hydrator;
use DeepLife_API\Model\NewsFeed;
use DeepLife_API\Model\Schedule;
use DeepLife_API\Model\Testimony;
use DeepLife_API\Model\User;
use DeepLife_API\Model\User_Role;
use DeepLife_API\Model\UserReport;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class apiController extends AbstractRestfulController
{
    protected $api_Response;
    protected $api_Services = array(
        'GetAll_Disciples','GetNew_Disciples','AddNew_Disciples','AddNew_Disciples_Log','Delete_All_Disciple_Log',
        'GetAll_Schedules','GetNew_Schedules','AddNew_Schedules','AddNew_Schedule_Log','Delete_All_Schedule_Log',
        'IsValid_User','CreateUser','GetAll_Questions','GetAll_Answers','AddNew_Answers','Send_Log','Log_In','Sign_Up',
        'Update_Disciples','Update','Meta_Data','Send_Report','GetNew_NewsFeed',"Send_Testimony"
    );
    protected $api_Param;
    protected $api_Service;
    /**
     * @var \DeepLife_API\Model\User $api_user
     */
    protected $api_user;

    public function getList()
    {
        return new JsonModel(array('DeepLife'=>'Use POST request to use the api'));
    }
    public function Authenticate($data){
        /**
         * @var \DeepLife_API\Service\Service $smsService
         */
        $smsService = $this->getServiceLocator()->get('DeepLife_API\Service\Service');
        if($smsService->authenticate($data['User_Name'],$data['User_Pass'])){
            $_user = new User();
            $_user->setPhoneNo($data['User_Name']);
            $this->api_user = $smsService->Get_User($_user);
            if($this->api_user->getCountry() == $data['Country']){
                return true;
            }
        }
        $error['Authentication'] = 'Invalid User';
        $this->api_Response['Request_Error'] = $error;
        return false;
    }
    public function create($data)
    {
        if(isset($data['Service']) && $data['Service'] == 'CreateUser' && (isset($data['UserEmail']) || $data['UserPhone']) && isset($data['UserPass'])){
            if($this->CreateNewUser($data)){
                $this->api_Response['Response'] = 1;
            }else{
                $this->api_Response['Response'] = 0;
            }

        }else{
            if($this->isValidRequest($data)){
                if($this->isValidParam($data['Param'],$data['Service'])){
                    if($data['Service'] == 'Sign_Up'){
                        $this->Sign_Up_User($data['Param']);
                    }else{
                        if($this->Authenticate($data)){
                            $this->ProcessRequest($data['Service'],$data['Param']);
                        }
                    }
                    if($data['Service'] == 'Meta_Data'){
                        /**
                         * @var \DeepLife_API\Service\Service $smsService
                         */
                        $smsService = $this->getServiceLocator()->get('DeepLife_API\Service\Service');
                        $found['Country'] = $smsService->GetAll_Country();
                        $this->api_Response['Response'] = $found;
                    }

                }
            }
        }
        return new JsonModel($this->api_Response);
    }
    public function CreateNewUser($data){
        /**
         * @var \DeepLife_API\Service\Service $smsService
         */
        $smsService = $this->getServiceLocator()->get('DeepLife_API\Service\Service');
        $newUser = new User();
        $newUser->setDisplayName(isset($data['displayName'])? ($data['displayName']):null);
        $newUser->setFirstName(isset($data['firstName'])? ($data['firstName']):null);
        $newUser->setCountry(isset($data['category'])? ($data['category']):null);
        $newUser->setPhoneNo(isset($data['phone_no'])? ($data['phone_no']):null);
        $newUser->setPicture(isset($data['picture'])? ($data['picture']):null);
        $newUser->setPassword(isset($data['password'])? ($data['password']):null);
        $newUser->setEmail(isset($data['email'])? ($data['email']):null);
        $state = $smsService->AddNewDisciples($newUser);
        return $state;
    }
    public function Sign_Up_User($param){
        /**
         * @var \DeepLife_API\Service\Service $smsService
         */
        $smsService = $this->getServiceLocator()->get('DeepLife_API\Service\Service');
        $param = json_decode($param,true);
        if(is_array($param)){
            $param = $param[0];
            if(isset($param['User_Name']) && isset($param['User_Country']) && isset($param['User_Phone']) && isset($param['User_Email'])&& isset($param['User_Gender'])&& isset($param['User_Pass'])){
                $new_user = new User();
                $new_user->setFirstName($param['User_Name']);
                $new_user->setCountry($param['User_Country']);
                $new_user->setPhoneNo($param['User_Phone']);
                $new_user->setEmail($param['User_Email']);
                $new_user->setPassword($param['User_Pass']);
                $new_user->setGender($param['User_Gender']);
                $new_user->setRoleId(1);
                $new_user->setPicture('Default');
                if(!$smsService->isThere_User($new_user)){
                    $state = $smsService->AddNew_User($new_user);
                    if($state){
                        $this->api_user = $new_user;
                        $found['Disciples'] = $smsService->GetAll_Disciples($this->api_user);
                        $found['Schedules'] = $smsService->GetAll_Schedule($this->api_user);
                        $found['NewsFeeds'] = $smsService->GetNew_NewsFeeds($this->api_user);
                        $found['Questions'] = $smsService->GetAll_Question();
                        $found['Reports'] = $smsService->GetAll_Report();
                        $this->api_Response['Response'] = $found;
                        /**
                         * @var \DeepLife_API\Model\User $added_user
                         */
                        $added_user = $smsService->Get_User($new_user);
                        if($added_user != null){
                            $smsService->Add_User_Role($added_user->getId(),2);
                        }
                    }else{
                        $error['Parameter Error'] = 'User Could not be Registered now. Please Try again later';
                        $this->api_Response['Request_Error'] = $error;
                    }
                }else{
                    if($smsService->authenticate($new_user->getPhoneNo(),'-')){
                        $this->api_user = $smsService->Get_User($new_user);
                        $this->api_user->setPassword($new_user->getPassword());
                        $state = $smsService->Delete_User($this->api_user);
                        if($state){
                            $state = $smsService->AddNew_User($this->api_user);
                            if($state){
                                /**
                                 * @var \DeepLife_API\Model\User $added_user
                                 */
                                $added_user = $smsService->Get_User($this->api_user);
                                if($added_user != null){
                                    $smsService->Add_User_Role($added_user->getId(),2);
                                }
                                $found['Disciples'] = $smsService->GetAll_Disciples($this->api_user);
                                $found['Schedules'] = $smsService->GetAll_Schedule($this->api_user);
                                $found['NewsFeeds'] = $smsService->GetNew_NewsFeeds($this->api_user);
                                $found['Questions'] = $smsService->GetAll_Question();
                                $found['Reports'] = $smsService->Get_Report($this->api_user);
                                $this->api_Response['Response'] = $found;
                            }else{
                                $error['Parameter Error'] = 'Something went wrong try again!';
                                $this->api_Response['Request_Error'] = $error;
                            }
                        }else{
                            $error['Parameter Error'] = 'Your Account is already taken! Use different account';
                            $this->api_Response['Request_Error'] = $error;
                        }
                    }else{
                        $error['Parameter Error'] = 'Your are Already Registered. Please Log in';
                        $this->api_Response['Request_Error'] = $error;
                    }
                }
            }else{
                $error['Parameter Error'] = 'Invalid parameter given to create new user';
                $this->api_Response['Request_Error'] = $error;
            }
        }else{
            $error['Parameter Error'] = 'Invalid parameter given to create new user';
            $this->api_Response['Request_Error'] = $error;
        }
    }
    public function ProcessRequest($service,$param){
        /**
         * @var \DeepLife_API\Service\Service $smsService
         */
        $smsService = $this->getServiceLocator()->get('DeepLife_API\Service\Service');
        $this->api_Response['Response'] = array();
        if($service == $this->api_Services[0]){
            //  GetAll_Disciples
            $this->api_Response['Response'] = array('Disciples',$smsService->GetAll_Disciples($this->api_user));
        }else if($service == $this->api_Services[1]){
            //  GetNew_Disciples
            $this->api_Response['Response'] = array('Disciples',$smsService->GetNew_Disciples($this->api_user));
        }else if($service == $this->api_Services[2]){
            //  AddNew_Disciples
            $res['Log_Response'] = array();
            foreach($this->api_Param as $data){
                $hydrator = new Hydrator();
                $new_user = $hydrator->GetDisciple($data);
                $new_user->setId($this->api_user->getId());
                $new_user->setMentorId($this->api_user->getId());
                $new_user->setPassword('new_pass');
                $new_user->setRoleId(1);
                $new_user->setPicture('Default');
                $state = $smsService->AddNew_Disciple($this->api_user,$new_user);
                if($state){
                    /**
                     * @var \DeepLife_API\Model\User $_user
                     */
                    $_user = $smsService->Get_User($new_user);
                    if( $_user != null){
                        $_new_disciple = new Disciple();
                        $_new_disciple->setDiscipleID($_user->getId());
                        $_new_disciple->setUserID($this->api_user->getId());
                        $smsService->AddNew_Disciple_log($_new_disciple);
                    }
                    if($state){
                        $disciple_res['Log_ID'] = $data['id'];
                        $res['Log_Response'][] = $disciple_res;
                    }
                }

            }
            $this->api_Response['Response'] = $res;
        }else if($service == $this->api_Services[3]){
            $state = null;
            foreach($this->api_Param as $data){
                $sch = new Schedule();
                $state[] = $smsService->AddNew_Schedule($sch);
            }
        }elseif($service == $this->api_Services[5]){
            $this->api_Response['Response'] = array('Schedules',$smsService->GetAll_Schedule($this->api_user));
        }elseif($service == $this->api_Services[6]){
            $this->api_Response['Response'] = array('Schedules',$smsService->GetNew_Schedule($this->api_user));
        }elseif($service == $this->api_Services[7]){
           //Add new Schedule
            $res['Log_Response'] = array();
            $state = null;
            foreach($this->api_Param as $data){
                $sch = new Schedule();
                $sch->setUserId($this->api_user->getId());
                $sch->setName($data['Title']);
                $sch->setTime($data['Alarm_Time']);
                $sch->setType($data['Alarm_Repeat']);
                $sch->setDisciplePhone($data['Disciple_Phone']);
                $sch->setDescription($data['Description']);
                $state = $smsService->AddNew_Schedule($sch);
                if($state){
                    $disciple_res['Log_ID'] = $data['ID'];
                    $res['Log_Response'][] = $disciple_res;
                }
            }
            $this->api_Response['Response'] = $res;
        }elseif($service == $this->api_Services[8]){
           // Add Schedule Log
            $state = null;
            foreach($this->api_Param as $data){
                $sch = new Schedule();
                $sch->setUserId($this->api_user->getId());
                $sch->setId($data['schedule_id']);
                $state[] = $smsService->AddNew_Schedule_log($sch);
            }
            $this->api_Response['Response'] = $state;
        }elseif($service == $this->api_Services[10]){
            foreach($this->api_Param as $data){
                $sch = new Schedule();
                $sch->setUserId($this->api_user->getId());
                $sch->setId($data['schedule_id']);
                $state[] = $smsService->AddNew_Schedule_log($sch);
            }
            $this->api_Response['Response'] = $state;
        }elseif($service == $this->api_Services[12]){
            $this->api_Response['Response'] = array('Questions',$smsService->GetAll_Question());
        }elseif($service == $this->api_Services[13]){
            $this->api_Response['Response'] = $smsService->GetAll_Answers($this->api_user);
        }elseif($service == $this->api_Services[14]){
            foreach($this->api_Param as $data){
                $sch = new Answers();
                $sch->setUserId($this->api_user->getId());
                $sch->setQuestionId($data['question_id']);
                $sch->setAnswer($data['answer']);
                $state[] = $smsService->AddNew_Answer($sch);
            }
            $this->api_Response['Response'] = $state;
        }elseif($service == $this->api_Services[15]){
            /// If Send_Log Task is Sent
            $res['Log_Response'] = array();
            foreach($this->api_Param as $data){
                if($data['Type'] == "Schedule"){
                    $new_schedule = new Schedule();
                    $new_schedule->setUserId($this->api_user->getId());
                    $new_schedule->setId($data['Value']);
                    $state = $smsService->AddNew_Schedule_log($new_schedule);
                    if($state){
                        $schedule_res['Log_ID'] = $data['id'];
                        $res['Log_Response'][] = $schedule_res;
                    }
                }else if($data['Type'] == "Disciple"){
                    $new_disciple = new Disciple();
                    $new_disciple->setUserID($this->api_user->getId());
                    $new_disciple->setDiscipleID($data['Value']);
                    $state = $smsService->AddNew_Disciple_log($new_disciple);
                    if($state){
                        $disciple_res['Log_ID'] = $data['id'];
                        $res['Log_Response'][] = $disciple_res;
                    }
                }else if($data['Type'] == "Remove_Disciple"){
                    $user1 = new User();
                    $user1->setPhoneNo($data['Value']);
                    /**
                     * @var \DeepLife_API\Model\User $_new_user
                     */
                    $_new_user = $smsService->Get_User($user1);
                    if($_new_user != null){
                        $_new_user->setMentorId("NULL");
                        $state = $smsService->Update_User($_new_user);
                        $disciple_res['Log_ID'] = $data['id'];
                        $res['Log_Response'][] = $disciple_res;
                    }
                }else if($data['Type'] == "Remove_Schedule"){
                    $schedule = new Schedule();
                    $schedule->setDisciplePhone($data['Value']);
                    $state = $smsService->Delete_Schedule($schedule);
                    $disciple_res['Log_ID'] = $data['id'];
                    $res['Log_Response'][] = $disciple_res;
                }else if($data['Type'] == "NewsFeeds"){
                    $new_newsfeed = new NewsFeed();
                    $new_newsfeed->setUserID($this->api_user->getId());
                    $new_newsfeed->setId($data['Value']);
                    $state = $smsService->AddNew_NewsFeed_log($new_newsfeed);
                    if($state){
                        $disciple_res['Log_ID'] = $data['id'];
                        $res['Log_Response'][] = $disciple_res;
                    }
                }
            }
            $this->api_Response['Response'] = $res;
        }elseif($service == $this->api_Services[16]) {
            /// Log in authentication
            $smsService->Delete_Disciple_Log($this->api_user);
            $smsService->Delete_Schedule_Log($this->api_user);
            $found['Disciples'] = $smsService->GetAll_Disciples($this->api_user);
            $found['Schedules'] = $smsService->GetAll_Schedule($this->api_user);
            $found['Questions'] = $smsService->Get_Question($this->api_user);
            $found['Reports'] = $smsService->Get_Report($this->api_user);
            /**
             * @var \DeepLife_API\Model\User $profile
             */
            $profile = $smsService->Get_User($this->api_user);
            $found['Profile'] = $profile->getArray();

            $this->api_Response['Response'] = $found;
        }elseif($service == $this->api_Services[17]) {
            /// Sign up
            $smsService->Delete_Disciple_Log($this->api_user);
            $smsService->Delete_Schedule_Log($this->api_user);
            $found['Disciples'] = $smsService->GetAll_Disciples($this->api_user);
            $found['Schedules'] = $smsService->GetAll_Schedule($this->api_user);
            $found['Questions'] = $smsService->Get_Question($this->api_user);
            $found['Reports'] = $smsService->Get_Report($this->api_user);
            $this->api_Response['Response'] = $found;
        }elseif($service == $this->api_Services[18]) {
            /// Update_Disciples
            $res['Log_Response'] = array();
            foreach($this->api_Param as $data){
                $hydrator = new Hydrator();
                $new_user = $hydrator->GetDisciple($data);
                /**
                 * @var \DeepLife_API\Model\User $_new_user
                 */
                $_new_user = $smsService->Get_User($new_user);
                $new_user->setId($_new_user->getId());
                $state = $smsService->Update_User1($new_user);
                if($state){
                    $disciple_res['Log_ID'] = $data['id'];
                    $res['Log_Response'][] = $disciple_res;
                }
            }
            $this->api_Response['Response'] = $res;
        }elseif($service == $this->api_Services[19]){
            // Update
            $found['Disciples'] = $smsService->GetNew_Disciples($this->api_user);
            $found['Schedules'] = $smsService->GetNew_Schedule($this->api_user);
            $found['NewsFeeds'] = $smsService->GetNew_NewsFeeds($this->api_user);
            //$found['Questions'] = $smsService->Get_Question($this->api_user);
             //$found['Reports'] = $smsService->Get_Report($this->api_user);

            $this->api_Response['Response'] = $found;
        }elseif($service == $this->api_Services[21]){
            // send report
            $res['Log_Response'] = array();
            foreach($this->api_Param as $data){
                $new_user_report = new UserReport();
                $new_user_report->setUserId($this->api_user->getId());
                $new_user_report->setReportId($data['Report_ID']);
                $new_user_report->setValue($data['Value']);
                $state = $smsService->AddNew_UserReport($new_user_report);
                if($state){
                    $disciple_res['Log_ID'] = $data['id'];
                    $res['Log_Response'][] = $disciple_res;
                }
            }
            $this->api_Response['Response'] = $res;
        }elseif($service == $this->api_Services[22]){
            // GetNew NewsFeed
            $this->api_Response['Response'] = array('NewsFeeds',$smsService->GetNew_NewsFeeds($this->api_user));
        }elseif($service == $this->api_Services[23]){
            // GetNew Testimony
            foreach($this->api_Param as $data){
                $sch = new Testimony();
                $sch->setUserId($this->api_user->getId());
                $sch->setTitle($data['title']);
                $sch->setDetail($data['detail']);
                $state = $smsService->AddTestimony($sch);
                if($state){
                    $disciple_res['Log_ID'] = $data['id'];
                    $res['Log_Response'][] = $disciple_res;
                }
            }
            $this->api_Response['Response'] = $res;
        }
    }
    public function isValidRequest($api_request){
        $this->api_Response['Request_Error'] = array();
        if(isset($api_request['User_Name']) && isset($api_request['User_Pass']) && isset($api_request['Country'])
            && isset($api_request['Service']) && isset($api_request['Param'])
        ){
            if(in_array($api_request['Service'],$this->api_Services)){
                $this->api_Service = $api_request['Service'];
                return true;
            }else{
                $error['Service_Request'] = 'Unknown';
                $this->api_Response['Request_Error'] = $error;
            }
        }else{
            $error['Request_Format'] = 'Invalid';
            $this->api_Response['Request_Error'] = $error;
        }
        return false;
    }
    public function isValidParam($param,$type){
        $is_valid = false;
        $param = json_decode($param,true);
        if(is_array($param)){
            if($type == $this->api_Services[2]){
                foreach($param as $items){
                    if(isset($items['Full_Name']) && isset($items['Country']) && isset($items['Phone']) && isset($items['Email'])){
                        $is_valid = true;
                    }else{
                        $error['Parameter Error'] = 'Invalid add new Disciple parameter given';
                        $this->api_Response['Request_Error'] = $error;
                        $is_valid = false;
                        break;
                    }
                }
            }elseif($type == $this->api_Services[3]){
                foreach($param as $items){
                    if(isset($items['disciple_id'])){
                        $is_valid = true;
                    }else{
                        $error['Parameter Error'] = 'Invalid Disciple id for logging';
                        $this->api_Response['Request_Error'] = $error;
                        $is_valid = false;
                        break;
                    }
                }
            }elseif($type == $this->api_Services[7]){
                foreach($param as $items){
                    if(isset($items['Alarm_Repeat']) && isset($items['Alarm_Time']) && isset($items['Disciple_Phone']) && isset($items['Disciple_Phone']) ){
                        $is_valid = true;
                    }else{
                        $error['Parameter Error'] = 'Invalid Disciple id for logging';
                        $this->api_Response['Request_Error'] = $error;
                        $is_valid = false;
                        break;
                    }
                }
            }elseif($type == $this->api_Services[8]){
                foreach($param as $items){
                    if(isset($items['schedule_id']) ){
                        $is_valid = true;
                    }else{
                        $error['Parameter Error'] = 'Invalid Disciple id for logging';
                        $this->api_Response['Request_Error'] = $error;
                        $is_valid = false;
                        break;
                    }
                }
            }elseif($type == $this->api_Services[14]){
                foreach($param as $items){
                    if(isset($items['question_id'])&& isset($items['answer'])){
                        $is_valid = true;
                    }else{
                        $error['Parameter Error'] = 'Invalid Question_Answer id for logging';
                        $this->api_Response['Request_Error'] = $error;
                        $is_valid = false;
                        break;
                    }
                }
            }
            $is_valid =  true;
        }else{
            $error['Parameter Error'] = 'The parameter should be an array';
            $this->api_Response['Request_Error'] = $error;
        }
        if($is_valid){
            $this->api_Param = $param;
        }

        return $is_valid;
    }
}