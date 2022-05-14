<?php

namespace App\Entity;

use App\Repository\OrderEquipmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderEquipmentRepository::class)]
class OrderEquipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $quantity;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'equipments')]
    #[ORM\JoinColumn(nullable: false)]
    private $rent;

    #[ORM\ManyToOne(targetEntity: Equipment::class, inversedBy: 'equipment')]
    #[ORM\JoinColumn(nullable: false)]
    private $equipment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getRent(): ?Order
    {
        return $this->rent;
    }

    public function setRent(?Order $rent): self
    {
        $this->rent = $rent;

        return $this;
    }

    public function getEquipment(): ?Equipment
    {
        return $this->equipment;
    }

    public function setEquipment(?Equipment $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }
}
