<?php
/**
 * news
 * This module will be used for news
 *@package controller
 *@author Abhinav
 */

namespace News\Controller;

use News\Entity\News;
use News\Form\NewsForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use DoctrineExtensions\Query\Mysql;
use Zend\Stdlib\DateTime;

class NewsController extends AbstractActionController
{
/**
* Entity manager instance
* @var Doctrine\ORM\EntityManager
*/
protected $em;

    public $fileuploaderr=array(
        'size'=>array('The image you tried to upload.it needs to be at min Width 100 and Max Width 300')
    ,'type'=>array('Please enter a file with a valid extension (jpg, gif, png) in image.')
    ,'sizemb'=>array(' Image must be smaller than 4 MB') );
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

    $queryBuilder = $this->getEntityManager()->createQueryBuilder();
    $queryBuilder->select("u.id,u.title,u.description,u.country,u.created,u.image")
        ->from('News\Entity\News', 'u')
        ->andWhere('REGEXP(u.country, :regexp) = true')
        ->orderBy('u.created','DESC')
        ->setParameter('regexp', '(^|,)('.$country.')(,|$)');
    $news = $queryBuilder->getQuery()->getResult();


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


            $files   = $request->getFiles();
            $data =$this->getRequest()->getPost()->toArray();




            $news = new News();
            $form->setInputFilter($news->getInputFilter());
            $form->setData($request->getPost());


            if ($form->isValid()) {


                $flag=1;
                $newImage =$files['image']['name'];
                if(strlen($newImage))  {
                    $validIsImage = new \Zend\Validator\File\IsImage();
                    /* values here minWidth,minHeight,maxWidth,maxHeight   */
                    //     $validImageSize = new \Zend\Validator\File\ImageSize(100, 100, 300,300 );
                    $validSize = new \Zend\Validator\File\Size(array('min' => '1kB', 'max' => '1MB'));
                    if(!$validIsImage->isValid($files['image'])){

                        $form->get('image')->setMessages($this->fileuploaderr['type']);
                        $flag=0;

                        //  }elseif(!$validImageSize->isValid($files['picture'])){
                        //   $form->get('picture')->setMessages($this->fileuploaderr['size']);
                        //   $flag=0;

                    }elseif(!$validSize->isValid($files['image'])){
                        $form->get('image')->setMessages($this->fileuploaderr['sizemb']);
                        $flag=0;
                    }

                }
                if($flag) {
                     $photo_src = $_FILES['image']['tmp_name'];

                    if (is_file($photo_src)) {
                        // photo path in our example
                        $userImage = 'photo_' . time() . '.jpg';
                        $photo_dest = PUBLIC_PATH . '/img/news/' . $userImage;
                        // copy the photo from the tmp path to our path
                        copy($photo_src, $photo_dest);
  if($data['x']!=0 && $data['y']!=0 && $data['w']!=0&& $data['h']!=0 ) {
      $targ_w = 300;
      $targ_h = 270;
      $jpeg_quality = 90;
      $src = $photo_dest;
      $img_r = imagecreatefromjpeg($src);
      $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
      // crop photo
      imagecopyresampled($dst_r, $img_r, 0, 0, $data['x'], $data['y'], $targ_w, $targ_h, $data['w'], $data['h']);
      // create the physical photo
      imagejpeg($dst_r, $src, $jpeg_quality);
  }
                        $data['image'] = '/img/news/' . $userImage;
                    } else {
                        $data['image'] = '';
                    }


                    foreach($data as $key=>$val){
                       if($key=='country'){
                           $news->$key=implode(',',$val);
                       }else{
                           $news->$key=$val;
                       }


                    }


                    $news->created=new DateTime();

                    $this->getEntityManager()->persist($news);
                $this->getEntityManager()->flush();
                $session = new Container('message');
	            $session->success = 'Data saved successfully';
                // Redirect to list of Learningtools
                return $this->redirect()->toRoute('news',array(
                'action' => 'newstool'
            ));
            }}
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
        $form->get('country')->setValueOptions($ValueOptions)->setValue(explode(',',$news->country)) ;
           $form->get('status')->setValue($news->status) ;

