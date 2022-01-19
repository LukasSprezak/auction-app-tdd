<?php
declare(strict_types=1);
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductOfferControllerTest extends WebTestCase
{
    /**
     * @param string $url
     */
    public function testAddProductOffer(string $url): void
    {
        $client = static::createClient();
        $client->request('POST', '/add-product-offer');

        $this->assertEquals( Response::HTTP_OK, $client->getResponse()->getStatusCode());
        self::assertResponseIsSuccessful($url);
    }
}
