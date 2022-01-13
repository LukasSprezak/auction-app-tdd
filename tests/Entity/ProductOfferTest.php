<?php
declare(strict_types=1);
namespace App\Tests\Entity;

use App\Entity\ProductOffer;
use PHPUnit\Framework\TestCase;

class ProductOfferTest extends TestCase
{
    protected object $productOffer;

    protected function setUp(): void
    {
        $this->productOffer = new ProductOffer();
    }
}