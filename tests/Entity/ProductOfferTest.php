<?php
declare(strict_types=1);
namespace App\Tests\Entity;

use App\Entity\ProductOffer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ProductOfferTest extends TestCase
{
    /**
     * @dataProvider productOfferDataProvider
     */
    public function testGettersAndSetters(string $property, mixed $value): void
    {
        $object = new productOffer();
        $accessor = PropertyAccess::createPropertyAccessor();
        $accessor->setValue($object, $property, $value);
        $this->assertEquals($value, $accessor->getValue($object, $property));
    }

    public function productOfferDataProvider(): array
    {
        $now = new \DateTime();

        return [
            ['title', 'test'],
            ['description', 'test'],
            ['price', 10.10],
            ['stateOfProduct', 'new'],
            ['giveForFree', false, true],
            ['enabled', true, false],
            ['status', 'status'],
            ['companyOrIndividual', 'companyOrIndividual'],
            ['createdAt', $now],
            ['updateAt', $now],
            ['expiresAt', $now],
        ];
    }
}