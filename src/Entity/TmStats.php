<?php

namespace App\Entity;

use App\Repository\TmStatsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TmStatsRepository::class)
 */
class TmStats
{
    /**
     * @ORM\Column(type="float")
     * @Groups("map:read")
     */
    private $record;
    
    /**
     * @ORM\Column(type="integer")
     * @Groups("map:read")
     */
    private $top;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Map::class, inversedBy="mapHasUserStats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $map;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("map:read")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userHasStatsOnMap")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("map:read")
     */
    private $user;

    public function __construct()
    {
        $this->updatedAt = new \DateTime();
    }

    public function getTop(): ?int
    {
        return $this->top;
    }

    public function setTop(int $top): self
    {
        $this->top = $top;

        return $this;
    }

    public function getmap(): ?Map
    {
        return $this->map;
    }

    public function setmap(?Map $map): self
    {
        $this->map = $map;

        return $this;
    }

    public function getRecord(): ?float
    {
        return $this->record;
    }

    public function setRecord(?float $record): self
    {
        $this->record = $record;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
