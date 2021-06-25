<?php

namespace App\Entity;

use App\Repository\DebtItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DebtItemRepository::class)
 */
class DebtItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Debt::class, inversedBy="debtItems", cascade={"persist"})
     */
    private $debt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $item_name;
    
    public function __toString()
    {
        return $this->getItemName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDebt(): ?Debt
    {
        return $this->debt;
    }

    public function setDebt(?Debt $debt): self
    {
        $this->debt = $debt;

        return $this;
    }

    public function getItemName(): ?string
    {
        return $this->item_name;
    }

    public function setItemName(string $item_name): self
    {
        $this->item_name = $item_name;

        return $this;
    }
}
