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
use Zend\View\Model\ViewModel;
use Zend\Mail;  
use Zend\Mime\Part as MimePart;  
use Zend\Mime\Message as MimeMessage;  

class IndexController extends AbstractActionController
{
    
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
}
