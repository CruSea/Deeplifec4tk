<?php
/**
 * Created by PhpStorm.
 * User: BENGEOS-PC
 * Date: 3/25/2016
 * Time: 1:20 PM
 */

namespace DeepLife_API\Repository;


use DeepLife_API\Model\Answers;
use DeepLife_API\Model\Category;
use DeepLife_API\Model\Country;
use DeepLife_API\Model\Disciple;
use DeepLife_API\Model\DiscipleTree;
use DeepLife_API\Model\Hydrator;
use DeepLife_API\Model\LearningTools;
use DeepLife_API\Model\NewsFeed;
use DeepLife_API\Model\Questions;
use DeepLife_API\Model\Report;
use DeepLife_API\Model\Schedule;
use DeepLife_API\Model\Testimony;
use DeepLife_API\Model\User;
use DeepLife_API\Model\UserReport;
use Zend\Crypt\Password\Bcrypt;
use Zend\Db\Adapter\AdapterAwareTrait;

class RepositoryImpl implements RepositoryInterface
{
    use AdapterAwareTrait;

    public function isValidUser(User $user)
    {
        $row_sql = 'SELECT * FROM users WHERE users.password = \'' . $this->Encrypt($user->getPassword()) . '\' AND (users.email = \'' . $user->getEmail() . '\' OR users.phone_no = \'' . $user->getPhoneNo() . '\')';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function isThere_User(User $user)
    {
        $row_sql = 'SELECT * FROM users WHERE users.phone_no = \'' . $user->getPhoneNo() . '\'';
        $statement = $this->adapter->query($row_sql);
        $result1 = $statement->execute();

        $row_sql = 'SELECT * FROM users WHERE users.email = \'' . $user->getEmail() . '\'';
        $statement = $this->adapter->query($row_sql);
        $result2 = $statement->execute();

        $posts = null;
        if ($result1->count() > 0 || $result2->count() >0) {
            return true;
        } else {
            return false;
        }
    }

    public function Encrypt($password)
    {
        $encrypter = new Bcrypt();
        $encrypter->setCost(14);
        return $encrypter->create($password);
    }


    public function AddNew_User(User $user)
    {
        /**
         * @var \Zend\Db\Sql\Sql $ sql
         */
        $sql1 = "INSERT INTO users( email, displayName, password, firstName, country, phone_no, mentor_id, picture, stage, role_id, gender, userlocale) VALUES ('".$user->getEmail()."','".$user->getDisplayName()."','".$this->Encrypt($user->getPassword())."','".$user->getFirstName()."','".$user->getCountry()."','".$user->getPhoneNo()."','".$user->getMentorId()."','".$user->getPicture()."','".$user->getStage()."','".$user->getRoleId()."','".$user->getGender()."','".$user->getUserlocale()."')";
        $statement = $this->adapter->query($sql1);
        $result = $statement->execute();
//        $sql = new \Zend\Db\Sql\Sql($this->adapter);
//        $insert = $sql->insert()
//            ->values(array(
//                'email' => $user->getEmail(),
//                'displayName' => $user->getDisplayName(),
//                'password' => $this->Encrypt($user->getPassword()),
//                'firstName' => $user->getFirstName(),
//                'country' => $user->getCountry(),
//                'phone_no' => $user->getPhoneNo(),
//                'mentor_id' => $user->getMentorId(),
//                'gender' => $user->getGender(),
//                'role_id' => $user->getRoleId(),
//                'stage' => $user->getStage(),
//                'picture' => $user->getPicture(),
//                'userlocale' => $user->getUserlocale(),
//            ))
//            ->into('users');
//        $statement = $sql->prepareStatementForSqlObject($insert);
//        $result = $statement->execute();
        return $result->valid();
    }

    public function Delete_User(User $user)
    {
        $row_sql = 'DELETE FROM users WHERE users.phone_no = ' . $user->getPhoneNo();
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            return true;
        }
        return false;
    }

