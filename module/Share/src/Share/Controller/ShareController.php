<?php

/**
 * Share
 * This module will be used for Share
 *@package controller
 *@author Abhinav
 */
namespace Share\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Share\Entity\Answers;
use Share\Entity\Questions;
use Schedules\Entity\Schedule;
use Share\Form\QuestionForm;
use Zend\Session\Container;
use Zend\Stdlib\DateTime;
class ShareController extends AbstractActionController
{
/**   
* Entity manager instance
* @var Doctrine\ORM\EntityManager
*/                
protected $em;

    /**
     * Function to getuserCountryids
     * @param NA
     * @author Abhinav
     */
protected function getuserCountryids() {
      $userCountryids=array();
      $session = new Container('userCountryids');
      if($session->offsetExists('countryids')){
	     $userCountryids= $session->offsetGet('countryids');
	     }
      
        return $userCountryids;
     }
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
    /**
     * Function to ishare Action to display ishare
     * @param NA
     * @author Abhinav
     */
public function ishareAction()
{
    
$this->layout()->setTemplate('layout/master');  
  
   $userCountryids=$this->getuserCountryids();
   $whereData=array();
   if(count($userCountryids)){
      $whereData= array('country'=>$userCountryids);
   }
  
  $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findAll( );
        $countriesData=array();
        foreach($countries as $country ){
        $countriesData[$country->id]=$country->name;    
        } 

return new ViewModel(
array(
'countries'=>$countriesData,
'questions' => $this->getEntityManager()->getRepository('Share\Entity\Questions')->findBy($whereData,array('created' => 'DESC')) ));

}

    /**
     * Function to index Action to display ishare question
     * @param NA
     * @author Abhinav
     */
public function indexAction()
{
    $id = (int) $this->params()->fromRoute('id', 0);
     if(!$id) {
           $stageShare=1;    
        }else{
            $stageShare=$id;
        }
  
   if ($this->zfcUserAuthentication()->hasIdentity()) {
          $userid = $this->zfcUserAuthentication()->getIdentity()->id;
           $country = $this->zfcUserAuthentication()->getIdentity()->country; 
           $userPhone=$this->zfcUserAuthentication()->getIdentity()->phone_no;

        
        }

    switch($stageShare){
      case 2 :
      $stageSharetext='BUILD';
     break;
      case 3 :
      $stageSharetext='SEND';
       break;
      default :
       $stageSharetext='WIN'; 
        
    }
 
$this->layout()->setTemplate('layout/master');  
$questions=$this->getEntityManager()->getRepository('Share\Entity\Questions')->findBy(array('country'=>$country,'category'=>$stageSharetext),array('created' => 'DESC'));
if(!$questions){
$questions=$this->getEntityManager()->getRepository('Share\Entity\Questions')->findBy(array('default_question'=>1,'category'=>$stageSharetext),array('created' => 'DESC'));
    
}
$userAnswer= $this->getEntityManager()->getRepository('Share\Entity\Answers')->findBy(array('user_id'=>$userid,'stage'=>$stageSharetext),array('created' => 'DESC'));
 $answerData=array();
  foreach($userAnswer as $answer){
    $answerData[$answer->report_form_id]=$answer->value;     
  }
  
  
   
       $request = $this->getRequest();
        if ($request->isPost()) {
         
       
       $userPostAnswers=$request->getPost('box');
       foreach($userPostAnswers as $key=>$userPostAnswer ){
              
            $answersupdate= $this->getEntityManager()->getRepository('Share\Entity\Answers')->findOneBy(array('user_id'=>$userid,'report_form_id'=>$key));
             if($answersupdate){
                   $this->getEntityManager()->remove($answersupdate);
                   $this->getEntityManager()->flush();
             }
            
             $answersTable=new Answers();
             $answersTable->user_id=$userid;
             $answersTable->report_form_id=$key;
             $answersTable->value=$userPostAnswer;
               $answersTable->stage=$stageSharetext;
                 $answersTable->country=$country;
             $this->getEntityManager()->persist($answersTable);
             $this->getEntityManager()->flush();
       
       
       
       
        }
        
        $Schedule=new Schedule();
          $Schedule->user_Id=$userid;
          $Schedule->disciple_phone=$userPhone;
          $Schedule->name='Share Question';
          $Schedule->type='Normal';
          $Schedule->description='Update Share Question ';  
          $currentDate=new DateTime();
          $Schedule->time =date( "Y-m-d H:i:s", strtotime( "+10 days" ) ); ;
          $Schedule->recurring =0;
          $Schedule->created =$currentDate;
          $this->getEntityManager()->persist($Schedule);
          $this->getEntityManager()->flush();
       
           $session = new Container('message');
	            $session->success = 'Data saved successfully';
                // Redirect to list of Learningtools
                return $this->redirect()->toRoute('share',array(
                'action' => 'index', 'id'=>$stageShare
            ));
       
      
      
      }




return new ViewModel(
array(
 'sharetext'=>$stageSharetext,
 'share'=>$stageShare,
 'answerData'=>$answerData,
'questions' =>$questions ));

}

