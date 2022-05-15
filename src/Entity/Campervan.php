<?php

namespace App\Entity;

use App\Repository\CampervanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampervanRepository::class)]
class Campervan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $registrationNumber;

    #[ORM\ManyToOne(targetEntity: CampervanType::class, inversedBy: 'campervans')]
    #[ORM\JoinColumn(nullable: false)]
    private $type;

    #[ORM\Column(type: 'boolean')]
    private $isRentedOut;

    #[ORM\OneToMany(mappedBy: 'campervan', targetEntity: Order::class)]
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(string $registrationNumber): self
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    public function getType(): ?CampervanType
    {
        return $this->type;
    }

    public function setType(?CampervanType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function isIsRentedOut(): ?bool
    {
        return $this->isRentedOut;
    }

    public function setIsRentedOut(bool $isRentedOut): self
    {
        $this->isRentedOut = $isRentedOut;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setCampervan($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCampervan() === $this) {
                $order->setCampervan(null);
            }
        }

        return $this;
    }
}
