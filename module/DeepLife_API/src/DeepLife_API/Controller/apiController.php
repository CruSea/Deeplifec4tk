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
use DeepLife_API\Model\UserReport;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

abstract class BasicEnum {
    private static $constCacheArray = NULL;

    private static function getConstants() {
        if (self::$constCacheArray == NULL) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new \ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        return self::$constCacheArray[$calledClass];
    }

    public static function isValidName($name, $strict = false) {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    public static function isValidValue($value, $strict = false) {
        $constants = self::getConstants();

        if ($strict) {
            $values = array_values($constants);
            return in_array($value, $values, $strict);
        }

        $values = array_map('strtolower', array_values($constants));
        return in_array(strtolower($value), $values);
    }
}

abstract class Req extends BasicEnum {
    const USER_NAME = 'user_name';
    const USER_PASS = 'user_pass';
    const COUNTRY = 'country';
    const SERVICE = 'service';
    const PARAM = 'param';
}

abstract class Resp extends BasicEnum {
    const RESPONSE = 'Response';
    const REQUEST_ERROR = 'Request_Error';
    const LOG_RESPONSE = 'Log_Response';
    const LOG_ID = 'Log_ID';
    const UPLOAD_RESPONSE = 'Upload_Response';
}

abstract class RespErr extends BasicEnum {
    const PARAMETER_ERROR = 'Parameter_Error';
    const SERVICE_REQUEST = 'Service_Request';
    const REQUEST_FORMAT = 'Request_Format';
    const AUTHENTICATION = 'Authentication';
}

abstract class RespErrServiceRequest extends BasicEnum {
    const UNKNOWN = 'Unknown';
}

abstract class RespErrRequestFormat extends BasicEnum {
    const INVALID = 'Invalid';
}

abstract class RespErrAuthentication extends BasicEnum {
    const INVALID_USER = 'Invalid User';
}

abstract class ApiMeta extends BasicEnum {
    const COUNTRY = 'Country';
    const CATEGORIES = 'Categories';
    const QUESTIONS = 'Questions';
}

abstract class ApiEntity extends BasicEnum {
    const DISCIPLES = 'Disciples';
    const SCHEDULES = 'Schedules';
    const NEWSFEEDS = 'NewsFeeds';
    const QUESTIONS = 'Questions';
    const REPORTS = 'Reports';
    const TESTIMONIES = 'Testimonies';
    const CATEGORIES = 'Categories';
    const ANSWERS = 'Answers';
    const PROFILE = 'Profile';
    const LEARNINGTOOLS = 'LearningTools';
    const DISCIPLETREE = 'DiscipleTree';
}

abstract class Svc extends BasicEnum {
    const GETALL_DISCIPLES = 'getall_disciples';
    const GETNEW_DISCIPLES = 'getnew_disciples';
    const ADDNEW_DISCIPLES = 'addnew_disciples';
    const ADDNEW_DISCIPLES_LOG = 'addnew_disciples_log';
    const DELETE_ALL_DISCIPLE_LOG = 'delete_all_disciple_log';
    const GETALL_SCHEDULES = 'getall_schedules';
    const GETNEW_SCHEDULES = 'getnew_schedules';
    const ADDNEW_SCHEDULES = 'addnew_schedules';
    const ADDNEW_SCHEDULE_LOG = 'addnew_schedule_log';
    const DELETE_ALL_SCHEDULE_LOG = 'delete_all_schedule_log';
    const ISVALID_USER = 'isvalid_user';
    const CREATEUSER = 'createuser';
    const GETALL_QUESTIONS = 'getall_questions';
    const GETALL_ANSWERS = 'getall_answers';
    const ADDNEW_ANSWERS = 'addnew_answers';
    const SEND_LOG = 'send_log';
    const LOG_IN = 'log_in';
    const SIGN_UP = 'sign_up';
    const UPDATE_DISCIPLES = 'update_disciples';
    const UPDATE = 'update';
    const META_DATA = 'meta_data';
    const SEND_REPORT = 'send_report';
    const GETNEW_NEWSFEED = 'getnew_newsfeed';
    const SEND_TESTIMONY = "send_testimony";
    const UPLOAD_USER_PIC = "upload_user_pic";
    const UPLOAD_DISCIPLE_PIC = "upload_disciple_pic";
    const UPDATE_SCHEDULES = 'update_schedules';
    const GETALL_TESTIMONIES = 'getall_testimonies';
    const GETNEW_TESTIMONIES = 'getnew_testimonies';
    const ADDNEW_TESTIMONY = 'addnew_testimony';
    const DELETE_TESTIMONY = 'delete_testimony';
    const ADDNEW_TESTIMONY_LOG = 'addnew_testimony_log';
    const DELETE_ALL_TESTIMONYLOGS = 'delete_all_testimonylogs';
    const GETALL_NEWSFEEDS = 'getall_newsfeeds';
    const GETNEW_NEWSFEEDS = 'getnew_newsfeeds';
    const ADDNEW_NEWSFEED_LOG = 'addnew_newsfeed_log';
    const DELETE_ALL_NEWSFEED_LOGS = 'delete_all_newsfeed_logs';
    const GETALL_CATEGORY = 'getall_category';
    const GETALL_LEARNINGTOOLS = 'getall_learningtools';
    const GETNEW_LEARNINGTOOLS = 'getnew_learningtools';
    const DISCIPLETREE = 'discipletree';
    const UPDATE_PROFILE = 'update_profile';
    const REMOVE_DISCIPLE = 'remove_disciple';
}

abstract class ApiGeneric extends BasicEnum {
    const ID = 'id';
    CONST NULL = 'NULL';
}

abstract class ApiUser extends BasicEnum {

