<?php

namespace App\Entity;

use App\Repository\TypeCarteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TypeCarteRepository::class)]
class TypeCarte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"This field is required !")]
    private ?string $nom = null;

  
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"This field is required !")]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'idtypecarte', targetEntity: CarteBancaire::class)]
    private Collection $carteBancaires;

    public function __construct()
    {
        $this->carteBancaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    /**
     * @return Collection<int, CarteBancaire>
     */
    public function getCarteBancaires(): Collection
    {
        return $this->carteBancaires;
    }

    public function addCarteBancaire(CarteBancaire $carteBancaire): self
    {
        if (!$this->carteBancaires->contains($carteBancaire)) {
            $this->carteBancaires->add($carteBancaire);
            $carteBancaire->setIdtypecarte($this);
        }

        return $this;
    }

    public function removeCarteBancaire(CarteBancaire $carteBancaire): self
    {
        if ($this->carteBancaires->removeElement($carteBancaire)) {
            // set the owning side to null (unless already changed)
            if ($carteBancaire->getIdtypecarte() === $this) {
                $carteBancaire->setIdtypecarte(null);
            }
        }

        return $this;
    }

    public function __toString(): string {
        return $this->nom;
    }
}
