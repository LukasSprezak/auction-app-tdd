<?php
declare(strict_types=1);
namespace App\Tests\Form;

use App\Entity\ProductOffer;
use App\Form\ProductOfferType;
use Symfony\Component\Form\Test\TypeTestCase;

class ProductOfferTypeTest extends TypeTestCase
{
    public function testSubmitValidData(): void
    {
        $formData = [
            'title' => 'test',
            'description' => 'test2',
            'images' => 'test2',
            'price' => 11.11,
            'stateOfProduct' => 'aaa',
            'giveForFree' => false,
            'createdAt' => 'asda',
            'updateAt' => 'asa',
            'expiresAt' => 'asada',
            'enabled' => false,
            'productOwner' => 'Mike Smith'
        ];

        $model = new ProductOffer();
        $form = $this->factory->create(ProductOfferType::class, $model);

        $expected = new ProductOffer();
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
    }
}