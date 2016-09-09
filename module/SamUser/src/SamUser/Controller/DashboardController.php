<?php
/**
 * Created by PhpStorm.
 * User: Sami
 * Date: 10/24/15
 * Time: 10:04 PM
 */
/**
 * Dashboard
 * This module will be used for student dashboard
 * @package controller
 * @author Alvin.Abhinav
 */


namespace SamUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SamUser\Entity\Users;
use Zend\Form\Form;
use Zend\Stdlib\DateTime;
use SamUser\Form\UsersForm;
use Doctrine\ORM\EntityManager;
use Zend\Mail;
use DoctrineModule\Validator\NoObjectExists as NoObjectExistsValidator;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\Crypt\Password\Bcrypt;
use Zend\Session\Container;

class DashboardController extends AbstractActionController
{

    function __construct()
    {

    }

    protected $em;
    public $userid;

    /**
     * Function to get UserId
     * @param NA
     * @author Alvin.Abhinav
     */
    public function getMUserId()
    {
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            //get the user_id of the user
            $this->userid = $this->zfcUserAuthentication()->getIdentity()->getId();
        }
        return $this->userid;
    }

    /**
     * Function to getEntity Manager
     * @param NA
     * @author Alvin.Abhinav
     */
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }


    /**
     * Function to index Action
     * @param NA
     * @author Alvin.Abhinav
     */
    Public function indexAction()
    {

        $mentorId = $this->getMUserId();
        $this->layout()->setTemplate('layout/master');
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select("SUM(IFELSE(u.stage='win',1,0)) AS win,SUM(IFELSE(u.stage='build',1,0)) AS build,SUM(IFELSE(u.stage='send',1,0)) AS send")
            ->from('SamUser\Entity\Users', 'u')
            ->andWhere('u.mentor_id = (:mentor_id)')
            ->groupBy('u.mentor_id')
            ->setParameter('mentor_id', $mentorId);

        $stageData = $queryBuilder->getQuery()->getScalarResult();


        return new ViewModel(array(

            'messagesdata' => $this->messagingDetail($mentorId),
            'schedules' => $this->scheduleDetail($mentorId),
            'news' => $this->newsDetail(),
            'testimonials' => $this->testimonialsDetail($mentorId),
            'disciples' => $this->getEntityManager()->getRepository('SamUser\Entity\Disciplescount')->findBy(array('user_id' => $mentorId)),
            'stage' => $stageData,
            'Url' => '/',
            'title' => 'Your Dashboard',
        ));


    }

    /**
     * Function to get news Detail
     * @param NA
     * @author Alvin.Abhinav
     */
    public function newsDetail()
    {
        $country = $this->userCountry();
        $news = array();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select("u.id,u.title,u.description,u.country,u.created,u.image")
            ->from('News\Entity\News', 'u')
            ->andWhere('u.status=1')
            ->andWhere('REGEXP(u.country, :regexp) = true')
            ->orderBy('u.created', 'DESC')
            ->setParameter('regexp', '(^|,)(' . $country . ')(,|$)');
        $news = $queryBuilder->getQuery()->getResult();
        return ($news);


    }

    /**
     * Function to get messagingDetail
     * @param NA
     * @author Alvin.Abhinav
     */
    public function messagingDetail($userid)
    {

        $messagesBuilder = $this->getEntityManager()->createQueryBuilder();
        $messagesBuilder->select("m.id,m.subject,m.description,m.created,u.displayName,u.picture,m.status ")->from('Messaging\Entity\Messaging', 'm')
            ->leftJoin('SamUser\Entity\Users u', 'WITH m.user_id=u.id')
            ->andWhere('m.sender_id = (:userid)')
            ->addOrderBy('m.created', 'DESC')
            ->setMaxResults(3)
            ->setParameter('userid', $userid);

        $messagesData = array();
        $messages = array();
        $messages = $messagesBuilder->getQuery()->getScalarResult();
        $countBuilder = $this->getEntityManager()->createQueryBuilder();
        $countBuilder->select("COUNT(m.status) ")
            ->from('Messaging\Entity\Messaging', 'm')
            ->andWhere('m.sender_id = (:userid)')
            ->andWhere('m.status = 1')
            ->setParameter('userid', $userid);
        $messagesCount = $countBuilder->getQuery()->getSingleScalarResult();
        $messagesData['messages'] = $messages;
        $messagesData['messagesCount'] = $messagesCount;
        return ($messagesData);


    }

    /**
     * Function to get scheduleDetail
     * @param NA
     * @author Alvin.Abhinav
     */
    public function scheduleDetail($userid)
    {

        $schedulesBuilder = $this->getEntityManager()->createQueryBuilder();
        $schedulesBuilder->select("s.id,s.description,s.created,s.name,s.time")->from('Schedules\Entity\Schedule', 's')->andWhere('s.user_Id = (:userid)')
            ->addOrderBy('s.created', 'DESC')
            ->setMaxResults(3)
            ->setParameter('userid', $userid);
        $schedules = $schedulesBuilder->getQuery()->getScalarResult();

        return ($schedules);


    }

    /**
     * Function to get testimonialsDetail
     * @param NA
     * @author Alvin.Abhinav
     */
    public function testimonialsDetail()
    {
        $country = $this->userCountry();
        $em = $this->getEntityManager();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select("t.description,t.created,u.displayName,u.picture")
            ->from('Testimonial\Entity\Testimonial', 't')
            ->leftJoin('SamUser\Entity\Users u', 'WITH t.user_id=u.id')
            ->andWhere('t.status = 1')
            ->andWhere('u.country = (:country)')
            ->addOrderBy('t.created', 'DESC')
            ->setMaxResults(3)
            ->setParameter('country', $country)
            ->setMaxResults(10);

        $testimonials = array();
        $testimonials = $queryBuilder->getQuery()->getScalarResult();

        return ($testimonials);


    }

    /**
     * Function to get userCountry
     * @param NA
     * @author Alvin.Abhinav
     */
    public function userCountry()
    {
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            $country = $this->zfcUserAuthentication()->getIdentity()->country;
        }
        return $country;
    }


}