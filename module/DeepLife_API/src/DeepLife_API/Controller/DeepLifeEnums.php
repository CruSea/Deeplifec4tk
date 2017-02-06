<?php
/**
 * Created by PhpStorm.
 * User: briggsm
 * Date: 2/6/17
 * Time: 2:12 PM
 */

namespace DeepLife_API\Controller;


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