<?php
declare(strict_types=1);
namespace App\DataFixtures;

use App\Entity\ProductOffer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductOfferFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $productOffer = new ProductOffer();
        $productOffer->setTitle('Computer');
        $productOffer->setDescription('Text description');
        $productOffer->setPrice(1000.10);
        $productOffer->setEnabled(true);
        $manager->persist($productOffer);

        $manager->flush();
    }
}