    const USER_NAME = 'user_name';
    const USER_COUNTRY = 'user_country';
    const USER_PHONE = 'user_phone';
    const USER_EMAIL = 'user_email';
    const USER_GENDER = 'user_gender';
    const USER_PASS = 'user_pass';
    const PHONE_CODE = 'phone_code';
}

abstract class ApiDisciple extends BasicEnum {
    const EMAIL = 'email';
    const FULL_NAME = 'full_name';
    const FULLNAME = 'fullname';
    const COUNTRY = 'country';
    const PHONE = 'phone';
    const DISCIPLE_PHONE = 'disciple_phone';
    const STAGE = 'stage';
    const GENDER = 'gender';
    const DISCIPLE_EMAIL = 'disciple_email';
    const PHONE_CODE = 'phone_code';
}

abstract class ApiDiscipleLog extends BasicEnum
{
    const DISCIPLE_ID = "disciple_id";
}

abstract class ApiSchedule extends BasicEnum {
    const USER_ID = 'user_id';
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const ALARM_REPEAT = 'alarm_repeat';
    const ALARM_TIME = 'alarm_time';
    const DISCIPLE_PHONE = 'disciple_phone';
}

abstract class ApiScheduleLog extends BasicEnum {
    const SCHEDULE_ID = 'schedule_id';
}

abstract class ApiAnswer extends BasicEnum {
    const ANSWER = 'answer';
    const DISCIPLEPHONE = 'disciplephone';
    const QUESTIONID = 'questionid';
    const BUILDSTAGE = 'buildstage';
}

abstract class ApiTestimony extends BasicEnum {
    const DETAIL = 'detail';
    const TITLE = 'title';
    const DESCRIPTION = 'description';
}

abstract class ApiTestimonyLog extends BasicEnum {
    const TESTIMONY_ID = 'testimony_id';
}

abstract class ApiProfile extends BasicEnum {
    const EMAIL = 'email';
    const FULLNAME = 'fullname';
    const COUNTRY = 'country';
    const GENDER = 'gender';
    const PHONE = 'phone';
    const PHONE_CODE = 'phone_code';
}

abstract class ApiLog extends BasicEnum {
    const TYPE = 'type';
}

abstract class ApiLogType extends BasicEnum {
    const SCHEDULE = 'schedule';
    const DISCIPLE = 'disciple';
    const REMOVE_DISCIPLE = 'remove_disciple';
    const REMOVE_SCHEDULE = 'remove_schedule';
    const NEWSFEEDS = 'newsfeeds';
}

abstract class ApiSendLog extends BasicEnum {
    const VALUE = 'value';
}

abstract class ApiSendReport extends BasicEnum {
    const REPORT_ID = 'Report_ID';
    const VALUE = 'value';
}

abstract class ApiUploadUserPic extends BasicEnum {
    const IMAGE = 'image';
    const STATUS = 'status';
    const FILENAME = 'filename';
    const FILE_NAME = 'file_name';
}

abstract class ApiNewsFeedLog extends BasicEnum {
    const NEWSFEED_ID = 'newsfeed_id';
}



class apiController extends AbstractRestfulController
{
    protected $api_Response;
    protected $file_trans;
    protected $api_Param;
    protected $api_Service;  // case-insensitive
    /**
     * @var \DeepLife_API\Model\User $api_User
     */
    protected $api_User;

    public function getList()
    {
        return new JsonModel(array('DeepLife' => 'Use POST request to use the api'));
    }

    public function Authenticate($data)
    {
        $data = array_change_key_case($data, CASE_LOWER);

        /**
         * @var \DeepLife_API\Service\Service $smsService
         */
        $smsService = $this->getServiceLocator()->get('DeepLife_API\Service\Service');
        $reqUserName = $data[Req::USER_NAME];
        $reqUserPass = $data[Req::USER_PASS];
        $reqCountry = $data[Req::COUNTRY];

        if ($smsService->authenticate($reqUserName,$reqUserPass)) {
            $user = new User();
            $user->setEmail($reqUserName);
            $this->api_User = $smsService->Get_User($user);
//            if ($this->api_user->getCountry() === $reqCountry) {
//                return true;
//            }
            if ($this->api_User != null) {
                return true;
            }
        }else if($smsService->authenticate2($reqUserName,$reqUserPass)){
            $user = new User();
            $user->setPhoneNo($reqUserName);
            $this->api_User = $smsService->Get_User($user);
            if ($this->api_User->getCountry() === $reqCountry) {
                return true;
            }
        }
        $error[RespErr::AUTHENTICATION] = RespErrAuthentication::INVALID_USER;
        $this->api_Response[Resp::REQUEST_ERROR] = $error;
        return false;
    }

    public function UploadFile($Image, $id)
    {
        $status = array();
        $status[ApiUploadUserPic::STATUS] = 0;
        $status[ApiUploadUserPic::FILENAME] = '';
        $name = $id . $this->randomString();
        $upload_dest = "public/img/profile/" . $name . ".jpeg";
        $Image = str_replace(' ', '+', $Image);
        $binary = base64_decode($Image);
        header('Content-Type: bitmap; charset=utf-8');
        $file = fopen($upload_dest, 'wb');
        fwrite($file, $binary);
        fclose($file);
        $status[ApiUploadUserPic::STATUS] = 1;
        $status[ApiUploadUserPic::FILENAME] = $name . ".jpeg";
        return $status;
    }

    function randomString()
    {
        $length = 20;
        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $str = "";

        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $str;
    }

    public function create($data)
    {
        $data = array_change_key_case($data, CASE_LOWER);

//        if (isset($data['Service']) && ($data['Service'] === ApiService::CREATEUSER) && (isset($data['UserEmail']) || isset($data['UserPhone'])) && isset($data['UserPass'])) {
//            //Sign Up New User
//            if ($this->CreateNewUser($data)) {
//                $this->api_Response[Resp::RESPONSE] = 1;
//            } else {
//                $this->api_Response[Resp::RESPONSE] = 0;
//            }
//        } else {
            if ($this->isValidRequest($data)) {
                $reqService = strtolower($data[Req::SERVICE]);
                $reqParam = $data[Req::PARAM];
                $reqCountry = $data[Req::COUNTRY];

                if ($this->isValidParam($reqParam, $reqService)) {
                    if ($reqService === Svc::SIGN_UP) {
                        $this->Sign_Up_User($reqParam);
                    } else if ($reqService === Svc::META_DATA) {
                        /**
                         * @var \DeepLife_API\Service\Service $smsService
                         */
                        $smsService = $this->getServiceLocator()->get('DeepLife_API\Service\Service');
                        $found[ApiMeta::COUNTRY] = $smsService->GetAll_Country();
                        $found[ApiMeta::CATEGORIES] = $smsService->GetAll_Categories();
                        $newUser = new User();
                        $newUser->setCountry($reqCountry);
                        $found[ApiMeta::QUESTIONS] = $smsService->Get_Question($newUser);
                        $this->api_Response[Resp::RESPONSE] = $found;
                    } else {
                        if ($this->Authenticate($data)) {
                            $this->ProcessRequest($reqService, $reqParam);
                        }else{
                            $this->api_Response[Resp::RESPONSE] = "Authentication has failed";
                        }
                    }
                }else{
                    $this->api_Response[Resp::RESPONSE] = "Invalid Param";
                }
            }
//        }
        return new JsonModel($this->api_Response);
    }


//    public function CreateNewUser($data)
//    {
//        /**
//         * @var \DeepLife_API\Service\Service $smsService
//         */
//        $smsService = $this->getServiceLocator()->get('DeepLife_API\Service\Service');
//        $newUser = new User();
//        $newUser->setDisplayName(isset($data['displayName']) ? ($data['displayName']) : null);
//        $newUser->setFirstName(isset($data['firstName']) ? ($data['firstName']) : null);
//        $newUser->setCountry(isset($data['category']) ? ($data['category']) : null);
//        $newUser->setPhoneNo(isset($data['phone_no']) ? ($data['phone_no']) : null);
//        $newUser->setPicture(isset($data['picture']) ? ($data['picture']) : null);
//        $newUser->setPassword(isset($data['password']) ? ($data['password']) : null);
//        $newUser->setEmail(isset($data['email']) ? ($data['email']) : null);
//        $state = $smsService->AddNewDisciples($newUser);
//        return $state;
//    }


