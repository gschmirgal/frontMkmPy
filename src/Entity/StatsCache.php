<?php

namespace App\Entity;

use App\Repository\StatsCacheRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatsCacheRepository::class)]
#[ORM\Table(name: 'stats_cache')]
#[ORM\Index(name: 'idx_cache_key', columns: ['cache_key'])]
class StatsCache
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 100, unique: true)]
    private ?string $cacheKey = null;

    #[ORM\Column(type: Types::JSON)]
    private mixed $cacheValue = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $expiresAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCacheKey(): ?string
    {
        return $this->cacheKey;
    }

    public function setCacheKey(string $cacheKey): static
    {
        $this->cacheKey = $cacheKey;
        return $this;
    }

    public function getCacheValue(): mixed
    {
        return $this->cacheValue;
    }

    public function setCacheValue(mixed $cacheValue): static
    {
        $this->cacheValue = $cacheValue;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getExpiresAt(): ?\DateTime
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(\DateTime $expiresAt): static
    {
        $this->expiresAt = $expiresAt;
        return $this;
    }

    public function isExpired(): bool
    {
        return $this->expiresAt < new \DateTime();
    }
}
