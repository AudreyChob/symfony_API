<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=article::class, mappedBy="category")
     */
    private $nom;

    public function __construct()
    {
        $this->nom = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|article[]
     */
    public function getNom(): Collection
    {
        return $this->nom;
    }

    public function addNom(article $nom): self
    {
        if (!$this->nom->contains($nom)) {
            $this->nom[] = $nom;
            $nom->setCategory($this);
        }

        return $this;
    }

    public function removeNom(article $nom): self
    {
        if ($this->nom->removeElement($nom)) {
            // set the owning side to null (unless already changed)
            if ($nom->getCategory() === $this) {
                $nom->setCategory(null);
            }
        }

        return $this;
    }
}
