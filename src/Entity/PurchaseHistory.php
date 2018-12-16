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
     * @ORM\Column(name="user_id", type="string", length=70, nullable=true)
     */
    private $user_id;

    /**
    * @var string
    * @ORM\Column(name="product_id", type="string", length=70, nullable=false)
    */
    private $product_id;

    /**
    * @var string
    * @ORM\Column(name="tracking_id", type="string", length=70, nullable=false)
    */
    private $tracking_id;

    /**
     * @var string
     * @ORM\Column(name="seller_id", type="string", length=70)
     */
    private $seller_id;

    /**
     * @var datetime
     *
     * @ORM\Column(name="purchase_time", type="datetime", nullable=true)
     */
    private $purchase_time;

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

    public function getProductId(): ?string
    {
        return $this->product_id;
    }

    public function setProductId(string $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }


    public function getTrackingId(): ?string
    {
        return $this->tracking_id;
    }

    public function setTrackingId(string $tracking_id): self
    {
        $this->tracking_id = $tracking_id;

        return $this;
    }


    public function getSellerId(): ?string
    {
        return $this->seller_id;
    }

    public function setSellerId(string $seller_id): self
    {
        $this->seller_id = $seller_id;

        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->user_id;
    }

    public function setUserId(?string $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getPurchaseTime(): ?\DateTimeInterface
    {
        return $this->purchase_time;
    }

    public function setPurchaseTime(?\DateTimeInterface $purchase_time): self
    {
        $this->purchase_time = $purchase_time;

        return $this;
    }
    
}
