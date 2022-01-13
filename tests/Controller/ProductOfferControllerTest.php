<?php
declare(strict_types=1);
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductOfferControllerTest extends WebTestCase
{
    public function testHomePage(string $url): void
    {
        $client = static::createClient();
        $client->request('POST', '/add-product-offer');

        $this->assertEquals( Response::HTTP_OK, $client->getResponse()->getStatusCode());
        self::assertResponseIsSuccessful($url);

        self::assertResponseRedirects('/my-product-offer', Response::HTTP_FOUND);
    }

     public function getUrlAddressesThatHavePermissions(): ?\Generator
     {
         yield ['/add-product-offer'];
         yield ['/my-product-offer'];
     }
}
