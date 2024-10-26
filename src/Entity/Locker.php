<?php

namespace App\Entity;

use App\Repository\LockerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LockerRepository::class)]
class Locker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 191)]
    private string $name;

    #[ORM\Column(type: 'boolean')]
    private bool $isPublic;

    #[ORM\Column(type: 'integer')]
    private int $likes;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\OneToMany(mappedBy: 'locker', targetEntity: LockerItem::class)]
    private Collection $lockerItems;

    #[ORM\OneToOne(mappedBy: 'locker', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct(string $name, bool $isPublic, int $likes = 0)
    {
        $this->name = $name;
        $this->isPublic = $isPublic;
        $this->likes = $likes;
        $this->lockerItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): void
    {
        $this->isPublic = $isPublic;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): void
    {
        $this->likes = $likes;
    }

    public function incrementLikes(): void
    {
        $this->likes++;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getLockerItems(): Collection
    {
        return $this->lockerItems;
    }

    public function addLockerItem(LockerItem $item): static
    {
        if (!$this->lockerItems->contains($item)) {
            $this->lockerItems->add($item);
        }

        return $this;
    }

    public function removeLockerItem(LockerItem $item): static
    {
        $this->lockerItems->removeElement($item);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setLocker(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getLocker() !== $this) {
            $user->setLocker($this);
        }

        $this->user = $user;

        return $this;
    }

}
