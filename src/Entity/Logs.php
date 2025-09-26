<?php

namespace App\Entity;

use App\Repository\LogsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogsRepository::class)]
class Logs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTime $dateImport = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTime $dateImportFile = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateData = null;

    #[ORM\ManyToOne(targetEntity: Logsteps::class)]
    #[ORM\JoinColumn(name: "idStep", referencedColumnName: "id")]
    private ?Logsteps $step = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getDateImport(): ?\DateTime
    {
        return $this->dateImport;
    }

    public function setDateImport(\DateTime $dateImport): static
    {
        $this->dateImport = $dateImport;

        return $this;
    }

    public function getDateImportFile(): ?\DateTime
    {
        return $this->dateImportFile;
    }

    public function setDateImportFile(\DateTime $dateImportFile): static
    {
        $this->dateImportFile = $dateImportFile;

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

    public function getStep(): ?Logsteps
    {
        return $this->step;
    }

    public function setStep(?Logsteps $step): static
    {
        $this->step = $step;
        return $this;
    }
}
