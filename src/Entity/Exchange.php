<?php

namespace App\Entity;

use App\Repository\ExchangeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExchangeRepository::class)]
class Exchange
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'exchanges')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $productId1 = null;

    #[ORM\ManyToOne(inversedBy: 'exchanges')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $productId2 = null;

    #[ORM\OneToMany(mappedBy: 'exchange_id', targetEntity: ExchangeStatus::class)]
    private Collection $exchangeStatus;

    public function __construct()
    {
        $this->exchangeStatus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductId1(): ?Product
    {
        return $this->productId1;
    }

    public function setProductId1(?Product $productId1): self
    {
        $this->productId1 = $productId1;

        return $this;
    }

    public function getProductId2(): ?Product
    {
        return $this->productId2;
    }

    public function setProductId2(?Product $productId2): self
    {
        $this->productId2 = $productId2;

        return $this;
    }

    /**
     * @return Collection<int, ExchangeStatus>
     */
    public function getExchangeStatus(): Collection
    {
        return $this->exchangeStatus;
    }

    public function addExchangeStatus(ExchangeStatus $exchangeStatus): self
    {
        if (!$this->exchangeStatus->contains($exchangeStatus)) {
            $this->exchangeStatus->add($exchangeStatus);
            $exchangeStatus->setExchangeId($this);
        }

        return $this;
    }

    public function removeExchangeStatus(ExchangeStatus $exchangeStatus): self
    {
        if ($this->exchangeStatus->removeElement($exchangeStatus)) {
            // set the owning side to null (unless already changed)
            if ($exchangeStatus->getExchangeId() === $this) {
                $exchangeStatus->setExchangeId(null);
            }
        }

        return $this;
    }


}
