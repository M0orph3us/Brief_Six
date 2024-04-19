<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank()]
    #[Assert\Email()]
    #[Assert\Length(min: 5)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 5)]
    #[Assert\Regex('^(?=.*[0-9])(?=.*[A-Z])(?=.*[\W_]).+$^
    ')]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 3, max: 10)]
    private ?string $username = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    /**
     * @var Collection<int, Votes>
     */
    #[ORM\OneToMany(targetEntity: Votes::class, mappedBy: 'user')]
    private Collection $votes;

    /**
     * @var Collection<int, Threads>
     */
    #[ORM\OneToMany(targetEntity: Threads::class, mappedBy: 'users')]
    private Collection $threads;

    /**
     * @var Collection<int, Responses>
     */
    #[ORM\OneToMany(targetEntity: Responses::class, mappedBy: 'users')]
    private Collection $responses;

    public function __construct()
    {
        $this->votes = new ArrayCollection();
        $this->threads = new ArrayCollection();
        $this->responses = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, Votes>
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Votes $vote): static
    {
        if (!$this->votes->contains($vote)) {
            $this->votes->add($vote);
            $vote->setUser($this);
        }

        return $this;
    }

    public function removeVote(Votes $vote): static
    {
        // set the owning side to null (unless already changed)
        if ($this->votes->removeElement($vote) && $vote->getUser() === $this) {
            $vote->setUser(null);
        }

        return $this;
    }

    /**
     * @return Collection<int, Threads>
     */
    public function getThreads(): Collection
    {
        return $this->threads;
    }

    public function addThread(Threads $thread): static
    {
        if (!$this->threads->contains($thread)) {
            $this->threads->add($thread);
            $thread->setUsers($this);
        }

        return $this;
    }

    public function removeThread(Threads $thread): static
    {
        // set the owning side to null (unless already changed)
        if ($this->threads->removeElement($thread) && $thread->getUsers() === $this) {
            $thread->setUsers(null);
        }

        return $this;
    }

    /**
     * @return Collection<int, Responses>
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(Responses $response): static
    {
        if (!$this->responses->contains($response)) {
            $this->responses->add($response);
            $response->setUsers($this);
        }

        return $this;
    }

    public function removeResponse(Responses $response): static
    {
        // set the owning side to null (unless already changed)
        if ($this->responses->removeElement($response) && $response->getUsers() === $this) {
            $response->setUsers(null);
        }

        return $this;
    }
}
