<?php
/**
 * Created by PhpStorm.
 * User: Sami
 * Date: 10/24/15
 * Time: 10:04 PM
 */

namespace SamUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SamUser\Entity\Users;
use SamUser\Form\UsersForm;
use Doctrine\ORM\EntityManager;
use Zend\Mail;

class DashboardController  extends AbstractActionController
{
   
     function __construct() {
       
   }
   
    protected $em;
    public $userid;

    public function getMUserId()
    {
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            //get the user_id of the user
            $this->userid = $this->zfcUserAuthentication()->getIdentity()->getId();
        }
        return $this->userid;
    }

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }
    // add disciple
    Public function indexAction()
    {
        $this->layout()->setTemplate('layout/master');  
        $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findAll( );
        $countriesData=array();
        foreach($countries as $country ){
        $countriesData[$country->id]=$country->name;    
        } 
        return new ViewModel(array(
            'users' => $this->getEntityManager()->getRepository('SamUser\Entity\User')->findBy(array('mentor_id' => $this ->userid )),
            'countries'=>$countriesData,
            'Url' => '/',
            'title' => 'Your Dashboard',
        ));


    }
//    Add Disiple
    Public function adddiscipleAction()
    {
        $this->layout()->setTemplate('layout/master');   
        $form = new UsersForm();
      
        $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findAll( );
        $ValueOptions=array();
        foreach($countries as $country ){
        $ValueOptions[$country->id]=$country->name;    
        }
        
              
        $form->get('country_id')->setValueOptions($ValueOptions);
        $form->get('submit')->setValue('Add');
        $request = $this->getRequest();
        if ($request->isPost()) {
              $Users = new Users();
             $form->setInputFilter($Users->getInputFilter());
             
           
             $post = array_merge_recursive(
            $request->getPost()->toArray(),
            $request->getFiles()->toArray()
        );

              $form->setData($request->getPost());
             
                         
               if ($form->isValid()) {
                $Users->exchangeArray($form->getData());
                $this->getEntityManager()->persist($Users);
                $this->getEntityManager()->flush();
                // Redirect to list of dashboard
                return $this->redirect()->toRoute('dashboard');
              }                
               
          }
        
        $view = new ViewModel(array(
            'Url' => '/',
            'form' => $form,
            'title' => 'Add Disciples',
        ));
        return $view;

    }
    
    //    Add Disiple
    Public function contactusAction()
    {
      
     $request = $this->getRequest();
     if ($request->isPost()) {
     $dataArray= $request->getPost();
       // print('<pre>');
     // print_r($dataArray);
    ///echo $dataArray['txtname'];
    $body="sadfafsafadfafdfad";
    $mail = new Mail\Message();
    $mail->addFrom('alvin.abhinav@ithands.net');
    $mail->addTo('abhinav.dobhal@gmail.com');
    $mail->setSubject('test email ');
    $mail->setBody($body);
    $mail->setEncoding('UTF-8');
  //  $mail->send(); 
    echo 1;
    die;
    
     }
    
    echo 0;  
      die;
     
  

    }
   
    //edit user info
    Public function editAction()
    {
     
     $id = (int) $this->params()->fromRoute('id', 0);
      if (!$id) {
            return $this->redirect()->toRoute('dashboard/adddisciple');
        } 
     
        $user = $this->getEntityManager()->find('SamUser\Entity\Users', $id);
        
      if (!$user) {
            return $this->redirect()->toRoute('dashboard');
        }



       $form = new UsersForm();
        $form->bind($user);
        $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findAll( );
        $ValueOptions=array();
        foreach($countries as $country ){
        $ValueOptions[$country->id]=$country->name;    
        }
         $form->get('country_id')->setValueOptions($ValueOptions)->setValue($user->country_id) ;
         $form->get('gender')->setValue($user->gender) ;
         $form->get('submit')->setAttribute('value', 'Edit');
        
         $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getEntityManager()->flush();

                // Redirect to list of dashboard
                return $this->redirect()->toRoute('dashboard');
            }
        }
        
        
        
        
         $this->layout()->setTemplate('layout/master');   
        $view = new ViewModel(array(
            'Url' => '/',
            'title' => 'Update Your Information',
             'id' => $id,
            'form' => $form,
        ));
        return $view;
    }
    
  
    
}