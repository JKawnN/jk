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
     * @ORM\ManyToOne(targetEntity=Map::class, inversedBy="mapHasPlayerStats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $map;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Player::class, inversedBy="playerHasStatsOnMap")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("map:read")
     */
    private $player;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("map:read")
     */
    private $updatedAt;

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

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

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
}
