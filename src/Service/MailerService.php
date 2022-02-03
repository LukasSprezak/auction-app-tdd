<?php
declare(strict_types=1);
namespace App\Service;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Twig\Environment;

class MailerService
{
    public function __construct(private MailerInterface $mailer, protected Environment $twig, private string $testEmail) {}

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
        } catch (TransportExceptionInterface $exception) {}

        return $email;
    }
}