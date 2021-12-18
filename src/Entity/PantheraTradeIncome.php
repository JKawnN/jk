<?php

namespace App\Entity;

use App\Repository\PantheraTradeIncomeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PantheraTradeRepository::class)
 */
class PantheraTradeIncome
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=CapitalPantheraTrade::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $CapitalPantheraTrade;

    /**
     * @ORM\Column(type="float")
     */
    private $Percentage;

    /**
     * @ORM\Column(type="float")
     */
    private $beforeUpdate;

    /**
     * @ORM\Column(type="float")
     */
    private $afterUpdate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCapitalPantheraTrade(): ?CapitalPantheraTrade
    {
        return $this->CapitalPantheraTrade;
    }

    public function setCapitalPantheraTrade(?CapitalPantheraTrade $CapitalPantheraTrade): self
    {
        $this->CapitalPantheraTrade = $CapitalPantheraTrade;

        return $this;
    }

    public function getPercentage(): ?float
    {
        return $this->Percentage;
    }

    public function setPercentage(float $Percentage): self
    {
        $this->Percentage = $Percentage;

        return $this;
    }

    public function getBeforeUpdate(): ?float
    {
        return $this->beforeUpdate;
    }

    public function setBeforeUpdate(float $beforeUpdate): self
    {
        $this->beforeUpdate = $beforeUpdate;

        return $this;
    }

    public function getAfterUpdate(): ?float
    {
        return $this->afterUpdate;
    }

    public function setAfterUpdate(float $afterUpdate): self
    {
        $this->afterUpdate = $afterUpdate;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): self
    {
        $this->Type = $Type;

        return $this;
    }
}
