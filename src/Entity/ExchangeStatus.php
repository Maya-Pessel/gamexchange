<?php

namespace App\Entity;

use App\Repository\ExchangeStatusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExchangeStatusRepository::class)]
class ExchangeStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'exchangeStatus')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Exchange $exchange_id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Status $status_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExchangeId(): ?Exchange
    {
        return $this->exchange_id;
    }

    public function setExchangeId(?Exchange $exchange_id): self
    {
        $this->exchange_id = $exchange_id;

        return $this;
    }

    public function getStatusId(): ?Status
    {
        return $this->status_id;
    }

    public function setStatusId(?Status $status_id): self
    {
        $this->status_id = $status_id;

        return $this;
    }


}
