<?php
declare(strict_types=1);
namespace App\Entity;

use App\Utils\IdGenerator;
use DateTime;
use App\Repository\ProductOfferRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductOfferRepository::class)]
class ProductOffer
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 8)]
    private string $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'string', length: 255)]
    private string $description;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $images;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $price;

    #[ORM\Column(type: 'string', length: 255)]
    private string $stateOfProduct;

    #[ORM\Column(type: 'string', length: 255)]
    private string $giveForFree;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    private ?DateTimeInterface $updateAt;

    #[ORM\Column(type: 'datetime')]
    private ?DateTimeInterface $expiresAt;

    #[ORM\Column(type: 'boolean')]
    private bool $enabled;

    #[ORM\Column(type: 'string', length: 255)]
    private string $productOwner;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $status;

    public function __construct()
    {
        $this->id = IdGenerator::IdGenerator();
        $this->setCreatedAt(new \DateTime());
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): ProductOffer
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): ProductOffer
    {
        $this->description = $description;
        return $this;
    }

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(string $images): ProductOffer
    {
        $this->images = $images;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): ProductOffer
    {
        $this->price = $price;
        return $this;
    }

    public function getStateOfProduct(): ?string
    {
        return $this->stateOfProduct;
    }

    public function setStateOfProduct(string $stateOfProduct): ProductOffer
    {
        $this->stateOfProduct = $stateOfProduct;

        return $this;
    }

    public function getGiveForFree(): ?string
    {
        return $this->giveForFree;
    }

    public function setGiveForFree(string $giveForFree): ProductOffer
    {
        $this->giveForFree = $giveForFree;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): ProductOffer
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeImmutable $updateAt): ProductOffer
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    public function getExpiresAt(): ?\DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(\DateTimeImmutable $expiresAt): ProductOffer
    {
        $this->expiresAt = $expiresAt;
        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): ProductOffer
    {
        $this->enabled = $enabled;
        return $this;
    }

    public function getProductOwner(): ?string
    {
        return $this->productOwner;
    }

    public function setProductOwner(string $productOwner): ProductOffer
    {
        $this->productOwner = $productOwner;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): ProductOffer
    {
        $this->status = $status;

        return $this;
    }
}
