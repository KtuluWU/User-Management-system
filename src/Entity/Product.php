<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @var string
     * @ORM\Column(name="product_id", type="string", length=70, nullable=false, unique=true)
     */
    private $product_id;

    /**
     * @var string
     * @ORM\Column(name="product_name", type="string", nullable=false)
     */
    private $product_name;

    /**
     * @var string
     * @ORM\Column(name="barcode", type="string", length=70, nullable=false)
     */
    private $barcode;

    /**
     * @var string
     * @ORM\Column(name="image_path", type="string", nullable=true)
     */
    private $image_path;

    /**
     * @var string
     * @ORM\Column(name="category", type="string", nullable=false)
     */
    private $category;

    /**
     * @var string
     * @ORM\Column(name="shelf_life", type="string", nullable=false)
     */
    private $shelf_life;

    /**
     * @var string
     * @ORM\Column(name="promotion", type="string", length=70, nullable=true)
     */
    private $promotion;

    /**
     * @var integer
     * @ORM\Column(name="stock", type="integer", nullable=true)
     */
    private $stock;

    /**
     * @var string
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    public function getProductId(): ?string
    {
        return $this->product_id;
    }

    public function setProductId(string $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->product_name;
    }

    public function setProductName(string $product_name): self
    {
        $this->product_name = $product_name;

        return $this;
    }

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(string $barcode): self
    {
        $this->barcode = $barcode;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getShelfLife(): ?string
    {
        return $this->shelf_life;
    }

    public function setShelfLife(string $shelf_life): self
    {
        $this->shelf_life = $shelf_life;

        return $this;
    }

    public function getPromotion(): ?string
    {
        return $this->promotion;
    }

    public function setPromotion(?string $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

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

    public function getImagePath(): ?string
    {
        return $this->image_path;
    }

    public function setImagePath(?string $image_path): self
    {
        $this->image_path = $image_path;

        return $this;
    }


}
