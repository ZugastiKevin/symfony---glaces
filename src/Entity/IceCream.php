<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Repository\IceCreamRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: IceCreamRepository::class)]
class IceCream
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $specialIngredient = null;

    #[ORM\ManyToOne(inversedBy: 'iceCreams')]
    private ?Cone $cone = null;

    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updateAt = null;

    /**
     * @var Collection<int, Toping>
     */
    #[ORM\ManyToMany(targetEntity: Toping::class, inversedBy: 'iceCreams')]
    private Collection $toping;

    #[ORM\ManyToOne(inversedBy: 'iceCreams')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->toping = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSpecialIngredient(): ?string
    {
        return $this->specialIngredient;
    }

    public function setSpecialIngredient(string $specialIngredient): static
    {
        $this->specialIngredient = $specialIngredient;

        return $this;
    }

    public function getCone(): ?Cone
    {
        return $this->cone;
    }

    public function setCone(?Cone $cone): static
    {
        $this->cone = $cone;

        return $this;
    }

    /**
     * @return Collection<int, Toping>
     */
    public function getToping(): Collection
    {
        return $this->toping;
    }

    public function addToping(Toping $toping): static
    {
        if (!$this->toping->contains($toping)) {
            $this->toping->add($toping);
        }

        return $this;
    }

    public function removeToping(Toping $toping): static
    {
        $this->toping->removeElement($toping);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            $this->updateAt = new \DateTimeImmutable();
        }
    }
}
