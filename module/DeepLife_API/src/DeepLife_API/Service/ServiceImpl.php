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
use Zend\Authentication\AuthenticationService;

class ServiceImpl implements Service
{
    /**
     * @var \DeePLife_API\Repository\RepositoryInterface $apiRepository
     */
    protected $apiRepository;

    /**
     * @return mixed
     */
    public function getApiRepository()
    {
        return $this->apiRepository;
    }

    /**
     * @param mixed $apiRepository
     */
    public function setApiRepository($apiRepository)
    {
        $this->apiRepository = $apiRepository;
    }

    public function LogError($error)
    {
        $file = fopen("Error Logs.txt", 'a');
        fwrite($file, $error);
        fclose($file);
    }

    public function isValidUser(User $user)
    {
        try {
            return $this->apiRepository->isValidUser($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function isThere_User(User $user)
    {
        try {
            return $this->apiRepository->isThere_User($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return true;
        }
    }

    public function isThere_User_By_Email(User $user)
    {
        try {
            return $this->apiRepository->isThere_User_By_Email($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return true;
        }
    }

    public function isThere_User_By_Phone(User $user)
    {
        try {
            return $this->apiRepository->isThere_User_By_Phone($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return true;
        }
    }

    public function getAuthenticationService()
    {
        $AuthAdapter = $this->apiRepository->getAuthenticationAdapter();
        return new AuthenticationService(null, $AuthAdapter);
    }

    public function getAuthenticationService2()
    {
        $AuthAdapter = $this->apiRepository->getAuthenticationAdapter2();
        return new AuthenticationService(null, $AuthAdapter);
    }

    public function authenticate2($userName, $userPass)
    {
        try {
            $AuthService = $this->getAuthenticationService2();
            /**
             * @var  \Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter $AuthAdapter
             */
            $AuthAdapter = $AuthService->getAdapter();
            $AuthAdapter->setIdentity($userName);
            $AuthAdapter->setCredential($userPass);
            $Result = $AuthAdapter->authenticate();
            return $Result->isValid();
        } catch (\Exception $e) {
            $this->LogError($e);
            return false;
        }
    }

    public function authenticate($userName, $userPass)
    {
        try {
            $AuthService = $this->getAuthenticationService();
            /**
             * @var  \Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter $AuthAdapter
             */
            $AuthAdapter = $AuthService->getAdapter();
            $AuthAdapter->setIdentity($userName);
            $AuthAdapter->setCredential($userPass);
            $Result = $AuthAdapter->authenticate();
            return $Result->isValid();
        } catch (\Exception $e) {
            $this->LogError($e);
            return false;
        }
    }

    public function AddNew_User(User $user)
    {
        try {
            return $this->apiRepository->AddNew_User($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function Add_User_Role($user_id, $role_id)
    {
        try {
            return $this->apiRepository->Add_User_Role($user_id, $role_id);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function Get_By_Email(User $user)
    {
        try {
            return $this->apiRepository->Get_By_Email($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function Get_By_Phone(User $user)
    {
        try {
            return $this->apiRepository->Get_By_Phone($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }


    public function Get_User_Profile(User $user)
    {
        try {
            return $this->apiRepository->Get_User_Profile($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function Update_UserInfo(User $user)
    {
        try {
            return $this->apiRepository->Update_UserInfo($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function Delete_User(User $user)
    {
        try {
            return $this->apiRepository->Delete_User($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function Update_User(User $user)
    {
        try {
            return $this->apiRepository->Update_User($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function Update_Disciple(User $user)
    {
        try {
            return $this->apiRepository->Update_Disciple($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function Update_DiscipleInfo(User $user)
    {
        try {
            return $this->apiRepository->Update_DiscipleInfo($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function Update_User_Pic(User $user)
    {
        try {
            return $this->apiRepository->Update_User_Pic($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function Update_User1(User $user)
    {
        try {
            return $this->apiRepository->Update_User1($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    /**
     * @param \DeepLife_API\Model\User $user
     * @return \DeepLife_API\Model\User | null
     */
    public function Get_User(User $user)
    {
        try {
            $data = $this->apiRepository->Get_User($user);
            return $data;
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }
    public function Get_Users(User $user)
    {
        try {
            $data = $this->apiRepository->Get_User($user);
            return $data;
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function GetAll_Disciples(User $user)
    {
        try {
            return $this->apiRepository->GetAll_Disciples($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function GetNew_Disciples(User $user)
    {
        try {
            return $this->apiRepository->GetNew_Disciples($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function AddNew_Schedule(Schedule $schedule)
    {
        try {
            return $this->apiRepository->AddNew_Schedule($schedule);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function AddNew_Schedule_log(Schedule $schedule)
    {
        try {
            return $this->apiRepository->AddNew_Schedule_log($schedule);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function Delete_Schedule(Schedule $schedule)
    {
        try {
            return $this->apiRepository->Delete_Schedule($schedule);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function Update_Schedule(Schedule $schedule)
    {
        try {
            return $this->apiRepository->Update_Schedule($schedule);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function GetAll_Schedule(User $user)
    {
        try {
            return $this->apiRepository->GetAll_Schedule($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function GetNew_Schedule(User $user)
    {
        try {
            return $this->apiRepository->GetNew_Schedule($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function Get_Schedule_By_AlarmTime(Schedule $schedule)
    {
        try {
            return $this->apiRepository->Get_Schedule_By_AlarmTime($schedule);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function Get_Schedule_By_AlarmName(Schedule $schedule)
    {
        try {
            return $this->apiRepository->Get_Schedule_By_AlarmName($schedule);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function Delete_Schedule_Log(User $user)
    {
        try {
            return $this->apiRepository->Delete_Schedule_Log($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function AddNew_Disciples(User $user, array $users)
    {
        try {
            if (is_array($users)) {
                /**
                 * @var \DeepLife_API\Model\User $newUser
                 */
                $state = null;
                foreach ($users as $newUser) {
                    $newUser->setMentorId($user->getId());
                    $state[] = $this->apiRepository->AddNew_User($newUser);
                }
                return $state;
            }
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }

    }

    public function AddNewDisciples(User $user)
    {
        try {
            return $this->apiRepository->AddNew_User($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function AddNew_Disciple(User $user, User $disciple)
    {
        try {
            $disciple->setMentorId($user->getId());
            return $this->apiRepository->AddNew_User($disciple);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function AddNew_Disciple_log(Disciple $disciple)
    {
        try {
            return $this->apiRepository->AddNew_Disciple_log($disciple);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function Delete_Disciple_Log(User $user)
    {
        try {
            return $this->apiRepository->Delete_Disciple_Log($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function AddNew_Question(Questions $questions)
    {
        try {
            return $this->apiRepository->AddNew_Question($questions);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function GetAll_Question()
    {
        try {
            return $this->apiRepository->GetAll_Question();
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function Get_Question(User $user)
    {
        try {
            return $this->apiRepository->Get_Question($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function AddNew_Answer(Answers $answers)
    {
        try {
            return $this->apiRepository->AddNew_Answer($answers);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function Get_Answer(Answers $answers)
    {
        try {
            return $this->apiRepository->Get_Answer($answers);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function GetAll_Answers(User $user)
    {
        try {
            return $this->apiRepository->GetAll_Answers($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function GetAll_Disciple_Answers(User $user)
    {
        try {
            return $this->apiRepository->GetAll_Disciple_Answers($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function Update_Answer(Answers $answers)
    {
        try {
            return $this->apiRepository->Update_Answer($answers);
        } catch (\Exception $e) {
            $this->LogError($e);
            return null;
        }
    }

    public function AddNew_Report(User $user)
    {
        // TODO: Implement AddNew_Report() method.
    }

    public function GetAll_Report()
    {
        try {
            return $this->apiRepository->GetAll_Report();
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function Get_Report(User $user)
    {
        try {
            return $this->apiRepository->Get_Report($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function GetAll_Country()
    {
        try {
            return $this->apiRepository->GetAll_Country();
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function Get_Country($id)
    {
        try {
            return $this->apiRepository->Get_Country($id);
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function Get_Country_By_PhoneCode($phone_code)
    {
        try {
            return $this->apiRepository->Get_Country_By_PhoneCode($phone_code);
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function AddNew_UserReport(UserReport $userReport)
    {
        try {
            return $this->apiRepository->AddNew_UserReport($userReport);
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function GetAll_NewsFeeds()
    {
        try {
            return $this->apiRepository->GetAll_NewsFeeds();
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function GetNew_NewsFeeds(User $user)
    {
        try {
            return $this->apiRepository->GetNew_NewsFeeds($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function AddNew_NewsFeed_log(NewsFeed $news)
    {
        try {
            return $this->apiRepository->AddNew_NewsFeed_log($news);
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function Delete_All_NewsFeed_Log(User $user)
    {
        try {
            return $this->apiRepository->Delete_All_NewsFeed_Log($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function AddTestimony(Testimony $testimony)
    {
        try {
            return $this->apiRepository->AddTestimony($testimony);
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }


    public function GetAll_Testimonies()
    {
        try {
            return $this->apiRepository->GetAll_Testimonies();
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function Get_Testimonies(User $user)
    {
        try {
            return $this->apiRepository->Get_Testimonies($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function GetNew_Testimonies(User $user)
    {
        try {
            return $this->apiRepository->GetNew_Testimonies($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function AddNew_Testimony(Testimony $testimony)
    {
        try {
            return $this->apiRepository->AddNew_Testimony($testimony);
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function AddNew_TestimonyLog(Testimony $testimony)
    {
        try {
            return $this->apiRepository->AddNew_TestimonyLog($testimony);
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function Delete_Testimony(Testimony $testimony)
    {
        try {
            return $this->apiRepository->Delete_Testimony($testimony);
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function Delete_All_TestimonyLog(User $user)
    {
        try {
            return $this->apiRepository->Delete_All_TestimonyLog($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function Get_Testimony(Testimony $testimony)
    {
        try {
            return $this->apiRepository->Get_Testimony($testimony);
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function GetAll_Categories()
    {
        try {
            return $this->apiRepository->GetAll_Categories();
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function GetAll_LearningTools()
    {
        try {
            return $this->apiRepository->GetAll_LearningTools();
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function GetNew_LearningTools(User $user)
    {
        try {
            return $this->apiRepository->GetNew_LearningTools($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }

    public function AddNew_LearningTools_log(Testimony $testimony)
    {
        // TODO: Implement AddNew_LearningTools_log() method.
    }

    public function Delete_All_LearningTools_Log(User $user)
    {
        // TODO: Implement Delete_All_LearningTools_Log() method.
    }

    public function Get_DiscipleCount(User $user)
    {
        try {
            return $this->apiRepository->Get_DiscipleCount($user);
        } catch (\Exception $e) {
            $this->LogError($e);
            return array();
        }
    }
    
}