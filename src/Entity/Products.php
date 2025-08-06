<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Expansions::class)]
    #[ORM\JoinColumn(name: "idExpansion", referencedColumnName: "id")]
    private ?Expansions $expansion = null;

    #[ORM\Column]
    private ?int $idMetaCard = null;

    #[ORM\Column]
    private ?\DateTime $dateAdded = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
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

    public function getExpansion(): ?Expansions
    {
        return $this->expansion;
    }

    public function setExpansion(?Expansions $expansion): static
    {
        $this->expansion = $expansion;
        return $this;
    }

    public function getIdMetaCard(): ?int
    {
        return $this->idMetaCard;
    }

    public function setIdMetaCard(int $idMetaCard): static
    {
        $this->idMetaCard = $idMetaCard;

        return $this;
    }

    public function getDateAdded(): ?\DateTime
    {
        return $this->dateAdded;
    }

    public function setDateAdded(\DateTime $dateAdded): static
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }
}
