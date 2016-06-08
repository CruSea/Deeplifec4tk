<?php

namespace UserCountries\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Doctrine\ORM\EntityManager;
use DoctrineExtensions\Query\Mysql;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\Session\Container;
class UserCountries extends AbstractHelper   {
   
  protected $em;
    public function __invoke($role_id,$id) {
  $countryids =array();
if($role_id!=2){
 
       $roleArea =$this->getEntityManager()
        ->getRepository('SamUser\Entity\Rolearea')
        ->findOneBy(array('user_id' => $id ));

     if($roleArea){
           $roleAreaid=$roleArea->area_groupsid;
           if(!$roleAreaid){
            $countryids[]=$roleArea->countryid;
           }elseif($roleAreaid){
                  $areaGroups =$this->getEntityManager()
                    ->getRepository('SamUser\Entity\Areagroups')
                    ->findBy(array('id' => json_decode($roleAreaid) ));
            $countryids=array();
        foreach($areaGroups as $areaGroup )
         {
         $tempdata=json_decode($areaGroup->countries_ids) ;
         $countryids=array_merge($countryids,$tempdata);
         }
        
        
         
           }


    }
}

   $session = new Container('userCountryids');
   $session->countryids = array_unique($countryids);


    }

    
public function getEntityManager(){
        if (null === $this->em) {
          
           $this->em = $this->getView()
                        ->getHelperPluginManager()
                        ->getServiceLocator()
                        ->get('doctrine.entitymanager.orm_default');
  
        }
        return $this->em;
    }



}