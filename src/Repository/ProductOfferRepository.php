<?php
declare(strict_types=1);
namespace App\Repository;

use App\Entity\ProductOffer;
use App\Enum\StatusProductOfferEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Service\PaginationService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

class ProductOfferRepository extends ServiceEntityRepository
{
    private const ENABLED = 1;
    private const NOT_DELETED = 0;
    private const PAGE = 1;

    public function __construct(ManagerRegistry $registry, private Security $security)
    {
        parent::__construct($registry, ProductOffer::class);
    }

    public function createProductOffer(ProductOffer $productOffer): void
    {
        if ($productOffer->isEnabled() === true) {
            $productOffer->setStatus(StatusProductOfferEnum::PUBLISHED);
        } else {
            $productOffer->setStatus(StatusProductOfferEnum::DRAFT);
        }

        $productOffer->setOwner($this->security->getUser());
        $this->getEntityManager()->persist($productOffer);
        $this->getEntityManager()->flush();
    }

    public function deleteProductOffer(ProductOffer $productOffer): void
    {
        $productOffer->setDeleted(true);

        $this->getEntityManager()->persist($productOffer);
        $this->getEntityManager()->flush();
    }

    public function getProductOffersPaginator(int $page = self::PAGE): PaginationService
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->where("p.enabled = :enabled")
            ->setParameter('enabled', self::ENABLED)
            ->andwhere('p.deleted = :deleted')
            ->setParameter('deleted', self::NOT_DELETED)
            ->andwhere('p.owner = :owner')
            ->setParameter('owner', $this->security->getUser())
            ->orderBy('p.createdAt', 'DESC')
        ;

        return (new PaginationService($queryBuilder))
            ->pagination($page);
    }

    public function getAllProductOffersPaginator(int $page = self::PAGE): PaginationService
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->where("p.enabled = :enabled")
            ->setParameter('enabled', self::ENABLED)
            ->andwhere('p.deleted = :deleted')
            ->setParameter('deleted', self::NOT_DELETED)
            ->orderBy('p.createdAt', 'DESC')
        ;

        return (new PaginationService($queryBuilder))
            ->pagination($page);
    }
}