    public function Update_User(User $user)
    {
        $row_sql = 'UPDATE users SET users.mentor_id = \'' . $user->getMentorId() . '\' WHERE users.id = \'' . $user->getId() . '\'';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function Update_User_Pic(User $user)
    {
        $row_sql = 'UPDATE users SET users.picture = \'' . $user->getPicture() . '\' WHERE users.id = \'' . $user->getId() . '\'';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function Update_User1(User $user)
    {
        $row_sql = 'UPDATE users SET users.stage = \'' . $user->getStage() . '\' WHERE users.id = \'' . $user->getId() . '\'';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param \DeepLife_API\Model\User $user
     * @return \DeepLife_API\Model\User|null
     */
    public function Get_User(User $user)
    {
        $row_sql = 'SELECT * FROM users WHERE users.email = \'' . $user->getEmail() . '\'';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $posts[] = $result->current();
                $result->next();
            }
        } else {
            $row_sql = 'SELECT * FROM users WHERE users.phone_no = \'' . $user->getPhoneNo() . '\'';
            $statement = $this->adapter->query($row_sql);
            $result = $statement->execute();
            if ($result->count() > 0) {
                while ($result->valid()) {
                    $posts[] = $result->current();
                    $result->next();
                }
            }
        }
        $hydrator = new Hydrator();
        
        $found = $hydrator->Get_Data($posts, new User());
        return $found;
    }
    public function Get_User_Profile(User $user)
    {
        $row_sql = 'SELECT * FROM users WHERE users.email = \'' . $user->getEmail() . '\'';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $posts[] = $result->current();
                $result->next();
            }
        } else {
            $row_sql = 'SELECT * FROM users WHERE users.phone_no = \'' . $user->getPhoneNo() . '\'';
            $statement = $this->adapter->query($row_sql);
            $result = $statement->execute();
            if ($result->count() > 0) {
                while ($result->valid()) {
                    $posts[] = $result->current();
                    $result->next();
                }
            }
        }
        $hydrator = new Hydrator();
        $found = $hydrator->Get_Json($posts, new User());
        return $found;
    }
    public function Get_UserByID(User $user)
    {
        $row_sql = 'SELECT * FROM users WHERE users.id = \'' . $user->getId() . '\'';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $posts[] = $result->current();
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        $found = $hydrator->Get_Data($posts, new User());
        return $found;
    }
    public function Add_User_Role($user_id, $role_id)
    {
        /**
         * @var \Zend\Db\Sql\Sql $ sql
         */
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'user_id' => $user_id,
                'role_id' => $role_id,
            ))
            ->into('user_role_linker');
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();
        return $result->valid();
    }

    public function GetAll_Disciples(User $user)
    {
        $row_sql = 'SELECT * FROM users WHERE users.mentor_id = \'' . $user->getId() . '\'';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $posts[] = $result->current();
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        return $hydrator->Extract($posts, new User());
    }

    public function AddNew_Disciple_log(Disciple $schedule)
    {
        /**
         * @var \Zend\Db\Sql\Sql $ sql
         */
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'user_id' => $schedule->getUserID(),
                'disciple_id' => $schedule->getDiscipleID(),
            ))
            ->into('disciple_log');
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();
        return $result->valid();
    }

    public function GetNew_Disciples(User $user)
    {
        $row_sql = 'SELECT * FROM users WHERE users.id NOT IN( SELECT disciple_log.disciple_id FROM disciple_log ) AND users.mentor_id = \'' . $user->getId() . '\'';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $posts[] = $result->current();
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        return $hydrator->Extract($posts, new User());
    }

    public function Delete_Disciple_Log(User $user)
    {
        $row_sql = 'DELETE FROM disciple_log WHERE disciple_log.user_id = ' . $user->getId();
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            return true;
        }
        return false;
    }

    public function Delete_Schedule(Schedule $schedule)
    {
        $row_sql = 'DELETE FROM schedule WHERE schedule.time = \'' . $schedule->getTime() . '\' AND schedule.user_id = ' . $schedule->getUserId();
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            return true;
        }
        return false;
    }

    public function AddNew_Schedule(Schedule $schedule)
    {
        /**
         * @var \Zend\Db\Sql\Sql $ sql
         */
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'user_id' => $schedule->getUserId(),
                'disciple_phone' => $schedule->getDisciplePhone(),
                'name' => $schedule->getName(),
                'time' => $schedule->getTime(),
                'type' => $schedule->getType(),
                'description' => $schedule->getDescription(),
            ))
            ->into('schedule');
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();
        return $result->valid();
    }

    public function Delete_Schedule_Log(User $user)
    {
        $row_sql = 'DELETE FROM schedule_logs WHERE schedule_logs.user_id = ' . $user->getId();
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            return true;
        }
        return false;
    }

    public function AddNew_Schedule_log(Schedule $schedule)
    {
        /**
         * @var \Zend\Db\Sql\Sql $ sql
         */
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'user_id' => $schedule->getUserId(),
                'schedule_id' => $schedule->getId(),
            ))
            ->into('schedule_logs');
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();
        return $result->valid();
    }

    public function Update_Schedule(Schedule $schedule)
    {
        $row_sql = 'UPDATE schedule SET schedule.name = \'' . $schedule->getName() . '\' , schedule.time = \'' . $schedule->getTime() . '\' , schedule.type = \'' . $schedule->getType() . '\' , schedule.description = \'' . $schedule->getDescription() . '\'WHERE schedule.name = \'' . $schedule->getName() . '\'';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function GetAll_Schedule(User $user)
    {
        $row_sql = 'SELECT * FROM schedule WHERE schedule.user_id = ' . $user->getId();
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $posts[] = $result->current();
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        return $hydrator->Extract($posts, new Schedule());
    }

    public function GetNew_Schedule(User $user)
    {
        $row_sql = 'SELECT * FROM schedule WHERE schedule.id NOT IN( SELECT schedule_logs.schedule_id FROM schedule_logs ) AND schedule.user_Id = ' . $user->getId();
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $posts[] = $result->current();
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        return $hydrator->Extract($posts, new Schedule());
    }

    public function Get_Schedule_By_AlarmTime(Schedule $schedule)
    {
        $row_sql = 'SELECT * FROM schedule WHERE schedule.time = "' . $schedule->getTime() . "\"";
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $posts = $result->current();
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        return $hydrator->GetSchedule($posts);
    }

    public function Get_Schedule_By_AlarmName(Schedule $schedule)
    {
        $row_sql = 'SELECT * FROM schedule WHERE schedule.name = "' . $schedule->getName() . "\"";
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $posts = $result->current();
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        return $hydrator->GetSchedule($posts);
    }


    public function getAuthenticationAdapter()
    {
        $callback = function ($encryptedPassword, $clearTextPassword) {
            $encrypter = new Bcrypt();
            $encrypter->setCost(12);
            return $encrypter->verify($clearTextPassword, $encryptedPassword);
        };
        $authenticationAdapter = new \Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter(
            $this->adapter,
            'users',
            'email',
            'password',
            $callback
        );
        return $authenticationAdapter;
    }

    public function getAuthenticationAdapter2()
    {
        $callback = function ($encryptedPassword, $clearTextPassword) {
            $encrypter = new Bcrypt();
            $encrypter->setCost(12);
            return $encrypter->verify($clearTextPassword, $encryptedPassword);
        };
        $authenticationAdapter = new \Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter(
            $this->adapter,
            'users',
            'phone_no',
            'password',
            $callback
        );
        return $authenticationAdapter;
    }

    public function AddNew_Question(Questions $questions)
    {
        /**
         * @var \Zend\Db\Sql\Sql $ sql
         */
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'category' => $questions->getCategory(),
                'question' => $questions->getQuestion(),
                'description' => $questions->getDescription(),
                'country' => $questions->getCountryId(),
            ))
            ->into('questions');
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();
        return $result->valid();
    }

    public function GetAll_Question()
    {
        $row_sql = 'SELECT * FROM questions';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $posts[] = $result->current();
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        return $hydrator->Extract($posts, new Questions());
    }

    public function Get_Question(User $user)
    {
        $row_sql = 'SELECT * FROM questions WHERE questions.country = ' . $user->getCountry();
        $statement = $this->adapter->query($row_sql);

        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $posts[] = $result->current();
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        return $hydrator->Extract($posts, new Questions());
    }


    public function AddNew_Answer(Answers $answers)
    {
        /**
         * @var \Zend\Db\Sql\Sql $ sql
         */
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'user_id' => $answers->getUserId(),
                'question_id' => $answers->getQuestionId(),
                'country' => $answers->getCountry(),
                'answer' => $answers->getAnswer(),
                'stage' => $answers->getStage(),
                'notes' => $answers->getNotes(),
            ))
            ->into('answers');
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();
        return $result->valid();
    }

    public function Update_Answer(Answers $answers)
    {
        $row_sql = 'UPDATE answers SET answers.answer = \'' . $answers->getAnswer() . '\' , answers.stage = \'' . $answers->getStage() . '\' , answers.notes = \'' . $answers->getNotes() . '\' , answers.country = \'' . $answers->getCountry() . '\' WHERE answers.user_id = \'' . $answers->getUserId() . '\' AND answers.question_id = \''. $answers->getQuestionId().'\'' ;
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        return $result->count();
    }

    public function Get_Answer(Answers $answers)
    {
        $row_sql = 'SELECT * FROM answers WHERE answers.question_id = \'' . $answers->getQuestionId() . '\' AND answers.user_id = ' . $answers->getUserId();
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $posts[] = $result->current();
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        return $hydrator->Get_Data($posts, new Answers());
    }

    public function GetAll_Answers(User $user)
    {
        $row_sql = 'SELECT * FROM answers WHERE answers.user_id = ' . $user->getId();
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $posts[] = $result->current();
                $result->next();
            }
        }



        $hydrator = new Hydrator();
        return $hydrator->Extract($posts, new Answers());
    }

    public function GetAll_Disciple_Answers(User $user)
    {
        $row_sql = 'SELECT * FROM answers WHERE answers.user_id IN (SELECT id FROM users WHERE users.mentor_id = \'' . $user->getId() . '\')';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $data = $result->current();
                $user = new User();
                $user->setId($data['user_id']);
                $dis = $this->Get_UserByID($user);
                if($dis != null){
                    $data['phone'] = $dis->getPhoneNo();
                }
                $posts[] = $data;
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        return $hydrator->Extract($posts, new Answers());
    }

    public function AddNew_Report(User $user)
    {
        // TODO: Implement AddNew_Report() method.
    }

    public function GetAll_Report()
    {
        $row_sql = 'SELECT * FROM report_forms';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $posts[] = $result->current();
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        return $hydrator->Extract($posts, new Report());
    }

    public function Get_Report(User $user)
    {
        $row_sql = 'SELECT * FROM report_forms WHERE report_forms.country = ' . $user->getCountry();
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $posts[] = $result->current();
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        return $hydrator->Extract($posts, new Report());
    }

    public function GetAll_Country()
    {
        $row_sql = 'SELECT * FROM country';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $posts[] = $result->current();
                $result->next();
            }
        }
        $hydrator = new Hydrator();

        return $hydrator->Extract($posts, new Country());
    }

    public function AddNew_UserReport(UserReport $userReport)
    {
        /**
         * @var \Zend\Db\Sql\Sql $ sql
         */
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'user_id' => $userReport->getUserId(),
                'report_form_id' => $userReport->getReportId(),
                'value' => $userReport->getValue(),
            ))
            ->into('reports');
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();
        return $result->valid();
    }

    public function GetAll_NewsFeeds()
    {
        $row_sql = 'SELECT * FROM news_feeds';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $posts[] = $result->current();
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        return $hydrator->Extract($posts, new NewsFeed());
    }

    public function GetNew_NewsFeeds(User $user)
    {
        $row_sql = 'SELECT * FROM news WHERE news.country = ' . $user->getCountry() . ' AND news.id NOT IN( SELECT news_feeds_log.news_feed_id FROM news_feeds_log WHERE news_feeds_log.user_Id = ' . $user->getId() . ')';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $data = $result->current();
                $posts[] = $data;
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        return $hydrator->Extract($posts, new NewsFeed());
    }

    public function AddNew_NewsFeed_log(NewsFeed $news)
    {
        /**
         * @var \Zend\Db\Sql\Sql $ sql
         */
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'user_id' => $news->getUserId(),
                'news_feed_id' => $news->getId(),
            ))
            ->into('news_feeds_log');
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();
        return $result->valid();
    }

    public function Delete_All_NewsFeed_Log(User $user)
    {
        $row_sql = 'DELETE FROM news_feeds_log WHERE news_feeds_log.user_id = ' . $user->getId();
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            return true;
        }
        return false;
    }

    public function AddTestimony(Testimony $testimony)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'user_id' => $testimony->getUserId(),
                'country' => $testimony->getCountryId(),
                'description' => $testimony->getDetail(),
            ))
            ->into('testimonial');
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();
        return $result->valid();
    }

    public function GetAll_Testimonies()
    {
        $row_sql = 'SELECT * FROM testimonial where testimonial.status = 1';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $data = $result->current();
                $new_user = new User();
                $new_user->setId($data['user_id']);
                $testimony_user = $this->Get_UserByID($new_user);
                $data['user_name'] = $testimony_user->getFirstName();
                $posts[] = $data;
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        return $hydrator->Extract($posts, new Testimony());
    }

    public function Get_Testimonies(User $user)
    {
        // TODO: Implement Get_Testimonies() method.
    }

    public function GetNew_Testimonies(User $user)
    {
        $row_sql = 'SELECT * FROM testimonial WHERE testimonial.country = ' . $user->getCountry() . ' AND testimonial.id NOT IN( SELECT testimonial_logs.testimonial_id FROM testimonial_logs WHERE testimonial_logs.user_Id = ' . $user->getId() . ')'.' AND testimonial.status = 1';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $data = $result->current();
                $new_user = new User();
                $new_user->setId($data['user_id']);
                $testimony_user = $this->Get_UserByID($new_user);
                $data['user_name'] = $testimony_user->getFirstName();
                $posts[] = $data;
                $result->next();
            }
        }
        $hydrator = new Hydrator();

        return $hydrator->Extract($posts, new Testimony());
    }

    public function AddNew_Testimony(Testimony $testimony)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'user_id' => $testimony->getUserId(),
                'country' => $testimony->getCountryId(),
                'description' => $testimony->getDescription(),
                'status' => $testimony->getStatus(),
            ))
            ->into('testimonial');
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();
        return $result->valid();
    }

    public function Delete_Testimony(Testimony $testimony)
    {
        $row_sql = 'DELETE FROM testimonial WHERE testimonial.user_id = ' . $testimony->getUserId().' AND testimonial.description = '.$testimony->getDescription();
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            return true;
        }
        return false;
    }

    public function Delete_All_TestimonyLog(User $user)
    {
        $row_sql = 'DELETE FROM testimonial_logs WHERE testimonial_logs.user_id = ' . $user->getId();
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            return true;
        }
        return false;
    }

    public function AddNew_TestimonyLog(Testimony $testimony)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'user_id' => $testimony->getUserId(),
                'testimonial_id' => $testimony->getId(),
            ))
            ->into('testimonial_logs');
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();
        return $result->valid();
    }

    public function Get_Testimony(Testimony $testimony)
    {
        $row_sql = 'SELECT * FROM testimonial WHERE testimonial.description = '.$testimony->getDescription().' AND testimonial.user_id = '.$testimony->getUserId();
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $posts[] = $result->current();
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        return $hydrator->Get_Data($posts, new Testimony());
    }

    public function GetAll_Categories()
    {
        $row_sql = 'SELECT * FROM categories';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $posts[] = $result->current();
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        return $hydrator->Extract($posts, new Category());
    }

    public function GetAll_LearningTools()
    {
        $row_sql = 'SELECT * FROM learningtools where learningtools.status = 1';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $data = $result->current();
                $posts[] = $data;
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        return $hydrator->Extract($posts, new LearningTools());
    }

    public function GetNew_LearningTools(User $user)
    {
        $row_sql = 'SELECT * FROM learningtools where learningtools.country = '.$user->getCountry();
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $data = $result->current();
                $posts[] = $data;
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        return $hydrator->Extract($posts, new LearningTools());
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
        $row_sql = 'SELECT * FROM disciplestreecount WHERE disciplestreecount.user_id = \'' . $user->getId() . '\'';
        $statement = $this->adapter->query($row_sql);
        $result = $statement->execute();
        $posts = null;
        if ($result->count() > 0) {
            while ($result->valid()) {
                $posts[] = $result->current();
                $result->next();
            }
        }
        $hydrator = new Hydrator();
        $found = $hydrator->Get_Json($posts, new DiscipleTree());
        return $found;
    }


}