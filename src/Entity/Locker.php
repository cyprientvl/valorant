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


    /**
     * @var Collection<int, Item>
     */
    #[ORM\OneToMany(mappedBy: 'locker', targetEntity: LockerItem::class)]
    private Collection $lockerItems;

    #[ORM\OneToOne(targetEntity: User::class)]
    private User $user;

    #[ORM\ManyToMany(targetEntity: User::class)]
    #[ORM\JoinTable(name: 'locker_user_likes')]
    private Collection $userLikes;

    public function __construct(string $name, bool $isPublic)
    {
        $this->name = $name;
        $this->isPublic = $isPublic;
        $this->lockerItems = new ArrayCollection();
        $this->userLikes = new ArrayCollection();

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
        if ($user === null && $this->user !== null) {
            $this->user->setLocker(null);
        }

        if ($user !== null && $user->getLocker() !== $this) {
            $user->setLocker($this);
        }

        $this->user = $user;

        return $this;
    }

    public function addLikes($user){
        if (!$this->userLikes->contains($user)) {
            $this->userLikes->add($user);
        }else{
            $this->userLikes->removeElement($user);
        }

        return $this;
    }

    public function getLikes(){
        return $this->userLikes->count();
    }

    public function isLiked($user){
        return $this->userLikes->contains($user);
    }
}
