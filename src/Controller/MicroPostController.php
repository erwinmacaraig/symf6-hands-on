<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

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
    public function add(Request $request, EntityManagerInterface $entityManager): Response 
    {
	    $microPost = new MicroPost();
	    $form = $this->createFormBuilder($microPost)
		  ->add('title')
		  ->add('text')
	  	  ->add('submit', SubmitType::class, ['label' => 'Save'])
		  ->getForm(); 

        $form->handleRequest($request);
        // handleRequest will let the form get the data that is being sent during the request and try to match to the fields that this form defines
        // including any validation constraints and you will need to know if the form is submitted 
        if ($form->isSubmitted() && $form->isValid()){
            $post = $form->getData();
            // read the data from the form
            $post->setCreated(new DateTime());
            $entityManager->persist($post);
            $entityManager->flush();

            //todo: Add a flash message 
            $this->addFlash('success', 'Your micro post have been successfully added');

            // Redirect to another page
            return $this->redirectToRoute('app_micro_post');            
        }  

	    return $this->renderForm('micro_post/add.html.twig', [
	    	'form' => $form
	    ]);

    }
}
