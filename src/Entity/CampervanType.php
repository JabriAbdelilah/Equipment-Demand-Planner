<?php

namespace App\Entity;

use App\Repository\CampervanTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampervanTypeRepository::class)]
class CampervanType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Campervan::class)]
    private $campervans;

    #[ORM\Column(type: 'integer')]
    private $price;

    public function __construct()
    {
        $this->campervans = new ArrayCollection();
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
     * @return Collection<int, Campervan>
     */
    public function getCampervans(): Collection
    {
        return $this->campervans;
    }

    public function addCampervan(Campervan $campervan): self
    {
        if (!$this->campervans->contains($campervan)) {
            $this->campervans[] = $campervan;
            $campervan->setType($this);
        }

        return $this;
    }

    public function removeCampervan(Campervan $campervan): self
    {
        if ($this->campervans->removeElement($campervan)) {
            // set the owning side to null (unless already changed)
            if ($campervan->getType() === $this) {
                $campervan->setType(null);
            }
        }

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
