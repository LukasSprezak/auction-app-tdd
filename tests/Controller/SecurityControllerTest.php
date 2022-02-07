<?php
declare(strict_types=1);
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin(): void
    {
        $client = static::createClient();
        $client->followRedirects();
        $client->request('GET', '/login');
        $client->submitForm('Sign in', [
            'email' => 'admin',
            'password' => 'admin',
        ]);

        $client->request('GET', '/');
        $this->assertEquals( Response::HTTP_OK, $client->getResponse()->getStatusCode());
        self::assertSelectorTextContains('h1','Advertisement');
        self::assertResponseIsSuccessful();
    }
}