<?php

namespace SamUser\Controller;
use Zend\View\Model\ViewModel;
use Zend\Validator\ValidatorChain;
use SamUser\Entity\Rolearea;
use DoctrineModule\Validator\ObjectExists;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;
use Zend\Stdlib\DateTime;
class UsersController extends AbstractActionController
{
    
    protected $em;

 public function __construct()
    {
       
       

    }
    
     protected function getuserCountryids() {
      $userCountryids=array();
      $session = new Container('userCountryids');
      if($session->offsetExists('countryids')){
	     $userCountryids= $session->offsetGet('countryids');
	     }
      
        return $userCountryids;
     }


    protected function getEntityManager() {
        if (null === $this->em)
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return $this->em;
    }

    
    /**
     * User list / default action
     */
    public function indexAction() {
       $this->layout()->setTemplate('layout/master');  
            $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findAll();
        $countriesData=array();
       $userCountryids=$this->getuserCountryids();
        foreach($countries as $country ){
        $countriesData[$country->id]=$country->name;    
        } 
     
     $users=$this->getEntityManager()->getRepository('SamUser\Entity\Users')->findBy(array('country'=>$userCountryids ),array('created' => 'DESC'));
     return new ViewModel(
            array(
               'countries'=>$countriesData,
           'users' => $users
            )
        );
    
    }
    
    public function editAction(){
       
       
        $id = (int) $this->params()->fromRoute('id', 0);
      if (!$id) {
            return $this->redirect()->toRoute('users');
        } 
     $user = $this->getEntityManager()->find('SamUser\Entity\Users', $id);
        
      if (!$user) {
            return $this->redirect()->toRoute('users');
        }
       
        $this->layout()->setTemplate('layout/master'); 
         $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findAll( );
        $countriesData=array();
         $userCountryids=$this->getuserCountryids();
        foreach($countries as $country ){
         if(in_array($country->id,$userCountryids))
        $countriesData[$country->id]=$country->name;    
        } 
        
        $areaGroups=$this->getEntityManager()->getRepository('SamUser\Entity\Areagroups')->findAll( );
        $areaGroupsData=array();
        foreach($areaGroups as $area ){
        $areaGroupsData[$area->id]=$area->groups_name;    
        } 
       
        $roleArea=$this->getEntityManager()->getRepository('SamUser\Entity\Rolearea')->findOneBy(array('user_id'=>$id ) );
        if(!$roleArea){
            $roleCountry=0;
             $roleGroups=0;
            $roleArea= new Rolearea();
            $roleArea->user_id=$id;
        }else{
            $roleCountry=$roleArea->countryid;
             $roleGroups=$roleArea->area_groupsid;
            
        }
           $request = $this->getRequest();
          if ($request->isPost()) {
           $rolePost=$request->getPost('role');
           $countryPost=$request->getPost('country');
           $areaGroups=$request->getPost('areagroups'); 
           $user=$this->getEntityManager()->getRepository('SamUser\Entity\Users')->findOneBy(array('id'=>$id ) );
           $user->role_id=$rolePost;
           $user->created =new DateTime();
           $this->getEntityManager()->persist($user);
                $this->getEntityManager()->flush();
          if(in_array($rolePost,array(2,3,4))){
              
            if($rolePost==4){
                  $roleArea->countryid=$countryPost;
                  $roleArea->area_groupsid='';
            }else{
                
                  $roleArea->countryid='';
                  $roleArea->area_groupsid=$areaGroups;
           
            }
                $this->getEntityManager()->persist($roleArea);
                $this->getEntityManager()->flush();
         
          }else {
                
               $this->getEntityManager()->remove($roleArea);
               $this->getEntityManager()->flush();
          }
            $session = new Container('message');
	       $session->success = 'Data saved successfully';
            return $this->redirect()->toRoute('users');
            
          }
       
        
         return new ViewModel(
            array(
               'countries' => $countriesData,
               'areagroups' =>$areaGroupsData,
               'roleid' => $user->role_id,
               'roleCountry' =>$roleCountry,
                 'roleGroups' =>$roleGroups,
            )
        );
        
    }
    

     
   
}
