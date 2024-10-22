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
    #[ORM\Column(type: 'string', length: 255)]
    private string $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $displayName;

    #[ORM\Column(type: 'string', length: 255)]
    private string $itemType;

    #[ORM\Column(type: 'string', length: 255)]
    private string $displayIcon;

    /**
     * @var Collection<int, Locker>
     */
    #[ORM\ManyToMany(targetEntity: Locker::class, mappedBy: 'items')]
    private Collection $lockers;

    public function __construct()
    {
        $this->lockers = new ArrayCollection();
    }

    public function getDisplayIcon()
    {
        return $this->displayIcon;
    }

    public function setDisplayIcon($icon)
    {
        return $this->displayIcon = $icon;
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
    public function getLockers(): Collection
    {
        return $this->lockers;
    }

    public function addLocker(Locker $locker): static
    {
        if (!$this->lockers->contains($locker)) {
            $this->lockers->add($locker);
            $locker->addItem($this);
        }

        return $this;
    }

    public function removeLocker(Locker $locker): static
    {
        if ($this->lockers->removeElement($locker)) {
            $locker->removeItem($this);
        }

        return $this;
    }
}
