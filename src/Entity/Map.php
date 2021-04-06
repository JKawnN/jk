<?php

namespace App\Entity;

use App\Repository\MapRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MapRepository::class)
 */
class Map
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("map:read")
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("map:read")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=TmStats::class, mappedBy="map")
     * @Groups("map:read")
     */
    private $mapHasPlayerStats;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="mapHasCategory")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("map:read")
     */
    private $category;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups("map:read")
     */
    private $worldRecord;

    public function __construct()
    {
        $this->mapHasPlayerStats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getname(): ?string
    {
        return $this->name;
    }

    public function setname(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|TmStats[]
     */
    public function getmapHasPlayerStats(): Collection
    {
        return $this->mapHasPlayerStats;
    }

    public function addmapHasPlayerStat(TmStats $mapHasPlayerStat): self
    {
        if (!$this->mapHasPlayerStats->contains($mapHasPlayerStat)) {
            $this->mapHasPlayerStats[] = $mapHasPlayerStat;
            $mapHasPlayerStat->setmap($this);
        }

        return $this;
    }

    public function removemapHasPlayerStat(TmStats $mapHasPlayerStat): self
    {
        if ($this->mapHasPlayerStats->removeElement($mapHasPlayerStat)) {
            // set the owning side to null (unless already changed)
            if ($mapHasPlayerStat->getmap() === $this) {
                $mapHasPlayerStat->setmap(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getWorldRecord(): ?float
    {
        return $this->worldRecord;
    }

    public function setWorldRecord(?float $worldRecord): self
    {
        $this->worldRecord = $worldRecord;

        return $this;
    }
}
