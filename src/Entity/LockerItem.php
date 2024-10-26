<?php

namespace App\Entity;

use App\Repository\LockerItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LockerItemRepository::class)]
class LockerItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Locker::class)]
    #[ORM\JoinColumn(nullable: false)] 
    private ?Locker $locker;

    #[ORM\ManyToOne(targetEntity: Item::class)]
    #[ORM\JoinColumn(nullable: false)] 
    private ?Item $item;

    #[ORM\ManyToOne(targetEntity: Chroma::class)]
    #[ORM\JoinColumn(nullable: true)] 
    private ?Chroma $chroma;

    #[ORM\Column(type: 'boolean')]
    private bool $isMainItemType = false;

    public function __construct(){
    }

    public function getLocker(): Locker{
        return $this->locker;
    }

    public function getItem(): Item{
        return $this->item;
    }

    public function getChroma(): Chroma{
        return $this->chroma;
    }

    public function getIsMainItemType(): bool{
        return $this->isMainItemType;
    }

    public function setIsMainItemType(bool $new){
        $this->isMainItemType = $new;
    }

    public function setItem(Item $item){
        $this->item = $item;
    }

    public function setLocker(Locker $locker){
        $this->locker = $locker;
    }

    public function setChroma(Chroma $c){
        $this->chroma = $c;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
