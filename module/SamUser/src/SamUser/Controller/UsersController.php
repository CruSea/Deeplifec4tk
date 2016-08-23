<?php
 /**
 * Created by PhpStorm.
 * User: Sami
 * Date: 11/12/15
 * Time: 12:53 AM
 */

/**
 * Users
 * This module will be used for users Role
 *@package controller
 *@author Abhinav
 */

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
    /**
     * Function to  getuserCountryids
     * @param NA
     * @author Abhinav
     */
     protected function getuserCountryids() {
      $userCountryids=array();
      $session = new Container('userCountryids');
      if($session->offsetExists('countryids')){
	     $userCountryids= $session->offsetGet('countryids');
	     }
      
        return $userCountryids;
     }

    /**
     * Function to  getEntityManager
     * @param NA
     * @author Abhinav
     */
    protected function getEntityManager() {
        if (null === $this->em)
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return $this->em;
    }

    /**
     * Function to  index Action
     * @param NA
     * @author Abhinav
     */
    public function indexAction() {
       $this->layout()->setTemplate('layout/master');  
       $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findAll();
        $countriesData=array();
       $userCountryids=$this->getuserCountryids();
        foreach($countries as $country ){
        $countriesData[$country->id]=$country->name;    
        } 
      if ($this->zfcUserAuthentication()->hasIdentity()) {
            //get the user_id of the user
            $role_id = $this->zfcUserAuthentication()->getIdentity()->role_id;
        }
        
    
   $whereData=array();
   if(count($userCountryids)){
      $whereData= array('country'=>$userCountryids);
   }
        
     $users=$this->getEntityManager()->getRepository('SamUser\Entity\Users')->findBy($whereData,array('created' => 'DESC'));
     return new ViewModel(
            array(
               'countries'=>$countriesData,
           'users' => $users,
           'myroleid'=>$role_id,
            )
        );
    
    }

    /**
     * Function to  edit Action
     * @param NA
     * @author Abhinav
     */
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
       
        $userCountryids=$this->getuserCountryids();
        $whereData=array();
    if(count($userCountryids)){
      $whereData= array('id'=>$userCountryids);
     }
        
     
        $countries=$this->getEntityManager()->getRepository('SamUser\Entity\Country')->findBy($whereData,array('name' => 'ASC') );
       
       
        $countriesData=array();
               foreach($countries as $country ){
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
           $areaGroups=json_encode($request->getPost('areagroups')); 
           $user=$this->getEntityManager()->getRepository('SamUser\Entity\Users')->findOneBy(array('id'=>$id ) );
           $user->role_id=$rolePost;
           $user->created =new DateTime();
           $this->getEntityManager()->persist($user);
                $this->getEntityManager()->flush();
          if(in_array($rolePost,array(3,4))){
              
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
       
        
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            //get the user_id of the user
            $role_id = $this->zfcUserAuthentication()->getIdentity()->role_id;
        }
        
         return new ViewModel(
            array(
               'countries' => $countriesData,
               'areagroups' =>$areaGroupsData,
               'roleid' => $user->role_id,
               'myroleid'=>$role_id,
               'roleCountry' =>$roleCountry,
               'roleGroups' =>$roleGroups,
            )
        );
        
    }
    

     
   
}
