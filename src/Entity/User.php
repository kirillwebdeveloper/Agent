<?php

namespace App\Entity;

use App\Entity\UserType\Agent;
use App\Exception\UserException;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="user",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_email", columns={"email"})
 *     }
 * )
 */
class User extends AbstractEntity implements EncoderAwareInterface, EquatableInterface, UserInterface
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Id
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $password;

    /**
     * @ORM\Column(type="simple_array", nullable=false)
     */
    protected $roles;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $lastSeen;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserType\Agent", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $agent;

    /**
     * Display as string using the first and last names, or email
     * if those are empty.
     */
    public function __toString(): string
    {
        if (empty($this->firstName) && empty($this->lastName)) {
            return $this->email;
        }

        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * Add the specified role to the user.
     */
    public function addRole(string $role): void
    {
        if (!in_array($role, $this->roles)) {
            $this->roles[] = $role;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
    }

    /**
     * Get the email address.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function getEncoderName()
    {
        return null;
    }

    /**
     * Get the first name.
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Get the database ID.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the last name.
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Get the last seen date.
     */
    public function getLastSeen(): ?DateTime
    {
        return $this->lastSeen;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Get the valid roles.
     *
     * @return array
     */
    public static function getValidRoles(): array
    {
        return [
            'User'                 => 'ROLE_USER',
            'Agent'                => 'ROLE_AGENT',
            'Administrator'        => 'ROLE_ADMIN',
            'System Administrator' => 'ROLE_SYSTEM_ADMIN'
        ];
    }

    /**
     * Determine if this user is empty (to be implemented).
     */
    public function isEmpty(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof User) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->email !== $user->getEmail()) {
            return false;
        }

        if ($this->firstName !== $user->getFirstName() || $this->lastName !== $user->getLastName()) {
            return false;
        }

        return true;
    }

    /**
     * Replace the user's roles.
     */
    public function replaceRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * Mark a user as seen.
     */
    public function seen(): void
    {
        $this->lastSeen = new DateTime();
    }

    /**
     * Update a user's names.
     */
    public function updateNames(?string $firstName, ?string $lastName): void
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * Update a user's required details.
     *
     * @param string $email
     * @throws \ReflectionException
     */
    public function updateRequiredDetails(string $email): void
    {
        $this->email = $email;

        $this->validateNonEmptyProperties(UserException::class, ['email']);
    }

    /**
     * @param string|null $email
     * @return $this
     */
    public function setEmail(?string $email) : self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param string|null $firstName
     * @return $this
     */
    public function setFirstName(?string $firstName) : self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @param string|null $lastName
     * @return $this
     */
    public function setLastName(?string $lastName) : self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @param string|null $password
     * @return $this
     */
    public function setPassword(?string $password) : self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles) : self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @param DateTime|null $lastSeen
     * @return $this
     */
    public function setLastSeen(?DateTime $lastSeen) : self
    {
        $this->lastSeen = $lastSeen;

        return $this;
    }

    /**
     * @return Agent|null
     */
    public function getAgent() : ?Agent
    {
        return $this->agent;
    }

    /**
     * @param Agent|null $agent
     * @return $this
     */
    public function setAgent(?Agent $agent) : self
    {
        $this->agent = $agent;

        return $this;
    }
}
