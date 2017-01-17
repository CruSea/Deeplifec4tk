<?php
/**
 * Created by PhpStorm.
 * User: BENGEOS-PC
 * Date: 3/25/2016
 * Time: 1:31 PM
 */

namespace DeepLife_API\Service;


use DeepLife_API\Model\Answers;
use DeepLife_API\Model\Disciple;
use DeepLife_API\Model\NewsFeed;
use DeepLife_API\Model\Questions;
use DeepLife_API\Model\Schedule;
use DeepLife_API\Model\Testimony;
use DeepLife_API\Model\User;
use DeepLife_API\Model\User_Role;
use DeepLife_API\Model\UserReport;

interface Service
{
    // Users Table Services
    public function AddNew_User(User $user);
    public function Add_User_Role($user_id, $role_id);
    public function Delete_User(User $user);
    public function Update_User(User $user);
    public function Update_UserInfo(User $user);
    public function Update_Disciple(User $user);
    public function Update_DiscipleInfo(User $user);
    public function Update_User1(User $user);
    public function Update_User_Pic(User $user);
    public function isThere_User(User $user);

    public function Get_User(User $user);
    public function Get_Users(User $user);
    public function Get_User_Profile(User $user);
    public function GetAll_Disciples(User $user);
    public function GetNew_Disciples(User $user);
    public function AddNew_Disciple_log(Disciple $disciple);


    // User Schedule Table

    public function AddNew_Schedule(Schedule $schedule);
    public function AddNew_Schedule_log(Schedule $schedule);
    public function Delete_Schedule(Schedule $schedule);

    public function Update_Schedule(Schedule $schedule);
    public function GetAll_Schedule(User $user);
    public function GetNew_Schedule(User $user);
    public function Get_Schedule_By_AlarmTime(Schedule $schedule);
    public function Get_Schedule_By_AlarmName(Schedule $schedule);
    public function Delete_Schedule_Log(User $user);

    // Disciple Service
    public function AddNew_Disciples(User $user,array $users);
    public function AddNew_Disciple(User $user,User $disciple);
    public function AddNewDisciples(User $user);
    public function Delete_Disciple_Log(User $user);

    public function isValidUser(User $user);
    public function authenticate($userName, $userPass);
    public function authenticate2($userName, $userPass);

    public function AddNew_Question(Questions $questions);
    public function GetAll_Question();
    public function Get_Question(User $user);

    public function AddNew_Answer(Answers $answers);
    public function Get_Answer(Answers $answers);
    public function Update_Answer(Answers $answers);
    public function GetAll_Answers(User $user);
    public function GetAll_Disciple_Answers(User $user);

    public function AddNew_Report(User $user);
    public function GetAll_Report();
    public function Get_Report(User $user);

    public function GetAll_Country();

    public function AddNew_UserReport(UserReport $userReport);

    public function GetAll_NewsFeeds();
    public function GetNew_NewsFeeds(User $user);
    public function AddNew_NewsFeed_log(NewsFeed $news);
    public function Delete_All_NewsFeed_Log(User $user);

    public function AddTestimony(Testimony $testimony);
    public function GetAll_Testimonies();
    public function Get_Testimony(Testimony $testimony);
    public function Get_Testimonies(User $user);
    public function GetNew_Testimonies(User $user);
    public function AddNew_Testimony(Testimony $testimony);
    public function AddNew_TestimonyLog(Testimony $testimony);
    public function Delete_Testimony(Testimony $testimony);
    public function Delete_All_TestimonyLog(User $user);

    public function GetAll_Categories();

    public function GetAll_LearningTools();
    public function GetNew_LearningTools(User $user);
    public function AddNew_LearningTools_log(Testimony $testimony);
    public function Delete_All_LearningTools_Log(User $user);

    public function Get_DiscipleCount(User $user);
}