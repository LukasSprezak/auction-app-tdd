<?php
declare(strict_types=1);
namespace App\DataFixtures;

use App\Entity\CustomerInformation;
use App\Entity\ProductOffer;
use App\Entity\User;
use App\Enum\CompanyOrIndividualEnum;
use App\Enum\ProductBillingEnum;
use App\Enum\StateProductEnum;
use App\Enum\StatusProductOfferEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        $longTimeAgo = new \DateTime('-100 years');
        $now = new \DateTime();
        $user = new User();

        $userRole = (new User())
            ->setEmail('user@admin.com')
            ->setUsername("user")
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->passwordHasher->hashPassword($user, 'admin'))
        ;
        $manager->persist($userRole);

        $adminRole = (new User())
            ->setEmail('admin@admin.com')
            ->setUsername("admin")
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->passwordHasher->hashPassword($user, 'admin'))
        ;
        $manager->persist($adminRole);

        $arrayRoles = [$adminRole, $userRole];

        for ($i = 0; $i < 10; $i++) {
            $productOffer = (new ProductOffer())
                ->setTitle("Computer {$i}")
                ->setDescription("Text description {$i}")
                ->setPrice(random_int(10, 100))
                ->setStateOfProduct(StateProductEnum::NEW)
                ->setEnabled(true)
                ->setStatus(StatusProductOfferEnum::PUBLISHED)
                ->setCompanyOrIndividual(CompanyOrIndividualEnum::COMPANY)
                ->setProductBilling(ProductBillingEnum::PRICE)
                ->setNegotiablePrice(true)
                ->setCreatedAt($now)
                ->setUpdatedAt($now)
                ->setExpiresAt($now)
                ->setDeleted(false)
                ->setOwner($arrayRoles[array_rand($arrayRoles)])
            ;
            $manager->persist($productOffer);
        }

        for ($i = 0; $i < 2; $i++) {
            $customerInformation = (new CustomerInformation())
                ->setFirstName('Lukas')
                ->setLastName('Smith')
                ->setBirthday($longTimeAgo)
                ->setCity('San Francisco')
                ->setAddress('Adress')
                ->setPhoneNumber('123456789')
                ->setZipCode('00-000')
                ->setUserId($arrayRoles[array_rand($arrayRoles)])
            ;
            $manager->persist($customerInformation);
        }

        $manager->flush();
    }
}