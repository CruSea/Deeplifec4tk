<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Form;
use Zend\Form\Validator;
//use Application\Form\RegisterForm;
use SamUser\Form\RegisterForm;
use Zend\View\Model\ViewModel;
use Zend\Mail;  
use Zend\Mime\Part as MimePart;  
use Zend\Mime\Message as MimeMessage;  
use Zend\Session\Container;




use SamUser\Entity\Users;
use Zend\Crypt\Password\Bcrypt;
class IndexController extends AbstractActionController
{
    
    protected $em;
   

    public function getEntityManager(){
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default'        );
        }
        return $this->em;
    }
    
    
    // add disciple
    Public function contactusAction()
    {
           
          
           $request = $this->getRequest();
        if ($request->isPost()) {
      $dataArray= $request->getPost();
     // setup SMTP options
     $options = new Mail\Transport\SmtpOptions(array(
            'name' => 'localhost',
            'host' => 'smtp.gmail.com',
            'port'=> 587,
            'connection_class' => 'login',
            'connection_config' => array(
                'username' => 'appsdeeplife@gmail.com',
                'password' => 'aarav321',
                'ssl'=> 'tls',
            ),
    ));
                 
//$this->renderer = $this->getServiceLocator()->get('ViewRenderer');
 //$content =$this->renderer->render('email/contactusmail', $dataArray);
$content="Name ::".$dataArray['name'] ."<br>Email::".$dataArray['email']."<br>Message::".$dataArray['message'];
// make a header as html
$html = new MimePart($content);
$html->type = "text/html";
$body = new MimeMessage();
$body->setParts(array($html,));
// instanc    e mail 
$mail = new Mail\Message();
$mail->setBody($body); // will generate our code html from template.phtml
$mail->setFrom('info@gmail.com','abhinav');
$mail->setTo('alvin.abhinav@ithands.net');
$mail->setSubject('contact us inquiry');
$transport = new Mail\Transport\Smtp($options);
$transport->send($mail);
echo 1;
}
else{
 
echo 0;   
}
 
   $viewModel = new ViewModel();
   $viewModel->setTerminal(true);
   return $viewModel;
      
      

   
 }
    
    
    // add disciple
    Public function indexAction()
    {
        
      
        $view = new ViewModel(array(
            'imageurl' => '',
            'Url' => '/',
            'title' => 'Add Disciples',
        ));
        return $view;
    }

    //update user info
    Public function mobileappAction()
    {
              
        $view = new ViewModel(array(
          'Url' => '/',
         'title' => 'Download the App',
        ));
       return $view;
    }

    public function signupAction(){
	
    
           if ($this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute($this->getOptions()->getLoginRedirectRoute());
        }

     
         $form = new RegisterForm();
        $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findAll( );
        $ValueOptions=array();
        foreach($countries as $country ){
        $ValueOptions[$country->id]=$country->name;    
        }
       
        
             
        $form->get('country')->setValueOptions($ValueOptions);
       //  $form->get('submit')->setValue('Save');
        $request = $this->getRequest();
             
       if ($request->isPost()) {
       //   $form->setInputFilter($form->getInputFilter());
           $form->setData($request->getPost());
            if ($form->isValid()) {
          
            $this->bcrypt = new Bcrypt();
            $this->bcrypt->setCost(14);
          
            $email=trim($request->getPost('email'));
            $phone_no=trim($request->getPost('phone_no'));
            $password=trim($request->getPost('password')); 
            $gender=trim($request->getPost('gender')); 
            $country=trim($request->getPost('country')); 
              $firstName=trim($request->getPost('firstName')); 
            
            $cryptPassword = $this->bcrypt->create($password);
            $Users =$this->getEntityManager()->getRepository('SamUser\Entity\Users')->findOneBy(array('email' =>$email));
               if (!$Users) {
                  	
                   $phone =$this->getEntityManager()->getRepository('SamUser\Entity\Users')->findOneBy(array('phone_no' =>$phone_no));
               if(!$phone){
                         $Users = new Users(); 
                         $Users->email=$email;
                         $Users->displayName=$firstName;
                         $Users->firstName=$firstName;
                         $Users->country=$country;
                         $Users->phone_no=$phone_no;
                         $Users->role_id=1;
                         $Users->gender=$gender;
                         $Users->password=$cryptPassword;
                         $this->getEntityManager()->persist($Users);
                        $this->getEntityManager()->flush();
             	   		$session = new Container('message');
	                   $session->success = 'User was added successfully.Please login';
	
                         return $this->redirect()->toRoute('home');
                      


                 }else{
                  $form->get('phone_no')->setMessages(array('This nee phone number already exists'));
  
                }
              
              
              
               } elseif($phone_no!=$Users->phone_no) {
                    $form->get('phone_no')->setMessages(array('This phone number already exists'));   		
				}elseif(strlen($Users->password)==0){
				  $Users->password=$cryptPassword;
			   	  $this->getEntityManager()->persist($Users);
                  $this->getEntityManager()->flush();
         	           
                     $session = new Container('message');
	                 $session->success = 'User was added successfully.Please login';
	
                         return $this->redirect()->toRoute('home');
                       
				}else {
                 $form->get('phone_no')->setMessages(array('This phone number already exists'));
                 $form->get('email')->setMessages(array('This email already exists'));
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
    





}
