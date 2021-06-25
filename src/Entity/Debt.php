<?php

namespace App\Entity;

use App\Repository\DebtRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DebtRepository::class)
 */
class Debt
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

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

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $paid_at;

    /**
     * @ORM\OneToMany(targetEntity=DebtItem::class, mappedBy="debt", cascade={"persist"})
     */
    private $debtItems;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $total;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="debts")
     */
    private $user;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $paid_amount;

    /**
     * @ORM\ManyToMany(targetEntity=Payment::class, inversedBy="debts")
     */
    private $payments;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cash;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function __construct()
    {
        $this->debtItems = new ArrayCollection();
        $this->payments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPaidAt(): ?\DateTimeInterface
    {
        return $this->paid_at;
    }

    public function setPaidAt(?\DateTimeInterface $paid_at): self
    {
        $this->paid_at = $paid_at;

        return $this;
    }

    /**
     * @return Collection|DebtItem[]
     */
    public function getDebtItems(): Collection
    {
        return $this->debtItems;
    }

    public function addDebtItem(DebtItem $debtItem): self
    {
        if (!$this->debtItems->contains($debtItem)) {
            $this->debtItems[] = $debtItem;
            $debtItem->setDebt($this);
        }

        return $this;
    }

    public function removeDebtItem(DebtItem $debtItem): self
    {
        if ($this->debtItems->removeElement($debtItem)) {
            // set the owning side to null (unless already changed)
            if ($debtItem->getDebt() === $this) {
                $debtItem->setDebt(null);
            }
        }

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPaidAmount(): ?float
    {
        return $this->paid_amount;
    }

    public function setPaidAmount(?float $paid_amount): self
    {
        $this->paid_amount = $paid_amount;

        return $this;
    }

    /**
     * @return Collection|Payment[]
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments[] = $payment;
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        $this->payments->removeElement($payment);

        return $this;
    }

    public function getCash(): ?float
    {
        return $this->cash;
    }

    public function setCash(?float $cash): self
    {
        $this->cash = $cash;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
