<?php

namespace App\Entity;

use App\Log\LogAware;
use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class Admin implements UserInterface, LogAware
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $username;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\OneToOne(mappedBy: 'admin', targetEntity: Employee::class, cascade: ['persist', 'remove'])]
    private $employee;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $firebaseUid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    public function __toString(): string
    {
        return $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        // unset the owning side of the relation if necessary
        if ($employee === null && $this->employee !== null) {
            $this->employee->setAdmin(null);
        }

        // set the owning side of the relation if necessary
        if ($employee !== null && $employee->getAdmin() !== $this) {
            $employee->setAdmin($this);
        }

        $this->employee = $employee;

        return $this;
    }

    public function getFirebaseUid(): ?string
    {
        return $this->firebaseUid;
    }

    public function setFirebaseUid(?string $firebaseUid): self
    {
        $this->firebaseUid = $firebaseUid;

        return $this;
    }
}
