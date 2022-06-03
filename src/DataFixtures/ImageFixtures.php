<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ImageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($img = 1; $img <= 100; $img++) {
            $image = new Image();
            $image
                ->setName($faker->imageUrl(640, 480))
                ->setProduct(
                    $this->getReference('product-' . rand(1, 10))
                );
            $manager->persist($image);
        }

        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            ProductFixtures::class
        ];
    }
}
