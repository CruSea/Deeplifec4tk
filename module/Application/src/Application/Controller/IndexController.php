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
use SamUser\Entity\Resetpassword;




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

       $this->layout()->setTemplate('layout/layout1');
         $form = new RegisterForm();
        $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findAll( );
        $ValueOptions=array();
        foreach($countries as $country ){

          $ValueOptions[] = array('attributes'=>['data-key'=>$country->phonecode],
                                  'value' => $country->id,
                                  'label' => $country->name);
        }
       
        $form->get('country')->setValueOptions($ValueOptions);

       
        
             
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
   
   public function forgotAction() {
    
   }
    
   public function ajaxforgotAction(){
       $mailSend=0;
         $request = $this->getRequest();
        if($request->isXmlHttpRequest()){
	        $data = $request->getPost();
	   
         
           if(isset($data['phone']) && !empty($data['phone'])){
	    $phone=$data['phone'];
	        }else{
                 $mailSend=0;
            }
	       if(isset($data['email']) && !empty($data['email'])){
	     $email=$data['email'];
	        }else{
                 $mailSend=0;
            }
	    
       
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select("u.id")   
         ->from('SamUser\Entity\Users', 'u')
             ->andWhere('u.email = (:email)')
            ->andWhere('u.phone_no = (:phone_no)')
            // ->andWhere('u.password !=""')
            ->setParameter('email', $email)
              ->setParameter('phone_no', $phone);
  
       $userid = $queryBuilder->getQuery()->getOneOrNullResult();
          
       if($userid){
      $keycode=$this->randomKeycode();
      $Users =$this->getEntityManager()->getRepository('SamUser\Entity\Users')->findOneBy(array('id' =>$userid['id']));
 
 if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
     $url= $protocol . "://" . parse_url($this->getRequest()->getUri(), PHP_URL_HOST);
 $mailSend=$this->sendMail($keycode,$email,$url);
if($mailSend){
     $dataSave=array();
      $dataSave['email']=$email;
      $dataSave['keycode']=$keycode;
      $dataSave['status']=1;
      $resetPassword =new Resetpassword();
      $resetPassword->exchangeArray($dataSave);
       $this->getEntityManager()->persist($resetPassword);
                $this->getEntityManager()->flush();
    
}
     
     
       }else{
           
      $mailSend=0;
       }
       
       
       
        }	    
     
     echo $mailSend;
       $viewModel = new ViewModel();
       $viewModel->setTerminal(true);
       return $viewModel;
   }


public function resetpasswordAction(){
     
  $status=1;
  $msg='';
  $email= $this->params()->fromQuery('email');
  $keycode= $this->params()->fromQuery('keycode');
  if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    } else{
        $protocol = 'http';
    }
   $url= $protocol . "://" . parse_url($this->getRequest()->getUri(), PHP_URL_HOST);
   $url.='/resetpassword?email='.urlencode($email).'&keycode='.urlencode($keycode);
  $usersReset =$this->getEntityManager()->getRepository('SamUser\Entity\Resetpassword')->findOneBy(array('email' =>$email,'keycode' =>$keycode));
  

    if($usersReset)
    {
       if(!$usersReset->status){ 
        $status=0;  
       }else {
           
          $request = $this->getRequest();
          if ($request->isPost()) {
          
           $pass=$request->getPost('pass');
           $cpass=$request->getPost('cpass');
          if(strcmp($pass,$cpass)){
          $msg='Sorry. . . Your password  and Confirm password do not match. Please try again.';    
          }else{
            
            $this->bcrypt = new Bcrypt();
            $this->bcrypt->setCost(14);   
            $cryptPassword = $this->bcrypt->create($pass);
            $Users =$this->getEntityManager()->getRepository('SamUser\Entity\Users')->findOneBy(array('email' =>$email));
            $Users->password=$cryptPassword;
                         $this->getEntityManager()->persist($Users);
                        $this->getEntityManager()->flush();
             	   		$usersReset->status=0;
                     $this->getEntityManager()->persist($usersReset);
                        $this->getEntityManager()->flush();
             	            
                        $session = new Container('message');
	                   $session->success = 'Your password has been reset successfully.Please login';
	
                         return $this->redirect()->toRoute('home');
          
          }    
       
       
       
            
       
       
       
       
       
       
            }



       }
    
    }else{
       $status=0; 
    }

     
        $view = new ViewModel(array(
            'Url' => $url,
            'title' => 'Reset password',
            'flashMessages'=>$msg,
            'active'=>$status
        ));
        return $view;
}
public function randomKeycode( $length = 10 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}
public function sendMail($keycode,$email,$url){
    

  $dataArray=array();
  $dataArray['keycode']=urlencode($keycode);
  $dataArray['email']=urlencode($email);
  $dataArray['url']=$url;
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
                 
$renderer = $this->getServiceLocator()->get('ViewRenderer');
$content =$renderer->render('forgot', $dataArray);
// make a header as html
$html = new MimePart($content);
$html->type = "text/html";
$body = new MimeMessage();
$body->setParts(array($html,));
// instanc    e mail 
$mail = new Mail\Message();
$mail->setBody($body); // will generate our code html from template.phtml
$mail->setFrom('info@deeplife.com','Deeplife');
$mail->setTo($email);
$mail->setSubject('Deeplife forgot password ');
$transport = new Mail\Transport\Smtp($options);
$transport->send($mail);
return 1;
}

}