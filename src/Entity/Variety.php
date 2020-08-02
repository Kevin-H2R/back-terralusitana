<?php

namespace App\Entity;

use App\Repository\VarietyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VarietyRepository::class)
 */
class Variety
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Wine::class, mappedBy="varieties")
     */
    private $wines;

    public function __construct()
    {
        $this->wines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Wine[]
     */
    public function getWines(): Collection
    {
        return $this->wines;
    }

    public function addWine(Wine $wine): self
    {
        if (!$this->wines->contains($wine)) {
            $this->wines[] = $wine;
            $wine->addVariety($this);
        }

        return $this;
    }

    public function removeWine(Wine $wine): self
    {
        if ($this->wines->contains($wine)) {
            $this->wines->removeElement($wine);
            $wine->removeVariety($this);
        }

        return $this;
    }
}
