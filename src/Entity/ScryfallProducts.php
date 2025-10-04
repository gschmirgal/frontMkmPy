<?php

namespace App\Entity;

use App\Repository\ScryfallExpansionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScryfallExpansionsRepository::class)]
class ScryfallProducts
{

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36, unique: true)]
    private string $id;

    #[ORM\Column(length: 36)]
    private ?string $oracleId = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $imgNormalUri = null;

    #[ORM\Column(length: 255)]
    private ?string $imgPngUri = null;

    #[ORM\Column(length: 255)]
    private ?string $imgNormalUriBack = null;

    #[ORM\Column(length: 255)]
    private ?string $imgPngUriBack = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $collectorNumber = null;

    #[ORM\Column(length: 10)]
    private ?string $rarity = null;

    #[ORM\Column]
    private ?bool $reserved = null;

    #[ORM\Column(length: 255)]
    private ?string $gathererUri = null;

    #[ORM\Column(length: 255)]
    private ?string $scryfallUri = null;

    #[ORM\ManyToOne(inversedBy: 'scryfall')]
    private ?Products $cardMarketId = null;

    #[ORM\ManyToOne]
    private ?ScryfallExpansions $scryfallExpansion = null;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getOracleId(): ?string
    {
        return $this->oracleId;
    }

    public function setOracleId(?string $oracleId): static
    {
        $this->oracleId = $oracleId;
        return $this;
    }

    public function getGathererUri(): ?string
    {
        return $this->gathererUri;
    }

    public function setGathererUri(?string $gathererUri): static
    {
        $this->gathererUri = $gathererUri;
        return $this;
    }

    public function getScryfallUri(): ?string
    {
        return $this->scryfallUri;
    }

    public function setScryfallUri(?string $scryfallUri): static
    {
        $this->scryfallUri = $scryfallUri;
        return $this;
    }

    public function getImgNormalUri(): ?string
    {
        return $this->imgNormalUri;
    }

    public function setImgNormalUri(?string $imgNormalUri): static
    {
        $this->imgNormalUri = $imgNormalUri;
        return $this;
    }

    public function getImgPngUri(): ?string
    {
        return $this->imgPngUri;
    }

    public function setImgPngUri(?string $imgPngUri): static
    {
        $this->imgPngUri = $imgPngUri;
        return $this;
    }

    public function isReserved(): ?bool
    {
        return $this->reserved;
    }

    public function setReserved(?bool $reserved): static
    {
        $this->reserved = $reserved;
        return $this;
    }

    public function getCardMarketId(): ?Products
    {
        return $this->cardMarketId;
    }

    public function setCardMarketId(?Products $cardMarketId): static
    {
        $this->cardMarketId = $cardMarketId;
        return $this;
    }

    public function getCollectorNumber(): ?string
    {
        return $this->collectorNumber;
    }

    public function setCollectorNumber(?string $collectorNumber): static
    {
        $this->collectorNumber = $collectorNumber;
        return $this;
    }

    public function getRarity(): ?string
    {
        return $this->rarity;
    }

    public function setRarity(?string $rarity): static
    {
        $this->rarity = $rarity;
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

    public function getImgNormalUriBack(): ?string
    {
        return $this->imgNormalUriBack;
    }

    public function setImgNormalUriBack(?string $imgNormalUriBack): static
    {
        $this->imgNormalUriBack = $imgNormalUriBack;
        return $this;
    }

    public function getImgPngUriBack(): ?string
    {
        return $this->imgPngUriBack;
    }

    public function setImgPngUriBack(?string $imgPngUriBack): static
    {
        $this->imgPngUriBack = $imgPngUriBack;
        return $this;
    }

    public function getScryfallExpansion(): ?ScryfallExpansions
    {
        return $this->scryfallExpansion;
    }

    public function setScryfallExpansion(?ScryfallExpansions $scryfallExpansion): static
    {
        $this->scryfallExpansion = $scryfallExpansion;
        return $this;
    }
}