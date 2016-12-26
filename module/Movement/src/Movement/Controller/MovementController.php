<?php
/**
 * Disciples
 * This module will be used for Movement
 *@package controller
 *@author Abhinav
 */

namespace Movement\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Movement\Entity\Answers;
use Movement\Entity\Questions;
use Movement\Entity\Categories;
use Movement\Form\QuestionForm;
use Zend\Session\Container;

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
 protected function getuserCountryids() {
      $userCountryids=array();
      $session = new Container('userCountryids');
      if($session->offsetExists('countryids')){
	     $userCountryids= $session->offsetGet('countryids');
	     }
      
        return $userCountryids;
     }
/**
* Index action displays a list of all the albums
* @return \Zend\View\Model\ViewModel
*/
public function indexAction()
{
$this->layout()->setTemplate('layout/master');  
  $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findAll( );
   $userCountryids=$this->getuserCountryids();
  
       $countriesData=array();
        foreach($countries as $country ){
        $countriesData[$country->id]=$country->name;    
        } 

    $queryBuilder = $this->getEntityManager()->createQueryBuilder();
    $queryBuilder->select("q.id,c.name as category,c.parent,q.question,q.mandatory,q.default_question,q.country")
        ->from('Movement\Entity\Questions', 'q')
        ->innerJoin('Movement\Entity\Categories c', 'WITH c.id = q.category')
        ->andWhere('q.country in (:country)')
        ->orderBy('q.created','DESC')
        ->setParameter('country', $userCountryids);
    $questions = $queryBuilder->getQuery()->getResult();
    for($a = 0 ; $a<count($questions);$a++) {
        if($questions[$a]['parent'] > 0) {
            $q = $this->getEntityManager()->find('Movement\Entity\Categories', $questions[$a]['parent']);
            $questions[$a]['folder'] = $questions[$a]['category'];
            $questions[$a]['category'] = $q->name;     
        }
    }
    //print_r($questions);die();
return new ViewModel(
array(
'countries'=>$countriesData,
'questions' => $questions ));

}
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


        $categories=$this->getEntityManager()->getRepository('Movement\Entity\Categories')->findBy(array('parent'=>0),array('id' => 'ASC') );
        foreach($categories as $category ){
          $CategoriesOptions[$category->id]=$category->name;    
        }
         $form->get('category')->setValueOptions($CategoriesOptions);
        //print_r($CategoriesOptions);die();

       // $form->get('submit')->setValue('Add');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $question = new Questions();
            $form->setInputFilter($question->getInputFilter());
            $form->setData($request->getPost());
           
            
            if ($form->isValid()) {
              
                $formdata = $form->getData();
                $question->populate($formdata);
                $question->category = $this->AddCategory($formdata['subcategory'],$formdata['category']);
                $this->getEntityManager()->persist($question);
                $this->getEntityManager()->flush();
                   $session = new Container('message');
	    $session->success = 'Data saved successfully';
                // Redirect to list of movement
                return $this->redirect()->toRoute('movement');
            }
        }
        return array('form' => $form, );
    }

    public function subcategoriesAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        $categories=$this->getEntityManager()->getRepository('Movement\Entity\Categories')->findBy(array('parent'=>$id),array('name' => 'ASC') );
        $CategoriesOptions = array();
        foreach($categories as $category ){
          $CategoriesOptions[] = array('id' => $category->id, 'text' => $category->name);    
        }

        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
        $response->setContent(json_encode($CategoriesOptions));
        return $response;

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

          $categories=$this->getEntityManager()->getRepository('Movement\Entity\Categories')->findBy(array(),array('id' => 'ASC') );
          $movement->subcategory = 0;
          foreach($categories as $category ){
            if($category->parent == 0) {
              $CategoriesOptions[$category->id]=$category->name;
            }
            if($movement->category == $category->id) {
              if($category->parent != 0) {
                $movement->category = $category->parent;
                $movement->subcategory = $category->id;
              }
            }    
          }
        $form  = new QuestionForm();
        $form->bind($movement);
        $form->get('category')->setValueOptions($CategoriesOptions)->setValue($movement->category);
       
        
        $form->get('country')->setValueOptions($ValueOptions)->setValue($movement->country) ;
        //$form->get('category')->setValue($movement->category) ;
        $form->get('mandatory')->setValue($movement->mandatory) ;
        
      //  $form->get('submit')->setAttribute('value', 'Edit');
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setInputFilter($movement->getInputFilter());
            $postdata = $request->getPost();
            $form->setData($postdata);
            if ($form->isValid()) {
                $form->bindValues();
                $movement->category = $this->AddCategory($postdata['subcategory'],$movement->category);
                $this->getEntityManager()->flush();
                 $session = new Container('message');
	    $session->success = 'Data saved successfully';
      
                // Redirect to list of albums
                return $this->redirect()->toRoute('movement');
            }
        }
        return array(
            'id' => $id,
            'form' => $form,
        );
    }

