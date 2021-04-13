<?php

namespace App\Entity;

use App\Repository\HomePagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HomePagesRepository::class)
 */
class HomePages
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;
    
    /**
     * @ORM\Column(type="string", length=20)
     */
    private $route;

    /**
     * @ORM\Column(type="integer")
     */
    private $homeOrder;

        public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
    
    public function getDescription(): ?string
    {
        return $this->description;
    }
    
    public function setDescription(string $description): self
    {
        $this->description = $description;
        
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }
    
    public function setImage(string $image): self
    {
        $this->image = $image;
        
        return $this;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }
    
    public function setRoute(string $route): self
    {
        $this->route = $route;
    
        return $this;
    }

    public function getHomeOrder(): ?int
    {
        return $this->homeOrder;
    }

    public function setHomeOrder(int $homeOrder): self
    {
        $this->homeOrder = $homeOrder;

        return $this;
    }
}
