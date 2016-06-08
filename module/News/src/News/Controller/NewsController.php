<?php
namespace News\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use News\Entity\News;
use News\Form\NewsForm;
use Zend\Session\Container;
use Zend\Stdlib\DateTime;
class NewsController extends AbstractActionController
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
  
  if ($this->zfcUserAuthentication()->hasIdentity()) {
           $country = $this->zfcUserAuthentication()->getIdentity()->country;
       }
$this->layout()->setTemplate('layout/master');  
$news=$this->getEntityManager()->getRepository('News\Entity\News')->findBy(array('status'=>1,'country'=>$country),array('created' => 'DESC'));

return new ViewModel(
array(
'news'=>$news,
 ));



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
          
        $form = new NewsForm();
        $form->get('country')->setValueOptions($ValueOptions);
        $form->get('submit')->setValue('Save');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $news = new News();
            $form->setInputFilter($news->getInputFilter());
            $form->setData($request->getPost());
    
           
            if ($form->isValid()) {
                          
                $news->populate($form->getData());
                $this->getEntityManager()->persist($news);
                $this->getEntityManager()->flush();
                $session = new Container('message');
	            $session->success = 'Data saved successfully';
                // Redirect to list of Learningtools
                return $this->redirect()->toRoute('news',array(
                'action' => 'newstool'
            ));
            }
        }
        return array('form' => $form, );
    }

public function editAction()
{
          $this->layout()->setTemplate('layout/master');  
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('news', array(
                'action' => 'add'
            ));
        }
        $news = $this->getEntityManager()->find('News\Entity\News', $id);
        
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
      
        $form  = new NewsForm();
        $form->bind($news);
        $form->get('country')->setValueOptions($ValueOptions)->setValue($news->country) ;
           $form->get('status')->setValue($news->status) ;
        
        $form->get('submit')->setAttribute('value', 'Save');
        $request = $this->getRequest();
        
        
        if ($request->isPost()) {
            $form->setInputFilter($news->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();
                $session = new Container('message');
	            $session->success = 'Data saved successfully';
                
                // Redirect to list of albums
                return $this->redirect()->toRoute('news' ,array(
                'action' => 'newstool'
            ));
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
            return $this->redirect()->toRoute('news', array(
                'action' => 'add'
            ));
        }
       $news = $this->getEntityManager()->find('News\Entity\News', $id);    
       $this->getEntityManager()->remove($news);
        $this->getEntityManager()->flush();
       $session = new Container('message');
	   $session->success = ' Deleted successfully';
                
         return $this->redirect()->toRoute('news',array(
                'action' => 'newstool'
            ));
}

public function newstoolAction()
{
$this->layout()->setTemplate('layout/master');  
 $userCountryids=$this->getuserCountryids();
   $whereData=array();
   if(count($userCountryids)){
      $whereData= array('country'=>$userCountryids);
   }
$news=$this->getEntityManager()->getRepository('News\Entity\News')->findBy($whereData,array('created' => 'DESC'));
return new ViewModel(
array(
'news'=>$news,
 ));



}


}