        $form->get('submit')->setAttribute('value', 'Save');
        $request = $this->getRequest();


        if ($request->isPost()) {

            $form->setInputFilter($news->getInputFilter());
            $form->setData($request->getPost());
            $files   = $request->getFiles();
            $data =$this->getRequest()->getPost()->toArray();
            if ($form->isValid()) {
                $form->bindValues();
                $flag=1;
                $newImage =$files['image']['name'];
                if(strlen($newImage))  {
                    $validIsImage = new \Zend\Validator\File\IsImage();
                    /* values here minWidth,minHeight,maxWidth,maxHeight   */
                    //     $validImageSize = new \Zend\Validator\File\ImageSize(100, 100, 300,300 );
                    $validSize = new \Zend\Validator\File\Size(array('min' => '1kB', 'max' => '1MB'));
                    if(!$validIsImage->isValid($files['image'])){

                        $form->get('image')->setMessages($this->fileuploaderr['type']);
                        $flag=0;

                        //  }elseif(!$validImageSize->isValid($files['picture'])){
                        //   $form->get('picture')->setMessages($this->fileuploaderr['size']);
                        //   $flag=0;

                    }elseif(!$validSize->isValid($files['image'])){
                        $form->get('image')->setMessages($this->fileuploaderr['sizemb']);
                        $flag=0;
                    }

                }
                if($flag) {
                    $photo_src = $_FILES['image']['tmp_name'];

                    if (is_file($photo_src)) {
                        // photo path in our example
                        $userImage = 'photo_' . time() . '.jpg';
                        $photo_dest = PUBLIC_PATH . '/img/news/' . $userImage;
                        // copy the photo from the tmp path to our path
                        copy($photo_src, $photo_dest);
                        if($data['x']!=0 && $data['y']!=0 && $data['w']!=0&& $data['h']!=0 ) {
                            $targ_w = 300;
                            $targ_h = 270;
                            $jpeg_quality = 90;
                            $src = $photo_dest;
                            $img_r = imagecreatefromjpeg($src);
                            $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
                            // crop photo
                            imagecopyresampled($dst_r, $img_r, 0, 0, $data['x'], $data['y'], $targ_w, $targ_h, $data['w'], $data['h']);
                            // create the physical photo
                            imagejpeg($dst_r, $src, $jpeg_quality);
                        }
                        $data['image'] = '/img/news/' . $userImage;
                    } else {
                        $data['image'] =$news->image;
                    }

                    foreach($data as $key=>$val) {
                        if ($key == 'country') {
                            $news->$key = implode(',', $val);
                        } else {
                            $news->$key = $val;
                        }

                    }

                    $news->created=new DateTime();

                    $this->getEntityManager()->persist($news);
                    $this->getEntityManager()->flush();
                    $session = new Container('message');
                    $session->success = 'Data saved successfully';
                    // Redirect to list of Learningtools
                    return $this->redirect()->toRoute('news',array(
                        'action' => 'newstool'
                    ));
                }}


        }


        return array(
            'id' => $id,
            'image' => $news->image,
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

    $queryBuilder = $this->getEntityManager()->createQueryBuilder();
    $queryBuilder->select("u.id,u.title,u.description,u.country,u.created,u.status")
        ->from('News\Entity\News', 'u');


   if(count($userCountryids)){
       $country=implode('|',$userCountryids);
       $queryBuilder->andWhere('REGEXP(u.country, :regexp) = true')
          ->setParameter('regexp', '(^|,)('.$country.')(,|$)');

   }

    $queryBuilder->orderBy('u.created','DESC');
    $news = $queryBuilder->getQuery()->getResult();





    return new ViewModel(
array(
'news'=>$news,
 ));



}


}