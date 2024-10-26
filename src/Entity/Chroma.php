<?php

namespace App\Entity;

use App\Repository\ChromaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChromaRepository::class)]
class Chroma
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 191)]
    private string $id;

    #[ORM\Column(type: 'string', length: 191)]
    private string $displayName;

    #[ORM\Column(type: 'string', length: 191)]
    private string $displayIcon;

    #[ORM\ManyToOne(targetEntity: Chroma::class)]
    #[ORM\JoinColumn(nullable: false)] 
    private ?Item $item;

    public function getItem(): Item{
        return $this->item;
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
}
