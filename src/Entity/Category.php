<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=Knowledge::class, mappedBy="Category")
     */
    private $knowledge;

    public function __construct()
    {
        $this->knowledge = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function gettitle(): ?string
    {
        return $this->title;
    }

    public function settitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Knowledge[]
     */
    public function getKnowledge(): Collection
    {
        return $this->knowledge;
    }

    public function addKnowledge(Knowledge $knowledge): self
    {
        if (!$this->knowledge->contains($knowledge)) {
            $this->knowledge[] = $knowledge;
            $knowledge->setCategory($this);
        }

        return $this;
    }

    public function removeKnowledge(Knowledge $knowledge): self
    {
        if ($this->knowledge->removeElement($knowledge)) {
            // set the owning side to null (unless already changed)
            if ($knowledge->getCategory() === $this) {
                $knowledge->setCategory(null);
            }
        }

        return $this;
    }
}