    public function Sign_Up_User($param) {
        /**
         * @var \DeepLife_API\Service\Service $smsService
         */
        $smsService = $this->getServiceLocator()->get('DeepLife_API\Service\Service');
        $objects = json_decode($param, true);
        if (is_array($objects)) {
            $object = $objects[0];
            $object = array_change_key_case($object, CASE_LOWER);

            //if (isset($object['User_Name']) && isset($object['User_Country']) && isset($object['User_Phone']) && isset($object['User_Email']) && isset($object['User_Gender']) && isset($object['User_Pass'])) {
            if (isset($object[ApiUser::USER_NAME]) && isset($object[ApiUser::USER_COUNTRY]) && isset($object[ApiUser::USER_PHONE]) && isset($object[ApiUser::USER_EMAIL]) && isset($object[ApiUser::USER_GENDER]) && isset($object[ApiUser::USER_PASS])) {
                $new_user = new User();
                $new_user->setFirstName($object[ApiUser::USER_NAME]);
                if(isset($object[ApiUser::PHONE_CODE])){
                    /**
                     * @var \DeepLife_API\Model\Country $id
                     */
                    $id = $smsService->Get_Country_By_PhoneCode($object[ApiUser::PHONE_CODE]);
                    if($id){
                        $new_user->setCountry($id->getId());
                    }
                }else{
                    $new_user->setCountry($object[ApiUser::USER_COUNTRY]);
                }
                $new_user->setPhoneNo($object[ApiUser::USER_PHONE]);
                $new_user->setEmail($object[ApiUser::USER_EMAIL]);
                $new_user->setPassword($object[ApiUser::USER_PASS]);
                $new_user->setGender($object[ApiUser::USER_GENDER]);
                $new_user->setRoleId(1);
                $new_user->setPicture('Default');
                if (!$smsService->isThere_User($new_user)) {
                    $state = $smsService->AddNew_User($new_user);
                    if ($state) {
                        $this->api_User = $smsService->Get_User($new_user);
                        $found[ApiEntity::DISCIPLES] = $smsService->GetAll_Disciples($this->api_User);
                        $found[ApiEntity::SCHEDULES] = $smsService->GetAll_Schedule($this->api_User);
                        $found[ApiEntity::NEWSFEEDS] = $smsService->GetNew_NewsFeeds($this->api_User);
                        $found[ApiEntity::QUESTIONS] = $smsService->GetAll_Question();
                        $found[ApiEntity::REPORTS] = $smsService->GetAll_Report();
                        $this->api_Response[Resp::RESPONSE] = $found;
                        /**
                         * @var \DeepLife_API\Model\User $added_user
                         */
                        $added_user = $smsService->Get_User($new_user);
                        if ($added_user != null) {
                            $smsService->Add_User_Role($added_user->getId(), 2);
                        }
                    } else {
                        $error[RespErr::PARAMETER_ERROR] = 'User Could not be Registered now. Please Try again later';
                        $this->api_Response[Resp::REQUEST_ERROR] = $error;
                    }
                } else {
                    if ($smsService->authenticate2($new_user->getPhoneNo(), 'new_pass') || $smsService->authenticate($new_user->getEmail(), 'new_pass')) {
                        $this->api_User = $smsService->Get_User($new_user);
                        $this->api_User->setPassword($new_user->getPassword());
                        $state = $smsService->Delete_User($this->api_User);
                        if ($state) {
                            $state = $smsService->AddNew_User($this->api_User);
                            if ($state) {
                                /**
                                 * @var \DeepLife_API\Model\User $added_user
                                 */
                                $added_user = $smsService->Get_User($this->api_User);
                                if ($added_user != null) {
                                    $smsService->Add_User_Role($added_user->getId(), 2);
                                }
//                                $found['Disciples'] = $smsService->GetAll_Disciples($this->api_User);
//                                $found['Disciples'] = $smsService->GetNew_Disciples($this->api_User); // briggsm: Why using both? Which one? I'll just pick 1 for now.
                                $found[ApiEntity::DISCIPLES] = $smsService->GetNew_Disciples($this->api_User);
                                $found[ApiEntity::SCHEDULES] = $smsService->GetNew_Schedule($this->api_User);
                                $found[ApiEntity::NEWSFEEDS] = $smsService->GetNew_NewsFeeds($this->api_User);
                                $found[ApiEntity::TESTIMONIES] = $smsService->GetNew_Testimonies($this->api_User);
                                $found[ApiEntity::CATEGORIES] = $smsService->GetAll_Categories();
                                $found[ApiEntity::QUESTIONS] = $smsService->Get_Question($this->api_User);
                                $found[ApiEntity::ANSWERS] = $smsService->GetAll_Disciple_Answers($this->api_User);
                                $found[ApiEntity::PROFILE] = $smsService->Get_User_Profile($this->api_User);
                                $found[ApiEntity::LEARNINGTOOLS] = $smsService->GetNew_LearningTools($this->api_User);
                                $found[ApiEntity::DISCIPLETREE] = $smsService->Get_DiscipleCount($this->api_User);
                                $this->api_Response[Resp::RESPONSE] = $found;
                            } else {
                                $error[RespErr::PARAMETER_ERROR] = 'Something went wrong try again!';
                                $this->api_Response[Resp::REQUEST_ERROR] = $error;
                            }
                        } else {
                            $error[RespErr::PARAMETER_ERROR] = 'Your Account is already taken! Use different account';
                            $this->api_Response[Resp::REQUEST_ERROR] = $error;
                        }
                    }else{
                        if($smsService->isThere_User_By_Phone($new_user)){
                            $error[RespErr::PARAMETER_ERROR] = 'The phone number is already taken! please use another phone number';
                            $this->api_Response[Resp::REQUEST_ERROR] = $error;
                        }elseif ($smsService->isThere_User_By_Email($new_user)){
                            $error[RespErr::PARAMETER_ERROR] = 'The email address is already taken! please use another email address';
                            $this->api_Response[Resp::REQUEST_ERROR] = $error;
                        }
                    }
                }
            } else {
                $error[RespErr::PARAMETER_ERROR] = 'Invalid parameter given to create new user';
                $this->api_Response[Resp::REQUEST_ERROR] = $error;
            }
        } else {
            $error[RespErr::PARAMETER_ERROR] = 'Invalid parameter given to create new user';
            $this->api_Response[Resp::REQUEST_ERROR] = $error;
        }
    }

