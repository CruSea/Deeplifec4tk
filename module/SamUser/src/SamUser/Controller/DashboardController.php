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
use Zend\Form\Form;

use SamUser\Form\UsersForm;
use Doctrine\ORM\EntityManager;
use Zend\Mail;
use DoctrineModule\Validator\NoObjectExists as NoObjectExistsValidator;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\Crypt\Password\Bcrypt;
class DashboardController  extends AbstractActionController
{
   
     function __construct() {
       
   }
   
    protected $em;
    public $userid;
    public $fileuploaderr=array('size'=>array('The image you tried to upload.it needs to be at min Width 100 and Max Width 300') ,'type'=>array('Please enter a value with a valid extension (jpg, gif, png) in Picture.') );

    public function getMUserId() {
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            //get the user_id of the user
            $this->userid = $this->zfcUserAuthentication()->getIdentity()->getId();
        }
        return $this->userid;
    }

    public function getEntityManager(){
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }
    
   
    
    // add disciple
Public function indexAction()  {
        
        
        $this->layout()->setTemplate('layout/master');  
        $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findAll( );
        $mentorId=$this->getMUserId();
        $countriesData=array();
        foreach($countries as $country ){
        $countriesData[$country->id]=$country->name;    
        } 
        
         $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select("SUM(IFELSE(u.stage='win',1,0)) AS win,SUM(IFELSE(u.stage='build',1,0)) AS build,SUM(IFELSE(u.stage='send',1,0)) AS send")   
         ->from('SamUser\Entity\Users', 'u')
             ->andWhere('u.mentor_id = (:mentor_id)')
           ->groupBy('u.mentor_id')
            ->setParameter('mentor_id', $mentorId);
  
        $stageData = $queryBuilder->getQuery()->getScalarResult();
     
       
     
     
        return new ViewModel(array(
            'users' => $this->getEntityManager()->getRepository('SamUser\Entity\Users')->findBy(array('mentor_id' => $mentorId ),array('created' => 'DESC')),
            'countries'=>$countriesData,
            'disciples'=>$this->getEntityManager()->getRepository('SamUser\Entity\Disciplescount')->findBy(array('user_id' => $mentorId )),
             'stage'=>$stageData,
            'Url' => '/',
            'title' => 'Your Dashboard',
        ));


    }
//    Add Disiple
Public function addAction()  {
       
        $this->layout()->setTemplate('layout/master');   
        $form = new UsersForm();
        $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findAll( );
        $ValueOptions=array();
        foreach($countries as $country ){
        $ValueOptions[$country->id]=$country->name;    
        }
        $emailValidator = new \DoctrineModule\Validator\ObjectExists(array(
        'object_repository' => $this->getEntityManager()->getRepository('SamUser\Entity\Users'),
    'fields' => array('email')));
        $phoneValidator = new \DoctrineModule\Validator\ObjectExists(array(
        'object_repository' => $this->getEntityManager()->getRepository('SamUser\Entity\Users'),
    'fields' => array('phone_no')));
          
             
        $form->get('country')->setValueOptions($ValueOptions);
        $form->get('mentor_id')->setValue($this->getMUserId());
        $form->get('stage')->setValue('Added');
        $form->get('password')->setValue('');
        $form->get('role_id')->setValue(1);
        
        $form->get('submit')->setValue('Save');
        $request = $this->getRequest();
        if ($request->isPost()) {
             
               $Users = new Users();
               $form->setInputFilter($Users->getInputFilter());
               $files   = $request->getFiles();
               $data =$this->getRequest()->getPost()->toArray() ;
              $form->setData($this->getRequest()->getPost());
              $uploadObj = new \Zend\File\Transfer\Adapter\Http(); 
              $uploadObj->setDestination(PUBLIC_PATH.'/img');
               unset($date['submit']);       
               if ($form->isValid()) {
                 $emailStatus=$emailValidator->isValid($data['email']);
                 $phoneStatus=$phoneValidator->isValid($data['phone_no']);
                 $flag=1;     
              
               $newImage =$files['picture']['name'];
              if(strlen($newImage))  {
                $validIsImage = new \Zend\Validator\File\IsImage();
             /* values here minWidth,minHeight,maxWidth,maxHeight   */
                $validImageSize = new \Zend\Validator\File\ImageSize(100, 100, 300,300 );
             if(!$validIsImage->isValid($files['picture'])){
              
              $form->get('picture')->setMessages($this->fileuploaderr['type']);  
                  $flag=0;
            
             }elseif(!$validImageSize->isValid($files['picture'])){
                  $form->get('picture')->setMessages($this->fileuploaderr['size']);  
                  $flag=0;
            
            }
             }
              
                 if($emailStatus){
       $form->get('email')->setMessages(array('An account with this email already exists'));                   $flag=0;
                 }
                 if($phoneStatus){
         $form->get('phone_no')->setMessages(array('This phone number already exists'));     
                 $flag=0;
                 }
                 
               if($flag){
              	  $uploadObj->receive();
                $temp=$uploadObj->getFileInfo();
                if(strlen($temp['picture']['name'])){
				 $data['picture']='/img/'.$temp['picture']['name'];		
				}else{
				$data['picture']='';	
				}
              
              
                $Users->exchangeArray($data);
                $this->getEntityManager()->persist($Users);
                $this->getEntityManager()->flush();
                // Redirect to list of dashboard
                return $this->redirect()->toRoute('dashboard');
               }
              }                
               
          }
        
        $view = new ViewModel(array(
            'Url' => '/',
            'form' => $form,
            'title' => 'Add Disciples',
        ));
        return $view;

    }
