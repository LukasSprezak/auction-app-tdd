<?php
declare(strict_types=1);
namespace App\Tests\Controller;

use App\Repository\ProductOfferRepository;
use App\Repository\UserRepository;
use App\Service\PaginationService;
use App\Tests\Helper\TestHelper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductOfferControllerTest extends WebTestCase
{
    private const ADD_PRODUCT_BUTTON_NAME = 'Add product';
    private const EDIT_PRODUCT_BUTTON_NAME = 'Edit product';
    private const EMAIL_LOGIN = 'admin@admin.com';

    public function testMyProductOffer(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', TestHelper::getUrl('my_product_offer'));

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

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail(self::EMAIL_LOGIN);
        $client->loginUser($testUser);

        $crawler = $client->request('GET', TestHelper::getUrl('add_product_offer'));
        $form = $crawler->selectButton(self::ADD_PRODUCT_BUTTON_NAME)->form();
        $form['product_offer[title]']->setValue('title');
        $form['product_offer[description]']->setValue('description');
        $form['product_offer[price]'] = 19.12;
        $form['product_offer[companyOrIndividual]']->setValue('company');
        $form['product_offer[stateOfProduct]']->setValue('new');
        $form['product_offer[productBilling]']->setValue('price');
        $form['product_offer[negotiablePrice]'] = 1;
        $form['product_offer[enabled]'] = 1;
        $client->submit($form);

        self::assertEmailCount(1);
        $email = self::getMailerMessage(0);
        self::assertEmailHeaderSame($email, 'To', 'test@example.com');
    }

    public function testViewProductOffer(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail(self::EMAIL_LOGIN);
        $client->loginUser($testUser);

        $client->request('GET', '/my-product-offer/YlZ-lXuL');

        self::assertResponseIsSuccessful();
    }

    public function testEditProductOffer(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail(self::EMAIL_LOGIN);
        $client->loginUser($testUser);

        $EditProductOfferDescription = 'Edit description';
        $client->request('GET', '/my-product-offer/edit/QFJas-pu');
        $client->submitForm(self::EDIT_PRODUCT_BUTTON_NAME, [
            'product_offer[description]' => $EditProductOfferDescription,
        ]);

        $productOffer = static::getContainer()->get(ProductOfferRepository::class)->find(1);
        $this->assertSame($EditProductOfferDescription, $productOffer->getTitle());
    }
}
