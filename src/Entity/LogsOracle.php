<?php

namespace App\Entity;

use App\Repository\LogsOracleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogsOracleRepository::class)]
class LogsOracle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTime $date = null;

    #[ORM\ManyToOne(targetEntity: Logsteps::class)]
    #[ORM\JoinColumn(name: "idStep", referencedColumnName: "id")]
    private ?Logsteps $step = null;

    #[ORM\ManyToOne(targetEntity: Taskstypes::class)]
    #[ORM\JoinColumn(name: "idTask", referencedColumnName: "id")]
    private ?Taskstypes $task = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(?\DateTime $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getStep(): ?Logsteps
    {
        return $this->step;
    }

    public function setStep(?Logsteps $step): self
    {
        $this->step = $step;
        return $this;
    }

    public function getTask(): ?Taskstypes
    {
        return $this->task;
    }

    public function setTask(?Taskstypes $task): self
    {
        $this->task = $task;
        return $this;
    }

}
