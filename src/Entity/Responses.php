<?php

namespace App\Entity;

use App\Repository\ResponsesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ResponsesRepository::class)]
class Responses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 20)]
    private ?string $body = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    #[Assert\DateTime()]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\DateTime()]
    private ?\DateTimeInterface $updated_at = null;

    /**
     * @var Collection<int, Votes>
     */
    #[ORM\OneToMany(targetEntity: Votes::class, mappedBy: 'responses')]
    private Collection $votes;

    #[ORM\ManyToOne(inversedBy: 'responses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $users = null;

    #[ORM\ManyToOne(inversedBy: 'responses')]
    private ?Threads $threads = null;

    public function __construct()
    {
        $this->votes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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
            $vote->setResponses($this);
        }

        return $this;
    }

    public function removeVote(Votes $vote): static
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getResponses() === $this) {
                $vote->setResponses(null);
            }
        }

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

    public function getThreads(): ?Threads
    {
        return $this->threads;
    }

    public function setThreads(?Threads $threads): static
    {
        $this->threads = $threads;

        return $this;
    }
}
