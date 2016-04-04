<?php
/**
 * Created by PhpStorm.
 * User: Sami
 * Date: 11/12/15
 * Time: 12:53 AM
 */

namespace SamUser\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use SamUser\Entity\User;
use Doctrine\ORM\EntityManager;

class TreeController extends AbstractActionController
{
    protected $user;
    protected $users;
    protected $em;
    public $userid;
    protected $entity = 'SamUser\Entity\User';

    
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    Public function indexAction()
    {
        
          $this->layout()->setTemplate('layout/master'); 
          
          
        
          
        return new ViewModel(array(

            'Url' => '/',
            'title' => 'Generation Tree',
        ));

    }
    public function jsonAction()
    {
       
           
       
      if ($this->zfcUserAuthentication()->hasIdentity()) {
            //get the user_id of the user
            $userid = $this->zfcUserAuthentication()->getIdentity()->getId();
            $avatar='/avatar/noavatar.jpg';
              if( file_exists($this->zfcUserAuthentication()->getIdentity()->getPicture())) { 
               $avatar=$this->zfcUserAuthentication()->getIdentity()->getPicture();
                }   
                $name= ucwords($this->zfcUserAuthentication()->getIdentity()->getDisplayname());

        }
    
      $users =$this->getEntityManager()->getRepository('SamUser\Entity\User')->findBy(array('mentor_id' => $userid ));
    
   // $url=explode('/',$this->getRequest()->getUri());
 // print_r($url);  
  
  if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
     $url= $protocol . "://" . parse_url($this->getRequest()->getUri(), PHP_URL_HOST);
  
    
          $tree['name'] =  $name;
          $tree['icon'] = $url.''.$avatar;
          $tree['immediate'] = count($users);
          $tree['total'] = count($users);
          $tree['url'] = '2';
          $i=0;
     foreach ($users as $user){
         
              $avatar='/avatar/noavatar.jpg';
              if( file_exists($user->getPicture())) { 
               $avatar=$user->getPicture();
                }    
            $tree['children'][$i]['name'] = ucwords($user->getDisplayname());
            $tree['children'][$i]['icon'] = $url.''.$avatar;
            $tree['children'][$i]['immediate'] = '12';
            $tree['children'][$i]['total'] = '500';
            $tree['children'][$i]['url'] = '';
           $i++;
     
     }
     
         
           
   /*        
           $tree['children'][0]['name'] = 'analytics';
           $tree['children'][0]['icon'] = 'avatar2.png';
           $tree['children'][0]['immediate'] = '12';
           $tree['children'][0]['total'] = '500';
           $tree['children'][0]['url'] = 'http://google.com';
          
           $tree['children'][0]['children'][0]['name'] = 'cluster';
           $tree['children'][0]['children'][0]['icon'] = 'avatar3.png';
           $tree['children'][0]['children'][0]['immediate'] = '12';
           $tree['children'][0]['children'][0]['total'] = '500';
           $tree['children'][0]['children'][0]['url'] = '3';
          
           $tree['children'][0]['children'][1]['name'] = 'graph';
           $tree['children'][0]['children'][1]['icon'] = 'avatar4.png';
           $tree['children'][0]['children'][1]['immediate'] = '12';
           $tree['children'][0]['children'][1]['total'] = '500';
               
           $tree['children'][0]['children'][2]['name'] = 'optimization';
           $tree['children'][0]['children'][2]['icon'] =  'avatar5.png';
           $tree['children'][0]['children'][2]['immediate'] =  '12';
           $tree['children'][0]['children'][2]['total'] =  '500';
           $tree['children'][0]['children'][2]['url'] =  'http://google.com';
               
          */
  
        return new JsonModel($tree);
    }



}


