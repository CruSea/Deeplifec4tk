<?php
namespace Testimonial\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Testimonial\Entity\Testimonial;
use SamUser\Entity\Users;
use Testimonial\Form\TestimonialForm;
use Zend\Session\Container;
use Zend\Stdlib\DateTime;
class TestimonialController extends AbstractActionController
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
public function indexAction()
{

$this->layout()->setTemplate('layout/master');  
if ($this->zfcUserAuthentication()->hasIdentity()) {
           $country = $this->zfcUserAuthentication()->getIdentity()->country;
        }
$em = $this->getEntityManager();
       $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select("t.description,t.created,u.displayName,u.picture")   
         ->from('Testimonial\Entity\Testimonial', 't')
        ->leftJoin('SamUser\Entity\Users u', 'WITH t.user_id=u.id')
           ->andWhere('t.status = 1')
          ->andWhere('u.country = (:country)')
          ->addOrderBy('t.created', 'DESC')
          ->setParameter('country',  $country)
          ->setMaxResults(10);
         
    $testimonials =array();
        $testimonials = $queryBuilder->getQuery()->getScalarResult();
return new ViewModel(
array(
'testimonials'=>$testimonials,
 ));

}


public function addAction()
{
    
   $status=0;
   $request = $this->getRequest();
    if ($request->isXmlHttpRequest()) {
       if ($this->zfcUserAuthentication()->hasIdentity()) {
             $country = $this->zfcUserAuthentication()->getIdentity()->country;
             $userid = $this->zfcUserAuthentication()->getIdentity()->id;
        }
       
       $msg= $request->getPost('testmess');   
        $Testimonial = new Testimonial(); 
                       
                         $Testimonial->description=$msg;
                         $Testimonial->country=$country;
                         $Testimonial->status=0;
                         $Testimonial->user_id=$userid;
                         $Testimonial->created =new DateTime();
                        $this->getEntityManager()->persist($Testimonial);
                        $this->getEntityManager()->flush();
    
    $status=1;
    } 
  
  echo $status; 
  
   die;
      

}

public function editAction()
{
          $this->layout()->setTemplate('layout/master');  
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('testimonial', array(
                'action' => 'testimonialtool'
            ));
        }
        $testimonial = $this->getEntityManager()->find('Testimonial\Entity\Testimonial', $id);
        
      
        
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
      
        $form  = new TestimonialForm();
        $form->bind($testimonial);
        $form->get('country')->setValueOptions($ValueOptions)->setValue($testimonial->country) ;
        $form->get('status')->setValue($testimonial->status) ;
         $request = $this->getRequest();
        
        
        if ($request->isPost()) {
            $form->setInputFilter($testimonial->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();
                $session = new Container('message');
	            $session->success = 'Data saved successfully';
                
                // Redirect to list of albums
                return $this->redirect()->toRoute('testimonial' ,array(
                'action' => 'testimonialtool'
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
            return $this->redirect()->toRoute('learn', array(
                'action' => 'add'
            ));
        }
       $testimonial = $this->getEntityManager()->find('Testimonial\Entity\Testimonial', $id);    
       $this->getEntityManager()->remove($testimonial);
        $this->getEntityManager()->flush();
       $session = new Container('message');
	   $session->success = ' Deleted successfully';
                
         return $this->redirect()->toRoute('testimonial',array(
                'action' => 'testimonialtool'
            ));
}

public function testimonialtoolAction()
{
$this->layout()->setTemplate('layout/master');  
 $userCountryids=$this->getuserCountryids();
   $whereData=array();
   if(count($userCountryids)){
      $whereData= array('country'=>$userCountryids);
   }
$testimonial=$this->getEntityManager()->getRepository('Testimonial\Entity\Testimonial')->findBy($whereData,array('created' => 'DESC'));
return new ViewModel(
array(
'testimonials'=>$testimonial,
 ));



}


}