    public function ProcessRequest($service, $param)
    {
        /**
         * @var \DeepLife_API\Service\Service $smsService
         */
        $smsService = $this->getServiceLocator()->get('DeepLife_API\Service\Service');
        $this->api_Response[Resp::RESPONSE] = array();
        if ($service === Svc::GETALL_DISCIPLES) {
            $this->api_Response[Resp::RESPONSE] = array(ApiEntity::DISCIPLES, $smsService->GetAll_Disciples($this->api_User));
        } else if ($service === Svc::GETNEW_DISCIPLES) {
            $this->api_Response[Resp::RESPONSE] = array(ApiEntity::DISCIPLES, $smsService->GetNew_Disciples($this->api_User));
        } else if ($service === Svc::ADDNEW_DISCIPLES) {
            $res[Resp::LOG_RESPONSE] = array();
            foreach ($this->api_Param as $object) {
                $object = array_change_key_case($object, CASE_LOWER);
                $hydrator = new Hydrator();
                if(isset($object[ApiDisciple::PHONE_CODE])){
                    /**
                     * @var \DeepLife_API\Model\Country $country
                     */
                    $country = $smsService->Get_Country_By_PhoneCode($object[ApiDisciple::PHONE_CODE]);
                    if($country != null && $country->getId() != null){
                        $object[ApiDisciple::COUNTRY] = $country->getId();
                    }
                }
                $new_user = $hydrator->GetDisciple($object);
                $new_user->setId($this->api_User->getId());
                $new_user->setMentorId($this->api_User->getId());
                $new_user->setPassword('new_pass');
                $new_user->setRoleId(1);
                $new_user->setPicture('Default');
                $new_user->setUserlocale(1);
                $state = $smsService->AddNew_Disciple($this->api_User, $new_user);
                /**
                 * @var \DeepLife_API\Model\User $_user
                 */
                $_user = $smsService->Get_User($new_user);
                if ($_user != null) {
                    $_new_disciple = new Disciple();
                    $_new_disciple->setDiscipleID($_user->getId());
                    $_new_disciple->setUserID($this->api_User->getId());
                    $_user->setMentorId($this->api_User->getId());
                    $smsService->AddNew_Disciple_log($_new_disciple);
                    $smsService->Update_User($_user);
                }
                if ($_user != null) {
                    $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                    $res[Resp::LOG_RESPONSE][] = $disciple_res;
                }
            }
            $this->api_Response[Resp::RESPONSE] = $res;
        } else if ($service === Svc::ADDNEW_DISCIPLES_LOG) {
            $state = null;
            foreach ($this->api_Param as $object) {
                $object = array_change_key_case($object, CASE_LOWER);
                $sch = new Schedule();
                $state[] = $smsService->AddNew_Schedule($sch);
            }
        } elseif ($service === Svc::GETALL_SCHEDULES) {
            $this->api_Response[Resp::RESPONSE] = array(ApiEntity::SCHEDULES, $smsService->GetAll_Schedule($this->api_User));
        } elseif ($service === Svc::GETNEW_SCHEDULES) {
            $this->api_Response[Resp::RESPONSE] = array(ApiEntity::SCHEDULES, $smsService->GetNew_Schedule($this->api_User));
        } elseif ($service === Svc::ADDNEW_SCHEDULES) {
            $res[Resp::LOG_RESPONSE] = array();
            $state = null;
            foreach ($this->api_Param as $object) {
                $object = array_change_key_case($object, CASE_LOWER);
                $sch = new Schedule();
                $sch->setUserId($this->api_User->getId());
                $sch->setName($object[ApiSchedule::TITLE]);
                $sch->setTime($object[ApiSchedule::ALARM_TIME]);
                $sch->setType($object[ApiSchedule::ALARM_REPEAT]);
                $sch->setDisciplePhone($object[ApiSchedule::DISCIPLE_PHONE]);
                $sch->setDescription($object[ApiSchedule::DESCRIPTION]);
                $state = $smsService->AddNew_Schedule($sch);
                if ($state) {
                    /**
                     * @var \DeepLife_API\Model\Schedule $_new_schedule
                     */
                    $_new_schedule = $smsService->Get_Schedule_By_AlarmTime($sch);
                    $_new_schedule->setUserId($this->api_User->getId());
                    $smsService->AddNew_Schedule_log($_new_schedule);
                    $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                    $res[Resp::LOG_RESPONSE][] = $disciple_res;
                }
            }
            $this->api_Response[Resp::RESPONSE] = $res;
        } elseif ($service === Svc::ADDNEW_SCHEDULE_LOG) {
            $state = null;
            foreach ($this->api_Param as $object) {
                $object = array_change_key_case($object, CASE_LOWER);
                $sch = new Schedule();
                $sch->setUserId($this->api_User->getId());
                $sch->setId($object[ApiScheduleLog::SCHEDULE_ID]);
                $state[] = $smsService->AddNew_Schedule_log($sch);
            }
            $this->api_Response[Resp::RESPONSE] = $state;
        } elseif ($service === Svc::ISVALID_USER) {
            foreach ($this->api_Param as $object) {
                $object = array_change_key_case($object, CASE_LOWER);
                $sch = new Schedule();
                $sch->setUserId($this->api_User->getId());
                $sch->setId($object[ApiScheduleLog::SCHEDULE_ID]);
                $state[] = $smsService->AddNew_Schedule_log($sch);
            }
            $this->api_Response[Resp::RESPONSE] = $state;
        } elseif ($service === Svc::GETALL_QUESTIONS) {
            $this->api_Response[Resp::RESPONSE] = array(ApiEntity::QUESTIONS, $smsService->GetAll_Question());
        } elseif ($service === Svc::GETALL_ANSWERS) {
            //$this->api_Response[Resp::RESPONSE] = $smsService->GetAll_Answers($this->api_User);
            $this->api_Response[Resp::RESPONSE] = $smsService->GetAll_Disciple_Answers($this->api_User);
        } elseif ($service === Svc::ADDNEW_ANSWERS) {
            $res[Resp::LOG_RESPONSE] = array();
            foreach ($this->api_Param as $object) {
                $object = array_change_key_case($object, CASE_LOWER);
                $sch = new Answers();
                $new_user = new User();
                $new_user->setPhoneNo($object[ApiAnswer::DISCIPLEPHONE]);
                /**
                 * @var \DeepLife_API\Model\User $disciple
                 */
                $disciple = $smsService->Get_User($new_user);
                $sch->setUserId($disciple->getId());
                $sch->setQuestionId($object[ApiAnswer::QUESTIONID]);
                $sch->setAnswer($object[ApiAnswer::ANSWER]);
                $sch->setStage($object[ApiAnswer::BUILDSTAGE]);
                $sch->setNotes("None");
                $sch->setCountry($disciple->getCountry());

                $ans = $smsService->Get_Answer($sch);
                if($ans != null){
                    $state = $smsService->Update_Answer($sch);
                    $schedule_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                    $res[Resp::LOG_RESPONSE][] = $schedule_res;
                }else{
                    $state = $smsService->AddNew_Answer($sch);
                    $schedule_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                    $res[Resp::LOG_RESPONSE][] = $schedule_res;
                }

            }
            $this->api_Response[Resp::RESPONSE] = $res;
        } elseif ($service === Svc::SEND_LOG) {
            $res[Resp::LOG_RESPONSE] = array();
            foreach ($this->api_Param as $object) {
                $object = array_change_key_case($object, CASE_LOWER);
                $logType = strtolower($object[ApiLog::TYPE]);
                if ($logType === ApiLogType::SCHEDULE) {
                    $new_schedule = new Schedule();
                    $new_schedule->setUserId($this->api_User->getId());
                    $new_schedule->setId($object[ApiSendLog::VALUE]);
                    $state = $smsService->AddNew_Schedule_log($new_schedule);
                    if ($state) {
                        $schedule_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                        $res[Resp::LOG_RESPONSE][] = $schedule_res;
                    }
                } else if ($logType === ApiLogType::DISCIPLE) {
                    $new_disciple = new Disciple();
                    $new_disciple->setUserID($this->api_User->getId());
                    $new_disciple->setDiscipleID($object[ApiSendLog::VALUE]);
                    $state = $smsService->AddNew_Disciple_log($new_disciple);
                    if ($state) {
                        $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                        $res[Resp::LOG_RESPONSE][] = $disciple_res;
                    }
                } else if ($logType === ApiLogType::REMOVE_DISCIPLE) {
                    $user1 = new User();
                    $user1->setPhoneNo($object[ApiSendLog::VALUE]);
                    /**
                     * @var \DeepLife_API\Model\User $_new_user
                     */
                    $_new_user = $smsService->Get_User($user1);
                    if ($_new_user != null) {
                        $_new_user->setMentorId(ApiGeneric::NULL);
                        $state = $smsService->Update_User($_new_user);
                        if($state){
                            $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                            $res[Resp::LOG_RESPONSE][] = $disciple_res;
                        }else{
                            $user1->setPhoneNo("");
                            //$user1->setEmail("Value");  // briggsm: Why the string "Value"? Is $object["Value"] meant?
                            $user1->setEmail($object[ApiSendLog::VALUE]);
                            $_new_user = $smsService->Get_User($user1);
                            if ($_new_user != null) {
                                $_new_user->setMentorId(ApiGeneric::NULL);
                                $state = $smsService->Update_User($_new_user);
                            }
                            $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                            $res[Resp::LOG_RESPONSE][] = $disciple_res;
                        }
                    }
                } else if ($logType === ApiLogType::REMOVE_SCHEDULE) {
                    $schedule = new Schedule();
                    $schedule->setTime($object[ApiSendLog::VALUE]);
                    $schedule->setUserId($this->api_User->getId());
                    $state = $smsService->Delete_Schedule($schedule);
                    $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                    $res[Resp::LOG_RESPONSE][] = $disciple_res;
                } else if ($logType === ApiLogType::NEWSFEEDS) {
                    $new_newsfeed = new NewsFeed();
                    $new_newsfeed->setUserId($this->api_User->getId());
                    $new_newsfeed->setId($object[ApiSendLog::VALUE]);
                    $state = $smsService->AddNew_NewsFeed_log($new_newsfeed);
                    if ($state) {
                        $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                        $res[Resp::LOG_RESPONSE][] = $disciple_res;
                    }
                }
            }
            $this->api_Response[Resp::RESPONSE] = $res;
        } elseif ($service === Svc::LOG_IN) {
            $smsService->Delete_Disciple_Log($this->api_User);
            $smsService->Delete_Schedule_Log($this->api_User);
            $found[ApiEntity::DISCIPLES] = $smsService->GetAll_Disciples($this->api_User);
            $found[ApiEntity::PROFILE] = $smsService->Get_User_Profile($this->api_User);
            $found[ApiEntity::TESTIMONIES] = $smsService->GetNew_Testimonies($this->api_User);
            $found[ApiEntity::SCHEDULES] = $smsService->GetAll_Schedule($this->api_User);
            $found[ApiEntity::QUESTIONS] = $smsService->Get_Question($this->api_User);
            $found[ApiEntity::NEWSFEEDS] = $smsService->GetNew_NewsFeeds($this->api_User);
            $found[ApiEntity::ANSWERS] = $smsService->GetAll_Disciple_Answers($this->api_User);
            $found[ApiEntity::REPORTS] = $smsService->Get_Report($this->api_User);
            $found[ApiEntity::LEARNINGTOOLS] = $smsService->GetNew_LearningTools($this->api_User);
            $found[ApiEntity::DISCIPLETREE] = $smsService->Get_DiscipleCount($this->api_User);
            /**
             * @var \DeepLife_API\Model\User $profile
             */
            $this->api_Response[Resp::RESPONSE] = $found;

        } /*elseif ($service === ApiServices::SIGN_UP) {
            $smsService->Delete_Disciple_Log($this->api_User);
            $smsService->Delete_Schedule_Log($this->api_User);
            $found['Disciples'] = $smsService->GetAll_Disciples($this->api_User);
            $found['Schedules'] = $smsService->GetAll_Schedule($this->api_User);
            $found['Questions'] = $smsService->Get_Question($this->api_User);
            $found['Reports'] = $smsService->Get_Report($this->api_User);
            $this->api_Response[Resp::RESPONSE] = $found;
        }*/ elseif ($service === Svc::UPDATE_DISCIPLES) {
            $res[Resp::LOG_RESPONSE] = array();
            foreach ($this->api_Param as $object) {
                $hydrator = new Hydrator();
                $new_user = $hydrator->GetDisciple($object);
                /**
                 * @var \DeepLife_API\Model\User $_new_user
                 */
                $_new_user = $smsService->Get_User($new_user);
                $new_user->setId($_new_user->getId());
                $state = $smsService->Update_Disciple($new_user);
                $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                $res[Resp::LOG_RESPONSE][] = $disciple_res;
            }
            $this->api_Response[Resp::RESPONSE] = $res;
        } elseif ($service === Svc::UPDATE) {
            $found[ApiEntity::DISCIPLES] = $smsService->GetAll_Disciples($this->api_User);
            $found[ApiEntity::SCHEDULES] = $smsService->GetNew_Schedule($this->api_User);
            $found[ApiEntity::NEWSFEEDS] = $smsService->GetNew_NewsFeeds($this->api_User);
            $found[ApiEntity::TESTIMONIES] = $smsService->GetNew_Testimonies($this->api_User);
            $found[ApiEntity::CATEGORIES] = $smsService->GetAll_Categories();
            $found[ApiEntity::QUESTIONS] = $smsService->Get_Question($this->api_User);
            $found[ApiEntity::ANSWERS] = $smsService->GetAll_Disciple_Answers($this->api_User);
            $found[ApiEntity::PROFILE] = $smsService->Get_User_Profile($this->api_User);
            $found[ApiEntity::LEARNINGTOOLS] = $smsService->GetNew_LearningTools($this->api_User);
            $found[ApiEntity::DISCIPLETREE] = $smsService->Get_DiscipleCount($this->api_User);

            //$found['Reports'] = $smsService->Get_Report($this->api_user);

            $this->api_Response[Resp::RESPONSE] = $found;
        } elseif ($service === Svc::SEND_REPORT) {
            // send report
            $res[Resp::LOG_RESPONSE] = array();
            foreach ($this->api_Param as $object) {
                $object = array_change_key_case($object, CASE_LOWER);
                $new_user_report = new UserReport();
                $new_user_report->setUserId($this->api_User->getId());
                $new_user_report->setReportId($object[ApiSendReport::REPORT_ID]);
                $new_user_report->setValue($object[ApiSendReport::VALUE]);
                $state = $smsService->AddNew_UserReport($new_user_report);
                if ($state) {
                    $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                    $res[Resp::LOG_RESPONSE][] = $disciple_res;
                }
            }
            $this->api_Response[Resp::RESPONSE] = $res;
        } elseif ($service === Svc::GETNEW_NEWSFEED) {
            $this->api_Response[Resp::RESPONSE] = array(ApiEntity::NEWSFEEDS, $smsService->GetNew_NewsFeeds($this->api_User));
        } elseif ($service === Svc::SEND_TESTIMONY) {
            $res[Resp::LOG_RESPONSE] = array();
            foreach ($this->api_Param as $object) {
                $object = array_change_key_case($object, CASE_LOWER);
                $sch = new Testimony();
                $sch->setUserId($this->api_User->getId());
                $sch->setTitle($object[ApiTestimony::TITLE]);
                $sch->setCountryId($this->api_User->getCountry());
                $sch->setDetail($object[ApiTestimony::DETAIL]);
                $state = $smsService->AddTestimony($sch);
                if ($state) {
                    $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                    $res[Resp::LOG_RESPONSE][] = $disciple_res;
                }
            }
            $this->api_Response[Resp::RESPONSE] = $res;
        } elseif ($service === Svc::UPLOAD_USER_PIC) {
            $file = fopen("data.txt", 'wb');
            fwrite($file, $param);
            fclose($file);
            $res[Resp::UPLOAD_RESPONSE] = array();
            foreach ($this->api_Param as $object) {
                $object = array_change_key_case($object, CASE_LOWER);
                $status = $this->UploadFile($object[ApiUploadUserPic::IMAGE], $this->api_User->getId());
                if ($status[ApiUploadUserPic::STATUS] == 1) {
                    $new_user = $this->api_User;
                    $new_user->setPicture($status[ApiUploadUserPic::FILENAME]);
                    $state = $smsService->Update_User_Pic($new_user);
                    $upload_status[ApiGeneric::ID] = $object[ApiGeneric::ID];
                    $upload_status[ApiUploadUserPic::FILE_NAME] = $status[ApiUploadUserPic::FILENAME];
                    $res[Resp::UPLOAD_RESPONSE][] = $upload_status;
                }
            }
            $this->api_Response[Resp::RESPONSE] = $res;
        } elseif ($service === Svc::UPDATE_SCHEDULES) {
            $res[Resp::LOG_RESPONSE] = array();
            foreach ($this->api_Param as $object) {
                $object = array_change_key_case($object, CASE_LOWER);
                $hydrator = new Hydrator();
                $new_Sch = $hydrator->GetSchedule_($object);
                /**
                 * @var \DeepLife_API\Model\Schedule $_new_sch
                 */
                $_new_sch = $smsService->Get_Schedule_By_AlarmName($new_Sch);
                $_new_sch->setName($_new_sch->getName());
                $_new_sch->setTime($new_Sch->getTime());
                $_new_sch->setType($new_Sch->getType());
                $_new_sch->setDescription($_new_sch->getDescription());
                $state = $smsService->Update_Schedule($_new_sch);
                if ($state) {
                    $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                    $res[Resp::LOG_RESPONSE][] = $disciple_res;
                }
            }
            $this->api_Response[Resp::RESPONSE] = $res;
        } elseif ($service === Svc::GETALL_TESTIMONIES) {
            $this->api_Response[Resp::RESPONSE] = array(ApiEntity::TESTIMONIES, $smsService->GetAll_Testimonies());
        } elseif ($service === Svc::GETNEW_TESTIMONIES) {
            $this->api_Response[Resp::RESPONSE] = array(ApiEntity::TESTIMONIES, $smsService->GetNew_Testimonies($this->api_User));
        } elseif ($service === Svc::ADDNEW_TESTIMONY) {
            $res[Resp::LOG_RESPONSE] = array();
            $state = null;
            foreach ($this->api_Param as $object) {
                $object = array_change_key_case($object, CASE_LOWER);
                $sch = new Testimony();
                $sch->setDescription($object[ApiTestimony::TITLE]."\n".$object[ApiTestimony::DETAIL]);
                $sch->setCountryId($this->api_User->getCountry());
                $sch->setUserId($this->api_User->getId());
                $sch->setStatus(1);

                $state = $smsService->AddNew_Testimony($sch);
                if ($state) {
                    /**
                     * @var \DeepLife_API\Model\Testimony $_new_testimony
                     */
                    $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                    $res[Resp::LOG_RESPONSE][] = $disciple_res;
                }

            }
            $this->api_Response[Resp::RESPONSE] = $res;
        } elseif ($service === Svc::DELETE_TESTIMONY) {
            $res[Resp::LOG_RESPONSE] = array();
            $state = null;

            foreach ($this->api_Param as $object) {
                $object = array_change_key_case($object, CASE_LOWER);
                $sch = new Testimony();
                $sch->setDescription($object[ApiTestimony::DESCRIPTION]);
                $sch->setCountryId($this->api_User->getCountry());
                $sch->setUserId($this->api_User->getId());
                $state = $smsService->Delete_Testimony($sch);
                if ($state) {
                    print_r('Deleted:-> ',$sch);
                    $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                    $res[Resp::LOG_RESPONSE][] = $disciple_res;
                }else{
                    print_r('Not Deleted:-> ',$sch);
                }

            }
            $this->api_Response[Resp::RESPONSE] = $res;
        } elseif ($service === Svc::ADDNEW_TESTIMONY_LOG) {
            $res[Resp::LOG_RESPONSE] = array();
            foreach ($this->api_Param as $object) {
                $object = array_change_key_case($object, CASE_LOWER);
                $sch = new Testimony();
                $sch->setUserId($this->api_User->getId());
                $sch->setId($object[ApiTestimonyLog::TESTIMONY_ID]);
                $state = $smsService->AddNew_TestimonyLog($sch);
                if ($state) {
                    $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                    $res[Resp::LOG_RESPONSE][] = $disciple_res;
                }
            }
            $this->api_Response[Resp::RESPONSE] = $res;
        } elseif ($service === Svc::DELETE_ALL_TESTIMONYLOGS) {
            $res[Resp::LOG_RESPONSE] = array();
            foreach ($this->api_Param as $object) {
                $object = array_change_key_case($object, CASE_LOWER);
                $state = $smsService->Delete_All_TestimonyLog($this->api_User);
                if ($state) {
                    $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                    $res[Resp::LOG_RESPONSE][] = $disciple_res;
                }
            }
            $this->api_Response[Resp::RESPONSE] = $res;
        } elseif ($service === Svc::GETALL_NEWSFEEDS) {
            $this->api_Response[Resp::RESPONSE] = array(ApiEntity::NEWSFEEDS, $smsService->GetAll_NewsFeeds());
        } elseif ($service === Svc::GETNEW_NEWSFEEDS) {
            $this->api_Response[Resp::RESPONSE] = array(ApiEntity::NEWSFEEDS, $smsService->GetNew_NewsFeeds($this->api_User));
        } elseif ($service === Svc::ADDNEW_NEWSFEED_LOG) {
            $res[Resp::LOG_RESPONSE] = array();
            foreach ($this->api_Param as $object) {
                $object = array_change_key_case($object, CASE_LOWER);
                $sch = new NewsFeed();
                $sch->setUserId($this->api_User->getId());
                $sch->setId($object[ApiNewsFeedLog::NEWSFEED_ID]);
                $state = $smsService->AddNew_NewsFeed_log($sch);
                if ($state) {
                    $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                    $res[Resp::LOG_RESPONSE][] = $disciple_res;
                }
            }
            $this->api_Response[Resp::RESPONSE] = $res;
        } elseif ($service === Svc::DELETE_ALL_NEWSFEED_LOGS) {
            $res[Resp::LOG_RESPONSE] = array();
            foreach ($this->api_Param as $object) {
                $object = array_change_key_case($object, CASE_LOWER);
                $state = $smsService->Delete_All_NewsFeed_Log($this->api_User);
                if ($state) {
                    $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                    $res[Resp::LOG_RESPONSE][] = $disciple_res;
                }
            }
            $this->api_Response[Resp::RESPONSE] = $res;
        } elseif ($service === Svc::GETALL_CATEGORY) {
            $this->api_Response[Resp::RESPONSE] = array(ApiEntity::CATEGORIES, $smsService->GetAll_Categories());
        } elseif ($service === Svc::GETALL_LEARNINGTOOLS) {
            $this->api_Response[Resp::RESPONSE] = array(ApiEntity::LEARNINGTOOLS, $smsService->GetAll_LearningTools($this->api_User));
        } elseif ($service === Svc::GETNEW_LEARNINGTOOLS) {
            $this->api_Response[Resp::RESPONSE] = array(ApiEntity::LEARNINGTOOLS, $smsService->GetNew_LearningTools($this->api_User));
        }elseif ($service === Svc::DISCIPLETREE) {
            $this->api_Response[Resp::RESPONSE] = array(ApiEntity::DISCIPLETREE, $smsService->Get_DiscipleCount($this->api_User));
        }elseif ($service === Svc::UPDATE_PROFILE) {
            $res[Resp::LOG_RESPONSE] = array();
            foreach ($this->api_Param as $object) {
                $object = array_change_key_case($object, CASE_LOWER);
                $hydrator = new Hydrator();
                if(isset($object[ApiDisciple::PHONE_CODE])){
                    /**
                     * @var \DeepLife_API\Model\Country $country
                     */
                    $country = $smsService->Get_Country_By_PhoneCode($object[ApiProfile::PHONE_CODE]);
                    if($country != null && $country->getId() != null){
                        $object[ApiProfile::COUNTRY] = $country->getId();
                    }
                }
                $new_user = $hydrator->GetUser($object);
                /**
                 * @var \DeepLife_API\Model\User $_new_user
                 */
                $_new_user = $smsService->Get_User($this->api_User);
                $new_user->setId($_new_user->getId());
                $state = $smsService->Update_UserInfo($new_user);
                $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                $res[Resp::LOG_RESPONSE][] = $disciple_res;
            }
            $this->api_Response[Resp::RESPONSE] = $res;
        }elseif ($service === Svc::REMOVE_DISCIPLE) {
            $res[Resp::LOG_RESPONSE] = array();
            foreach ($this->api_Param as $object) {
                $object = array_change_key_case($object, CASE_LOWER);
                $user1 = new User();
                $user1->setPhoneNo($object[ApiDisciple::DISCIPLE_PHONE]);
                /**
                 * @var \DeepLife_API\Model\User $_new_user
                 */
                $_new_user = $smsService->Get_User($user1);
                if ($_new_user != null) {
                    $_new_user->setMentorId(ApiGeneric::NULL);
                    $state = $smsService->Update_User($_new_user);
                    if($state){
                        $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                        $res[Resp::LOG_RESPONSE][] = $disciple_res;
                    }else{
                        $user1->setPhoneNo("");
                        $user1->setEmail($object[ApiDisciple::DISCIPLE_EMAIL]);
                        $_new_user = $smsService->Get_User($user1);
                        if($_new_user != null){
                            $_new_user->setMentorId(ApiGeneric::NULL);
                            $state = $smsService->Update_User($_new_user);
                            $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                            $res[Resp::LOG_RESPONSE][] = $disciple_res;
                        }else{
                            $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                            $res[Resp::LOG_RESPONSE][] = $disciple_res;
                        }
                    }
                }else{
                    $disciple_res[Resp::LOG_ID] = $object[ApiGeneric::ID];
                    $res[Resp::LOG_RESPONSE][] = $disciple_res;
                }
            }
            $this->api_Response[Resp::RESPONSE] = $res;
        }
    }

