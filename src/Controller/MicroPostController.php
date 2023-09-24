<?php

namespace App\Controller;

use DateTime;
use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Form\CommentType;
use App\Form\MicroPostType;
use App\Repository\CommentRepository;

use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $post): Response
    {
        return $this->render('micro_post/index.html.twig', [
            //'posts' => $post->findAll(),
            'posts' => $post->findAllWithComments()
        ]);
    }

    #[Route('/add-micro-post', name: 'app_add_micro_post')]
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

    #[Route('micro-post-show/{post}', name: "app_micro_post_show_param")]
    public function showOneForParam(MicroPost $post): Response
    {
        dd($post);
    }


    #[Route('/micro-post/add', name: 'app_micro_post_add', priority: 2)]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $microPost = new MicroPost();
        $form = $this->createForm(MicroPostType::class, $microPost);

        $form->handleRequest($request);
        // handleRequest will let the form get the data that is being sent during the request and try to match to the fields that this form defines
        // including any validation constraints and you will need to know if the form is submitted 
        if ($form->isSubmitted() && $form->isValid()) {
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

    #[Route('/micro-post/{post}/edit', name: 'app_micro_post_edit')]
    public function edit(MicroPost $post, Request $request, EntityManagerInterface $entityManager): Response
    {
        // we let the param converter works here that is why the MicroPost was injected

        $form = $this->createForm(MicroPostType::class, $post);

        $form->handleRequest($request);
        // handleRequest will let the form get the data that is being sent during the request and try to match to the fields that this form defines
        // including any validation constraints and you will need to know if the form is submitted 
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            // read the data from the form
            $entityManager->persist($post);
            $entityManager->flush();

            //todo: Add a flash message 
            $this->addFlash('success', 'Your micro post have been successfully updated');

            // Redirect to another page
            return $this->redirectToRoute('app_micro_post');
        }

        return $this->renderForm('micro_post/edit.html.twig', [
            'form' => $form,
            'post' => $post
        ]);
    }

    #[Route('/micro-post/{post}/comment', name: 'app_micro_post_comment')]
    public function addComment(MicroPost $post, Request $request, CommentRepository $comments, EntityManagerInterface $entityManager): Response
    {
        // we let the param converter works here that is why the MicroPost was injected

        $form = $this->createForm(CommentType::class, new Comment());

        $form->handleRequest($request);
        // handleRequest will let the form get the data that is being sent during the request and try to match to the fields that this form defines
        // including any validation constraints and you will need to know if the form is submitted 
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setPost($post);
            // read the data from the form
            $entityManager->persist($comment);
            $entityManager->flush();

            //todo: Add a flash message 
            $this->addFlash('success', 'Your comment have been successfully updated');

            // Redirect to another page
            return $this->redirectToRoute('app_micro_post_show', [
                'post' => $post->getId()
            ]);
        }

        return $this->renderForm('micro_post/comment.html.twig', [
            'form' => $form,
            'post' => $post
        ]);
    }
}
