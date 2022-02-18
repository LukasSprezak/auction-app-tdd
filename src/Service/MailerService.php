<?php
declare(strict_types=1);
namespace App\Service;

use App\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class MailerService
{
    public function __construct(
        private MailerInterface $mailer,
        protected Environment $twig,
        private string $testEmail,
        protected RouterInterface $router,
        private LoggerInterface $logger
    ) {}

    public function sendAddProductOffer(User $user): TemplatedEmail
    {
        $email = (new TemplatedEmail())
            ->to(new Address(
                $user->getEmail(),
            ))
            ->subject('You have successfully added a product offer')
            ->htmlTemplate('partial/email/add-product-offer.html.twig')
            ->from($this->testEmail)
            ->to($this->testEmail)
            ->context([
                'user' => $user,
            ]);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $exception) {
            $exception->getMessage();
        }

        return $email;
    }

    public function sendResetPassword(User $user): TemplatedEmail
    {
        $urlParameter = ['token' => $user->getToken()];
        $resetPasswordUrl = $this->router->generate('user_password_reset_token', $urlParameter, UrlGeneratorInterface::ABSOLUTE_URL);

        $email = (new TemplatedEmail())
            ->to(new Address(
                $user->getEmail(),
            ))
            ->subject('Reset password for your account')
            ->htmlTemplate('partial/email/reset-password-link.html.twig')
            ->from($this->testEmail)
            ->to($this->testEmail)
            ->context([
                'user' => $user->getToken(),
                'resetPasswordUrl' => $resetPasswordUrl
            ]);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $exception) {
            $exception->getMessage();
        }

        return $email;
    }

    public function sendActiveRegisterLink(User $user): TemplatedEmail
    {
        $urlParameter = ['token' => $user->getToken()];
        $activeAccountUrl = $this->router->generate('active_account_token', $urlParameter, UrlGeneratorInterface::ABSOLUTE_URL);

        $email = (new TemplatedEmail())
            ->to(new Address(
                $user->getEmail(),
            ))
            ->subject('Confirm your user account registration.')
            ->htmlTemplate('partial/email/active-account.html.twig')
            ->from($this->testEmail)
            ->to($this->testEmail)
            ->context([
                'user' => $user->getToken(),
                'username' => $user->getUsername(),
                'expiration_date' => new \DateTime('+1 hours'),
                'activeAccountUrl' => $activeAccountUrl
            ]);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $exception) {
                $this->logger->warning(
                    sprintf('Failed to deliver the message: %s', $exception->getMessage()), [
                        'exception' => $exception,
                    ]
                );
            }

        return $email;
    }
}