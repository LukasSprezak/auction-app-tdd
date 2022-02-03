<?php
declare(strict_types=1);
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AdvertisementControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertEquals( Response::HTTP_OK, $client->getResponse()->getStatusCode());
        self::assertSelectorTextContains('h1','Advertisement');
        self::assertResponseIsSuccessful();
    }
}
