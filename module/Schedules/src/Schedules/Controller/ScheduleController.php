<?php
namespace Schedules\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Schedules\Entity\Schedule;
use Schedules\Form\ScheduleForm;

class ScheduleController extends AbstractActionController
{
/**   
* Entity manager instance
* @var Doctrine\ORM\EntityManager
*/                
protected $em;

/**
* Returns an instance of the Doctrine entity manager loaded from the service 
* locator
* @return Doctrine\ORM\EntityManager
*/
public function getEntityManager()
{
if (null === $this->em) {
$this->em = $this->getServiceLocator()
->get('doctrine.entitymanager.orm_default');
}
return $this->em;
}
public function getUserId(){
	
	 if ($this->zfcUserAuthentication()->hasIdentity()) {
            //get the user_id of the user
            $userid = $this->zfcUserAuthentication()->getIdentity()->getId();
        }
        return $userid;
}



/**
* Index action displays a list of all the albums
* @return \Zend\View\Model\ViewModel
*/
public function indexAction()
{
$this->layout()->setTemplate('layout/master');  
$schedule=$this->getEntityManager()->getRepository('Schedules\Entity\Schedule')->findBy(array('user_Id' => $this->getUserId() ));

  
  
return new ViewModel(
array(
'schedules'=>$schedule
 ));

}


public function addAction()
{
        $this->layout()->setTemplate('layout/master');  
        $form = new ScheduleForm();
        $users=$this->getEntityManager()->getRepository('SamUser\Entity\Users')->findBy(array('mentor_id' => $this->getUserId()) );
        $usersData=array();
        foreach($users as $user ){
        $usersData[$user->id.'#'.$user->phone_no.'#'.$user->displayName]=$user->displayName;    
        } 
        
        $form->get('userdetail')->setValueOptions($usersData) ;
     //   $form->get('user_Id')->setValue($this->getUserId());
        $form->get('submit')->setValue('Save');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $schedule = new Schedule();
            $form->setInputFilter($schedule->getInputFilter());
             $Userdetail =  $request->getPost('userdetail');
             $dateVal=$request->getPost('txtdate');
             $timeVal=$request->getPost('txttime');
         
            $data=array();
           list($data['user_Id'],$data['disciple_phone'],$data['name'])=explode('#',$Userdetail);
          $data['time']=$dateVal." ".$timeVal;  
         $temp=$this->getRequest()->getPost()->toArray();
          unset($temp['userdetail']);
          unset($temp['txtdate']);
          unset($temp['txttime']);
            $data['user_Id']=$this->getUserId();
             $datatemp = array_merge(
               $temp
               ,
                // Notice: make certain to merge the Files also to the post data
               $data
               );   
                       
            $form->setData($request->getPost());
          if ($form->isValid()) {
                          
                $schedule->populate($datatemp);
                $this->getEntityManager()->persist($schedule);
                $this->getEntityManager()->flush();
                // Redirect to list of schedule
                return $this->redirect()->toRoute('schedule');
            }
        }
        
return new ViewModel(
array(
'form' => $form
 ));


    }

public function editAction()
{
          $this->layout()->setTemplate('layout/master');  
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
           return $this->redirect()->toRoute('schedule');
        }
        $schedule = $this->getEntityManager()->find('Schedules\Entity\Schedule', $id);
        
        $formUsers=$schedule->user_Id.'#'.$schedule->disciple_phone.'#'.$schedule->name;
              
        $form  = new ScheduleForm();
        $users=$this->getEntityManager()->getRepository('SamUser\Entity\Users')->findBy(array('mentor_id' => $this->getUserId()) );
        $usersData=array();
        foreach($users as $user ){
        $usersData[$user->id.'#'.$user->phone_no.'#'.$user->displayName]=$user->displayName;    
        } 
        
        $form->get('userdetail')->setValueOptions($usersData)->setValue($formUsers) ;
         $form->get('description')->setValue($schedule->description) ;
  
  			$datetime = date_create($schedule->time);
 			$date = date_format($datetime,"Y-m-d");
		 	$time = date_format($datetime,"H:i");
            $form->get('txtdate')->setValue($date) ;
            $form->get('txttime')->setValue($time) ;     
  
        
        $form->get('submit')->setAttribute('value', 'Save');
        $request = $this->getRequest();
        
        
        if ($request->isPost()) {
            
                       $Userdetail =  $request->getPost('userdetail');
             $dateVal=$request->getPost('txtdate');
             $timeVal=$request->getPost('txttime');
         
            $data=array();
           list($data['user_Id'],$data['disciple_phone'],$data['name'])=explode('#',$Userdetail);
          $data['time']=$dateVal." ".$timeVal;  
           $data['user_Id']=$this->getUserId();
         $temp=$this->getRequest()->getPost()->toArray();
          unset($temp['userdetail']);
          unset($temp['txtdate']);
          unset($temp['txttime']);
             $datatemp = array_merge(
               $temp
               ,
                // Notice: make certain to merge the Files also to the post data
               $data
               );   
                       
  
            $form->setInputFilter($schedule->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
              
              
              $schedule->populate($datatemp);
                $this->getEntityManager()->persist($schedule);
                $this->getEntityManager()->flush();
               
               // $form->bindValues();
              //  $this->getEntityManager()->flush();
                // Redirect to list of albums
              return $this->redirect()->toRoute('schedule');
            }
        }
        
return new ViewModel(
array(
'form' => $form,
'id' => $id
 ));
    }

public function deleteAction(){
     $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('learn', array(
                'action' => 'add'
            ));
        }
       $schedule = $this->getEntityManager()->find('Schedules\Entity\Schedule', $id);    
       $this->getEntityManager()->remove($schedule);
        $this->getEntityManager()->flush();
               return $this->redirect()->toRoute('schedule');
}






}