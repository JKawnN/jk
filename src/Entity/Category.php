<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("map:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("map:read")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Map::class, mappedBy="category")
     */
    private $mapHasCategory;

    public function __construct()
    {
        $this->mapHasCategory = new ArrayCollection();
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
     * @return Collection|Map[]
     */
    public function getMapHasCategory(): Collection
    {
        return $this->mapHasCategory;
    }

    public function addMapHasCategory(Map $mapHasCategory): self
    {
        if (!$this->mapHasCategory->contains($mapHasCategory)) {
            $this->mapHasCategory[] = $mapHasCategory;
            $mapHasCategory->setCategory($this);
        }

        return $this;
    }

    public function removeMapHasCategory(Map $mapHasCategory): self
    {
        if ($this->mapHasCategory->removeElement($mapHasCategory)) {
            // set the owning side to null (unless already changed)
            if ($mapHasCategory->getCategory() === $this) {
                $mapHasCategory->setCategory(null);
            }
        }

        return $this;
    }
}
