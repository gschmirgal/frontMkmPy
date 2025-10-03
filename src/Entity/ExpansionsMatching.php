<?php

namespace App\Entity;

use App\Repository\ExpansionsMatchingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpansionsMatchingRepository::class)]
class ExpansionsMatching
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
    #[ORM\ManyToOne(targetEntity: Expansions::class)]
    #[ORM\JoinColumn(name: "cardMarketExpansionId", referencedColumnName: "id")]
    private ?Expansions $cardMarketExpansionId = null;

    #[ORM\ManyToOne(targetEntity: ScryfallExpansions::class)]
    #[ORM\JoinColumn(name: "scryfallExpansionId", referencedColumnName: "id")]
    private ?ScryfallExpansions $scryfallExpansion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCardMarketExpansionId(): ?Expansions
    {
        return $this->cardMarketExpansionId;
    }

    public function setCardMarketExpansionId(?Expansions $cardMarketExpansionId): static
    {
        $this->cardMarketExpansionId = $cardMarketExpansionId;
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
