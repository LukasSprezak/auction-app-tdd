<?php
declare(strict_types=1);
namespace App\Tests\Controller;

use App\Service\PaginationService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductOfferControllerTest extends WebTestCase
{
    private const ADD_PRODUCT_BUTTON_NAME = 'product_offer[submit]';

    public function testMyProductOffer(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/my-product-offer');

        self::assertResponseIsSuccessful();
        $this->assertEquals( Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertCount(
            PaginationService::PAGE_SIZE,
            $crawler->filter('div.container')
        );
    }

    public function testAddProductOffer(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/add-product-offer');

        $form = $crawler->selectButton(self::ADD_PRODUCT_BUTTON_NAME)->form();
        $form['product_offer[title]']->setValue('title');
        $form['product_offer[description]']->setValue('description');
        $form['product_offer[price]']->setValue(19.12);
        $form['product_offer[companyOrIndividual]']->setValue('company');
        $form['product_offer[stateOfProduct]']->setValue('new');
        $form['product_offer[productBilling]']->setValue('price');
        $form['product_offer_negotiablePrice'] = 1;
        $form['product_offer_enabled'] = 1;
        $client->submit($form);

        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin',
        ]);

        $client->submit($form);
        $client->submit($form);

        self::assertEmailCount(1);
        $email = self::getMailerMessage(0);
        self::assertEmailHeaderSame($email, 'To', 'test@example.com');
    }
}
