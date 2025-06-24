<?php

namespace App\Entity;

use App\Repository\ConeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConeRepository::class)]
class Cone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $typeCone = null;

    /**
     * @var Collection<int, IceCream>
     */
    #[ORM\OneToMany(targetEntity: IceCream::class, mappedBy: 'cone')]
    private Collection $iceCreams;

    public function __construct()
    {
        $this->iceCreams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeCone(): ?string
    {
        return $this->typeCone;
    }

    public function setTypeCone(string $typeCone): static
    {
        $this->typeCone = $typeCone;

        return $this;
    }

    public function __toString(): string
    {
        return $this->typeCone ?? '';
    }

    /**
     * @return Collection<int, IceCream>
     */
    public function getIceCreams(): Collection
    {
        return $this->iceCreams;
    }

    public function addIceCream(IceCream $iceCream): static
    {
        if (!$this->iceCreams->contains($iceCream)) {
            $this->iceCreams->add($iceCream);
            $iceCream->setCone($this);
        }

        return $this;
    }

    public function removeIceCream(IceCream $iceCream): static
    {
        if ($this->iceCreams->removeElement($iceCream)) {
            // set the owning side to null (unless already changed)
            if ($iceCream->getCone() === $this) {
                $iceCream->setCone(null);
            }
        }

        return $this;
    }
}
