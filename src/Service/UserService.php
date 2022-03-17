<?php
declare(strict_types=1);
namespace App\Service;

use App\Entity\CustomerInformation;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Twig\Environment;
use Symfony\Component\Routing\RouterInterface;

class UserService
{
    private const TOKEN_LENGTH = 32;
    private const ALPHABET = 'abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789';

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected UserPasswordHasherInterface $userPasswordHasher,
        protected Environment $twig,
        protected RouterInterface $router,
        protected MailerService $mailerService,
        private ManagerRegistry $doctrine,
    ) {}

    public function changePassword(User $user, UserPasswordHasherInterface $hasher): bool
    {
        if (null === $user->getPlainPassword()){
            throw new \RuntimeException('No new password has been set.');
        }

        $password = $hasher->hashPassword($user, $user->getPlainPassword());
        $user->setPassword($password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return true;
    }

    public function sendLinkToNewPassword($email): bool
    {
        $user = $this->doctrine->getRepository(User::class)
            ->findOneBy(['email' => $email]);

        if (null === $user) {
            throw new UserNotFoundException('User not found.');
        }

        $user->setToken($this->getGenerateRandomToken(self::TOKEN_LENGTH));
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->mailerService->sendResetPassword($user);

        return true;
    }

    public function createRegisterUser(
        User $user,
        CustomerInformation $customerInformation,
        MailerService $mailerService, UploadService $uploadService, UploadedFile $file): bool
    {
        $now = new DateTime;

        if (!is_null($user)) {
            $customerInformation->setUserId($user);
        }

        $user->setToken($this->getGenerateRandomToken(self::TOKEN_LENGTH));
        $user->setEnabled(false);
        $user->setExpiresEnabled($now);

        $uploadService->upload($file, $user);

        $this->entityManager->persist($user);
        $this->entityManager->persist($customerInformation);
        $this->entityManager->flush();

        $mailerService->sendActiveRegisterLink($user);

        return true;
    }

    public function activeAccount($token): bool
    {
        $user = $this->doctrine->getRepository(User::class)
            ->findOneBy(['token' => $token]);

        $user->setEnabled(true);
        $user->setToken(null);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return true;
    }

    public function getGenerateRandomToken(int $length): string
    {
        $maxNumber = strlen(self::ALPHABET);
        $token = '';

        for ($index = 0; $index < $length; $index++) {
            try {
                $token .= self::ALPHABET [random_int(0, $maxNumber - 1)];
            } catch (\Exception $exception) {}
        }

        return $token;
    }
}