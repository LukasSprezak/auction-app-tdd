<?php
declare(strict_types=1);
namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected UserPasswordHasherInterface $userPasswordHasher,
    ) {}

    public function changePassword(User $user, UserPasswordHasherInterface $hasher): bool
    {
        if (null === $user->getPlainPassword()){
            throw new \RuntimeException('No new password has been set');
        }

        $password = $hasher->hashPassword($user, $user->getPlainPassword());
        $user->setPassword($password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return true;
    }
}