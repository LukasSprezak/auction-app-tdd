<?php
declare(strict_types=1);
namespace App\Repository;

use App\Entity\CustomerInformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CustomerInformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerInformation::class);
    }

    public function editCustomerInformation(CustomerInformation $customerInformation): void
    {
        $this->getEntityManager()->persist($customerInformation);
        $this->getEntityManager()->flush();
    }
}