    /**
     * Function to add  Action to add ishare question
     * @param NA
     * @author Abhinav
     */
public function addAction()
{
         $this->layout()->setTemplate('layout/master');  
         $userCountryids=$this->getuserCountryids();
        $whereData=array();
    if(count($userCountryids)){
      $whereData= array('id'=>$userCountryids);
     }
        
     
        $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findBy($whereData,array('name' => 'ASC') );
         
         $ValueOptions=array();
          foreach($countries as $country ){
             $ValueOptions[$country->id]=$country->name;    
        }
          
        $form = new QuestionForm();
        $form->get('country')->setValueOptions($ValueOptions);
         $request = $this->getRequest();
        if ($request->isPost()) {
            $question = new Questions();
            $form->setInputFilter($question->getInputFilter());
            $form->setData($request->getPost());
           
            
            if ($form->isValid()) {
                           
                $question->populate($form->getData());
                $this->getEntityManager()->persist($question);
                $this->getEntityManager()->flush();
                   $session = new Container('message');
	    $session->success = 'Data saved successfully';
                // Redirect to list of movement
             
              return $this->redirect()->toRoute('share', array(
                'action' => 'ishare'
            ));
            
            }
        }
        return array('form' => $form, );
    }

    /**
     * Function to edit Action to edit ishare question
     * @param NA
     * @author Abhinav
     */
public function editAction()
{
          $this->layout()->setTemplate('layout/master');  
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('share', array(
                'action' => 'add'
            ));
        }
      
      $userCountryids=$this->getuserCountryids();
        $whereData=array();
    if(count($userCountryids)){
      $whereData= array('id'=>$userCountryids);
     }
        
     
        $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findBy($whereData,array('name' => 'ASC') );
      
        $share = $this->getEntityManager()->find('Share\Entity\Questions', $id);
      
        $ValueOptions=array();
        foreach($countries as $country ){
        $ValueOptions[$country->id]=$country->name;    
        }
       
        $form  = new QuestionForm();
        $form->bind($share);
        $form->get('country')->setValueOptions($ValueOptions)->setValue($share->country) ;
        $form->get('category')->setValue($share->category) ;
      
      //  $form->get('submit')->setAttribute('value', 'Edit');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($share->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();
                 $session = new Container('message');
	    $session->success = 'Data saved successfully';
                      return $this->redirect()->toRoute('share', array(
                'action' => 'ishare'
            ));
            }
        }
        return array(
            'id' => $id,
            'form' => $form,
        );
    }
    /**
     * Function to deleteAction to Delete ishare question
     * @param NA
     * @author Abhinav
     */
public function deleteAction(){
     $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('share');
        }
       $share = $this->getEntityManager()->find('Share\Entity\Questions', $id);    
       $this->getEntityManager()->remove($share);
        $this->getEntityManager()->flush();
        $session = new Container('message');
	   $session->success = ' Deleted successfully';
       return $this->redirect()->toRoute('share', array(
                'action' => 'ishare'
            ));
}


}