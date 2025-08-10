<?php

namespace App\Entity;

use App\Repository\ScryfallProductsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScryfallProductsRepository::class)]
class ScryfallProducts
{

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36, unique: true)]
    private string $id;

    #[ORM\Column(length: 36)]
    private ?string $oracleId = null;

    #[ORM\Column(length: 255)]
    private ?string $scryfallUri = null;

    #[ORM\Column(length: 255)]
    private ?string $imgNormalUri = null;

    #[ORM\Column(length: 255)]
    private ?string $imgLargeUri = null;

    #[ORM\Column(length: 255)]
    private ?string $imgPngUri = null;

    #[ORM\Column(length: 255)]
    private ?string $imgArtcropUri = null;

    #[ORM\Column(length: 255)]
    private ?string $imgBordercropUri = null;

    #[ORM\Column]
    private ?bool $reserved = null;

    #[ORM\ManyToOne(inversedBy: 'scryfall')]
    private ?Products $cardMarketId = null;

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

    public function setOracleId(string $oracleId): static
    {
        $this->oracleId = $oracleId;

        return $this;
    }

    public function getScryfallUri(): ?string
    {
        return $this->scryfallUri;
    }

    public function setScryfallUri(string $scryfallUri): static
    {
        $this->scryfallUri = $scryfallUri;

        return $this;
    }

    public function getImgNormalUri(): ?string
    {
        return $this->imgNormalUri;
    }

    public function setImgNormalUri(string $imgNormalUri): static
    {
        $this->imgNormalUri = $imgNormalUri;

        return $this;
    }

    public function getImgLargeUri(): ?string
    {
        return $this->imgLargeUri;
    }

    public function setImgLargeUri(string $imgLargeUri): static
    {
        $this->imgLargeUri = $imgLargeUri;

        return $this;
    }

    public function getImgPngUri(): ?string
    {
        return $this->imgPngUri;
    }

    public function setImgPngUri(string $imgPngUri): static
    {
        $this->imgPngUri = $imgPngUri;

        return $this;
    }

    public function getImgArtcropUri(): ?string
    {
        return $this->imgArtcropUri;
    }

    public function setImgArtcropUri(string $imgArtcropUri): static
    {
        $this->imgArtcropUri = $imgArtcropUri;

        return $this;
    }

    public function getImgBordercropUri(): ?string
    {
        return $this->imgBordercropUri;
    }

    public function setImgBordercropUri(string $imgBordercropUri): static
    {
        $this->imgBordercropUri = $imgBordercropUri;

        return $this;
    }

    public function isReserved(): ?bool
    {
        return $this->reserved;
    }

    public function setReserved(bool $reserved): static
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
}
