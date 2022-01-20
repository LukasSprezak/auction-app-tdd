<?php
declare(strict_types=1);
namespace App\Entity;

use App\Repository\CustomerInformationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerInformationRepository::class)]

class CustomerInformation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\OneToOne(inversedBy: 'customerInformation', targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private mixed $userId;

    #[ORM\Column(type: 'string', length: 50)]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 50)]
    private string $lastName;

    #[ORM\Column(type: 'date', nullable: true)]
    private \DateTime|null $birthday;

    #[ORM\Column(type: 'string', length: 50)]
    private string $city;

    #[ORM\Column(type: 'string', length: 120)]
    private string $address;

    #[ORM\Column(type: 'string', length: 20)]
    private string $phoneNumber;

    #[ORM\Column(type: 'string', length: 20)]
    private string $zipCode;

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getUserId(): User
    {
        return $this->userId;
    }

    public function setUserId(User $userId): static
    {
        $this->userId = $userId;
        return $this;
    }

    public function getFirstName(): string|null
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): CustomerInformation
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string|null
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): CustomerInformation
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getBirthday(): \DateTime|null
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTime|null $birthday): CustomerInformation
    {
        $this->birthday = $birthday;
        return $this;
    }

    public function getCity(): string|null
    {
        return $this->city;
    }

    public function setCity(string $city): CustomerInformation
    {
        $this->city = $city;
        return $this;
    }

    public function getAddress(): string|null
    {
        return $this->address;
    }

    public function setAddress(string $address): CustomerInformation
    {
        $this->address = $address;
        return $this;
    }

    public function getPhoneNumber(): string|null
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): CustomerInformation
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getZipCode(): string|null
    {
        return $this->zipCode;
    }

    public function setZipCode($zipCode): CustomerInformation
    {
        $this->zipCode = $zipCode;
        return $this;
    }
}
