<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 * @ORM\Table(name="vehicles")
 */
class Vehicle
{

    /**
     * @var integer
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups({"safe"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     *
     * @Groups({"safe"})
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     *
     * @Groups({"safe"})
     */
    private $brand;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false, options={"default": 0})
     *
     * @Groups({"safe"})
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false, columnDefinition="ENUM('available', 'sold')")
     *
     * @Groups({"safe"})
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false, columnDefinition="ENUM('car', 'truck')")
     *
     * @Groups({"safe"})
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false, options={"default": 0})
     *
     * @Groups({"safe"})
     */
    private $seats;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=1, nullable=true)
     *
     * @Groups({"safe"})
     */
    private $pollution_certificate;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     */
    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getSeats(): int
    {
        return $this->seats;
    }

    /**
     * @param int $seats
     */
    public function setSeats(int $seats): void
    {
        $this->seats = $seats;
    }

    /**
     * @return string|null
     */
    public function getPollutionCertificate(): ?string
    {
        return $this->pollution_certificate;
    }

    /**
     * @param string|null $pollution_certificate
     */
    public function setPollutionCertificate(?string $pollution_certificate): void
    {
        $this->pollution_certificate = $pollution_certificate;
    }

}
