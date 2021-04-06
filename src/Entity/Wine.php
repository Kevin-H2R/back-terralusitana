<?php

namespace App\Entity;

use App\Repository\WineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\ManyToOne(targetEntity=Region::class, inversedBy="wines")
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;

    /**
     * @ORM\ManyToMany(targetEntity=Variety::class, inversedBy="wines")
     */
    private $varieties;

    /**
     * @ORM\OneToMany(targetEntity=Trophy::class, mappedBy="wine")
     */
    private $trophies;

    /**
     * @ORM\OneToMany(targetEntity=OrderDetail::class, mappedBy="wine", orphanRemoval=true)
     */
    private $orderDetails;

    /**
     * @ORM\Column(type="smallint")
     */
    private $type;

    public function __construct()
    {
        $this->varieties = new ArrayCollection();
        $this->trophies = new ArrayCollection();
        $this->orderDetails = new ArrayCollection();
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

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection|Variety[]
     */
    public function getVarieties(): Collection
    {
        return $this->varieties;
    }

    public function addVariety(Variety $variety): self
    {
        if (!$this->varieties->contains($variety)) {
            $this->varieties[] = $variety;
        }

        return $this;
    }

    public function removeVariety(Variety $variety): self
    {
        if ($this->varieties->contains($variety)) {
            $this->varieties->removeElement($variety);
        }

        return $this;
    }

    /**
     * @return Collection|Trophy[]
     */
    public function getTrophies(): Collection
    {
        return $this->trophies;
    }

    public function addTrophy(Trophy $trophy): self
    {
        if (!$this->trophies->contains($trophy)) {
            $this->trophies[] = $trophy;
            $trophy->setWine($this);
        }

        return $this;
    }

    public function removeTrophy(Trophy $trophy): self
    {
        if ($this->trophies->contains($trophy)) {
            $this->trophies->removeElement($trophy);
            // set the owning side to null (unless already changed)
            if ($trophy->getWine() === $this) {
                $trophy->setWine(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OrderDetail[]
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetail $orderDetail): self
    {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails[] = $orderDetail;
            $orderDetail->setWine($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetail $orderDetail): self
    {
        if ($this->orderDetails->contains($orderDetail)) {
            $this->orderDetails->removeElement($orderDetail);
            // set the owning side to null (unless already changed)
            if ($orderDetail->getWine() === $this) {
                $orderDetail->setWine(null);
            }
        }

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }
}
