<?php
/**
 * Created by PhpStorm.
 * User: Sami
 * Date: 11/12/15
 * Time: 12:53 AM
 */

namespace SamUser\Controller;
use Zend\Validator\Digits as Digits;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use SamUser\Entity\Users;
use SamUser\Entity\Disciplescount;
use Doctrine\ORM\EntityManager;
use DoctrineExtensions\Query\Mysql;


class TreeController extends AbstractActionController
{
    
    protected $users;
    protected $em;
    public $userid;
    protected $entity = 'SamUser\Entity\User';
    
public function getEntityManager(){
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }
Public function indexAction() {
      
      $id = (int) $this->params()->fromRoute('id', 0);
      
        
       $this->layout()->setTemplate('layout/master'); 
        return new ViewModel(array(
            'Url' => '/',
            'title' => 'Generation Tree',
            'id'=>$id ,       
        ));

    }
public function jsonAction(){
       
           $id = (int) $this->params()->fromRoute('id', 0);
       
        
        if (!$id) {
          
    
            //get the user_id of the user
            $userid = $this->zfcUserAuthentication()->getIdentity()->getId();
            $avatar='/avatar/noavatar.jpg';
           if( is_file('public'.$this->zfcUserAuthentication()->getIdentity()->picture)){ 
               $avatar=$this->zfcUserAuthentication()->getIdentity()->picture;
                }   
           $name= ucwords($this->zfcUserAuthentication()->getIdentity()->displayName);

            
     
            } else{
                $rootUser = $this->getEntityManager()->find('SamUser\Entity\Users', $id);
                              
                $userid =$rootUser->id;
               $avatar='/avatar/noavatar.jpg';
              if( is_file('public'.$rootUser->picture)) { 
               $avatar=$rootUser->picture;
                }   
                $name= ucwords($rootUser->displayName);

               
            
            
            }
    
    
    
     $users =$this->getEntityManager()->getRepository('SamUser\Entity\Users')->findBy(array('mentor_id' => $userid ));
   
  
  if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
     $url= $protocol . "://" . parse_url($this->getRequest()->getUri(), PHP_URL_HOST);
 // $url=$url.'/deeplife/public';
    $rootUSerCount= 0;

          $tree['name'] =  $name;
          $tree['icon'] = $url.''.$avatar;
          $tree['user_id'] = $userid;
          $tree['immediate'] = $rootUSerCount;
          $tree['total'] = $this->countParentChildTree($userid);
          $tree['url'] = $url.'/tree/'.$userid;
          $tree['parent_url'] = $url.'/tree/'.$userid;
          $tree['draggable'] = true;
          $tree['children'] = $this->parentChildTree($userid);
 
        $jsonArray= array();
        $jsonArray['config']['isDraggable']=true;
        $jsonArray['config']['treeType']='user' ;
        $jsonArray['config']['currentUserType']='countryAdmin';
        $jsonArray['tree']=$tree;
  
        return new JsonModel($jsonArray);
  
    }
public function updatejsonAction(){
        $result['status']='error';
        $result['code']='401';
        $request = $this->getRequest();
      if ($request->isPost()) {
        
            $data=$this->getRequest()->getPost()->toArray();
           $parent=$data['parent'];
           $user=$data['user'];
           $valid = new Digits();
           if(!$valid->isValid($parent) && !$valid->isValid($parent) ){
                 $result['status']='error';
                 $result['code']='402';
           }else{
            $em =$this->getEntityManager();
            $users = $em->find('SamUser\Entity\Users', $user);
           if($users->id!=$parent){
                $users->mentor_id=$parent;
           }else {
               $result['status']='error';
                 $result['code']='4022';
           }
           
            try {
            $result['status']='success';
            $result['code']='0';
            $em->flush();
            }catch ( Exception $e ) {
            $result['status']='error';
            $result['code']='403';
            } 
        
           
           }
           
           
        }
        
       
  
        return new JsonModel($result);
    }
public function parentChildTree($parent = 0) {
   $users =$this->getEntityManager()->getRepository('SamUser\Entity\Users')->findBy(array('mentor_id' => $parent ));
if(isset($_SERVER['HTTPS'])){
      $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
       $protocol = 'http';
    }
    $url= $protocol . "://" . parse_url($this->getRequest()->getUri(), PHP_URL_HOST);
  // $url=$url.'/deeplife/public';
    $i=0;
    foreach ($users as $user){
      $avatar='/avatar/noavatar.jpg';
              if( is_file('public'.$user->picture)) { 
               $avatar=$user->picture;
                }    
            $tree[$i]['name'] = ucwords($user->displayName);
            $tree[$i]['icon'] = $url.''.$avatar;
            $tree[$i]['immediate'] = 0;
            $tree[$i]['user_id'] = $user->id;
           if($user->mentor_id==null){
            $tree[$i]['parent_url'] = $url.'/tree/'.$user->id;
           }else{
            $tree[$i]['parent_url'] = $url.'/tree/'.$user->mentor_id;
            }
            $tree[$i]['draggable'] = true;
            $tree[$i]['total'] = $this->countParentChildTree($user->id);
            $tree[$i]['url'] = $url.'/tree/'.$user->id;
                 
           if($user->id!=$user->mentor_id){   
          $children=$this->parentChildTree($user->id );
          }
           if(is_array($children)){
                $childCount=count($children);
                $tree[$i]['children'] =$children;
                $tree[$i]['immediate'] =$childCount;
               
           }
        
           $i++;
    
    
    }


	return $tree;
}
public  function countParentChildTree($userid) {

$disciplescount=0;
$usersCouny = $this->getEntityManager()->getRepository('SamUser\Entity\Disciplescount')->findOneBy(array('user_id' => $userid ));
if(!$usersCouny ){
    $disciplescount=0;
 }else{
     $disciplescount=$usersCouny->disciplescount;
  }
 
  return $disciplescount;

}
public function ajaxchartAction() {
     
        $request = $this->getRequest();
      if ($request->isPost()) {
          
      
       $countriesid=$this->getRequest()->getPost('ids');
         
     $countryChartData=$this->countryChartData($countriesid);
 
    
     $queryBuilder = $this->getEntityManager()->createQueryBuilder();
     $queryBuilder->select('u.id,u.name')   
     ->from('SamUser\Entity\Country', 'u')
     ->andWhere('u.id IN (:countryid)')
     ->orderBy('u.name')
     ->setParameter('countryid', $countriesid);
      $countries = $queryBuilder->getQuery()->getScalarResult();
      foreach($countries as $country ){
        $countriesData[$country['id']]=$country['name'];    
        } 
        
     
        
      
     $this->renderer = $this->getServiceLocator()->get('ViewRenderer');
     echo $content =$this->renderer->render('chart',array('chart'=>$countryChartData, 'countries'=>$countriesData));
   
       die;
       
       }
       
 }
public function countryAction() {
    $this->layout()->setTemplate('layout/master');  
    $countryData=array();
    $countriesid=array();   
    $countriesData=array();
    $countryChartData=array();
    $stageData=array();
    $userid = $this->zfcUserAuthentication()->getIdentity()->getId();
    $user =$this->getEntityManager()->getRepository('SamUser\Entity\Rolearea')->findOneBy(array('user_id' => $userid ));
    $roleCountry=trim($user->area_groupsid);
   if($roleCountry){

  $areaGroups =$this->getEntityManager()->getRepository('SamUser\Entity\Areagroups')->findOneBy(array('id' => $roleCountry ));
  if(count($areaGroups)){
   
     $countriesid=json_decode($areaGroups->countries_ids) ; 
  } 
  
   }else {
   $roleCountry=trim($user->countryid);
   $countriesid=array($roleCountry);   
   }
   
 
  if(count($countriesid)){
      
 
     $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select("count(u.id)as totaluser ,SUM(IFELSE(u.stage='win',1,0)) AS win,SUM(IFELSE(u.stage='build',1,0)) AS build,SUM(IFELSE(u.stage='send',1,0)) AS send")   
         ->from('SamUser\Entity\Users', 'u')
             ->andWhere('u.country IN (:country)')
            ->setParameter('country', $countriesid);
    $stageData = $queryBuilder->getQuery()->getScalarResult();
   // $countriesid = array_slice($countriesid, 0, 3); 
   
      $queryBuilder = $this->getEntityManager()->createQueryBuilder();
     $queryBuilder->select('u.id,u.name')   
     ->from('SamUser\Entity\Country', 'u')
     ->andWhere('u.id IN (:countryid)')
     ->orderBy('u.name')
     ->setParameter('countryid', $countriesid);
      $countries = $queryBuilder->getQuery()->getScalarResult();
      foreach($countries as $country ){
        $countriesData[$country['id']]=$country['name'];    
        } 
      $countryData=$this->countryData($countriesid);
     
    }
    
     return new ViewModel(
            array(
            'countries'=>$countriesData,
            'buildmovements'=>$countryData,
               'stage'=>$stageData,
            
            )
        );
    
   }
public function countryData($countryIds) {
   $countryData=array();    
   $countryInfo=array();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select("u.country,SUM(IFELSE(u.stage='win',1,0)) AS win,SUM(IFELSE(u.stage='build',1,0)) AS build,SUM(IFELSE(u.stage='send',1,0)) AS send")   
         ->from('SamUser\Entity\Users', 'u')
          ->andWhere('u.country IN (:country)')
           ->groupBy('u.country')
        ->setParameter('country', $countryIds);
  
        $countryData = $queryBuilder->getQuery()->getScalarResult();
        foreach ($countryData  as $country ){
            $countryInfo[$country['country']]['win']=$country['win'];
            $countryInfo[$country['country']]['build']=$country['build'];
             $countryInfo[$country['country']]['send']=$country['send'];
        }
 
    return $countryInfo;
    }
public function countryChartData($countryIds) {
        $countryData=array();    
        $countryIds = array_slice($countryIds, 0, 3); 
    
          
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select("u.country,YEAR(u.created) as ycreated,SUM(IFELSE(u.stage='win',1,0)) AS win,SUM(IFELSE(u.stage='build',1,0)) AS build,SUM(IFELSE(u.stage='send',1,0)) AS send")->from('SamUser\Entity\Users', 'u')
        ->andWhere('u.country IN (:country)')
       ->groupBy('ycreated,u.country')
        ->setParameter('country', $countryIds);
  
     $countryData = $queryBuilder->getQuery()->getScalarResult();
 
 
   $chartData=array();
   foreach($countryData as $val ){
   $chartData[$val['ycreated']]['win'][$val['country']]=$val['win'];
   $chartData[$val['ycreated']]['build'][$val['country']]=$val['build'];
   $chartData[$val['ycreated']]['send'][$val['country']]=$val['send'];
    }
 
  
 
 foreach($chartData as $key=>$chart){
     foreach($chart as $key1=>$stage){
   $stage['year']=(string)$key;
 
  if($key1=='win'){
  $win[]= $stage ;       
  }
  if($key1=='build'){
  $build[]= $stage ;       
  }
 
  if($key1=='send'){
  $send[]= $stage ;       
  }
    
  
     }
     
 } 
 $countryData=array();
  if(count($win))
  $countryData['win']=$win;
  if(count($build)) 
  $countryData['build']=$build;
   if(count($send))
  $countryData['send']=$send;
  
   
    
    
    return $countryData;
    }
public function learnAction() {
    $this->layout()->setTemplate('layout/master');  
    
    
     return new ViewModel(
            array(
          
            'stage'=>'',
            
            )
        );
    
   }
public function totalAction() {
    
   $users =$this->getEntityManager()->getRepository('SamUser\Entity\Users')->findAll( );
   echo "Start Cron Time:: ".date('m/d/Y h:i:s a', time()).'<br/>';
  foreach($users as $user){
      $total=0;
           
      $total=count($this->disciplecount($user->id));
      $usersTotal = $this->getEntityManager()->getRepository('SamUser\Entity\Disciplescount')->findOneBy(array('user_id' => $user->id ));
     if(!$usersTotal ){
     $usersTotal=new Disciplescount();
     $usersTotal->user_id=$user->id;
     }
     $usersTotal->disciplescount=$total;
     $this->getEntityManager()->persist($usersTotal);
     $this->getEntityManager()->flush();
   
   } 
   echo "End Cron Time:: ".date('m/d/Y h:i:s a', time());
   die;
   }
public function disciplecount($parent){
    ini_set('max_execution_time', 0);
 $users =$this->getEntityManager()->getRepository('SamUser\Entity\Users')->findBy(array('mentor_id' => $parent ));
    foreach ($users as $user){
          $tree[$user->id]=$user->id;
       // echo $user->id.'<br/>---';

         if($user->id!=$user->mentor_id){
             $children=$this->disciplecount($user->id );
         }

          if(is_array($children)){
                 $tree = array_merge($tree,$children);
               
               
           }
  }
return $tree;

}

