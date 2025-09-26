<?php

namespace App\Entity;

use App\Repository\PricesPredictRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PricesPredictRepository::class)]
class PricesPredict
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Products::class)]
    #[ORM\JoinColumn(name: "idProduct", referencedColumnName: "id")]
    private ?Products $product = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateData = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $avg1 = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $avg1Foil = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getProduct(): ?Products
    {
        return $this->product;
    }

    public function setProduct(?Products $product): static
    {
        $this->product = $product;
        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->dateData;
    }

    public function setDate(?\DateTime $dateData): static
    {
        $this->dateData = $dateData;

        return $this;
    }

    public function getAvg1(): ?string
    {
        return $this->avg1;
    }

    public function setAvg1(string $avg1): static
    {
        $this->avg1 = $avg1;
        return $this;
    }

    public function getAvg1Foil(): ?string
    {
        return $this->avg1Foil;
    }

    public function setAvg1Foil(string $avg1Foil): static
    {
        $this->avg1Foil = $avg1Foil;
        return $this;
    }

}
