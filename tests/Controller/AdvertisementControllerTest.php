<?php
declare(strict_types=1);
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AdvertisementControllerTest extends WebTestCase
{
    /**
     * @dataProvider getUrlsThatDontHavePermissions
     * @param string $url
     */
    public function testHomePage(string $url): void
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertEquals( Response::HTTP_OK, $client->getResponse()->getStatusCode());
        self::assertResponseIsSuccessful($url);
    }


    public function getUrlsThatDontHavePermissions(): ?\Generator
    {
        yield ['/'];
    }

    public function getUrlAddressesThatHavePermissions(): ?\Generator
    {
        yield [''];
    }
}
