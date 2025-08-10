<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, ScryfallProducts>
     */
    #[ORM\OneToMany(targetEntity: ScryfallProducts::class, mappedBy: 'cardMarketId')]
    private Collection $scryfall;

    public function __construct()
    {
        $this->scryfall = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, ScryfallProducts>
     */
    public function getScryfall(): Collection
    {
        return $this->scryfall;
    }

    public function addScryfall(ScryfallProducts $scryfall): static
    {
        if (!$this->scryfall->contains($scryfall)) {
            $this->scryfall->add($scryfall);
            $scryfall->setCardMarketId($this);
        }

        return $this;
    }

    public function removeScryfall(ScryfallProducts $scryfall): static
    {
        if ($this->scryfall->removeElement($scryfall)) {
            // set the owning side to null (unless already changed)
            if ($scryfall->getCardMarketId() === $this) {
                $scryfall->setCardMarketId(null);
            }
        }

        return $this;
    }
}
