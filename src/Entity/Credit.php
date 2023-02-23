<?php

namespace App\Entity;

use App\Repository\CreditRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreditRepository::class)]
class Credit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'credits')]
    private ?Category $creditCategory = null;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreditCategory(): ?Category
    {
        return $this->creditCategory;
    }

    public function setCreditCategory(?Category $creditCategory): self
    {
        $this->creditCategory = $creditCategory;

        return $this;
    }

  
   
}