Public function editAction()  {
       
     $id = (int) $this->params()->fromRoute('id', 0);
      if (!$id) {
            return $this->redirect()->toRoute('dashboard/add');
        } 
     
        $user = $this->getEntityManager()->find('SamUser\Entity\Users', $id);
        
      if (!$user) {
            return $this->redirect()->toRoute('dashboard');
        }
        
         $picture=$user->picture;
         $this->layout()->setTemplate('layout/master');   
        $form = new UsersForm();
        $form->bind($user);
        $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findAll( );
        $ValueOptions=array();
        foreach($countries as $country ){
        $ValueOptions[$country->id]=$country->name;    
        }
        
          
        $form->get('country')->setValueOptions($ValueOptions)->setValue($user->country) ;
        $form->get('gender')->setValue($user->gender) ;
        $form->get('picture')->setValue('') ;  
        $form->get('mentor_id')->setValue($this->getMUserId());
        $form->get('stage')->setValue($user->stage);
        $form->get('password')->setValue($user->password);
        $form->get('role_id')->setValue($user->role_id);
        
        
        $form->get('submit')->setValue('Save');
        $request = $this->getRequest();
        if ($request->isPost()) {
             
       //        $Users = new Users();
               $form->setInputFilter($user->getInputFilter());
                $files   = $request->getFiles();
               $data =$this->getRequest()->getPost()->toArray();
             
                    
              
              $form->setData($this->getRequest()->getPost());
              $uploadObj = new \Zend\File\Transfer\Adapter\Http(); 
              $uploadObj->setDestination(PUBLIC_PATH.'/img');
                     
               if ($form->isValid()) {
                              
                 $flag=1;     
              
               $newImage =$files['picture']['name'];
              if(strlen($newImage))  {
                $validIsImage = new \Zend\Validator\File\IsImage();
             /* values here minWidth,minHeight,maxWidth,maxHeight   */
                $validImageSize = new \Zend\Validator\File\ImageSize(100, 100, 300,300 );
             if(!$validIsImage->isValid($files['picture'])){
              
              $form->get('picture')->setMessages($this->fileuploaderr['type']);  
                  $flag=0;
            
             }elseif(!$validImageSize->isValid($files['picture'])){
                  $form->get('picture')->setMessages($this->fileuploaderr['size']);  
                  $flag=0;
            
            }
             }
              
              
      $emailStatus=$this->isUserValid('email',$data['email'],$user->id);
                              
                 if($emailStatus){
                  $form->get('email')->setMessages(array('An account with this email already exists'));  
                  $flag=0;
                 }
                
       		     $phoneStatus=$this->isUserValid('phone_no',$data['phone_no'],$user->id);
                 if($phoneStatus){
                  $form->get('phone_no')->setMessages(array('This phone number already exists'));     
                 $flag=0;
                 }       
     
               if($flag){
                $uploadObj->receive();
                $temp=$uploadObj->getFileInfo();
                if(strlen($temp['picture']['name'])){
				 $data['picture']='/img/'.$temp['picture']['name'];		
				}else{
				$data['picture']=$picture;	
				}
                
              foreach($data as $key=>$val){
			  	$user->$key=$val;
			  } 
              	$user->password=$user->password;
                $this->getEntityManager()->persist($user);
                $this->getEntityManager()->flush();
                // Redirect to list of dashboard
              //  $this->flashMessenger()->addSuccessMessage('You are now logged in.');
                return $this->redirect()->toRoute('dashboard');
               }
              }                
               
          }
        
        $view = new ViewModel(array(
            'Url' => '/',
            'form' => $form,
            'title' => 'Edit Disciples',
        'id' => $id,
         'image' =>$picture,
        ));
        return $view;

    }
//edit user info
 public function deleteAction(){
     $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
                    return $this->redirect()->toRoute('dashboard');
        }
        $user = $this->getEntityManager()->find('SamUser\Entity\Users', $id);
        $user->mentor_id='';
                $this->getEntityManager()->persist($user);
                $this->getEntityManager()->flush();
            
                return $this->redirect()->toRoute('dashboard');
      
}
    
