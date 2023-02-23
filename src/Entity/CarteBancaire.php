<?php

namespace App\Entity;

use App\Repository\CarteBancaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CarteBancaireRepository::class)]
class CarteBancaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]

    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"This field is required !")]
    #[Assert\Email(message:"The email '{{ value }}' is not a valid email ")]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"This field is required !")]
    #[Assert\Regex(pattern:"/^[0-9]+$/", message:"the identifier must contain '{{ value }}'numbers")]
    #[Assert\Length(min:8, minMessage:"the identifier must contain '{{ limit }}' number")]
    #[Assert\Length(max:14, minMessage:"the identifier must contain'{{ limit }}' number")]
    private ?string $identifier = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"This field is required !")]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $cinS1 = null;

    #[ORM\Column(length: 255)]
    private ?string $cinS2 = null;

    #[ORM\ManyToOne(inversedBy: 'carteBancaires')]
    #[Assert\NotBlank(message:"This field is required !")]
    private ?TypeCarte $idtypecarte = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

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

    public function getCinS1(): ?string
    {
        return $this->cinS1;
    }

    public function setCinS1(string $cinS1): self
    {
        $this->cinS1 = $cinS1;

        return $this;
    }

    public function getCinS2(): ?string
    {
        return $this->cinS2;
    }

    public function setCinS2(string $cinS2): self
    {
        $this->cinS2 = $cinS2;

        return $this;
    }

    public function getIdtypecarte(): ?TypeCarte
    {
        return $this->idtypecarte;
    }

    public function setIdtypecarte(?TypeCarte $idtypecarte): self
    {
        $this->idtypecarte = $idtypecarte;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

}
