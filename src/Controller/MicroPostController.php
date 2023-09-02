<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\MicroPostRepository;
use App\Entity\MicroPost;
use DateTime;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
	public function index(MicroPostRepository $post	): Response
	{
		dd($post->findAll());
        return $this->render('micro_post/index.html.twig', [
            'controller_name' => 'MicroPostController',
        ]);
    }
    
    #[Route('/add-micro-post', name:'app_add_micro_post')]
    public function addPost(EntityManagerInterface $entityManager): Response
    {
       $microPost = new MicroPost();
       $microPost->setTitle("Introduction to Muay Thai");
       $microPost->setText("The Art of Eight Limbs");
       $microPost->setCreated(new DateTime());
	   $entityManager->persist($microPost);
       $entityManager->flush();

       return new Response('success');
    }

    #[Route('/micro-post/{id}', name: 'app_micro_post_show')]
    public function showOne($id, MicroPostRepository $posts): Response 
    {
	    dd($posts->find($id));

    } 

    #[Route('micro-post-show/{post}', name:"app_micro_post_show_param")]
    public function showOneForParam(MicroPost $post): Response
    {
	    // by default it is fetching by id. just read the documentation on sensio/framework-extra-bundle
	    dd($post);
    }
}
