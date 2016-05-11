<?php
namespace Movement\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Movement\Entity\Answers;
use Movement\Entity\Questions;
use Movement\Form\QuestionForm;

class MovementController extends AbstractActionController
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

/**
* Index action displays a list of all the albums
* @return \Zend\View\Model\ViewModel
*/
public function indexAction()
{
$this->layout()->setTemplate('layout/master');  
  $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findAll( );
 
  
       $countriesData=array();
        foreach($countries as $country ){
        $countriesData[$country->id]=$country->name;    
        } 

return new ViewModel(
array(
'countries'=>$countriesData,
'questions' => $this->getEntityManager()->getRepository('Movement\Entity\Questions')->findAll() ));

}
public function addAction()
{
         $this->layout()->setTemplate('layout/master');  
         $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findAll( );
        $ValueOptions=array();
        foreach($countries as $country ){
        $ValueOptions[$country->id]=$country->name;    
        }
          
        $form = new QuestionForm();
        $form->get('country')->setValueOptions($ValueOptions);
        $form->get('submit')->setValue('Add');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $question = new Questions();
            $form->setInputFilter($question->getInputFilter());
            $form->setData($request->getPost());
           
            
            if ($form->isValid()) {
              
              
                $question->populate($form->getData());
                $this->getEntityManager()->persist($question);
                $this->getEntityManager()->flush();
                // Redirect to list of movement
                return $this->redirect()->toRoute('movement');
            }
        }
        return array('form' => $form, );
    }

public function editAction()
{
          $this->layout()->setTemplate('layout/master');  
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('movement', array(
                'action' => 'add'
            ));
        }
        $movement = $this->getEntityManager()->find('Movement\Entity\Questions', $id);
        $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findAll( );
        $ValueOptions=array();
        foreach($countries as $country ){
        $ValueOptions[$country->id]=$country->name;    
        }
       
        $form  = new QuestionForm();
        $form->bind($movement);
        $form->get('country')->setValueOptions($ValueOptions)->setValue($movement->country) ;
        $form->get('category')->setValue($movement->category) ;
        $form->get('mandatory')->setValue($movement->mandatory) ;
        
        $form->get('submit')->setAttribute('value', 'Edit');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($movement->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();
                // Redirect to list of albums
                return $this->redirect()->toRoute('movement');
            }
        }
        return array(
            'id' => $id,
            'form' => $form,
        );
    }


public function deleteAction(){
     $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('movement');
        }
       $movement = $this->getEntityManager()->find('Movement\Entity\Questions', $id);    
       $this->getEntityManager()->remove($movement);
        $this->getEntityManager()->flush();
       
         return $this->redirect()->toRoute('movement');
}


public function questionAction()
{
$id = (int) $this->params()->fromRoute('id', 0);
if (!$id) {
return $this->redirect()->toRoute('dashboard');
  }
$user = $this->getEntityManager()->find('SamUser\Entity\Users', $id);
if (!count($user)) {
    return $this->redirect()->toRoute('dashboard');
    }
$stage=trim($user->stage);
if (!count($user)) {
    return $this->redirect()->toRoute('dashboard');
    }
switch($stage){
    case 'WIN':
    case 'win':
    $stage='BUILD';
    break;
   case 'BUILD':
   case 'build':
    $stage='SEND';
    break;
   case 'SEND':
   case 'send':
    return $this->redirect()->toRoute('dashboard');
    break;
   default:
    $stage='WIN';
}

  
$questions =$this->getEntityManager()
->getRepository('Movement\Entity\Questions')
->findBy(array('category' => $stage ,'country'=>$user->country )); 

if(!count($questions)){
$questions =$this->getEntityManager()
->getRepository('Movement\Entity\Questions')
->findBy(array('category' => $stage ,'default_question'=>1 )); 
  
}

$this->layout()->setTemplate('layout/master');  



return new ViewModel(
array( 'questions' =>$questions,'country'=>$user->country,'disciple_id'=>$user->id,'stage'=>$stage,'userid'=>$id ));

}
public function localbuildAction(){
    
   $request = $this->getRequest();
   if ($request->isPost()) {
       $flagSave=$request->getPost('flagsave');  
       if($flagSave){
           
           
        $answersData=$request->getPost('answersdata');  
        foreach($answersData as $answers ){
       
         list($questionid ,$radioInline ,$country,$stage,$userid) =explode("#",$answers);
       
             $answers = new Answers();
             $answers->user_id=$userid;
             $answers->question_id=$questionid;
             if($radioInline){
             $answers->answer='yes';     
             }else{
             $answers->answer='no';    
             }
             $answers->country=$country;
             $answers->stage=$stage;
             $this->getEntityManager()->persist($answers);
            

       }
         $this->getEntityManager()->flush();
       
        $user = $this->getEntityManager()->find('SamUser\Entity\Users', $userid );
        $user->stage=strtoupper($stage);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
            
       }
       
           
           }
   
  //  $viewModel = new ViewModel();
   //$viewModel->setTerminal(true);
   echo '1';
   die;
   //return $viewModel;
    
}


}