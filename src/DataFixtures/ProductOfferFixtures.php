<?php
declare(strict_types=1);
namespace App\DataFixtures;

use App\Entity\ProductOffer;
use App\Enum\CompanyOrIndividualEnum;
use App\Enum\ProductBillingEnum;
use App\Enum\StateProductEnum;
use App\Enum\StatusProductOfferEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductOfferFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $now = new \DateTime();

        for ($i = 0; $i < 10; $i++) {

           $productOffer = new ProductOffer();
           $productOffer->setTitle('Computer');
           $productOffer->setDescription('Text description');
           $productOffer->setPrice(random_int(10, 100));
           $productOffer->setStateOfProduct(StateProductEnum::NEW);
           $productOffer->setEnabled(true);
           $productOffer->setStatus(StatusProductOfferEnum::PUBLISHED);
           $productOffer->setCompanyOrIndividual(CompanyOrIndividualEnum::COMPANY);
           $productOffer->setProductBilling(ProductBillingEnum::PRICE);
           $productOffer->setNegotiablePrice(true);
           $productOffer->setCreatedAt($now);
           $productOffer->setUpdateAt($now);
           $productOffer->setExpiresAt($now);
           $productOffer->setDeleted(false);
           $manager->persist($productOffer);
       }

        $manager->flush();

    }
}