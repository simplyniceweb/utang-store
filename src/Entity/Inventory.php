<?php

namespace App\Entity;

use App\Repository\InventoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InventoryRepository::class)
 */
class Inventory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $wholesale_price;

    /**
     * @ORM\Column(type="float")
     */
    private $store_price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modified_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $view_status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWholesalePrice(): ?float
    {
        return $this->wholesale_price;
    }

    public function setWholesalePrice(float $wholesale_price): self
    {
        $this->wholesale_price = $wholesale_price;

        return $this;
    }

    public function getStorePrice(): ?float
    {
        return $this->store_price;
    }

    public function setStorePrice(float $store_price): self
    {
        $this->store_price = $store_price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modified_at;
    }

    public function setModifiedAt(?\DateTimeInterface $modified_at): self
    {
        $this->modified_at = $modified_at;

        return $this;
    }

    public function getViewStatus(): ?int
    {
        return $this->view_status;
    }

    public function setViewStatus(int $view_status): self
    {
        $this->view_status = $view_status;

        return $this;
    }
}
