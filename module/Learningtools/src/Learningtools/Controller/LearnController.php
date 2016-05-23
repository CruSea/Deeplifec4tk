<?php
namespace Learningtools\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Learningtools\Entity\Learningtools;
use Learningtools\Form\LearnForm;
use Zend\Session\Container;
use Zend\Stdlib\DateTime;
class LearnController extends AbstractActionController
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
 $country = $this->zfcUserAuthentication()->getIdentity()->country;
$learn=$this->getEntityManager()->getRepository('Learningtools\Entity\Learningtools')->findBy(array('country' => $country ),array('created' => 'DESC'));
if(!$learn){
$learn=$this->getEntityManager()->getRepository('Learningtools\Entity\Learningtools')->findBy(array('default_learn' => 1 ),array('created' => 'DESC'));
    
}




return new ViewModel(
array(
'learning'=>$learn,
 ));



}


public function addAction()
{
         $this->layout()->setTemplate('layout/master');  
        $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findAll( );
         $ValueOptions=array();
         foreach($countries as $country ){
         $ValueOptions[$country->id]=$country->name;    
         }
          
        $form = new LearnForm();
        $form->get('country')->setValueOptions($ValueOptions);
        $form->get('submit')->setValue('Save');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $learningTools = new Learningtools();
            $form->setInputFilter($learningTools->getInputFilter());
            $form->setData($request->getPost());
    
           
            if ($form->isValid()) {
                          
                $learningTools->populate($form->getData());
                $this->getEntityManager()->persist($learningTools);
                $this->getEntityManager()->flush();
                $session = new Container('message');
	            $session->success = 'Data saved successfully';
                // Redirect to list of Learningtools
                return $this->redirect()->toRoute('learn',array(
                'action' => 'display'
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
            return $this->redirect()->toRoute('learn', array(
                'action' => 'add'
            ));
        }
        $learningTools = $this->getEntityManager()->find('Learningtools\Entity\Learningtools', $id);
        
      
        
        $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findAll( );
        $ValueOptions=array();
        foreach($countries as $country ){
        $ValueOptions[$country->id]=$country->name;    
        }
      
        $form  = new LearnForm();
        $form->bind($learningTools);
        $form->get('country')->setValueOptions($ValueOptions)->setValue($learningTools->country) ;
           $form->get('default_learn')->setValue($learningTools->default_learn) ;
        
        $form->get('submit')->setAttribute('value', 'Save');
        $request = $this->getRequest();
        
        
        if ($request->isPost()) {
            $form->setInputFilter($learningTools->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();
                $session = new Container('message');
	            $session->success = 'Data saved successfully';
                
                // Redirect to list of albums
                return $this->redirect()->toRoute('learn' ,array(
                'action' => 'display'
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
       $learningTools = $this->getEntityManager()->find('Learningtools\Entity\Learningtools', $id);    
       $this->getEntityManager()->remove($learningTools);
        $this->getEntityManager()->flush();
       $session = new Container('message');
	   $session->success = ' Deleted successfully';
                
         return $this->redirect()->toRoute('learn',array(
                'action' => 'display'
            ));
}

public function displayAction()
{
$this->layout()->setTemplate('layout/master');  
$learn=$this->getEntityManager()->getRepository('Learningtools\Entity\Learningtools')->findBy(array(),array('created' => 'DESC'));
return new ViewModel(
array(
'learning'=>$learn,
 ));



}


}