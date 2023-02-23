<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'compteTransaction')]
    private ?Compte $compte = null;

    #[ORM\Column(length: 255)]
    private ?string $typeTransaction = null;

    #[ORM\Column(length: 255)]
    private ?string $montant = null;

    #[ORM\Column(length: 255)]
    private ?string $dateTransaction = null;

    #[ORM\Column(length: 255)]
    private ?string $requestFrom = null;

    #[ORM\Column(length: 255)]
    private ?string $requestTo = null;

    #[ORM\Column(length: 255)]
    private ?string $statue = null;

    #[ORM\Column(length: 255)]
    private ?string $agenceName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    public function getTypeTransaction(): ?string
    {
        return $this->typeTransaction;
    }

    public function setTypeTransaction(string $typeTransaction): self
    {
        $this->typeTransaction = $typeTransaction;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateTransaction(): ?string
    {
        return $this->dateTransaction;
    }

    public function setDateTransaction(string $dateTransaction): self
    {
        $this->dateTransaction = $dateTransaction;

        return $this;
    }

    public function getRequestFrom(): ?string
    {
        return $this->requestFrom;
    }

    public function setRequestFrom(string $requestFrom): self
    {
        $this->requestFrom = $requestFrom;

        return $this;
    }

    public function getRequestTo(): ?string
    {
        return $this->requestTo;
    }

    public function setRequestTo(string $requestTo): self
    {
        $this->requestTo = $requestTo;

        return $this;
    }

    public function getStatue(): ?string
    {
        return $this->statue;
    }

    public function setStatue(string $statue): self
    {
        $this->statue = $statue;

        return $this;
    }

    public function getAgenceName(): ?string
    {
        return $this->agenceName;
    }

    public function setAgenceName(string $agenceName): self
    {
        $this->agenceName = $agenceName;

        return $this;
    }
}
