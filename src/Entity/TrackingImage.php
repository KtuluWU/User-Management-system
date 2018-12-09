<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrackingImageRepository")
 */
class TrackingImage
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
     * @ORM\Column(name="$tracking_id", type="string", length=70, nullable=false, unique=true)
     */
    private $tracking_id;


    /**
     * @var string
     * @ORM\Column(name="$start_message", type="string", nullable=true)
     */
    private $start_message;

    /**
     * @var string
     * @ORM\Column(name="start_image_path", type="string", nullable=true)
     */
    private $start_image_path;


    /**
     * @var string
     * @ORM\Column(name="$ranch_message", type="string", nullable=true)
     */
    private $ranch_message;

    /**
     * @var string
     * @ORM\Column(name="ranch_image_path", type="string", nullable=true)
     */
    private $ranch_image_path;

    /**
     * @var string
     * @ORM\Column(name="$factory_message", type="string", nullable=true)
     */
    private $factory_message;

    /**
     * @var string
     * @ORM\Column(name="factory_image_path", type="string", nullable=true)
     */
    private $factory_image_path;



    /**
     * @var string
     * @ORM\Column(name="$factory_delivery_message", type="string", nullable=true)
     */
    private $factory_delivery_message;

    /**
     * @var string
     * @ORM\Column(name="factory_delivery_image_path", type="string", nullable=true)
     */
    private $factory_delivery_image_path;


    /**
     * @var string
     * @ORM\Column(name="$export_message", type="string", nullable=true)
     */
    private $export_message;

    /**
     * @var string
     * @ORM\Column(name="export_image_path", type="string", nullable=true)
     */
    private $export_image_path;


    /**
     * @var string
     * @ORM\Column(name="$import_message", type="string", nullable=true)
     */
    private $import_message;

    /**
     * @var string
     * @ORM\Column(name="import_image_path", type="string", nullable=true)
     */
    private $import_image_path;

    /**
     * @var string
     * @ORM\Column(name="$center_message", type="string", nullable=true)
     */
    private $center_message;

    /**
     * @var string
     * @ORM\Column(name="center_image_path", type="string", nullable=true)
     */
    private $center_image_path;

    /**
     * @var string
     * @ORM\Column(name="$site_1_message", type="string", nullable=true)
     */
    private $site_1_message;

    /**
     * @var string
     * @ORM\Column(name="site_1_image_path", type="string", nullable=true)
     */
    private $site_1_image_path;

    /**
     * @var string
     * @ORM\Column(name="$site2_message", type="string", nullable=true)
     */
    private $site2_message;

    /**
     * @var string
     * @ORM\Column(name="site2_image_path", type="string", nullable=true)
     */
    private $site2_image_path;

    /**
     * @var string
     * @ORM\Column(name="$site3_message", type="string", nullable=true)
     */
    private $site3_message;

    /**
     * @var string
     * @ORM\Column(name="site3_image_path", type="string", nullable=true)
     */
    private $site3_image_path;

    /**
     * @var string
     * @ORM\Column(name="$client_message", type="string", nullable=true)
     */
    private $client_message;

    /**
     * @var string
     * @ORM\Column(name="client_image_path", type="string", nullable=true)
     */
    private $client_image_path;

    public function getTrackingId(): ?string
    {
        return $this->tracking_id;
    }

    public function setTrackingId(string $tracking_id): self
    {
        $this->tracking_id = $tracking_id;

        return $this;
    }

    public function getStartMessage(): ?string
    {
        return $this->start_message;
    }

    public function setStartMessage(?string $start_message): self
    {
        $this->start_message = $start_message;

        return $this;
    }

    public function getStartImagePath(): ?string
    {
        return $this->start_image_path;
    }

    public function setStartImagePath(?string $start_image_path): self
    {
        $this->start_image_path = $start_image_path;

        return $this;
    }

    public function getRanchMessage(): ?string
    {
        return $this->ranch_message;
    }

    public function setRanchMessage(?string $ranch_message): self
    {
        $this->ranch_message = $ranch_message;

        return $this;
    }

    public function getRanchImagePath(): ?string
    {
        return $this->ranch_image_path;
    }

    public function setRanchImagePath(?string $ranch_image_path): self
    {
        $this->ranch_image_path = $ranch_image_path;

        return $this;
    }

    public function getFactoryMessage(): ?string
    {
        return $this->factory_message;
    }

    public function setFactoryMessage(?string $factory_message): self
    {
        $this->factory_message = $factory_message;

        return $this;
    }

    public function getFactoryImagePath(): ?string
    {
        return $this->factory_image_path;
    }

    public function setFactoryImagePath(?string $factory_image_path): self
    {
        $this->factory_image_path = $factory_image_path;

        return $this;
    }

    public function getFactoryDeliveryMessage(): ?string
    {
        return $this->factory_delivery_message;
    }

    public function setFactoryDeliveryMessage(?string $factory_delivery_message): self
    {
        $this->factory_delivery_message = $factory_delivery_message;

        return $this;
    }

    public function getFactoryDeliveryImagePath(): ?string
    {
        return $this->factory_delivery_image_path;
    }

    public function setFactoryDeliveryImagePath(?string $factory_delivery_image_path): self
    {
        $this->factory_delivery_image_path = $factory_delivery_image_path;

        return $this;
    }

    public function getExportMessage(): ?string
    {
        return $this->export_message;
    }

    public function setExportMessage(?string $export_message): self
    {
        $this->export_message = $export_message;

        return $this;
    }

    public function getExportImagePath(): ?string
    {
        return $this->export_image_path;
    }

    public function setExportImagePath(?string $export_image_path): self
    {
        $this->export_image_path = $export_image_path;

        return $this;
    }

    public function getImportMessage(): ?string
    {
        return $this->import_message;
    }

    public function setImportMessage(?string $import_message): self
    {
        $this->import_message = $import_message;

        return $this;
    }

    public function getImportImagePath(): ?string
    {
        return $this->import_image_path;
    }

    public function setImportImagePath(?string $import_image_path): self
    {
        $this->import_image_path = $import_image_path;

        return $this;
    }

    public function getCenterMessage(): ?string
    {
        return $this->center_message;
    }

    public function setCenterMessage(?string $center_message): self
    {
        $this->center_message = $center_message;

        return $this;
    }

    public function getCenterImagePath(): ?string
    {
        return $this->center_image_path;
    }

    public function setCenterImagePath(?string $center_image_path): self
    {
        $this->center_image_path = $center_image_path;

        return $this;
    }

    public function getSite1Message(): ?string
    {
        return $this->site_1_message;
    }

    public function setSite1Message(?string $site_1_message): self
    {
        $this->site_1_message = $site_1_message;

        return $this;
    }

    public function getSite1ImagePath(): ?string
    {
        return $this->site_1_image_path;
    }

    public function setSite1ImagePath(?string $site_1_image_path): self
    {
        $this->site_1_image_path = $site_1_image_path;

        return $this;
    }

    public function getSite2Message(): ?string
    {
        return $this->site2_message;
    }

    public function setSite2Message(?string $site2_message): self
    {
        $this->site2_message = $site2_message;

        return $this;
    }

    public function getSite2ImagePath(): ?string
    {
        return $this->site2_image_path;
    }

    public function setSite2ImagePath(?string $site2_image_path): self
    {
        $this->site2_image_path = $site2_image_path;

        return $this;
    }

    public function getSite3Message(): ?string
    {
        return $this->site3_message;
    }

    public function setSite3Message(?string $site3_message): self
    {
        $this->site3_message = $site3_message;

        return $this;
    }

    public function getSite3ImagePath(): ?string
    {
        return $this->site3_image_path;
    }

    public function setSite3ImagePath(?string $site3_image_path): self
    {
        $this->site3_image_path = $site3_image_path;

        return $this;
    }

    public function getClientMessage(): ?string
    {
        return $this->client_message;
    }

    public function setClientMessage(?string $client_message): self
    {
        $this->client_message = $client_message;

        return $this;
    }

    public function getClientImagePath(): ?string
    {
        return $this->client_image_path;
    }

    public function setClientImagePath(?string $client_image_path): self
    {
        $this->client_image_path = $client_image_path;

        return $this;
    }

}
