<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 191)]
    private string $id;

    #[ORM\Column(type: 'string', length: 191)]
    private string $displayName;

    #[ORM\Column(type: 'string', length: 191)]
    private string $itemType;
    
    #[ORM\Column(type: 'string', length: 191)]
    private string $displayIcon;
    /**
     * @var Collection<int, Locker>
     */
    #[ORM\OneToMany(targetEntity: LockerItem::class, mappedBy: 'item')]
    private Collection $lockerItems;

    #[ORM\OneToMany(targetEntity: Chroma::class, mappedBy: 'item')]
    private Collection $chromas;

    public function __construct()
    {
        $this->lockerItems = new ArrayCollection();
        $this->chromas = new ArrayCollection();
    }

    public function getDisplayIcon(): string{
        return $this->displayIcon;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    public function setDisplayName(string $displayName): void
    {
        $this->displayName = $displayName;
    }

    public function getItemType(): string
    {
        return $this->itemType;
    }

    public function setItemType(string $itemType): void
    {
        $this->itemType = $itemType;
    }

    /**
     * @return Collection<int, Locker>
     */
    public function getLockerItems(): Collection
    {
        return $this->lockerItems;
    }

    public function getChromas(): Collection{
        return $this->chromas;
    }

    public function addChroma(Chroma $chroma): static
    {
        if (!$this->chromas->contains($chroma)) {
            $this->chromas->add($chroma);
        }
        return $this;
    }
}
