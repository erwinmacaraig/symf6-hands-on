<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;

use App\Entity\MicroPost;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

	public function __construct(
		private UserPasswordHasherInterface $userPasswordHasher
	) {
	}

	public function load(ObjectManager $manager): void
	{

		$user1 = new User();
		$user1->setEmail('admin@test.com');
		$user1->setPassword(
			$this->userPasswordHasher->hashPassword($user1, '12345678')
		);
		$manager->persist($user1);

		$user2 = new User();
		$user2->setEmail('erwin@test.com');
		$user2->setPassword(
			$this->userPasswordHasher->hashPassword($user2, '12345678')
		);
		$manager->persist($user2);


		// $product = new Product();
		// $manager->persist($product);

		$micropost1 = new MicroPost();
		$micropost1->setTitle('Welcome S sumfony 6');
		$micropost1->setText('Learning PHP Framwaorks is fun!');
		$micropost1->setCreated(new DateTime());
		$manager->persist($micropost1);

		$micropost2 = new MicroPost();
		$micropost2->setTitle('PHP for Web Development');
		$micropost2->setText('This is the way to go');
		$micropost2->setCreated(new DateTime());
		$manager->persist($micropost2);

		$micropost3 = new MicroPost();
		$micropost3->setTitle('Flutter for Mobile');
		$micropost3->setText('I am Leraning Flutter too');
		$micropost3->setCreated(new DateTime());
		$manager->persist($micropost3);



		$manager->flush();
	}
}
