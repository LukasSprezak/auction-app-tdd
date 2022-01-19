<?php
declare(strict_types=1);
namespace App\Tests\Form;

use App\Form\ProductOfferType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductOfferTypeTest extends TypeTestCase
{
    private ProductOfferType $type;

    protected function setUp(): void
    {
        $this->type = new ProductOfferType();
    }

    public function testBuildForm(): void
    {
        $fields = [
            ['title', TextType::class],
            ['description', TextType::class],
            ['price', NumberType::class],
            ['stateOfProduct', EnumType::class],
            ['enabled', CheckboxType::class],
            ['companyOrIndividual', EnumType::class],
            ['negotiablePrice', CheckboxType::class],
            ['productBilling', EnumType::class]
        ];

        $builder = $this->createMock(FormBuilder::class);
        $builder->expects($this->exactly(count($fields)))
            ->method('add')
            ->withConsecutive(...$fields)
            ->willReturnSelf();

        $this->type->buildForm($builder, []);
    }

    public function testConfigureOptions(): void
    {
        $resolver = $this->createMock(OptionsResolver::class);

        $resolver->expects($this->once())
            ->method('setDefaults')
            ->with($this->isType('array'));
        $this->type->configureOptions($resolver);
    }
}