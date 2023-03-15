<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ArticleType;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo): Response
    {   $articles= $repo->findAll(); 
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles'=>$articles,
        ]);
    }
    /**
     * @Route("/",name="home")
     */

    public function home()
    {
        return $this->render('blog/home.html.twig');
    }
     /**
     * @Route("/blog/new",name="blog_new")
     * @Route("/blog/{id}/edit",name="blog_edit")
     */
    public function create(Article $article = null ,Request $request,ObjectManager $manager)
    {   if(!$article){
        $article = new Article();
        }
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            if(!$article->getId()){
                $article->setCreateAt(new \DateTimeImmutable());
            } 
            $manager->persist($article);
            $manager->flush();
        }
        return $this->render('blog/create.html.twig',[
            'formArticle' => $form->createView(),
            'editMode' =>$article->getId() !==null
        ]);

    }
    /**
     * @Route("/blog/{id}",name="blog_show")
     */

     public function show(Article $article)
     { 
         return $this->render('blog/show.html.twig',['article'=>$article]);
     }
}
