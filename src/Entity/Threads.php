<?php

namespace App\Entity;

use App\Repository\ThreadsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ThreadsRepository::class)]
class Threads
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 5)]
    private ?string $status = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 5)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 20)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 20)]
    private ?string $body = null;

    #[ORM\Column]
    #[Assert\DateTime()]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\DateTime()]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'threads')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $users = null;

    /**
     * @var Collection<int, Responses>
     */
    #[ORM\OneToMany(targetEntity: Responses::class, mappedBy: 'threads')]
    private Collection $responses;

    /**
     * @var Collection<int, Categories>
     */
    #[ORM\ManyToMany(targetEntity: Categories::class, inversedBy: 'threads')]
    private Collection $categories;

    public function __construct()
    {
        $this->responses = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): static
    {
        $this->body = $body;

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

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): static
    {
        $this->users = $users;

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
            $response->setThreads($this);
        }

        return $this;
    }

    public function removeResponse(Responses $response): static
    {
        if ($this->responses->removeElement($response)) {
            // set the owning side to null (unless already changed)
            if ($response->getThreads() === $this) {
                $response->setThreads(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Categories>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categories $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Categories $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }
}