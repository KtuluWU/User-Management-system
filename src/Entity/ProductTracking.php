<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductTrackingRepository")
 */
class ProductTracking
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
     * @ORM\Column(name="tracking_id", type="string", length=70, nullable=false, unique=true)
     */
    private $tracking_id;

    /**
     * @var string
     * @ORM\Column(name="product_id", type="string", length=70, nullable=false)
     */
    private $product_id;

    /**
     * @var datetime
     *
     * @ORM\Column(name="production_date", type="datetime", nullable=false)
     */
    private $production_date;

    /**
     * @var string
     * @ORM\Column(name="batch_id", type="string", length=70, nullable=true)
     */
    private $batch_id;

    /**
     * @var datetime
     *
     * @ORM\Column(name="starting_time", type="datetime", nullable=true)
     */
    private $starting_time;

    /**
     * @var string
     * @ORM\Column(name="ranch_id", type="string", length=70,nullable=true)
     */
    private $ranch_id;

    /**
     * @var datetime
     *
     * @ORM\Column(name="milk_collection_time", type="datetime", nullable=true)
     */
    private $milk_collection_time;

    /**
     * @var string
     * @ORM\Column(name="ranch_responsible", type="string", length=70,nullable=true)
     */
    private $ranch_responsible;

    /**
     * @var string
     * @ORM\Column(name="factory", type="string", length=70,nullable=true)
     */
    private $factory;

    /**
     * @var datetime
     *
     * @ORM\Column(name="factory_processing_time", type="datetime", nullable=true)
     */
    private $factory_processing_time;

    /**
     * @var string
     * @ORM\Column(name="factory_responsible", type="string", length=70,nullable=true)
     */
    private $factory_responsible;

    /**
     * @var datetime
     *
     * @ORM\Column(name="factory_delivery_time", type="datetime", nullable=true,nullable=true)
     */
    private $factory_delivery_time;

    /**
     * @var string
     * @ORM\Column(name="factory_delivery_responsible", type="string", length=70,nullable=true)
     */
    private $factory_delivery_responsible;

    /**
     * @var datetime
     *
     * @ORM\Column(name="export_time", type="datetime", nullable=true)
     */
    private $export_time;

    /**
     * @var string
     * @ORM\Column(name="export_responsible", type="string", length=70,nullable=true)
     */
    private $export_responsible;

    /**
     * @var datetime
     *
     * @ORM\Column(name="import_time", type="datetime", nullable=true)
     */
    private $import_time;

    /**
     * @var string
     * @ORM\Column(name="import_responsible", type="string", length=70,nullable=true)
     */
    private $import_responsible;

    /**
     * @var datetime
     *
     * @ORM\Column(name="center_arrival_time", type="datetime", nullable=true)
     */
    private $center_arrival_time;

    /**
     * @var string
     * @ORM\Column(name="arrival_responsible", type="string", length=70,nullable=true)
     */
    private $arrival_responsible;

    /**
     * @var string
     * @ORM\Column(name="site_1", type="string", length=70,nullable=true)
     */
    private $site_1;

    /**
     * @var datetime
     *
     * @ORM\Column(name="site_1_delivery_time", type="datetime", nullable=true)
     */
    private $site_1_delivery_time;

    /**
     * @var string
     * @ORM\Column(name="site_1_responsible", type="string", length=70,nullable=true)
     */
    private $site_1_responsible;

    /**
     * @var string
     * @ORM\Column(name="site_2", type="string", length=70,nullable=true)
     */
    private $site_2;

    /**
     * @var datetime
     *
     * @ORM\Column(name="site_2_delivery_time", type="datetime", nullable=true)
     */
    private $site_2_delivery_time;

    /**
     * @var string
     * @ORM\Column(name="site_2_responsible", type="string", length=70,nullable=true)
     */
    private $site_2_responsible;

    /**
     * @var string
     * @ORM\Column(name="site_3", type="string", length=70,nullable=true)
     */
    private $site_3;

    /**
     * @var datetime
     *
     * @ORM\Column(name="site_3_delivery_time", type="datetime", nullable=true)
     */
    private $site_3_delivery_time;

    /**
     * @var string
     * @ORM\Column(name="site_3_responsible", type="string", length=70,nullable=true)
     */
    private $site_3_responsible;
    /**
     * @var string
     * @ORM\Column(name="client_id", type="string", length=70,nullable=true)
     */
    private $client_id;

    /**
     * @var datetime
     *
     * @ORM\Column(name="purchase_time", type="datetime", nullable=true)
     */
    private $purchase_time;

    /**
     * @var string
     * @ORM\Column(name="seller_id", type="string", length=70)
     */
    private $seller_id;

    public function getTrackingId(): ?string
    {
        return $this->tracking_id;
    }

    public function setTrackingId(string $tracking_id): self
    {
        $this->tracking_id = $tracking_id;

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

    public function getProductionDate(): ?\DateTimeInterface
    {
        return $this->production_date;
    }

    public function setProductionDate(\DateTimeInterface $production_date): self
    {
        $this->production_date = $production_date;

        return $this;
    }

    public function getBatchId(): ?string
    {
        return $this->batch_id;
    }

    public function setBatchId(?string $batch_id): self
    {
        $this->batch_id = $batch_id;

        return $this;
    }

    public function getStartingTime(): ?\DateTimeInterface
    {
        return $this->starting_time;
    }

    public function setStartingTime(?\DateTimeInterface $starting_time): self
    {
        $this->starting_time = $starting_time;

        return $this;
    }

    public function getRanchId(): ?string
    {
        return $this->ranch_id;
    }

    public function setRanchId(?string $ranch_id): self
    {
        $this->ranch_id = $ranch_id;

        return $this;
    }

    public function getMilkCollectionTime(): ?\DateTimeInterface
    {
        return $this->milk_collection_time;
    }

    public function setMilkCollectionTime(?\DateTimeInterface $milk_collection_time): self
    {
        $this->milk_collection_time = $milk_collection_time;

        return $this;
    }

    public function getRanchResponsible(): ?string
    {
        return $this->ranch_responsible;
    }

    public function setRanchResponsible(?string $ranch_responsible): self
    {
        $this->ranch_responsible = $ranch_responsible;

        return $this;
    }

    public function getFactory(): ?string
    {
        return $this->factory;
    }

    public function setFactory(?string $factory): self
    {
        $this->factory = $factory;

        return $this;
    }

    public function getFactoryProcessingTime(): ?\DateTimeInterface
    {
        return $this->factory_processing_time;
    }

    public function setFactoryProcessingTime(?\DateTimeInterface $factory_processing_time): self
    {
        $this->factory_processing_time = $factory_processing_time;

        return $this;
    }

    public function getFactoryResponsible(): ?string
    {
        return $this->factory_responsible;
    }

    public function setFactoryResponsible(?string $factory_responsible): self
    {
        $this->factory_responsible = $factory_responsible;

        return $this;
    }

    public function getFactoryDeliveryTime(): ?\DateTimeInterface
    {
        return $this->factory_delivery_time;
    }

    public function setFactoryDeliveryTime(?\DateTimeInterface $factory_delivery_time): self
    {
        $this->factory_delivery_time = $factory_delivery_time;

        return $this;
    }

    public function getFactoryDeliveryResponsible(): ?string
    {
        return $this->factory_delivery_responsible;
    }

    public function setFactoryDeliveryResponsible(?string $factory_delivery_responsible): self
    {
        $this->factory_delivery_responsible = $factory_delivery_responsible;

        return $this;
    }

    public function getExportTime(): ?\DateTimeInterface
    {
        return $this->export_time;
    }

    public function setExportTime(?\DateTimeInterface $export_time): self
    {
        $this->export_time = $export_time;

        return $this;
    }

    public function getExportResponsible(): ?string
    {
        return $this->export_responsible;
    }

    public function setExportResponsible(?string $export_responsible): self
    {
        $this->export_responsible = $export_responsible;

        return $this;
    }

    public function getImportTime(): ?\DateTimeInterface
    {
        return $this->import_time;
    }

    public function setImportTime(?\DateTimeInterface $import_time): self
    {
        $this->import_time = $import_time;

        return $this;
    }

    public function getImportResponsible(): ?string
    {
        return $this->import_responsible;
    }

    public function setImportResponsible(?string $import_responsible): self
    {
        $this->import_responsible = $import_responsible;

        return $this;
    }

    public function getCenterArrivalTime(): ?\DateTimeInterface
    {
        return $this->center_arrival_time;
    }

    public function setCenterArrivalTime(?\DateTimeInterface $center_arrival_time): self
    {
        $this->center_arrival_time = $center_arrival_time;

        return $this;
    }

    public function getArrivalResponsible(): ?string
    {
        return $this->arrival_responsible;
    }

    public function setArrivalResponsible(?string $arrival_responsible): self
    {
        $this->arrival_responsible = $arrival_responsible;

        return $this;
    }

    public function getSite1(): ?string
    {
        return $this->site_1;
    }

    public function setSite1(?string $site_1): self
    {
        $this->site_1 = $site_1;

        return $this;
    }

    public function getSite1DeliveryTime(): ?\DateTimeInterface
    {
        return $this->site_1_delivery_time;
    }

    public function setSite1DeliveryTime(?\DateTimeInterface $site_1_delivery_time): self
    {
        $this->site_1_delivery_time = $site_1_delivery_time;

        return $this;
    }

    public function getSite1Responsible(): ?string
    {
        return $this->site_1_responsible;
    }

    public function setSite1Responsible(?string $site_1_responsible): self
    {
        $this->site_1_responsible = $site_1_responsible;

        return $this;
    }

    public function getSite2(): ?string
    {
        return $this->site_2;
    }

    public function setSite2(?string $site_2): self
    {
        $this->site_2 = $site_2;

        return $this;
    }

    public function getSite2DeliveryTime(): ?\DateTimeInterface
    {
        return $this->site_2_delivery_time;
    }

    public function setSite2DeliveryTime(?\DateTimeInterface $site_2_delivery_time): self
    {
        $this->site_2_delivery_time = $site_2_delivery_time;

        return $this;
    }

    public function getSite2Responsible(): ?string
    {
        return $this->site_2_responsible;
    }

    public function setSite2Responsible(?string $site_2_responsible): self
    {
        $this->site_2_responsible = $site_2_responsible;

        return $this;
    }

    public function getSite3(): ?string
    {
        return $this->site_3;
    }

    public function setSite3(?string $site_3): self
    {
        $this->site_3 = $site_3;

        return $this;
    }

    public function getSite3DeliveryTime(): ?\DateTimeInterface
    {
        return $this->site_3_delivery_time;
    }

    public function setSite3DeliveryTime(?\DateTimeInterface $site_3_delivery_time): self
    {
        $this->site_3_delivery_time = $site_3_delivery_time;

        return $this;
    }

    public function getSite3Responsible(): ?string
    {
        return $this->site_3_responsible;
    }

    public function setSite3Responsible(?string $site_3_responsible): self
    {
        $this->site_3_responsible = $site_3_responsible;

        return $this;
    }

    public function getClientId(): ?string
    {
        return $this->client_id;
    }

    public function setClientId(?string $client_id): self
    {
        $this->client_id = $client_id;

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

    public function getSellerId(): ?string
    {
        return $this->seller_id;
    }

    public function setSellerId(string $seller_id): self
    {
        $this->seller_id = $seller_id;

        return $this;
    }















}
