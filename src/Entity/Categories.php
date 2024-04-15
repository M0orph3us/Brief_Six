<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 3)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 20)]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    #[Assert\DateTime()]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\DateTime()]
    private ?\DateTimeInterface $updated_at = null;

    /**
     * @var Collection<int, Threads>
     */
    #[ORM\ManyToMany(targetEntity: Threads::class, mappedBy: 'categories')]
    private Collection $threads;

    public function __construct()
    {
        $this->threads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $thread->addCategory($this);
        }

        return $this;
    }

    public function removeThread(Threads $thread): static
    {
        if ($this->threads->removeElement($thread)) {
            $thread->removeCategory($this);
        }

        return $this;
    }
}