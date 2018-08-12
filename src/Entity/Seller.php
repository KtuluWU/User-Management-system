<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="seller")
 * @ORM\Entity(repositoryClass="App\Repository\SellerRepository")
 */

class Seller extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
    * @var string
    *
    * @Assert\NotBlank()
    * @ORM\Column(name="employee_id", type="string", nullable=false)
    */
    private $employee_id;

    /**
    * @var string
    *
    * @ORM\Column(name="firstname", type="string", length=70, nullable=true)
    */
    private $firstname;

    /**
    * @var string
    *
    * @Assert\NotBlank()
    * @ORM\Column(name="lastname", type="string", length=70, nullable=false)
    */
    private $lastname;

    /**
    * @var datetime
    *
    * @ORM\Column(name="date_birth", type="datetime", nullable=true)
    */
    private $date_birth;

    /**
    * @var bool
    *
    * @Assert\NotBlank()
    * @ORM\Column(name="sex", type="bool", nullable=false)
    */
    private $sex;

    /**
    * @var string
    *
    * @Assert\NotBlank()
    * @ORM\Column(name="id_card", type="string", nullable=false, length=20)
    */
    private $id_card;

    /**
    * @var string
    *
    * @ORM\Column(name="phone", type="string", nullable=true, length=20)
    */
    private $phone;

    /**
    * @var string
    *
    * @ORM\Column(name="wechat", type="string", nullable=true)
    */
    private $wechat;

    /**
    * @var string
    *
    * @ORM\Column(name="address", type="string", nullable=true)
    */
    private $address;

    /**
    * @var datetime
    *
    * @Assert\NotBlank()
    * @ORM\Column(name="date_register", type="datetime", nullable=false)
    */
    private $date_register;

    /**
    * @var string
    * @Assert\NotBlank()
    * @ORM\Column(name="responsible_region", type="string", nullable=false)
    */
    private $responsible_region;


    /**
    * @var string
    * @ORM\Column(name="responsible_id", type="string", nullable=true)
    */
    private $responsible_id;








    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployeeId(): ?string
    {
        return $this->employee_id;
    }

    public function setEmployeeId(string $employee_id): self
    {
        $this->employee_id = $employee_id;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getDateBirth(): ?\DateTimeInterface
    {
        return $this->date_birth;
    }

    public function setDateBirth(?\DateTimeInterface $date_birth): self
    {
        $this->date_birth = $date_birth;

        return $this;
    }

    public function getSex()
    {
        return $this->sex;
    }

    public function setSex($sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getIdCard(): ?string
    {
        return $this->id_card;
    }

    public function setIdCard(string $id_card): self
    {
        $this->id_card = $id_card;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getWechat(): ?string
    {
        return $this->wechat;
    }

    public function setWechat(?string $wechat): self
    {
        $this->wechat = $wechat;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getDateRegister(): ?\DateTimeInterface
    {
        return $this->date_register;
    }

    public function setDateRegister(\DateTimeInterface $date_register): self
    {
        $this->date_register = $date_register;

        return $this;
    }

    public function getResponsibleRegion(): ?string
    {
        return $this->responsible_region;
    }

    public function setResponsibleRegion(string $responsible_region): self
    {
        $this->responsible_region = $responsible_region;

        return $this;
    }

    public function getResponsibleId(): ?string
    {
        return $this->responsible_id;
    }

    public function setResponsibleId(?string $responsible_id): self
    {
        $this->responsible_id = $responsible_id;

        return $this;
    }
}
