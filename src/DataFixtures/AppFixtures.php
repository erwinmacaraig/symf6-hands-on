<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use DateTime;
use App\Entity\MicroPost; 

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
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