protected function AddCategory($subcat,$parent) {
  //echo $subcat . ' space ' . $parent;die();
    if($subcat == "" || $subcat == "0") {
      return $parent;
    } else {
      if((int)$subcat > 0) {
        return $subcat;
      } else {
        $subcat = substr($subcat,2);
      }
    }

    $category = new Categories();
    $category->name = $subcat;
    $category->parent = $parent;
    $category->status = 1;
    //$category->created = date('Y-m-d H:i:s');
    $this->getEntityManager()->persist($category);
    $this->getEntityManager()->flush();
    return $category->id;
}

public function deleteAction(){
     $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('movement');
        }
       $movement = $this->getEntityManager()->find('Movement\Entity\Questions', $id);    
       $this->getEntityManager()->remove($movement);
        $this->getEntityManager()->flush();
        $session = new Container('message');
	   $session->success = ' Deleted successfully';
      
         return $this->redirect()->toRoute('movement');
}


public function questiondetailAction() {

$id = (int) $this->params()->fromRoute('id', 0);
$qid = (int) $this->params()->fromRoute('qid', 0);

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
$stage = strtolower($stage);
switch($stage){
  case 'win':
    $stage='WIN';
    break;
  case 'build':
    $stage='BUILD';
    break;
  case 'send':
    $stage='SEND';
    break;
  case 'complete':
    return $this->redirect()->toRoute('dashboard');
    break;
  default:
    $stage='WIN';
}

$parent =  $this->getEntityManager()->getRepository('Movement\Entity\Categories')->findBy(array('name' => $stage ));
$parentCat = $parent[0]->id;

$categories =$this->getEntityManager()
->getRepository('Movement\Entity\Categories')
->findBy(array('parent' => $parentCat )); 

$catArray = array();
$catArray[] = $parentCat;
foreach($categories as $cat) {
  $catArray[] = $cat->id;
} 


$questions =$this->getEntityManager()
->getRepository('Movement\Entity\Questions')
->findBy(array('category' => $catArray ,'country'=>$user->country ),array('category'=>'ASC')); 
if(!count($questions)){
$questions =$this->getEntityManager()
->getRepository('Movement\Entity\Questions')
->findBy(array('category' => $stage ,'default_question'=>1 ),array('category'=>'ASC')); 
  
}

$a = 0;
$questionid = 0;
foreach ($questions as $question) {
  if($question->id == $qid) {
    $questionid = $a;
  }
  $answer =  $this->getEntityManager()->getRepository('Movement\Entity\Answers')->findBy(
                                                            array('user_id' => $id, 'question_id' => $question->id, 
                                                            'country' => $question->country ),
                                                            array('id'=>'DESC'));
  $questions[$a++]->answer = $answer;
}

//print_r($questions);die();

$this->layout()->setTemplate('layout/master');  


return new ViewModel(
array( 'questions' =>$questions,'country'=>$user->country,'disciple_id'=>$user->id,'stage'=>$stage,'userid'=>$id,'questionid'=>$questionid ));

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
$stage = strtolower($stage);
switch($stage){
  case 'win':
    $stage='WIN';
    break;
  case 'build':
    $stage='BUILD';
    break;
  case 'send':
    $stage='SEND';
    break;
  case 'complete':
    return $this->redirect()->toRoute('dashboard');
    break;
  default:
    $stage='WIN';
}

$parent =  $this->getEntityManager()->getRepository('Movement\Entity\Categories')->findBy(array('name' => $stage ));
$parentCat = $parent[0]->id;

$categories =$this->getEntityManager()
->getRepository('Movement\Entity\Categories')
->findBy(array('parent' => $parentCat )); 

$catArray = array();
$catArray[] = $parentCat;
foreach($categories as $cat) {
  $catArray[] = $cat->id;
} 

$questions = array();
$a = 0;
foreach($catArray as $cat) {
  
  $queryBuilder = $this->getEntityManager()->createQueryBuilder();
  $queryBuilder->select("q.id,q.question,q.description,q.mandatory,q.type,
        q.default_question,q.country,q.created,c.id as catid, c.name as category,c.parent")
      ->from('Movement\Entity\Questions', 'q')
      ->innerJoin('Movement\Entity\Categories c', 'WITH c.id = q.category')
      ->andWhere('c.id in (:category)')
      ->andWhere('q.country in (:country)')
      ->orderBy('c.id','ASC')
      ->setParameter('category', $cat)
      ->setParameter('country', $user->country);
  $q = $queryBuilder->getQuery()->getResult();

  if(!count($q)){
    $default = $this->getEntityManager()->createQueryBuilder();
    $default->select("q.id,q.question,q.description,q.mandatory,q.type,
        q.default_question,q.country,q.created,c.id as catid, c.name as category,c.parent")
      ->from('Movement\Entity\Questions', 'q')
      ->innerJoin('Movement\Entity\Categories c', 'WITH c.id = q.category')
      ->andWhere('c.id in (:category)')
      ->andWhere('q.default_question = 1')
      ->orderBy('c.id','ASC')
      ->setParameter('category', $cat);
    $q = $default->getQuery()->getResult();
  }
  if(count($q)) {
    $questions[$a]['questions'] = $q;
    $questions[$a]['category'] = $cat;
    $questions[$a]['parent'] = $questions[$a]['questions'][0]['parent'];
    $questions[$a]['foldername'] = $questions[$a]['questions'][0]['category'];
    $a++;
  }
  
}

///if answers are posted
$request = $this->getRequest();
if($request->isPost() && count($questions)) {
  $postdata = $request->getPost();
  $proceedToNextStage = true;
  for($a = 0 ; $a < count($questions);$a++) {
    for($b = 0; $b < count($questions[$a]['questions']);$b++) {
      $q = $questions[$a]['questions'][$b];

      $field = 'answer' . $q['id'];
      if(isset($postdata->$field)) {
          //echo $postdata->$field;
          if($q['type'] == "NUMBER" && $postdata->$field <= 0) {
            $proceedToNextStage = false;
            continue;
          }

          //delete last answer with empty notes
          $prev_ans = $this->getEntityManager()->getRepository('Movement\Entity\Answers')->
                      findBy(array('question_id' => $q['id'] , 'user_id' => $id ,'country' => $user->country,
                        'stage'=>$stage,'notes'=>''));
          if(count($prev_ans)) {    
            $this->getEntityManager()->remove($prev_ans[0]);
            $this->getEntityManager()->flush();
          }
          /////

          ///save answer
          $ans = new Answers();
          $ans->user_id=$id;
          $ans->question_id=$q['id'];
          $ans->answer= $postdata->$field; 
          $ans->notes="";
          $ans->country=$user->country;
          $ans->stage=$stage;
          $this->getEntityManager()->persist($ans);

      } elseif($q['mandatory'] == 1) {
        $proceedToNextStage = false;
      }

    }
  }
  $this->getEntityManager()->flush();

  if($proceedToNextStage) {
        $user = $this->getEntityManager()->find('SamUser\Entity\Users', $id );
        $stage = strtolower($stage);
        switch($stage){
          case 'win':
            $stage='BUILD';
            break;
          case 'build':
            $stage='SEND';
            break;
          case 'send':
            $stage='COMPLETE';
            break;
          default:
            $stage='WIN';
        }

        $user->stage=$stage;
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
  }
  $this->redirect()->toRoute('disciples');
  //print_r($questions);
  //print_r($postdata);die();
}

//get last answers
for($a = 0 ; $a < count($questions);$a++) {
    for($b = 0; $b < count($questions[$a]['questions']);$b++) {
      $q = $questions[$a]['questions'][$b];
      $answer =  $this->getEntityManager()->getRepository('Movement\Entity\Answers')->findBy(
                                                            array('user_id' => $id, 'question_id' => $q['id'], 
                                                            'country' => $q['country'] ),
                                                            array('id'=>'DESC'),1);
      if(count($answer)) {
        $questions[$a]['questions'][$b]['answer'] = $answer[0]->answer;
      }
    }
}

$this->layout()->setTemplate('layout/master');


return new ViewModel(
array( 'questions' =>$questions,'country'=>$user->country,'disciple_id'=>$user->id,'stage'=>$stage,'userid'=>$id ));

}

public function savenotesAction() {
    $request = $this->getRequest();
    //print_r($request->getPost('answersdata'));die();
    $answersData=$request->getPost('answerdata');  
    
    list($questionid ,$radioInline,$numberInline,$notes ,$country,$stage,$userid) = explode("#",$answersData);

    $ans = new Answers();
    $ans->user_id=$userid;
    $ans->question_id=$questionid;
    if((int)$numberInline > 0) {
        $ans->answer = (int)$numberInline;
    } elseif($radioInline){
        $ans->answer='yes';     
    } else {
       $ans->answer='no';    
    }
    $ans->notes=$notes;
    $ans->country=$country;
    $ans->stage=$stage;

    $this->getEntityManager()->persist($ans);
    $this->getEntityManager()->flush();

    $datetime = new \DateTime(date('Y-m-d H:i:s'));

    echo '<tr><td class="col-md-6">' . $notes  . '<span class="dl-note-info"><i class="fa fa-calendar-o" aria-hidden="true"></i>' . substr($datetime->format("r"),0,16) . '&nbsp;&nbsp;<i class="fa fa-clock-o" aria-hidden="true"></i>' . $datetime->format("H:i a") . '</span></td><td class="col-md-6 dl-notes-response"><h4>Answer - <span class="dl-response-result">' . $ans->answer . '</span></h4></td></tr>';
    die();
}


public function localbuildAction(){
    
   $request = $this->getRequest();
   //print_r($request->getPost('answersdata'));die();
   if ($request->isPost()) {
      $flagSave=$request->getPost('flagsave');  
      if($flagSave){
           
           
        $answersData=$request->getPost('answersdata');  
        foreach($answersData as $answers ){

          list($questionid ,$radioInline,$numberInline,$notes ,$country,$stage,$userid) =explode("#",$answers);

          $ans = new Answers();
          $ans->user_id=$userid;
          $ans->question_id=$questionid;
          if((int)$numberInline > 0) {
              $ans->answer = (int)$numberInline;
          } elseif($radioInline){
              $ans->answer='yes';     
          } else {
             $ans->answer='no';    
          }
          $ans->notes=$notes;
          $ans->country=$country;
          $ans->stage=$stage;
          $this->getEntityManager()->persist($ans);
          

        }
        $this->getEntityManager()->flush();
        
        //switch user to next stage
        $user = $this->getEntityManager()->find('SamUser\Entity\Users', $userid );
        $stage = strtolower($stage);
        switch($stage){
          case 'win':
            $stage='BUILD';
            break;
          case 'build':
            $stage='SEND';
            break;
          case 'send':
            $stage='COMPLETE';
            break;
          default:
            $stage='WIN';
        }

        $user->stage=$stage;
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
          
      }
  }
   //  $viewModel = new ViewModel();
   //$viewModel->setTerminal(true);
   echo $flagSave;
   die;
   //return $viewModel;
    
}


}