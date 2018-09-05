<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PurchaseHistoryRepository")
 */
class PurchaseHistory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @var string
    * @ORM\Column(name="purchase_id", type="string", length=70, nullable=false,unique=true)
    */
    private $purchase_id;

    /**
    * @var string
    * @ORM\Column(name="user_phone", type="string", length=70, nullable=false)
    */
    private $user_phone;

    /**
    * @var string
    * @ORM\Column(name="product_id", type="string", length=70, nullable=false)
    */
    private $product_id;

    /**
    * @var datetime
    * @ORM\Column(name="date_purchase", type="datetime", nullable=false)
    */
    private $date_purchase;

    /**
    * @var string
    * @ORM\Column(name="purchase_tracking_id", type="string", length=70, nullable=false)
    */
    private $purchase_tracking_id;
    
    
    /**
    * @var integer
    * @ORM\Column(name="quantity", type="integer", length=70, nullable=true)
    */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPurchaseId(): ?string
    {
        return $this->purchase_id;
    }

    public function setPurchaseId(string $purchase_id): self
    {
        $this->purchase_id = $purchase_id;

        return $this;
    }

    public function getUserPhone(): ?string
    {
        return $this->user_phone;
    }

    public function setUserPhone(string $user_phone): self
    {
        $this->user_phone = $user_phone;

        return $this;
    }

    public function getProductId(): ?string
    {
        return $this->product_id;
    }

    public function setProductId(string $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getDatePurchase(): ?\DateTimeInterface
    {
        return $this->date_purchase;
    }

    public function setDatePurchase(\DateTimeInterface $date_purchase): self
    {
        $this->date_purchase = $date_purchase;

        return $this;
    }

    public function getPurchaseTrackingId(): ?string
    {
        return $this->purchase_tracking_id;
    }

    public function setPurchaseTrackingId(string $purchase_tracking_id): self
    {
        $this->purchase_tracking_id = $purchase_tracking_id;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }



    
}
