<?php
declare(strict_types=1);
namespace App\DataFixtures;

use App\Entity\ProductOffer;
use App\Enum\CompanyOrIndividualEnum;
use App\Enum\StateProductEnum;
use App\Enum\StatusProductOfferEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;

class ProductOfferFixtures extends Fixture
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $now = new \DateTime();

        for ($i = 0; $i < 10; $i++) {

           $productOffer = new ProductOffer();
           $productOffer->setTitle('Computer');
           $productOffer->setDescription('Text description');
           $productOffer->setPrice(random_int(10, 100));
           $productOffer->setStateOfProduct(StateProductEnum::NEW);
           $productOffer->setGiveForFree(true);
           $productOffer->setEnabled(true);
           $productOffer->setStatus(StatusProductOfferEnum::PUBLISHED);
           $productOffer->setCompanyOrIndividual(CompanyOrIndividualEnum::COMPANY);
           $productOffer->setCreatedAt($now);
           $productOffer->setUpdateAt($now);
           $productOffer->setExpiresAt($now);
           $manager->persist($productOffer);
       }

        $manager->flush();

    }
}