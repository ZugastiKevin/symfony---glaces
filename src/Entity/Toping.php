<?php

namespace App\Entity;

use App\Repository\TopingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TopingRepository::class)]
class Toping
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $typeToping = null;

    /**
     * @var Collection<int, IceCream>
     */
    #[ORM\ManyToMany(targetEntity: IceCream::class, mappedBy: 'toping')]
    private Collection $iceCreams;

    public function __construct()
    {
        $this->iceCreams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeToping(): ?string
    {
        return $this->typeToping;
    }

    public function setTypeToping(string $typeToping): static
    {
        $this->typeToping = $typeToping;

        return $this;
    }

    public function __toString(): string
    {
        return $this->typeToping ?? '';
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
            $iceCream->addToping($this);
        }

        return $this;
    }

    public function removeIceCream(IceCream $iceCream): static
    {
        if ($this->iceCreams->removeElement($iceCream)) {
            $iceCream->removeToping($this);
        }

        return $this;
    }
}
