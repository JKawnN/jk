<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups("map:read")
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=TmStats::class, mappedBy="user", orphanRemoval=true)
     */
    private $userHasStatsOnMap;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $riotUsername;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $riotAccountId;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $riotPuuid;

    public function __construct()
    {
        $this->userHasStatsOnMap = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        // $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|TmStats[]
     */
    public function getUserHasStatsOnMap(): Collection
    {
        return $this->userHasStatsOnMap;
    }

    public function addUserHasStatsOnMap(TmStats $userHasStatsOnMap): self
    {
        if (!$this->userHasStatsOnMap->contains($userHasStatsOnMap)) {
            $this->userHasStatsOnMap[] = $userHasStatsOnMap;
            $userHasStatsOnMap->setUser($this);
        }

        return $this;
    }

    public function removeUserHasStatsOnMap(TmStats $userHasStatsOnMap): self
    {
        if ($this->userHasStatsOnMap->removeElement($userHasStatsOnMap)) {
            // set the owning side to null (unless already changed)
            if ($userHasStatsOnMap->getUser() === $this) {
                $userHasStatsOnMap->setUser(null);
            }
        }

        return $this;
    }

    public function getRiotUsername(): ?string
    {
        return $this->riotUsername;
    }

    public function setRiotUsername(?string $riotUsername): self
    {
        $this->riotUsername = $riotUsername;

        return $this;
    }

    public function getRiotAccountId(): ?string
    {
        return $this->riotAccountId;
    }

    public function setRiotAccountId(?string $riotAccountId): self
    {
        $this->riotAccountId = $riotAccountId;

        return $this;
    }

    public function getRiotPuuid(): ?string
    {
        return $this->riotPuuid;
    }

    public function setRiotPuuid(?string $riotPuuid): self
    {
        $this->riotPuuid = $riotPuuid;

        return $this;
    }
}
