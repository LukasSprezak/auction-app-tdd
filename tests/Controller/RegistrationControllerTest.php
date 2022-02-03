<?php
declare(strict_types=1);
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    private const REGISTER_BUTTON_NAME = 'Register';

    public function testRegister(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $form = $crawler->selectButton(self::REGISTER_BUTTON_NAME)->form();
        $form['user_customer_information[user][email]']->setValue(sprintf('admin%s@example.com', mt_rand()));
        $form['user_customer_information[user][username]']->setValue('Lukas');
        $form['user_customer_information[user][plainPassword][first]']->setValue('admin');
        $form['user_customer_information[user][plainPassword][second]']->setValue('admin');
        $form['user_customer_information[user][agreeTerms]']->tick();
        $client->submit($form);

        self::assertResponseIsSuccessful();
    }
}