    public function isValidRequest($data)
    {
        $this->api_Response[Resp::REQUEST_ERROR] = array();
        if (isset($data[Req::USER_NAME]) && isset($data[Req::USER_PASS]) && isset($data[Req::COUNTRY])
            && isset($data[Req::SERVICE]) && isset($data[Req::PARAM])
        ) {
            $reqService = strtolower($data[Req::SERVICE]);

            if (Svc::isValidValue($reqService)) {
                $this->api_Service = $reqService;
                return true;
            } else {
                $error[RespErr::SERVICE_REQUEST] = RespErrServiceRequest::UNKNOWN;
                $this->api_Response[Resp::REQUEST_ERROR] = $error;
            }
        } else {
            $error[RespErr::REQUEST_FORMAT] = RespErrRequestFormat::INVALID;
            $this->api_Response[Resp::REQUEST_ERROR] = $error;
        }
        return false;
    }

    public function isValidParam($param, $service) {
        $is_valid = false;
        $objects = json_decode($param, true);
        if (is_array($objects)) {
            if ($service === Svc::ADDNEW_DISCIPLES) {
                foreach ($objects as $object) {
                    $object = array_change_key_case($object, CASE_LOWER);
                    //if ((isset($object['Full_Name']) || isset($object['FullName'])) && isset($object['Country']) && isset($object['Phone']) && isset($object['Email'])) {
                    if ((isset($object[ApiDisciple::FULL_NAME]) || isset($object[ApiDisciple::FULLNAME])) && isset($object[ApiDisciple::COUNTRY]) && isset($object[ApiDisciple::PHONE]) && isset($object[ApiDisciple::EMAIL])) {
                        $is_valid = true;
                    } else {
                        $error[RespErr::PARAMETER_ERROR] = 'Invalid add new Disciple parameter given';
                        $this->api_Response[Resp::REQUEST_ERROR] = $error;
                        $is_valid = false;
                        break;
                    }
                }
            } elseif ($service === Svc::ADDNEW_DISCIPLES_LOG) {
                foreach ($objects as $object) {
                    $object = array_change_key_case($object, CASE_LOWER);
                    //if (isset($object['disciple_id'])) {
                    if (isset($object[ApiDiscipleLog::DISCIPLE_ID])) {
                        $is_valid = true;
                    } else {
                        $error[RespErr::PARAMETER_ERROR] = 'Invalid Disciple id for logging';
                        $this->api_Response[Resp::REQUEST_ERROR] = $error;
                        $is_valid = false;
                        break;
                    }
                }
            } elseif ($service === Svc::ADDNEW_SCHEDULES) {
                foreach ($objects as $object) {
                    $object = array_change_key_case($object, CASE_LOWER);
                    //if (isset($object['Alarm_Repeat']) && isset($object['Alarm_Time']) && isset($object['Disciple_Phone']) && isset($object['Disciple_Phone'])) {
                    if (isset($object[ApiSchedule::ALARM_REPEAT]) && isset($object[ApiSchedule::ALARM_TIME]) && isset($object[ApiSchedule::DISCIPLE_PHONE])) {
                        $is_valid = true;
                    } else {
                        $error[RespErr::PARAMETER_ERROR] = 'Invalid Disciple id for logging';
                        $this->api_Response[Resp::REQUEST_ERROR] = $error;
                        $is_valid = false;
                        break;
                    }
                }
            } elseif ($service === Svc::ADDNEW_SCHEDULE_LOG) {
                foreach ($objects as $object) {
                    $object = array_change_key_case($object, CASE_LOWER);
                    if (isset($object[ApiScheduleLog::SCHEDULE_ID])) {
                        $is_valid = true;
                    } else {
                        $error[RespErr::PARAMETER_ERROR] = 'Invalid Schedule id for logging';
                        $this->api_Response[Resp::REQUEST_ERROR] = $error;
                        $is_valid = false;
                        break;
                    }
                }
            } elseif ($service === Svc::ADDNEW_ANSWERS) {
                foreach ($objects as $object) {
                    $object = array_change_key_case($object, CASE_LOWER);
                    //if (isset($object['Answer']) && isset($object['DisciplePhone']) && isset($object['QuestionID']) && isset($object['BuildStage'])) {
                    if (isset($object[ApiAnswer::ANSWER]) && isset($object[ApiAnswer::DISCIPLEPHONE]) && isset($object[ApiAnswer::QUESTIONID]) && isset($object[ApiAnswer::BUILDSTAGE])) {
                        $is_valid = true;
                    } else {
                        $error[RespErr::PARAMETER_ERROR] = 'Invalid Question_Answer id for logging';
                        $this->api_Response[Resp::REQUEST_ERROR] = $error;
                        $is_valid = false;
                        break;
                    }
                }
            } elseif ($service === Svc::UPDATE_DISCIPLES) {
                foreach ($objects as $object) {
                    $object = array_change_key_case($object, CASE_LOWER);
                    //if (isset($object['FullName']) && isset($object['Stage']) && isset($object['Gender']) && (isset($object['Email']) || isset($object['Phone']))) {
                    if (isset($object[ApiDisciple::FULLNAME]) && isset($object[ApiDisciple::STAGE]) && isset($object[ApiDisciple::GENDER]) && (isset($object[ApiDisciple::EMAIL]) || isset($object[ApiDisciple::PHONE]))) {
                        $is_valid = true;
                    } else {
                        $error[RespErr::PARAMETER_ERROR] = 'Invalid Update Disciple Profile Param';
                        $this->api_Response[Resp::REQUEST_ERROR] = $error;
                        $is_valid = false;
                        break;
                    }
                }
            } elseif ($service === Svc::ADDNEW_TESTIMONY) {
                foreach ($objects as $object) {
                    $object = array_change_key_case($object, CASE_LOWER);
                    //if (isset($object['detail']) && isset($object[ApiGeneric::ID]) && isset($object['title'])) {
                    if (isset($object[ApiTestimony::DETAIL]) && isset($object[ApiGeneric::ID]) && isset($object[ApiTestimony::TITLE])) {
                        $is_valid = true;
                    } else {
                        $error[RespErr::PARAMETER_ERROR] = 'Invalid Add Testimony Param !';
                        $this->api_Response[Resp::REQUEST_ERROR] = $error;
                        $is_valid = false;
                        break;
                    }
                }
            } elseif ($service === Svc::UPDATE_PROFILE) {
                foreach ($objects as $object) {
                    $object = array_change_key_case($object, CASE_LOWER);
                    //if (isset($object['Email']) && isset($object['FullName']) && isset($object['Country'])  && isset($object['Gender']) && isset($object['Phone']) && isset($object[ApiGeneric::ID])) {
                    if (isset($object[ApiProfile::EMAIL]) && isset($object[ApiProfile::FULLNAME]) && isset($object[ApiProfile::COUNTRY])  && isset($object[ApiProfile::GENDER]) && isset($object[ApiProfile::PHONE]) && isset($object[ApiGeneric::ID])) {
                        $is_valid = true;
                    } else {
                        $error[RespErr::PARAMETER_ERROR] = 'Invalid Update User Profile Param!';
                        $this->api_Response[Resp::REQUEST_ERROR] = $error;
                        $is_valid = false;
                        break;
                    }
                }
            } elseif ($service === Svc::REMOVE_DISCIPLE) {
                foreach ($objects as $object) {
                    $object = array_change_key_case($object, CASE_LOWER);
                    //if (isset($object['Disciple_Phone']) && isset($object['Disciple_Email']) && isset($object[ApiGeneric::ID])) {
                    if (isset($object[ApiDisciple::DISCIPLE_PHONE]) && isset($object[ApiDisciple::DISCIPLE_EMAIL]) && isset($object[ApiGeneric::ID])) {
                        $is_valid = true;
                    } else {
                        $error[RespErr::PARAMETER_ERROR] = 'Invalid Remove Disciple Param!';
                        $this->api_Response[Resp::REQUEST_ERROR] = $error;
                        $is_valid = false;
                        break;
                    }
                }
            }
            if ($is_valid) {
                $this->api_Param = $objects;
            }
            $is_valid = true;
        } else {
            $error[RespErr::PARAMETER_ERROR] = 'The parameter should be an array';
            $this->api_Response[Resp::REQUEST_ERROR] = $error;
        }
        return $is_valid;
    }
}