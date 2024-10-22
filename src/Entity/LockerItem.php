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

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $idItem;

    #[ORM\Column(type: 'string', length: 255)]
    private string $itemType;

    public function __construct(string $name, string $idItem, string $itemType)
    {
        $this->name = $name;
        $this->idItem = $idItem;
        $this->itemType = $itemType;
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

    public function getIdItem(): string
    {
        return $this->idItem;
    }

    public function setIdItem(string $idItem): void
    {
        $this->idItem = $idItem;
    }

    public function getItemType(): string
    {
        return $this->itemType;
    }

    public function setItemType(string $itemType): void
    {
        $this->itemType = $itemType;
    }

}
