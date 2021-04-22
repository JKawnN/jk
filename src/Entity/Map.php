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
    private $mapHasUserStats;

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
        $this->mapHasUserStats = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|TmStats[]
     */
    public function getmapHasUserStats(): Collection
    {
        return $this->mapHasUserStats;
    }

    public function addmapHasUserStat(TmStats $mapHasUserStat): self
    {
        if (!$this->mapHasUserStats->contains($mapHasUserStat)) {
            $this->mapHasUserStats[] = $mapHasUserStat;
            $mapHasUserStat->setmap($this);
        }

        return $this;
    }

    public function removemapHasUserStat(TmStats $mapHasUserStat): self
    {
        if ($this->mapHasUserStats->removeElement($mapHasUserStat)) {
            // set the owning side to null (unless already changed)
            if ($mapHasUserStat->getmap() === $this) {
                $mapHasUserStat->setmap(null);
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
