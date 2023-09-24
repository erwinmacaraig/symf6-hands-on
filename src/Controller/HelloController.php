<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Entity\UserProfile;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserProfileRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HelloController extends AbstractController
{
    #[Route('/hello', name: 'app_hello')]
    public function index2(): Response
    {
        return new Response("Welcome To Symfony");
    }

    #[Route('/', name: 'app_index')]
    public function index(UserProfileRepository $profiles, EntityManagerInterface $entityManager): Response
    {


        // We need to have the user first 
        // $user = new User();
        // $user->setEmail('email3@test.com');
        // $user->setPassword('12345678');

        // $profile = new UserProfile();
        // $profile->setUser($user);
        // $profile->setName('Erwin Pogi');
        // $profile->setTwitterUsername('Erwin');

        // $profiles->add($profile, true);
        // $entityManager->persist($profile);
        // $entityManager->flush();
        // $profile = $profiles->find(1);        
        // $entityManager->remove($profile);
        // $entityManager->flush();

        return $this->render('hello/index.html.twig', []);
    }

    #[Route('/post', name: 'app_post')]
    public function post(EntityManagerInterface $entityManager, MicroPostRepository $posts): Response
    {

        // $post = new MicroPost(); // Owning Entity
        // $post->setTitle('Post Title Hello');
        // $post->setText('The quick brown fox');
        // $post->setCreated(new DateTime());
        // // MicroPost has comments (relationship) so MicroPost can exists without a comment

        $post = $posts->find(5);
        $comment = $post->getComments()[0];
        $post->removeComment($comment);

        // $comment = new Comment(); // Belonging Entity 
        // $comment->setText("I need to have this skill");
        // $comment->setPost($post);

        // $post->addComment($comment);

        $entityManager->persist($post);
        $entityManager->flush();

        return $this->render('hello/index.html.twig');
    }
}
