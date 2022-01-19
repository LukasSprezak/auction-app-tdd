<?php
declare(strict_types=1);
namespace App\Entity;

use App\Enum\CompanyOrIndividualEnum;
use App\Enum\ProductBillingEnum;
use App\Enum\StateProductEnum;
use App\Enum\StatusProductOfferEnum;
use App\Utils\IdGenerator;
use DateTime;
use App\Repository\ProductOfferRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;

#[ORM\Entity(repositoryClass: ProductOfferRepository::class)]
class ProductOffer
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 8)]
    private string $id;

    #[ORM\Column(type: 'string', length: 120)]
    private string $title;

    #[ORM\Column(type: 'string', length: 255)]
    private string $description;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $price;

    #[Column(type: 'string', length: 20, enumType: StateProductEnum::class)]
    public StateProductEnum $stateOfProduct;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\Column(type: 'datetime')]
    private null|DateTime $updateAt;

    #[ORM\Column(type: 'datetime')]
    private null|DateTime $expiresAt;

    #[ORM\Column(type: 'boolean')]
    private bool $enabled = false;

    #[Column(type: 'string', length: 20, enumType: StatusProductOfferEnum::class)]
    private StatusProductOfferEnum $status;

    #[Column(type: 'string', length: 20, enumType: CompanyOrIndividualEnum::class)]
    private CompanyOrIndividualEnum $companyOrIndividual;

    #[ORM\Column(type: 'boolean')]
    private bool $negotiablePrice;

    #[Column(type: 'string', length: 20, enumType: ProductBillingEnum::class)]
    private ProductBillingEnum $productBilling;

    public function __construct()
    {
        $this->id = IdGenerator::IdGenerator();
        $this->createdAt = new DateTime();
        $this->updateAt = new DateTime();
        $this->expiresAt = new DateTime();

    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): ProductOffer
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): ProductOffer
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): ProductOffer
    {
        $this->price = $price;
        return $this;
    }

    public function getStateOfProduct(): StateProductEnum
    {
        return $this->stateOfProduct;
    }

    public function setStateOfProduct(StateProductEnum $stateOfProduct): ProductOffer
    {
        $this->stateOfProduct = $stateOfProduct;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): ProductOffer
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdateAt(): null|DateTime
    {
        return $this->updateAt;
    }

    public function setUpdateAt(DateTime $updateAt): ProductOffer
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    public function getExpiresAt(): null|DateTime
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(DateTime $expiresAt): ProductOffer
    {
        $this->expiresAt = $expiresAt;
        return $this;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): ProductOffer
    {
        $this->enabled = $enabled;
        return $this;
    }

    public function getStatus(): StatusProductOfferEnum
    {
        return $this->status;
    }

    public function setStatus(StatusProductOfferEnum $status): ProductOffer
    {
        $this->status = $status;
        return $this;
    }

    public function getCompanyOrIndividual(): CompanyOrIndividualEnum
    {
        return $this->companyOrIndividual;
    }

    public function setCompanyOrIndividual(CompanyOrIndividualEnum $companyOrIndividual): ProductOffer
    {
        $this->companyOrIndividual = $companyOrIndividual;
        return $this;
    }

    public function isNegotiablePrice(): bool
    {
        return $this->negotiablePrice;
    }

    public function setNegotiablePrice(bool $negotiablePrice): ProductOffer
    {
        $this->negotiablePrice = $negotiablePrice;
        return $this;
    }

    public function getProductBilling(): ProductBillingEnum
    {
        return $this->productBilling;
    }

    public function setProductBilling(ProductBillingEnum $productBilling): ProductOffer
    {
        $this->productBilling = $productBilling;
        return $this;
    }
}
