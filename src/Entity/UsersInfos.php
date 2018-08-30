<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersInfosRepository")
 * @ORM\Table(name="users_infos")
 */
class UsersInfos
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
     * UsersInfos constructor.
     */
    public function __construct() {

    }

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

    public function getUserAmt(): ?string
    {
        return $this->user_amt;
    }

    public function setUserAmt(string $user_amt): self
    {
        $this->user_amt = $user_amt;

        return $this;
    }

    public function getSellerAmt(): ?string
    {
        return $this->seller_amt;
    }

    public function setSellerAmt(string $seller_amt): self
    {
        $this->seller_amt = $seller_amt;

        return $this;
    }

    public function getAdminAmt(): ?string
    {
        return $this->admin_amt;
    }

    public function setAdminAmt(string $admin_amt): self
    {
        $this->admin_amt = $admin_amt;

        return $this;
    }
}
