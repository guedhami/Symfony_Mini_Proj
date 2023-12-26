<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HotelRepository::class)]
class Hotel
{
private $hotel;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]


    private ?int $id = null;
  

    #[ORM\Column(length: 255)]
    private ?string $nomHôtel = null;

    #[ORM\Column]
    private ?int $capacite = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomHôtel(): ?string
    {
        return $this->nomHôtel;
    }

    public function setNomHôtel(string $nomHôtel): static
    {
        $this->nomHôtel = $nomHôtel;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): static
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }
}
