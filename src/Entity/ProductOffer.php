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
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ProductOfferRepository::class)]
class ProductOffer
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 8)]
    private string $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'productOffers')]
    private User $owner;

    #[ORM\Column(type: 'string', length: 120)]
    private string $title;

    #[ORM\Column(type: 'string', length: 255)]
    private string $description;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $price;

    #[Column(type: 'string', length: 20, enumType: StateProductEnum::class)]
    public StateProductEnum $stateOfProduct;

    #[ORM\Column(type: 'datetime')]
    private DateTime|null $expiresAt;

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

    #[ORM\Column(type: 'boolean')]
    private bool $deleted = false;

    public function __construct()
    {
        $this->id = IdGenerator::IdGenerator();
        $this->expiresAt = new DateTime();

    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): static
    {
        $this->owner = $owner;
        return $this;
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

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): ProductOffer
    {
        $this->deleted = $deleted;
        return $this;
    }

    public function __toString(): string
    {
        return $this->getId();
    }
}
