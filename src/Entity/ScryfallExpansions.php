<?php

namespace App\Entity;

use App\Repository\ScryfallExpansionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScryfallExpansionsRepository::class)]
class ScryfallExpansions
{

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36, unique: true)]
    private string $id;

    #[ORM\Column(length: 36)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $iconSvgUri = null;

    
    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getIconSvgUri(): ?string
    {
        return $this->iconSvgUri;
    }

    public function setIconSvgUri(?string $iconSvgUri): static
    {
        $this->iconSvgUri = $iconSvgUri;
        return $this;
    }


}
