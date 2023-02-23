<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'creditCategory', targetEntity: Credit::class)]
    private Collection $credits;

    public function __construct()
    {
        $this->credits = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getCredit(): ?Credit
    {
        return $this->credit;
    }
    public function setCredit(?Credit $credit): self
    {
        $this->credit = $credit;

        return $this;
    }

    /**
     * @return Collection<int, Credit>
     */
    public function getCredits(): Collection
    {
        return $this->credits;
    }

    public function addCredit(Credit $credit): self
    {
        if (!$this->credits->contains($credit)) {
            $this->credits->add($credit);
            $credit->setCreditCategory($this);
        }

        return $this;
    }

    public function removeCredit(Credit $credit): self
    {
        if ($this->credits->removeElement($credit)) {
            // set the owning side to null (unless already changed)
            if ($credit->getCreditCategory() === $this) {
                $credit->setCreditCategory(null);
            }
        }

        return $this;
    }
}
