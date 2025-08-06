<?php

namespace App\Entity;

use App\Repository\PricesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PricesRepository::class)]
class Prices
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Products::class)]
    #[ORM\JoinColumn(name: "idProduct", referencedColumnName: "id")]
    private ?Products $product = null;

    #[ORM\ManyToOne(targetEntity: Logs::class)]
    #[ORM\JoinColumn(name: "idLog", referencedColumnName: "id")]
    private ?Logs $log = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateData = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $avg = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $low = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $trend = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $avg1 = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $avg7 = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $avg30 = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $avgFoil = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $lowFoil = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $trendFoil = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $avg1Foil = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $avg7Foil = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $avg30Foil = null;


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

    public function getLog(): ?Logs
    {
        return $this->log;
    }

    public function setLog(?Logs $log): static
    {
        $this->log = $log;
        return $this;
    }

    public function getDateData(): ?\DateTime
    {
        return $this->dateData;
    }

    public function setDateData(?\DateTime $dateData): static
    {
        $this->dateData = $dateData;

        return $this;
    }

    public function getAvg(): ?string
    {
        return $this->avg;
    }

    public function setAvg(string $avg): static
    {
        $this->avg = $avg;

        return $this;
    }
    public function getLow(): ?string
    {
        return $this->low;
    }

    public function setLow(string $low): static
    {
        $this->low = $low;
        return $this;
    }

    public function getTrend(): ?string
    {
        return $this->trend;
    }

    public function setTrend(string $trend): static
    {
        $this->trend = $trend;
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

    public function getAvg7(): ?string
    {
        return $this->avg7;
    }

    public function setAvg7(string $avg7): static
    {
        $this->avg7 = $avg7;
        return $this;
    }

    public function getAvg30(): ?string
    {
        return $this->avg30;
    }

    public function setAvg30(string $avg30): static
    {
        $this->avg30 = $avg30;
        return $this;
    }

    public function getAvgFoil(): ?string
    {
        return $this->avgFoil;
    }

    public function setAvgFoil(string $avgFoil): static
    {
        $this->avgFoil = $avgFoil;
        return $this;
    }

    public function getLowFoil(): ?string
    {
        return $this->lowFoil;
    }

    public function setLowFoil(string $lowFoil): static
    {
        $this->lowFoil = $lowFoil;
        return $this;
    }

    public function getTrendFoil(): ?string
    {
        return $this->trendFoil;
    }

    public function setTrendFoil(string $trendFoil): static
    {
        $this->trendFoil = $trendFoil;
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

    public function getAvg7Foil(): ?string
    {
        return $this->avg7Foil;
    }

    public function setAvg7Foil(string $avg7Foil): static
    {
        $this->avg7Foil = $avg7Foil;
        return $this;
    }

    public function getAvg30Foil(): ?string
    {
        return $this->avg30Foil;
    }

    public function setAvg30Foil(string $avg30Foil): static
    {
        $this->avg30Foil = $avg30Foil;
        return $this;
    }
}