      public function userjsonAction(){
           $str=$this->params()->fromQuery('q', 0);
           $str='%'.$str.'%';
           
           $result = $this->getEntityManager()->getRepository("SamUser\Entity\Users")->createQueryBuilder('o')
           ->where('o.displayName LIKE  :displayName')
            ->orWhere('o.email LIKE :email')
           ->setParameter('email', $str)
           ->setParameter('displayName', $str)
           ->setMaxResults(5)
           ->getQuery()
           ->getResult(); 
            $data=array();
        
          if(isset($_SERVER['HTTPS'])){
      $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
       $protocol = 'http';
    }
    $url= $protocol. "://" . parse_url($this->getRequest()->getUri(), PHP_URL_HOST);
           
           
           $i=0;
            foreach($result as $val){
             $avatar='/avatar/noavatar.jpg';
              if( is_file('public'.$val->picture)) { 
              $avatar=$val->picture;
              } 
                  $url.= $avatar;
                   $data[$i]['id']=ucwords($val->id);
                  $data[$i]['first_name']=ucwords($val->displayName);
                  $data[$i]['last_name']='';
                  $data[$i]['url']=trim($url);
                  $data[$i++]['email']=$val->email;
           $url='';
           
            }
                              
            
    
       return new JsonModel($data);
      }

}



