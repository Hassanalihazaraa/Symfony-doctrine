<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Embeddable */
class Address
{
    /** @ORM\Column(type="string") */
    private string $street;

    /** @ORM\Column(type="integer") */
    private int $streetNumber;

    /** @ORM\Column(type="string") */
    private string $city;

    /** @ORM\Column(type="integer") */
    private int $zipcode;

    public function __construct(string $street, int $streetNumber, string $city, int $zipcode)
    {
        $this->street = $street;
        $this->streetNumber = $streetNumber;
        $this->city = $city;
        $this->zipcode = $zipcode;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): string
    {
        $this->street = $street;
    }

    public function getStreetNumber(): int
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(int $streetNumber): int
    {
        $this->streetNumber = $streetNumber;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): string
    {
        $this->city = $city;
    }

    public function getZipcode(): int
    {
        return $this->zipcode;
    }

    public function setZipcode(int $zipcode): int
    {
        $this->zipcode = $zipcode;
    }

    public function toArray(): array
    {
        return [
            'street' => $this->getStreet(),
            'streetnumber' => $this->getStreetNumber(),
            'city' => $this->getCity(),
            'zipcode' => $this->getZipcode(),
        ];
    }
}
