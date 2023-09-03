<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Repository\MicroPostRepository;
use App\Entity\MicroPost;
use DateTime;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
	public function index(MicroPostRepository $post	): Response
	{
	return $this->render('micro_post/index.html.twig', [
            'posts' => $post->findAll(),
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

    #[Route('/micro-post/{post}', name: 'app_micro_post_show')]
    public function showOne(MicroPost $post): Response 
    {
        return $this->render('micro_post/show.html.twig', [
            'post' => $post,
        ]);
    } 

    #[Route('micro-post-show/{post}', name:"app_micro_post_show_param")]
    public function showOneForParam(MicroPost $post): Response
    {
	    dd($post);
    } 


    #[Route('/micro-post/add', name: 'app_micro_post_add', priority: 2)] 
    public function add(): Response 
    {
	    $microPost = new MicroPost();
	    $form = $this->createFormBuilder($microPost)
		  ->add('title')
		  ->add('text')
	  	  ->add('submit', SubmitType::class, ['label' => 'Save'])
		  ->getForm(); 

	    return $this->renderForm('micro_post/add.html.twig', [
	    	'form' => $form
	    ]);

    }
}
