<?php
declare(strict_types=1);
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: 'email', message: "There is already an account with this email")]
#[UniqueEntity(fields: 'username', message: "There is already an account with this username")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: ProductOffer::class)]
    #[ORM\JoinColumn(name: 'owner_id', referencedColumnName: 'id')]
    private Collection $productOffers;

    #[ORM\OneToOne(mappedBy: 'userId', targetEntity: CustomerInformation::class)]
    private mixed $customerInformation;

    #[ORM\Column(type: 'string', length: 32, unique: true)]
    private string $email;

    #[ORM\Column(type: 'string', length: 32, unique: true)]
    private string $username;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    private string|null $plainPassword;

    public function __construct()
    {
        $this->productOffers = new ArrayCollection();
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getProductOffers(): Collection
    {
        return new ArrayCollection($this->productOffers->toArray());
    }

    public function containsProductOffers(ProductOffer $productOffer): bool
    {
        return $this->productOffers->contains($productOffer);
    }

    public function addProductOffers(ProductOffer $productOffer): void
    {
        if (!$this->containsProductOffers($productOffer)) {
            $this->productOffers->add($productOffer);
            $productOffer->setOwner($this);
        }
    }

    public function removeProductOffers(ProductOffer $productOffer): void
    {
        if (!$this->containsProductOffers($productOffer)) {
            $this->productOffers->removeElement($productOffer);
            $productOffer->setOwner(null);
        }
    }

    public function getCustomerInformation(): mixed
    {
        return $this->customerInformation;
    }

    public function setCustomerInformation(mixed $customerInformation): void
    {
        $this->customerInformation = $customerInformation;
    }

    public function getEmail(): string|null
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): User
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        if (!in_array('ROLE_USER', $roles, true)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string|null
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function getPlainPassword(): string|null
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): User
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt(): string|null
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
         $this->plainPassword = null;
    }
}
