<?php

namespace App\Entity;

use App\Repository\KnowledgeRepository;
use App\Entity\Article;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KnowledgeRepository::class)
 */
class Knowledge
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icon;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $activate;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="knowledge")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $domain;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $level;

    /**
     * @ORM\OneToOne(targetEntity=Article::class, mappedBy="knowledge", cascade={"persist", "remove"})
     */
    private $article;

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

    public function getdescription(): ?string
    {
        return $this->description;
    }

    public function setdescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getcategory(): ?category
    {
        return $this->category;
    }

    public function setcategory(?category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function geticon(): ?string
    {
        return $this->icon;
    }

    public function seticon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getactivate(): ?bool
    {
        return $this->activate;
    }

    public function setactivate(bool $activate): self
    {
        $this->activate = $activate;

        return $this;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setDomain(?string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(?int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        // unset the owning side of the relation if necessary
        if ($article === null && $this->article !== null) {
            $this->article->setKnowledge(null);
        }

        // set the owning side of the relation if necessary
        if ($article !== null && $article->getKnowledge() !== $this) {
            $article->setKnowledge($this);
        }

        $this->article = $article;

        return $this;
    }
}
