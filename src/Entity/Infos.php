<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InfosRepository")
 * @ORM\Table(name="infos")
 */
class Infos
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="user_id", type="string", length=70, nullable=false)
     */
    private $user_id;

    /**
     * @var string
     * @ORM\Column(name="seller_id", type="string", length=70, nullable=false)
     */
    private $seller_id;

    /**
     * @var string
     * @ORM\Column(name="admin_id", type="string", length=70, nullable=false)
     */
    private $admin_id;

    /**
     * @var integer
     * @ORM\Column(name="user_amt", type="integer", length=30, nullable=false)
     */
    private $user_amt;

    /**
     * @var integer
     * @ORM\Column(name="seller_amt", type="integer", length=30, nullable=false)
     */
    private $seller_amt;

    /**
     * @var integer
     * @ORM\Column(name="admin_amt", type="integer", length=30, nullable=false)
     */
    private $admin_amt;

    /**
     * @var string
     * @ORM\Column(name="product_id", type="string", length=70, nullable=false)
     */
    private $product_id;

    /**
     * @var string
     * @ORM\Column(name="purchase_id", type="string", length=70, nullable=false)
     */
    private $purchase_id;

    /**
     * @var string
     * @ORM\Column(name="tracking_id", type="string", length=70, nullable=false)
     */
    private $tracking_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?string
    {
        return $this->user_id;
    }

    public function setUserId(string $user_id): self
    {
        $this->user_id = $user_id;

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

    public function getAdminId(): ?string
    {
        return $this->admin_id;
    }

    public function setAdminId(string $admin_id): self
    {
        $this->admin_id = $admin_id;

        return $this;
    }

    public function getUserAmt(): ?int
    {
        return $this->user_amt;
    }

    public function setUserAmt(int $user_amt): self
    {
        $this->user_amt = $user_amt;

        return $this;
    }

    public function getSellerAmt(): ?int
    {
        return $this->seller_amt;
    }

    public function setSellerAmt(int $seller_amt): self
    {
        $this->seller_amt = $seller_amt;

        return $this;
    }

    public function getAdminAmt(): ?int
    {
        return $this->admin_amt;
    }

    public function setAdminAmt(int $admin_amt): self
    {
        $this->admin_amt = $admin_amt;

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

    public function getPurchaseId(): ?string
    {
        return $this->purchase_id;
    }

    public function setPurchaseId(string $purchase_id): self
    {
        $this->purchase_id = $purchase_id;

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
}
