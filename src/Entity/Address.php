<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embeddable;

/** @Embeddable */
class Address
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $street;

    /**
     * @ORM\Column(type="integer")
     */
    private int $streetNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $city;

    /**
     * @ORM\Column(type="integer")
     */
    private int $zipcode;

    public function __construct(int $id, string $street, int $streetNumber, string $city, int $zipcode)
    {
        $this->id = $id;
        $this->street = $street;
        $this->streetNumber = $streetNumber;
        $this->city = $city;
        $this->zipcode = $zipcode;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getStreetNumber(): int
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(int $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipcode(): int
    {
        return $this->zipcode;
    }

    public function setZipcode(int $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'street' => $this->getStreet(),
            'streetnumber' => $this->getStreetNumber(),
            'city' => $this->getCity(),
            'zipcode' => $this->getZipcode(),
        ];
    }
}
