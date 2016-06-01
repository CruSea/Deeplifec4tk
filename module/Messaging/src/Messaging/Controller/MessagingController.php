<?php
namespace Messaging\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Messaging\Entity\Messaging;
use Messaging\Form\MessagingForm;
use Zend\Session\Container;
use Zend\Stdlib\DateTime;
class MessagingController extends AbstractActionController
{
/**   
* Entity manager instance
* @var Doctrine\ORM\EntityManager
*/                
protected $em;

 public function getMUserId() {
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            //get the user_id of the user
            $this->userid = $this->zfcUserAuthentication()->getIdentity()->getId();
        }
        return $this->userid;
    }

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

public function indexAction()
{
$this->layout()->setTemplate('layout/master');  

if ($this->zfcUserAuthentication()->hasIdentity()) {
           $userid = $this->zfcUserAuthentication()->getIdentity()->id;
        }
        
        $messagesBuilder = $this->getEntityManager()->createQueryBuilder();
        $messagesBuilder->select("m.id,m.subject,m.description,m.created,u.displayName,m.status ")   
        ->from('Messaging\Entity\Messaging', 'm')
        ->leftJoin('SamUser\Entity\Users u', 'WITH m.sender_id=u.id')
        ->andWhere('m.sender_id = (:userid)')
        ->addOrderBy('m.created', 'DESC')
        ->setParameter('userid',  $userid);
                  
         $messages =array();
        $messages = $messagesBuilder->getQuery()->getScalarResult();
        
        $countBuilder = $this->getEntityManager()->createQueryBuilder();
        $countBuilder->select("COUNT(m.status) ")   
        ->from('Messaging\Entity\Messaging', 'm')
        ->andWhere('m.sender_id = (:userid)')
        ->andWhere('m.status = 1')
        ->setParameter('userid',  $userid);
             
         $messagesCount = $countBuilder->getQuery()->getSingleScalarResult();
         
         
return new ViewModel(
array(
'messages'=>$messages,
'readcount'=>$messagesCount,
 ));



}

public function sendAction()
{
$this->layout()->setTemplate('layout/master');  

if ($this->zfcUserAuthentication()->hasIdentity()) {
           $userid = $this->zfcUserAuthentication()->getIdentity()->id;
        }
        
        $messagesBuilder = $this->getEntityManager()->createQueryBuilder();
        $messagesBuilder->select("m.id,m.subject,m.description,m.created,u.displayName,m.status ")   
        ->from('Messaging\Entity\Messaging', 'm')
        ->leftJoin('SamUser\Entity\Users u', 'WITH m.sender_id=u.id')
        ->andWhere('m.user_id = (:userid)')
        ->addOrderBy('m.created', 'DESC')
        ->setParameter('userid',  $userid);
                  
        $messages =array();
        $messages = $messagesBuilder->getQuery()->getScalarResult();
        
     
         
         
return new ViewModel(
array(
'messages'=>$messages,
'readcount'=>$messagesCount,
 ));



}


public function composeAction()
{
       $this->layout()->setTemplate('layout/master');  
     
        $form = new MessagingForm();
         $form->get('user_id')->setValue($this->getMUserId());
        
         $request = $this->getRequest();
        
       
        
        if ($request->isPost()) {
       
    
       
            $Messaging = new Messaging();
            $form->setInputFilter($Messaging->getInputFilter());
            $form->setData($request->getPost());
               
            if ($form->isValid()) {
                          
                $Messaging->populate($form->getData());
                $this->getEntityManager()->persist($Messaging);
                $this->getEntityManager()->flush();
                $session = new Container('message');
	            $session->success = 'Data saved successfully';
                // Redirect to list of Learningtools
                return $this->redirect()->toRoute('messaging',array(
                'action' => 'index'     ));
            }
        }
        return array('form' => $form, );
    }

public function maildetailAction()
{
       
          $this->layout()->setTemplate('layout/master');  
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('messaging', array(
                'action' => 'index'
            ));
        }
       
       if ($this->zfcUserAuthentication()->hasIdentity()) {
           $userid = $this->zfcUserAuthentication()->getIdentity()->id;
        }
        $messages =array();
            
    $messagesBuilder = $this->getEntityManager()->createQueryBuilder();
        $messagesBuilder->select("m.subject,m.description,m.created,u.displayName,m.status ")   
        ->from('Messaging\Entity\Messaging', 'm')
        ->leftJoin('SamUser\Entity\Users u', 'WITH m.sender_id=u.id')
        ->andWhere('m.id = (:id)')
        ->addOrderBy('m.created', 'DESC')
        ->setParameter('id',  $id);          
         $message =array();
        $message = $messagesBuilder->getQuery()->getOneOrNullResult();

    if (!$message) {
            return $this->redirect()->toRoute('messaging', array(
                'action' => 'index'
            ));
        } 
   
        $read = $this->getEntityManager()->find('Messaging\Entity\Messaging', $id);
        $read->status=0;
        $this->getEntityManager()->persist($read);
                $this->getEntityManager()->flush();        
 
    $countBuilder = $this->getEntityManager()->createQueryBuilder();
        $countBuilder->select("COUNT(m.status) ")   
        ->from('Messaging\Entity\Messaging', 'm')
        ->andWhere('m.sender_id = (:userid)')
        ->andWhere('m.status = 1')
        ->setParameter('userid',  $userid);
          $messagesCount = $countBuilder->getQuery()->getSingleScalarResult();
   
        return array(
        'message'=>$message,
     'readcount'=>$messagesCount,
      'id'=>$id
        );
    }

public function deleteAction(){
     $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('messaging', array(
                'action' => 'index'
            ));
        }
       $messagingTools = $this->getEntityManager()->find('Messaging\Entity\Messaging', $id);    
       $this->getEntityManager()->remove($messagingTools);
        $this->getEntityManager()->flush();
       $session = new Container('message');
	   $session->success = ' Deleted successfully';
                
         return $this->redirect()->toRoute('messaging',array(
                'action' => 'index'
            ));
}

public function displayAction()
{
$this->layout()->setTemplate('layout/master');  
$learn=$this->getEntityManager()->getRepository('Messaging\Entity\Messaging')->findBy(array(),array('created' => 'DESC'));
return new ViewModel(
array(
'learning'=>$learn,
 ));



}




}