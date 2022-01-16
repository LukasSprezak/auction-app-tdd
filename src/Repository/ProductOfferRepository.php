<?php
declare(strict_types=1);
namespace App\Repository;

use App\Entity\ProductOffer;
use App\Enum\StatusProductOfferEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductOfferRepository extends ServiceEntityRepository
{
    private const ENABLED = 1;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductOffer::class);
    }

    public function getPublicProductOffers(): array
    {
        return $this->createQueryBuilder('p')
            ->where("p.enabled = :enabled")
            ->setParameter('enabled', self::ENABLED)
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function createProductOffer(ProductOffer $productOffer): void
    {
        if ($productOffer->isEnabled() === true) {
            $productOffer->setStatus(StatusProductOfferEnum::PUBLISHED);
        } else {
            $productOffer->setStatus(StatusProductOfferEnum::DRAFT);
        }

        $this->getEntityManager()->persist($productOffer);
        $this->getEntityManager()->flush();
    }
}
