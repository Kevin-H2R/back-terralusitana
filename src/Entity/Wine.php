<?php

namespace App\Entity;

use App\Repository\WineRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WineRepository::class)
 */
class Wine
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
     * @ORM\Column(type="float")
     */
    private $alcohol;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imagePath;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=512)
     */
    private $description;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $soft;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $dry;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $sweet;

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

    public function getAlcohol(): ?float
    {
        return $this->alcohol;
    }

    public function setAlcohol(float $alcohol): self
    {
        $this->alcohol = $alcohol;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): self
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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

    public function getSoft(): ?int
    {
        return $this->soft;
    }

    public function setSoft(?int $soft): self
    {
        $this->soft = $soft;

        return $this;
    }

    public function getDry(): ?int
    {
        return $this->dry;
    }

    public function setDry(?int $dry): self
    {
        $this->dry = $dry;

        return $this;
    }

    public function getSweet(): ?int
    {
        return $this->sweet;
    }

    public function setSweet(?int $sweet): self
    {
        $this->sweet = $sweet;

        return $this;
    }
}
