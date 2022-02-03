<?php
declare(strict_types=1);
namespace App\Tests\Service;

use App\Entity\User;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Twig\Environment;

class MailerServiceTest extends KernelTestCase
{
    public function testSendAddProductOffer(): void
    {
        $symfonyMailer = $this->createMock(MailerInterface::class);
        $symfonyMailer
            ->expects($this->once())
            ->method('send');

        $twigMock = $this->createMock(Environment::class);

        $user = new User();
        $user->setEmail('test@example.com');

        $testEmail = 'test@example.com';
        $mailer = new MailerService($symfonyMailer, $twigMock, $testEmail);
        $email = $mailer->sendAddProductOffer($user);

        $this->assertSame('You have successfully added a product offer', $email->getSubject());
        $this->assertCount(1, $email->getTo());

        $addresses = $email->getTo();

        $this->assertInstanceOf(Address::class, $addresses[0]);
        $this->assertSame('test@example.com', $addresses[0]->getAddress());
    }
}