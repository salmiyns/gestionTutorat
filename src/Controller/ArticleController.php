<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="admin")
     */
    public function index()
    {
        return $this->render('demo1.base.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    /**
     * @Route("/article/all", name="allArticle")
     */
    public function showAll()
    {
        return $this->render('article/all.html.twig', [
            'msg' => 'this page of list all articles ',
        ]);
    }

        /**
     * @Route("/article/{cours}", name="cours")
     */
    public function showCourse($cours)
    {
        return $this->render('article/cours.html.twig', [
            'msg' => 'this page of one of the courses  ',
            'cours'=>$cours
        ]);
    }


}
