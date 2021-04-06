<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("map:read")
     * @Groups("player:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("map:read")
     * @Groups("player:read")
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("player:read")
     */
    private $riotPseudo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $riotPuuid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $riotAccountId;

    /**
     * @ORM\OneToMany(targetEntity=TmStats::class, mappedBy="player")
     */
    private $playerHasStatsOnMap;

    public function __construct()
    {
        $this->playerHasStatsOnMap = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRiotPseudo(): ?string
    {
        return $this->riotPseudo;
    }

    public function setRiotPseudo(?string $riotPseudo): self
    {
        $this->riotPseudo = $riotPseudo;

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

    public function getRiotAccountId(): ?string
    {
        return $this->riotAccountId;
    }

    public function setRiotAccountId(?string $riotAccountId): self
    {
        $this->riotAccountId = $riotAccountId;

        return $this;
    }

    /**
     * @return Collection|TmStats[]
     */
    public function getPlayerHasStatsOnMap(): Collection
    {
        return $this->playerHasStatsOnMap;
    }

    public function addPlayerHasStatsOnMap(TmStats $playerHasStatsOnMap): self
    {
        if (!$this->playerHasStatsOnMap->contains($playerHasStatsOnMap)) {
            $this->playerHasStatsOnMap[] = $playerHasStatsOnMap;
            $playerHasStatsOnMap->setPlayer($this);
        }

        return $this;
    }

    public function removePlayerHasStatsOnMap(TmStats $playerHasStatsOnMap): self
    {
        if ($this->playerHasStatsOnMap->removeElement($playerHasStatsOnMap)) {
            // set the owning side to null (unless already changed)
            if ($playerHasStatsOnMap->getPlayer() === $this) {
                $playerHasStatsOnMap->setPlayer(null);
            }
        }

        return $this;
    }
}
