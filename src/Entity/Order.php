<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $functionalId;

    #[ORM\Column(type: 'datetime')]
    private $startDate;

    #[ORM\Column(type: 'datetime')]
    private $endDate;

    #[ORM\ManyToOne(targetEntity: Station::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private $pickupStation;

    #[ORM\ManyToOne(targetEntity: Station::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $returnStation;

    #[ORM\Column(type: 'string', length: 255)]
    private $status;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: Campervan::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private $campervan;

    #[ORM\OneToMany(mappedBy: 'rent', targetEntity: OrderEquipment::class)]
    private $equipments;

    public function __construct()
    {
        $this->equipments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFunctionalId(): ?string
    {
        return $this->functionalId;
    }

    public function setFunctionalId(string $functionalId): self
    {
        $this->functionalId = $functionalId;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getPickupStation(): ?Station
    {
        return $this->pickupStation;
    }

    public function setPickupStation(?Station $pickupStation): self
    {
        $this->pickupStation = $pickupStation;

        return $this;
    }

    public function getReturnStation(): ?Station
    {
        return $this->returnStation;
    }

    public function setReturnStation(?Station $returnStation): self
    {
        $this->returnStation = $returnStation;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCampervan(): ?Campervan
    {
        return $this->campervan;
    }

    public function setCampervan(?Campervan $campervan): self
    {
        $this->campervan = $campervan;

        return $this;
    }

    /**
     * @return Collection<int, OrderEquipment>
     */
    public function getEquipments(): Collection
    {
        return $this->equipments;
    }

    public function addEquipment(OrderEquipment $equipment): self
    {
        if (!$this->equipments->contains($equipment)) {
            $this->equipments[] = $equipment;
            $equipment->setRent($this);
        }

        return $this;
    }

    public function removeEquipment(OrderEquipment $equipment): self
    {
        if ($this->equipments->removeElement($equipment)) {
            // set the owning side to null (unless already changed)
            if ($equipment->getRent() === $this) {
                $equipment->setRent(null);
            }
        }

        return $this;
    }
}