Public function profileAction()  {
       
     $id =$this->getMUserId();
      if (!$id) {
            return $this->redirect()->toRoute('dashboard');
        } 
     
        $user = $this->getEntityManager()->find('SamUser\Entity\Users', $id);
        
      if (!$user) {
            return $this->redirect()->toRoute('dashboard');
        }
        
        $picture=$user->picture;
        $this->layout()->setTemplate('layout/master');   
        $form = new UsersForm();
        $form->bind($user);
        $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findAll( );
        $ValueOptions=array();
        foreach($countries as $country ){
        $ValueOptions[$country->id]=$country->name;    
        }
       

        
        $form->add(array(
            'name' => 'newpassword',
            'type' => 'Text',
          
            'options' => array(
                'label' => 'New Password',
                
            ), 'attributes' => array(
                           'id'       => 'newpassword',
                            'class'    => 'form-control',
                          
                            ),
     
        ));
     
        $form->get('country')->setValueOptions($ValueOptions)->setValue($user->country) ;
        $form->get('gender')->setValue($user->gender) ;
        $form->get('mentor_id')->setValue($this->getMUserId());
        $form->get('stage')->setValue($user->stage);
        $form->get('password')->setValue($user->password);
        $form->get('role_id')->setValue($user->role_id);
        $form->get('submit')->setValue('Save');
        $request = $this->getRequest();
     
       

        if ($request->isPost()) {

       
              $form->setInputFilter($user->getInputFilter());
              $files   = $request->getFiles();
              $data =$this->getRequest()->getPost()->toArray();
              $form->setData($this->getRequest()->getPost());
              $uploadObj = new \Zend\File\Transfer\Adapter\Http(); 
              $uploadObj->setDestination(PUBLIC_PATH.'/img');
              if ($form->isValid()) {
                  
              $flag=1;     
              $newImage =$files['picture']['name'];
              if(strlen($newImage))  {
                $validIsImage = new \Zend\Validator\File\IsImage();
             /* values here minWidth,minHeight,maxWidth,maxHeight   */
                $validImageSize = new \Zend\Validator\File\ImageSize(100, 100, 300,300 );
             if(!$validIsImage->isValid($files['picture'])){
              
              $form->get('picture')->setMessages($this->fileuploaderr['type']);  
                  $flag=0;
            
             }elseif(!$validImageSize->isValid($files['picture'])){
                  $form->get('picture')->setMessages($this->fileuploaderr['size']);  
                  $flag=0;
            
            }
             }
               
               
                $emailStatus=$this->isUserValid('email',$data['email'],$user->id);
                              
                 if($emailStatus){
                  $form->get('email')->setMessages(array('An account with this email already exists'));  
                  $flag=0;
                 }
                
       		     $phoneStatus=$this->isUserValid('phone_no',$data['phone_no'],$user->id);
                 if($phoneStatus){
                  $form->get('phone_no')->setMessages(array('This phone number already exists'));     
                 $flag=0;
                 }
                 
       
               if($flag){
                $uploadObj->receive();
                $temp=$uploadObj->getFileInfo();
                if(strlen($temp['picture']['name'])){
				 $data['picture']='/img/'.$temp['picture']['name'];		
				}else{
				$data['picture']=$picture;	
				}
             
             
      
         
              foreach($data as $key=>$val){
			  	$user->$key=$val;
			  } 
                $user->password=$user->password;  ;
              if(strlen($data['newpassword'])){
               $this->bcrypt = new Bcrypt();
               $this->bcrypt->setCost(14);
               $cryptPassword = $this->bcrypt->create($data['newpassword']);
               $user->password=$cryptPassword;  
              
              
                }
                  
                
                $this->getEntityManager()->persist($user);
                $this->getEntityManager()->flush();
                // Redirect to list of dashboard
              //  $this->flashMessenger()->addSuccessMessage('You are now logged in.');
                return $this->redirect()->toRoute('dashboard');
               }
              }                
               
          }
        
        $view = new ViewModel(array(
            'Url' => '/',
            'form' => $form,
            'title' => 'Profile',
             'id' => $id,
              'image' =>$picture,
        ));
        return $view;

    }

   public function isUserValid($field='email',$value ,$exclude=0){
       $qb = $this->getEntityManager()->createQueryBuilder();
       $qb->select('t')
            ->from('SamUser\Entity\Users', 't')
            ->where('t.' . $field . '= :field')
            ->setParameter('field', $value);
            if($exclude){
                $qb->andWhere('t.id <> :id');
                $qb->setParameter('id', $exclude);
            }
           $result = $qb->getQuery()->getScalarResult();
          
       
             if ($result) {
             return true; 
             }
      return false;
   }



}