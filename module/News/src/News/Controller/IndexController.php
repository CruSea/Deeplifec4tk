<?php

namespace News\Controller;

use News\Entity\Hydrator\CategoryHydrator;
use News\Entity\Hydrator\PostHydrator;
use News\Entity\Post;
use News\Form\Add;
use News\Form\Edit;
use News\InputFilter\AddPost;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel(array(
            'paginator' => $this->getBlogService()->fetch($this->params()->fromRoute('page')),
        ));
    }

    public function addAction()
    {
        $form = new Add();
        $variables = array('form' => $form);

        if ($this->request->isPost()) {
            $newsPost = new Post();
            $form->bind($newsPost);
            $form->setInputFilter(new AddPost());
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $this->getBlogService()->save($newsPost);
                $this->flashMessenger()->addSuccessMessage('The post has been added!');
            }
        }

        return new ViewModel($variables);
    }

    public function viewPostAction()
    {
        $categorySlug = $this->params()->fromRoute('categorySlug');
        $postSlug = $this->params()->fromRoute('postSlug');
        $post = $this->getBlogService()->find($categorySlug, $postSlug);

        if ($post == null) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
        }

        return new ViewModel(array(
            'post' => $post,
        ));
    }

    public function editAction()
    {
        $form = new Edit();

        if ($this->request->isPost()) {
            $post = new Post();
            $form->bind($post);
            $form->setData($this->request->getPost());


            if ($form->isValid()) {
                $this->getBlogService()->update($post);
                $this->flashMessenger()->addSuccessMessage('The post has been updated!');
            }
        } else {
            $post = $this->getBlogService()->findById($this->params()->fromRoute('postId'));

            if ($post == null) {
                $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            } else {
                $form->bind($post);
                $form->get('category_id')->setValue($post->getCategory()->getId());
                $form->get('slug')->setValue($post->getSlug());
                $form->get('id')->setValue($post->getId());
            }
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }

    public function deleteAction()
    {
        $this->getBlogService()->delete($this->params()->fromRoute('postId'));
        $this->flashMessenger()->addSuccessMessage('The post has been deleted!');
        return $this->redirect()->toRoute('news');
    }

    /**
     * @return \News\Service\BlogService $blogService
     */
    protected function getBlogService()
    {
        return $this->getServiceLocator()->get('News\Service\BlogService');
    }
} 